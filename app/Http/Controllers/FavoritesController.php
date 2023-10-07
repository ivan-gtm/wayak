<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redis;
// use Illuminate\Http\Response;
// use Illuminate\Support\Facades\App;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Str;
// use App\Models\Template;
// use Storage;

class FavoritesController extends Controller
{
    public function addFavorite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template-id' => 'required|string|alpha_num|size:10', // Assuming template-id is always 10 characters long
            'customerId' => 'required|string|alpha_num|min:8|max:20', // Assuming customerId is between 8 and 20 characters
            'collectionName' => 'nullable|string|alpha_dash|max:255', // Assuming collectionName can have alphabets, numbers, dashes and underscores
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $productID = $request->input('template-id');
        $customerId = $request->input('customerId');
        $collectionName = $request->input('collectionName', 'default');  // Default to 'default' if collectionName is not provided

        Redis::sadd('wayak:user:favorites:' . $customerId . ':' . $collectionName, $productID);

        return response()->json(['status' => 'success']);
    }

    public function isFavorite($productID, $clientId, $collectionId = 'default')
    {
        // Check in Redis
        $isFavorite = Redis::sismember('wayak:user:favorites:' . $clientId . ':' . $collectionId, $productID);

        // echo 'wayak:user:favorites:' . $clientId . ':' . $collectionId;
        // exit;

        // return response()->json(['isFavorite' => (bool) $isFavorite]);
        return (bool) $isFavorite;
        // return true;
    }

    public function removeFavorite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template-id' => 'required|string|alpha_num|size:10', // Assuming template-id is always 10 characters long
            'customerId' => 'required|string|alpha_num|min:8|max:20', // Assuming clientId is between 8 and 20 characters
            'collectionId' => 'nullable|string|alpha_dash|max:255', // Assuming collectionId can have alphabets, numbers, dashes and underscores
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $productID = $request->input('template-id');
        $clientId = $request->input('clientId');
        $collectionId = $request->input('collectionId', 'default');  // Default to 'default' if collectionId is not provided

        Redis::srem('wayak:user:favorites:' . $clientId . ':' . $collectionId, $productID);

        return response()->json(['status' => 'success']);
    }


    public function getFavorites(Request $request)
    {
        $clientId = $request->input('clientId');

        $collections = Redis::keys('wayak:user:favorites:' . $clientId . ':*');
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
            Redis::sadd('wayak:user:favorites:' . $clientId . ':' . $collectionId, []); // Create the collection

            return response()->json(['status' => 'success', 'collectionId' => $collectionId, 'collectionName' => $collectionName]);
        } elseif ($action === 'delete') {
            $collectionId = $request->input('collectionId');
            Redis::del('wayak:user:favorites:' . $clientId . ':' . $collectionId);
            Redis::del('collection_names:' . $collectionId);

            return response()->json(['status' => 'success']);
        }
    }

    // Inside FavoritesController
    public function getCollections(Request $request)
    {
        $clientId = $request->input('clientId');

        $collectionKeys = Redis::keys('wayak:user:favorites:' . $clientId . ':*');
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
