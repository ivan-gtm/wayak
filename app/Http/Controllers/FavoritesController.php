<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
// use Illuminate\Support\Str;
// use App\Models\Template;
// use Storage;

class FavoritesController extends Controller
{
    public function addFavorite(Request $request)
    {
        $productID = $request->input('template-id');
        $customerId = $request->input('customerId');
        $collectionId = $request->input('collectionId', 'default'); // We'll use 'default' for the default collection

        // Store in Redis
        Redis::sadd('wayak:favorites:' . $customerId . ':' . $collectionId, $productID);

        return response()->json(['status' => 'success']);
    }

    public function isFavorite($productID, $clientId, $collectionId = 'default')
    {
        // Check in Redis
        $isFavorite = Redis::sismember('wayak:favorites:' . $clientId . ':' . $collectionId, $productID);

        // echo 'wayak:favorites:' . $clientId . ':' . $collectionId;
        // exit;

        // return response()->json(['isFavorite' => (bool) $isFavorite]);
        return (bool) $isFavorite;
        // return true;
    }

    public function removeFavorite(Request $request)
    {
        $productID = $request->input('template-id');
        $clientId = $request->input('clientId');
        $collectionId = $request->input('collectionId', 'default'); // We'll use 'default' for the default collection

        // Remove from Redis
        Redis::srem('wayak:favorites:' . $clientId . ':' . $collectionId, $productID);

        return response()->json(['status' => 'success']);
    }

    public function getFavorites(Request $request)
    {
        $clientId = $request->input('clientId');

        $collections = Redis::keys('wayak:favorites:' . $clientId . ':*');
        $favorites = [];

        foreach ($collections as $collection) {
            $favorites[$collection] = Redis::smembers($collection);
        }

        return response()->json(['favorites' => $favorites]);
    }

    public function manageCollection(Request $request)
    {
        $action = $request->input('action'); // create or delete
        $collectionName = $request->input('collectionName');
        $clientId = $request->input('clientId');

        if ($action === 'create') {
            $collectionId = Redis::incr('collection_id_counter'); // Create a unique ID
            Redis::set('collection_names:' . $collectionId, $collectionName); // Save the name with the unique ID
            Redis::sadd('wayak:favorites:' . $clientId . ':' . $collectionId, []); // Create the collection

            return response()->json(['status' => 'success', 'collectionId' => $collectionId, 'collectionName' => $collectionName]);
        } elseif ($action === 'delete') {
            $collectionId = $request->input('collectionId');
            Redis::del('wayak:favorites:' . $clientId . ':' . $collectionId);
            Redis::del('collection_names:' . $collectionId);

            return response()->json(['status' => 'success']);
        }
    }

    // Inside FavoritesController
    public function getCollections(Request $request)
    {
        $clientId = $request->input('clientId');

        $collectionKeys = Redis::keys('wayak:favorites:' . $clientId . ':*');
        $collections = [];

        foreach ($collectionKeys as $key) {
            $parts = explode(':', $key);
            $collectionId = end($parts); // Collection ID is the last part
            $collectionName = Redis::get('collection_names:' . $collectionId); // Fetch name based on ID
            $collections[$collectionId] = $collectionName;
        }

        return response()->json(['collections' => $collections]);
    }
}
