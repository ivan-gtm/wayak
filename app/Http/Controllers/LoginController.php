<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    public function showLinkRequestForm(Request $request, $token = null)
    {
        $country = 'us';
        $locale = 'en';

        App::setLocale($locale);

        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        return view('auth.passwords.reset',['country' => $country, 'menu' => $menu, 'sale' => $sale, 'search_query' => null,
        'token' => $token, 'email' => $request->email]);
    }

    public function showResetForm()
    {
        $country = 'us';
        $locale = 'en';

        App::setLocale($locale);

        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        return view('auth.passwords.email')->with(
            [   'country' => $country, 'menu' => $menu, 'sale' => $sale, 'search_query' => null]
        );
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Validate the email
        $request->validate(['email' => 'required|email']);

        // Generate a token
        $token = Str::random(60);

        // Store the token in the database with the user's email and a timestamp
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Send the token to the user's email (this is a basic example, you'd use a queued job for better performance)
        Mail::send('emails.password', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Password Reset Request');
        });

        return back()->with('status', 'We have emailed your password reset link!');
    }

    public function reset(Request $request)
    {
        $request->validate([
            '_token' => 'required|string',
            'reset_token' => 'required',
            // 'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|same:password'
        ]);

        // Verify if the token is valid (also check if it's not older than, say, 60 minutes)
        $passwordReset = DB::table('password_resets')
            ->where('token', $request->reset_token)
            ->where('created_at', '>', now()->subMinutes(60))
            ->first();
        
        if (!$passwordReset) {
            return back()->withErrors(['email' => 'This password resset token is invalid.']);
        }

        // Reset the password
        $user = User::where('email', $passwordReset->email)->first();

        
        $user->password = $request->password;
        $user->save();
        
        // Delete the token
        DB::table('password_resets')->where('email', $passwordReset->email)->delete();
        
        return redirect('/login')->with('status', 'Your password has been reset!');
        
        // echo "<pre>";
        // print_r($request->password);
        // print_r($request->all() );
        // print_r( $passwordReset );
        // print_r($user );
        // // // print_r($passwordReset);
        // // // print_r($passwordReset);
        // exit;
    }
}
