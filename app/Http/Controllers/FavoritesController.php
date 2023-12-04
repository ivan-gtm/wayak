<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\LocaleTrait;
use App\Models\Template;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FavoritesController extends Controller
{
    use LocaleTrait;

    function showFavorites($country, Request $request){
        // $this->getFavorites();
        // $country = 'us';
        $validator = Validator::make($request->all(), [
            'userId' => 'required|string|alpha_num|min:10|max:10', // Assuming clientId is between 8 and 20 characters
        ]);

        if ($validator->fails()) {
            // return response()->json(['errors' => $validator->errors()], 422);
            abort(404);
        }

        $locale = $this->getLocaleByCountry($country);
        App::setLocale($locale);

        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        $user = Auth::user();
        if($user){
            $customerId = $user->customer_id;
        } elseif(isset($request->userId)) {
            $customerId = $request->userId;
        } else {
            abort(404);
        }

        $collections = Redis::keys('wayak:user:' . $customerId . ':favorites:*');
        $favorites = [];

        foreach ($collections as $collection) {
            // $favorites[$collection] = Redis::smembers($collection);
            $favorites = array_merge( Redis::smembers($collection) ,$favorites);
        }
        
        $page = $request->input('page', 1);
        $templates = [];
        $last_page = 0;
        if(sizeof($favorites) > 0){
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
    
            $total_documents = Template::whereIn('_id', ['gmnftcCJWK'])->count();
            $last_page = ceil($total_documents / $per_page);
        }
                
        return view('auth.user.wishlist2', [
            'menu' => $menu,
            'sale' => $sale,
            'customer_id' => $customerId,
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

        Redis::sadd('wayak:user:' . $customerId . ':favorites:' . $collectionName, $productID);

        return response()->json(['status' => 'success']);
    }

    public function isFavorite($productID, $customerId, $collectionId = 'default')
    {
        // Check in Redis
        $isFavorite = Redis::sismember('wayak:user:' . $customerId . ':favorites:' . $collectionId, $productID);

        // echo 'wayak:user:' . $customerId . ':favorites:' . $collectionId;
        // exit;

        // return response()->json(['isFavorite' => (bool) $isFavorite]);
        return (bool) $isFavorite;
        // return true;
    }

    public function removeFavorite(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'template-id' => 'required|string|alpha_num|size:10', // Assuming template-id is always 10 characters long
            'customerId' => 'required|string|alpha_num|min:10|max:10', // Assuming clientId is between 8 and 20 characters
            'collectionId' => 'nullable|string|alpha_dash|max:255', // Assuming collectionId can have alphabets, numbers, dashes and underscores
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $productID = $request->input('template-id');
        $customerId = $request->input('customerId');
        $collectionId = $request->input('collectionId', 'default');  // Default to 'default' if collectionId is not provided
        $redisKey = 'wayak:user:' . $customerId . ':favorites:' . $collectionId;
        // echo $redisKey.'<br>';
        Redis::srem($redisKey, $productID);

        return response()->json(['status' => 'success']);
    }

    // public function getFavorites(Request $request)
    // {
    //     $customerId = $request->input('clientId');

    //     $collections = Redis::keys('wayak:user:' . $customerId . ':favorites:*');
    //     $favorites = [];

    //     foreach ($collections as $collection) {
    //         $favorites[$collection] = Redis::smembers($collection);
    //     }

    //     return response()->json(['favorites' => $favorites]);
    // }

    public function manageCollection(Request $request)
    {
        $action = $request->input('action'); // create or delete
        $collectionName = $request->input('collectionName');
        $customerId = $request->input('clientId');

        if ($action === 'create') {
            $collectionId = Redis::incr('collection_id_counter'); // Create a unique ID
            Redis::set('collection_names:' . $collectionId, $collectionName); // Save the name with the unique ID
            Redis::sadd('wayak:user:' . $customerId . ':favorites:' . $collectionId, []); // Create the collection

            return response()->json(['status' => 'success', 'collectionId' => $collectionId, 'collectionName' => $collectionName]);
        } elseif ($action === 'delete') {
            $collectionId = $request->input('collectionId');
            Redis::del('wayak:user:' . $customerId . ':favorites:' . $collectionId);
            Redis::del('collection_names:' . $collectionId);

            return response()->json(['status' => 'success']);
        }
    }

    // Inside FavoritesController
    public function getCollections(Request $request)
    {
        $customerId = $request->input('clientId');

        $collectionKeys = Redis::keys('wayak:user:' . $customerId . ':favorites:*');
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
