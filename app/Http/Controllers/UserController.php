<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Traits\LocaleTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    use LocaleTrait;

    function showAccount(){
        $country = 'us';
        $locale = $this->getLocaleByCountry($country);

        App::setLocale($locale);

        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        return view('auth.user.account', [
            'menu' => $menu,
            'sale' => $sale,
            'country' => $country,
            'search_query' => ''
        ]);
    }
    
    function showCart(){
        $country = 'us';
        $locale = $this->getLocaleByCountry($country);

        App::setLocale($locale);

        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        return view('auth.user.cart', [
            'menu' => $menu,
            'sale' => $sale,
            'country' => $country,
            'search_query' => ''
        ]);
    }
    
    function showCheckout(){
        $country = 'us';
        $locale = $this->getLocaleByCountry($country);

        App::setLocale($locale);

        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        return view('auth.user.checkout', [
            'menu' => $menu,
            'sale' => $sale,
            'country' => $country,
            'search_query' => ''
        ]);
    }
    
    function showWishlist(){
        $country = 'us';
        $locale = $this->getLocaleByCountry($country);

        App::setLocale($locale);

        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');
        
        return view('auth.user.wishlist', [
            'menu' => $menu,
            'sale' => $sale,
            'country' => $country,
            'search_query' => ''
        ]);
    }
}
