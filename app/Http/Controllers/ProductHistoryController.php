<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Traits\LocaleTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use App\Models\Template;
// use Predis\Client as Redis;

class ProductHistoryController extends Controller
{
    use LocaleTrait;
    
    function showBrowsingHistory($country, Request $request){
        
        $locale = $this->getLocaleByCountry($country);

        App::setLocale($locale);

        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        $user = Auth::user();
        $clientId = $user->customer_id;
        $key = "wayak:user:{$clientId}:history:navigation";

        // Retrieve all fields of the Redis hash as an associative array
        $productHistory = Redis::hgetall($key);

        $page = $request->input('page', 1);
        $per_page = 100;
        $skip = $per_page * ($page - 1);
        $category_products = Template::whereIn('_id', array_keys($productHistory))
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

        $total_documents = sizeof(array_keys($productHistory));
        $last_page = ceil($total_documents / $per_page);

        return view('auth.user.wishlist2', [
            'menu' => $menu,
            'sale' => $sale,
            'templates' => $templates,
            'country' => $country,
            'search_query' => '',
            'current_page' => $page,
            'pagination_begin' => max($page - 4, 1),
            'pagination_end' => min($page + 4, $last_page),
            'first_page' => 1,
            'last_page' => $last_page,
            'templates' => $templates,
            'current_url' => url()->current()
        ]);
    }
    
    function showSearchHistory($country, Request $request){
        
        $locale = $this->getLocaleByCountry($country);

        App::setLocale($locale);

        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        $user = Auth::user();
        $clientId = $user->customer_id;
        $key = "wayak:user:{$clientId}:history:search";
        $searchHistory = Redis::hgetall($key);
        
        
        // wayak:us:analytics:search:terms
        echo "<pre>";
        foreach(array_keys($searchHistory) as $key) {
            // print_r($key);
            print_r( Redis::hget('wayak:us:analytics:search:terms', $key) );
            print_r( '<br>' );
            print_r( $key );
            print_r( '<br>' );
            print_r( '<br>' );
        }
        exit;

        $page = $request->input('page', 1);
        $per_page = 100;
        $skip = $per_page * ($page - 1);
        $category_products = Template::whereIn('_id', array_keys($productHistory))
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

        $total_documents = sizeof(array_keys($productHistory));
        $last_page = ceil($total_documents / $per_page);

        return view('auth.user.wishlist2', [
            'menu' => $menu,
            'sale' => $sale,
            'templates' => $templates,
            'country' => $country,
            'search_query' => '',
            'current_page' => $page,
            'pagination_begin' => max($page - 4, 1),
            'pagination_end' => min($page + 4, $last_page),
            'first_page' => 1,
            'last_page' => $last_page,
            'templates' => $templates,
            'current_url' => url()->current()
        ]);
    }

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
