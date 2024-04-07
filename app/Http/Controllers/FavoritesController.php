<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\LocaleTrait;
use App\Models\Template;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Services\FavoritesService;

class FavoritesController extends Controller
{
    use LocaleTrait;
    protected $favoriteService;

    public function __construct(FavoritesService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    function showFavorites($country, Request $request){
        $validator = Validator::make($request->all(), [
            'customerId' => 'required|string|alpha_num|min:10|max:10', // Assuming clientId is between 8 and 20 characters
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
        } elseif(isset($request->customerId)) {
            $customerId = $request->customerId;
        } else {
            abort(404);
        }

        $page = $request->input('page', 1);
        $favoritesResults = $this->favoriteService->getFavorites($page, $customerId, $locale);
        $lastPage = $favoritesResults['last_page'];

        return view('auth.user.wishlist2', [
            'menu' => $menu,
            'sale' => $sale,
            'customer_id' => $customerId,
            'templates' => $favoritesResults['templates'],
            'country' => $country,
            'search_query' => '',
            'current_page' => $favoritesResults['page'],
            'pagination_begin' => max($page - 4, 1),
            'pagination_end' => min($page + 4, $lastPage),
            'first_page' => 1,
            'last_page' => $lastPage,
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

        $result = $this->favoriteService->addToFavorites($customerId, $collectionName, $productID);

        return response()->json(['message' => $result['message'],'status' => 'success', 'success' => $result['success']], $result['success'] ? 200 : 400);
    }

    public function checkFavorite(Request $request)
    {
        $productID = $request->input('productID');
        $clientId = $request->input('clientId');
        $collectionId = $request->input('collectionId', 'default'); // Use 'default' if not provided

        $result = $this->favoriteService->isFavorite($productID, $clientId, $collectionId);

        if ($result['success']) {
            return response()->json([
                'status' => 'success',
                'success' => true,
                'isFavorite' => $result['isFavorite'],
                'message' => $result['message'],
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => $result['message'],
            ], 400);
        }
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
        
        $result = $this->favoriteService->removeFromFavorites($customerId, $collectionId,$productID);
        // echo "<pre>";
        // print_r($result);
        // exit;

        if ($result['success']) {
            return response()->json([
                'status' => ($result['success']) ? 'success' : 'fail',
                'success' => $result['success'],
                // 'isFavorite' => $result['isFavorite'],
                'message' => $result['message'],
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'success' => false,
                'message' => $result['message'],
            ], 400);
        }

        // return response()->json(['status' => 'success']);
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
        $action = $request->input('action');
        $collectionName = $request->input('collectionName');
        $customerId = $request->input('clientId');

        if ($action === 'create') {
            $result = $this->favoriteService->createCollection($collectionName, $customerId);
            if ($result['success']) {
                return response()->json(['status' => 'success', 'collectionId' => $result['collectionId'], 'collectionName' => $result['collectionName']]);
            } else {
                return response()->json(['status' => 'error', 'message' => $result['message']], 500);
            }
        } elseif ($action === 'delete') {
            $collectionId = $request->input('collectionId');
            $result = $this->favoriteService->deleteCollection($collectionId, $customerId);
            if ($result['success']) {
                return response()->json(['status' => 'success']);
            } else {
                return response()->json(['status' => 'error', 'message' => $result['message']], 500);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Invalid action specified'], 400);
        }
    }

    // Inside FavoritesController
    public function getCollections(Request $request)
    {
        $customerId = $request->input('clientId');

        $result = $this->favoriteService->getCollections($customerId);

        if ($result['success']) {
            return response()->json(['collections' => $result['collections']]);
        } else {
            return response()->json(['message' => $result['message']], 500);
        }
    }
}
