<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Template;
use Exception;
use App\Services\HomeCarouselsService;

class FavoritesService
{
    protected $homeCarouselService;

    public function __construct(HomeCarouselsService $homeCarouselService)
    {
        $this->homeCarouselService = $homeCarouselService;
    }

    public function getFavorites($page, $customerId, $locale)
    {
        $collections = Redis::keys('wayak:user:' . $customerId . ':favorites:*');
        $favorites = [];

        foreach ($collections as $collection) {
            $favorites = array_merge(Redis::smembers($collection), $favorites);
        }

        $templates = [];
        $last_page = 0;

        if (count($favorites) > 0) {
            $per_page = 100;
            $skip = $per_page * ($page - 1);
            $category_products = Template::whereIn('_id', $favorites)
                ->skip($skip)
                ->take($per_page)
                ->get([
                    '_id',
                    'title',
                    'slug',
                    'previewImageUrls',
                    'studioName',
                    'prices'
                ]);

            $templates = [];
            foreach ($category_products as $template) {
                $template->preview_image = App::environment() == 'local'
                    ? asset('design/template/' . $template->_id . '/thumbnails/' . $locale . '/' . $template->previewImageUrls["carousel"])
                    : Storage::disk('s3')->url('design/template/' . $template->_id . '/thumbnails/' . $locale . '/' . $template->previewImageUrls["carousel"]);

                $templates[] = $template;
            }

            $total_documents = Template::whereIn('_id', $favorites)->count();
            $last_page = ceil($total_documents / $per_page);
        }

        return [
            'templates' => $templates,
            'page' => $page,
            'last_page' => $last_page
        ];
    }

    /**
     * Adds a product to the favorites collection for a customer.
     *
     * @param string $customerId The ID of the customer.
     * @param string $collectionName The name of the collection to which the product is being added.
     * @param string $productID The ID of the product being added to the favorites.
     * @return array An array containing a success flag and a message.
     */
    public function addToFavorites($customerId, $collectionName = 'default', $productID)
    {
        // Validate input parameters
        if (empty($customerId) || empty($collectionName) || empty($productID)) {
            return ['success' => false, 'message' => 'Invalid input parameters.'];
        }

        try {
            $key = 'wayak:user:' . $customerId . ':favorites:' . $collectionName;
            $result = Redis::sadd($key, $productID);
            
            // echo $result;
            // exit;

            // Redis::sadd returns the number of elements added to the set, 0 if the element was already a member.
            if ($result === 1) {
                $this->homeCarouselService->buildFavoritesCarousels($customerId, $productID);
                return ['success' => true, 'message' => 'Product added to favorites successfully.'];
            } else {
                return ['success' => false, 'message' => 'Product is already in favorites.'];
            }
        } catch (Exception $e) {
            // Log the error or handle it as per your application's error handling policy
            return ['success' => false, 'message' => 'Failed to add product to favorites due to an error: ' . $e->getMessage()];
        }
    }

    public function isFavorite($productID, $clientId, $collectionId = 'default')
    {
        // Validate input parameters
        if (empty($productID) || empty($clientId)) {
            return ['success' => false, 'message' => 'Invalid input parameters.', 'isFavorite' => false];
        }

        try {
            $key = 'wayak:user:favorites:' . $clientId . ':' . $collectionId;
            $isFavorite = Redis::sismember($key, $productID);

            return ['success' => true, 'message' => 'Operation successful.', 'isFavorite' => (bool) $isFavorite];
        } catch (Exception $e) {
            // Log the error or handle it as per your application's error handling policy
            return ['success' => false, 'message' => 'Failed to check if product is a favorite due to an error: ' . $e->getMessage(), 'isFavorite' => false];
        }
    }

    public function removeFromFavorites($customerId, $collectionName, $productID)
    {
        // Validate input parameters
        if (empty($customerId) || empty($collectionName) || empty($productID)) {
            return ['success' => false, 'message' => 'Invalid input parameters.'];
        }

        try {
            $key = 'wayak:user:' . $customerId . ':favorites:' . $collectionName;
            $result = Redis::srem($key, $productID);

            // Redis::srem returns the number of members that were removed from the set, not present members are ignored.
            if ($result > 0) {
                $this->homeCarouselService->removeItemFromFavorites($customerId, $productID);
                return ['success' => true, 'message' => 'Product removed from favorites successfully.'];
            } else {
                return ['success' => false, 'message' => 'Product was not found in favorites.'];
            }
        } catch (Exception $e) {
            // Log the error or handle it as per your application's error handling policy
            return ['success' => false, 'message' => 'Failed to remove product from favorites due to an error: ' . $e->getMessage()];
        }
    }

    public function createCollection($collectionName, $customerId)
    {
        try {
            $collectionId = Redis::incr('collection_id_counter');
            Redis::set('collection_names:' . $collectionId, $collectionName);
            Redis::sadd('wayak:user:' . $customerId . ':favorites:' . $collectionId, []);

            return ['success' => true, 'collectionId' => $collectionId, 'collectionName' => $collectionName];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Failed to create collection due to an error: ' . $e->getMessage()];
        }
    }

    public function deleteCollection($collectionId, $customerId)
    {
        try {
            Redis::del('wayak:user:' . $customerId . ':favorites:' . $collectionId);
            Redis::del('collection_names:' . $collectionId);

            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Failed to delete collection due to an error: ' . $e->getMessage()];
        }
    }

    public function getCollections($customerId)
    {
        try {
            $collectionKeys = Redis::keys('wayak:user:' . $customerId . ':favorites:*');
            $collections = [];

            foreach ($collectionKeys as $key) {
                $parts = explode(':', $key);
                $collectionId = end($parts); // Collection ID is the last part
                $collectionName = Redis::get('collection_names:' . $collectionId); // Fetch name based on ID
                if ($collectionName) {
                    $collections[$collectionId] = $collectionName;
                }
            }

            return ['success' => true, 'collections' => $collections];
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Failed to retrieve collections due to an error: ' . $e->getMessage()];
        }
    }

}
