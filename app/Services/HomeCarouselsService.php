<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Template;

class HomeCarouselsService
{
    function addOrUpdateCarouselItem($jsonString, $newItem, $maxItems = 20) {
        // Decode the JSON string to an associative array
        $data = json_decode($jsonString, true);
    
        // Loop through the data to find the "recent-items" slider
        foreach ($data as &$slider) {
            if ($slider['slider_id'] === 'favorites') {
                // Initialize an index to hold the position of an existing item
                $existingItemIndex = null;
    
                // Search for the item in the existing list
                foreach ($slider['items'] as $index => $item) {
                    if ($item['_id'] === $newItem['_id']) { // Assuming '_id' is unique
                        $existingItemIndex = $index;
                        break; // Break out of the loop once found
                    }
                }
    
                if (!is_null($existingItemIndex)) {
                    // Remove the existing item
                    array_splice($slider['items'], $existingItemIndex, 1);
                }
    
                // Add the new item to the beginning of the "items" array
                array_unshift($slider['items'], $newItem);
    
                // Check if adding a new item exceeds the limit
                if (count($slider['items']) > $maxItems) {
                    // Remove the excess oldest items from the end
                    $slider['items'] = array_slice($slider['items'], 0, $maxItems);
                }
    
                break; // Exit the loop once we've processed the "recent-items" slider
            }
        }
    
        // Re-encode the modified array back to a JSON string
        return json_encode($data, JSON_PRETTY_PRINT);
    }
    

    function createNewCarouselItem($id, $title, $slug, $width, $height, $forSubscribers, $previewImageUrls, $previewImageUrl) {
        return [
            "_id" => $id,
            "title" => $title,
            "slug" => $slug,
            "width" => $width,
            "height" => $height,
            "forSubscribers" => $forSubscribers,
            "previewImageUrls" => array_reduce($previewImageUrls, function($carry, $urlType) {
                $carry[$urlType['type']] = $urlType['url'];
                return $carry;
            }, []),
            "preview_image_url" => $previewImageUrl
        ];
    }

    function getFavorites($customerId)
    {
        $collections = Redis::keys('wayak:user:' . $customerId . ':favorites:*');
        $favorites = [];

        foreach ($collections as $collection_key) {
            $collection_name = substr($collection_key, strrpos($collection_key, ":") + 1);
            $favorites[$collection_name] = Redis::smembers($collection_key);
        }

        $flattenedArray = array_merge(...array_values($favorites));

        return $flattenedArray;
    }

    function buildFavoritesCarousels($customerId, $templateID)
    {
        $language_code = 'en';
        $country = 'us';

        $product = Template::where('_id', $templateID)->select([
            'title',
            'slug',
            'previewImageUrls',
            'width',
            'height',
            'forSubscribers',
            'previewImageUrls'
        ])->first();

        if (App::environment() == 'local') {
            $product->preview_image_url = asset('design/template/' . $product->_id . '/thumbnails/' . $language_code . '/' . $product->previewImageUrls['carousel']);
        } else {
            $product->preview_image_url = Storage::disk('s3')->url('design/template/' . $product->_id . '/thumbnails/' . $language_code . '/' . $product->previewImageUrls['carousel']);
        }

        $carouselItem = [
            '_id' => $product->_id,
            'title' => $product->title,
            'slug' => $product->slug,
            'width' => $product->width,
            'height' => $product->height,
            'forSubscribers' => $product->forSubscribers,
            'previewImageUrls' => $product->previewImageUrls,
            'preview_image_url' => $product->preview_image_url
        ];

        // echo "<pre>";
        // print_r( $carouselItem );
        // exit;


        // Construct the carousel JSON object
        $carousel = [[
            'slider_id' => 'favorites',
            'title' => 'Favorites',
            'search_term' => 'Favorites',
            'link' => route('user.favorites', ['customerId' => $customerId, 'country' => $country]),
            // 'items' => $carouselItems
        ]];

        $redisCarouselsJSON = Redis::get("wayak:user:{$customerId}:recommendations:carousels");
        $modifiedJson = $this->addOrUpdateCarouselItem($redisCarouselsJSON, $carouselItem, 20);
        
        Redis::set("wayak:user:{$customerId}:recommendations:carousels",$modifiedJson);

        return $modifiedJson;

        // echo "<pre>";
        // print_r($modifiedJson);
        // exit;
    }
}
