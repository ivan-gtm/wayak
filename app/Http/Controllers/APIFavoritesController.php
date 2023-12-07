<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Template;
use Exception;


class APIFavoritesController extends Controller
{
    public function addFavorite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template-id' => 'required|string|alpha_num|size:10', // Assuming template-id is always 10 characters long
            'customerId' => 'required|string|alpha_num|min:10|max:10', // Assuming customerId is between 8 and 20 characters
            'collectionName' => 'nullable|string|alpha_dash|max:255', // Assuming collectionName can have alphabets, numbers, dashes and underscores
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $productID = $request->input('template-id');
        $customerId = $request->input('customerId');
        $collectionName = $request->input('collectionName', 'default');  // Default to 'default' if collectionName is not provided

        // return response()->json(['status' => 'success']);

        // // Check if the customer exists
        // if (!User::where('customer_id', $customerId)->exists()) {
        //     return response()->json(['error' => 'Customer does not exist.'], 404);
        // }

        // Check if the product exists
        if (!Template::where('_id', $productID)->exists()) {
            return response()->json(['error' => 'Product does not exist.'], 404);
        }

        // Generate the Redis key
        $redisKey = 'wayak:user:favorites:' . $customerId . ':' . $collectionName;

        try {
            // Check if the Redis key exists
            // if (!Redis::exists($redisKey)) {
            //     return response()->json(['error' => 'The favorite list does not exist.'], 404);
            // }

            // Add the product to the favorites set
            Redis::sadd('wayak:user:favorites:' . $customerId . ':' . $collectionName, $productID);
            
            // The user is logged in...
            if (Auth::check()) {
                // You can perform your logic here
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'Favorited anonymously'], 401);
            }
            
        } catch (Exception $e) {
            // Log the error message
            Log::error('Redis connection error: ' . $e->getMessage());
            
            // Return a response indicating that there was a server error
            return response()->json(['error' => 'Got an error getting favorites.'], 500);
        }
        
        return response()->json(['error' => 'Error.'], 404);

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
        $customerId = $request->input('customerId');
        $collectionId = $request->input('collectionId', 'default');  // Default to 'default' if collectionId is not provided

        // Check if the customer exists
        if (!User::where('customer_id', $customerId)->exists()) {
            return response()->json(['error' => 'Customer does not exist.'], 404);
        }

        // Check if the product exists
        if (!Template::where('_id', $productID)->exists()) {
            return response()->json(['error' => 'Product does not exist.'], 404);
        }

        // Generate the Redis key
        $redisKey = 'wayak:user:favorites:' . $customerId . ':' . $collectionId;

        try {
            // Check if the Redis key exists
            if (!Redis::exists($redisKey)) {
                return response()->json(['error' => 'The favorite list does not exist.'], 404);
            }

            // Remove the product from the favorites set
            Redis::srem($redisKey, $productID);

        } catch (Exception $e) {
            // Log the error message
            Log::error('Redis connection error: ' . $e->getMessage());

            // Return a response indicating that there was a server error
            return response()->json(['error' => 'Got an error getting favorites.'], 500);
        }

        return response()->json(['status' => 'success']);
    }


    public function getFavorites(Request $request)
    {
        $customerId = $request->input('customerId');

        $collections = Redis::keys('wayak:user:favorites:' . $customerId . ':*');
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
