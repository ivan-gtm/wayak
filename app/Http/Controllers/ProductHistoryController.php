<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
// use Predis\Client as Redis;

class ProductHistoryController extends Controller
{

    public function syncProductHistory(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'customerId' => 'required|string',
            'productHistory' => 'required|json'
        ]);

        $customerId = $request->input('customerId');
        $incomingProductHistory = json_decode($request->input('productHistory'), true);

        // Define the Redis key for storing the product history of this customer
        $key = "wayak:user:{$customerId}:history:navigation";

        // Update the existing product history
        foreach ($incomingProductHistory as $productId => $data) {
            $field = $productId;
            $existingDataJSON = Redis::hget($key, $field);
            $existingData = $existingDataJSON ? json_decode($existingDataJSON, true) : [];

            if (!$existingData) {
                // Store the updated product history in hash field
                Redis::hset($key, $field, json_encode($data));
            } elseif ($existingData && $existingData['lastVisited'] < $data['lastVisited']) {
                // Increment the counter
                $existingData['count'] += $data['count'];
                Redis::hset($key, $field, json_encode($existingData));
            }
        }

        return response()->json(['message' => 'Product history synced successfully']);
    }

    public function removeProductFromHistory(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'customerId' => 'required|string',
            'productId' => 'required|string'
        ]);

        $customerId = $request->input('customerId');
        $productId = $request->input('productId');

        // Define the Redis key for storing the product history of this customer
        $key = "wayak:user:{$customerId}:history:navigation";

        // Remove the product from the hash
        Redis::hdel($key, $productId);

        return response()->json(['message' => 'Product removed from history successfully']);
    }


    public function getProductHistory(Request $request)
    {
        // Validate incoming request
        $request->validate([
            'customerId' => 'required|string',
        ]);

        $customerId = $request->input('customerId');
        $key = "wayak:user:{$customerId}:history:navigation";

        // Retrieve all fields of the Redis hash as an associative array
        $productHistory = Redis::hgetall($key);

        // Decode each JSON string into an array
        foreach ($productHistory as $productId => &$data) {
            $data = json_decode($data, true);
        }

        return response()->json(['productHistory' => $productHistory]);
    }
}
