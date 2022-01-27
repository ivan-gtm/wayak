<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

ini_set("max_execution_time", 0);   // no time-outs!
ini_set("request_terminate_timeout", 2000);   // no time-outs!
ini_set('memory_limit', -1);
ini_set('display_errors', 1);

ignore_user_abort(true);            // Continue downloading even after user closes the browser.
error_reporting(E_ALL);


class CorjlController extends Controller
{
    private $category_ids = [];

    /**
     * Show the application dashboard.
     */
    public function index(Request $request)
    {
        self::generateWayakTemplate();
        exit;
        // self::parseFonts();
        // exit;
        // echo "<pre>";
        // print_r(json_decode(Redis::get('template:en:PKGMWt7qdkH35fZ:jsondata')));
        // exit;

        // echo "<pre>";
        // print_r(json_decode(self::svgToJSON()));
        // exit;
        // self::parseCategoryAndProducts();
        // exit;
    }

    
}
