<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
// use Predis\Client as Redis;

class ProductHistoryController extends Controller
{
    // private $redis;

    // public function __construct()
    // {
    //     $this->redis = new Redis();
    // }

    public function syncProductHistory(Request $request)
    {
        $clientId = $request->input('clientId');
        $productHistory = $request->input('productHistory');
        Redis::set('wayak:user:'.$clientId.':productHistory', json_encode($productHistory));
    }

    public function removeProductFromHistory(Request $request)
    {
        $clientId = $request->input('clientId');
        $productId = $request->input('productId');
        $productHistory = json_decode(Redis::get($clientId), true);
        if ($productHistory) {
            unset($productHistory[$productId]);
            Redis::set('wayak:user:'.$clientId.':productHistory', json_encode($productHistory));
        }
    }

    public function getProductHistory(Request $request)
    {
        $clientId = $request->input('clientId');
        return response()->json([
            'productHistory' => json_decode(Redis::get($clientId), true)
        ]);
    }
}
