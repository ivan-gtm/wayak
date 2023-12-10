<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\LocaleTrait;
use App\Models\Template;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserPurchaseController extends Controller
{
    // Mostrar la lista de compras del usuario
    public function index($country, Request $request){
    {
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
    
            $total_documents = Template::whereIn('_id', $favorites)->count();
            $last_page = ceil($total_documents / $per_page);
        }

        return view('auth.user.purchases.index',[
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

    // Mostrar los detalles de una compra específica
    public function show($id)
    {
        // Consulta la base de datos para obtener los detalles de la compra
        $purchase = []; // Supongamos que esto es una compra específica

        return view('user_purchases.show', compact('purchase'));
    }

    // Otras funciones como create, store, edit, update, destroy, etc.
}
