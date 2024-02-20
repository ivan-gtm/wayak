<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpParser\Node\Expr\AssignOp\Concat;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class RecommendationController extends Controller
{
    public function getUserCarousels(Request $request)
    {
        // // $query = $request->input('customerId');
        
        // $validator = Validator::make($request->all(), [
        //     'customerId' => 'required|string|alpha_num|min:10|max:10', // Assuming clientId is between 8 and 20 characters
        // ]);
        
        // if($validator->fails()) {
        //     // return response()->json(['errors' => $validator->errors()], 422);
        //     abort(404);
        // }
        
        // // $favorites = Redis::get("wayak:user:$customerId:carousels:favorites");
        // $customerId = $request->customerId;

        // // $productHistory = json_decode(Redis::get("wayak:user:$customerId:carousels:product-history"), true) ?? [];
        // // $favorites = json_decode(Redis::get("wayak:user:$customerId:carousels:favorites"), true) ?? [];
        // // $searchTerm = json_decode(Redis::get("wayak:user:$customerId:carousels:search"), true) ?? [];

        // $country = 'us';
        // $redisCarouselKey = "wayak:user:{$customerId}:recommendations:carousels";
        // $trendingCategories = json_decode(Redis::get($redisCarouselKey), true) ?? [];
        
        // // echo "<pre>";
        // // print_r( $trendingCategories );
        // // exit;

        // return $trendingCategories;
    }
}
