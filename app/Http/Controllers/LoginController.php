<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\App;

// Source: https://codeanddeploy.com/blog/laravel/laravel-8-authentication-login-and-registration-with-username-or-email
class LoginController extends Controller
{
    /**
     * Display login page.
     * 
     * @return Renderable
     */
    public function show()
    {
        $country = 'us';
        $locale = 'en';

        App::setLocale($locale);

        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        return view('auth.login', [
            'menu' => $menu,
            'sale' => $sale,
            'country' => $country,
            'search_query' => ''
        ]);
    }

    /**
     * Handle account login request
     * 
     * @param LoginRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if (!Auth::validate($credentials)) {
            return response()->json(['success' => false, 'message' => trans('auth.failed')], 401);
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        Auth::login($user);

        return $this->authenticated($request, $user);
    }

    protected function authenticated(Request $request, $user)
    {
        return response()->json(['success' => true, 'redirect_url' => url()->previous()]);
    }
}
