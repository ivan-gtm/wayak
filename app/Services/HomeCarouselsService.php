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
    function addOrUpdateCarouselItem($jsonString, $newItem, $maxItems = 20, $sliderId) {
        // Decode the JSON string to an associative array
        $data = json_decode($jsonString, true);
    
        // Check if $data is an array
        if (!is_array($data)) {
            // Handle the error or initialize $data as an empty array
            // For example, initialize as empty array (or you might want to return an error or throw an exception)
            $data = [];
        }
    
        // Loop through the data to find the "recent-items" slider
        foreach ($data as &$slider) {
            if ($slider['slider_id'] === $sliderId) {
                // Ensure $slider['items'] is an array before looping
                if (!isset($slider['items']) || !is_array($slider['items'])) {
                    $slider['items'] = []; // Initialize as empty array if not set or not an array
                }
    
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
    

    function removeCarouselItem($jsonString, $itemIdToRemove, $sliderId) {
        // Decode the JSON string to an associative array
        $data = json_decode($jsonString, true);
    
        // Loop through the data to find the specified slider
        foreach ($data as &$slider) {
            if ($slider['slider_id'] === $sliderId) {
                // Initialize an index to hold the position of the item to be removed
                $itemToRemoveIndex = null;
    
                // Search for the item in the existing list
                foreach ($slider['items'] as $index => $item) {
                    if ($item['_id'] === $itemIdToRemove) { // Assuming '_id' is unique
                        $itemToRemoveIndex = $index;
                        break; // Break out of the loop once found
                    }
                }
    
                if (!is_null($itemToRemoveIndex)) {
                    // Remove the item
                    array_splice($slider['items'], $itemToRemoveIndex, 1);
                }
    
                break; // Exit the loop once we've processed the specified slider
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

    // function getFavorites($customerId)
    // {
    //     $collections = Redis::keys('wayak:user:' . $customerId . ':favorites:*');
    //     $favorites = [];

    //     foreach ($collections as $collection_key) {
    //         $collection_name = substr($collection_key, strrpos($collection_key, ":") + 1);
    //         $favorites[$collection_name] = Redis::smembers($collection_key);
    //     }

    //     $flattenedArray = array_merge(...array_values($favorites));

    //     return $flattenedArray;
    // }

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

        $redisCarouselsJSON = Redis::get("wayak:user:{$customerId}:recommendations:carousels");
        $modifiedJson = $this->addOrUpdateCarouselItem($redisCarouselsJSON, $carouselItem, 20,'favorites');
        
        Redis::set("wayak:user:{$customerId}:recommendations:carousels",$modifiedJson);

        return $modifiedJson;
    }
    
    function addProductToRecentlyViewed($customerId, $templateID)
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

        $redisCarouselsJSON = Redis::get("wayak:user:{$customerId}:recommendations:carousels");
        $modifiedJson = $this->addOrUpdateCarouselItem($redisCarouselsJSON, $carouselItem, 20,'recently-viewed');
        
        Redis::set("wayak:user:{$customerId}:recommendations:carousels",$modifiedJson);

        return $modifiedJson;
    }
    
    function removeItemFromFavorites($customerId, $templateID)
    {
        // $language_code = 'en';
        // $country = 'us';
        $redisCarouselsJSON = Redis::get("wayak:user:{$customerId}:recommendations:carousels");
        $modifiedJson = $this->removeCarouselItem($redisCarouselsJSON,$templateID,'favorites');
        Redis::set("wayak:user:{$customerId}:recommendations:carousels",$modifiedJson);

        return $modifiedJson;
    }
}
