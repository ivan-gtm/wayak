<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use App\Traits\LocaleTrait;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// Source: https://codeanddeploy.com/blog/laravel/laravel-8-authentication-login-and-registration-with-username-or-email
class LoginController extends Controller
{
    use LocaleTrait;

    /**
     * Display login page.
     * 
     * @return Renderable
     */
    public function show()
    {
        $country = 'us';
        $locale = $this->getLocaleByCountry($country);

        App::setLocale($locale);

        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        return view('auth.login', [
            'menu' => $menu,
            'sale' => $sale,
            'country' => $country,
            'search_query' => '',
            'customer_id' => ''
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
            $errorResponse = ['success' => false, 'message' => trans('auth.failed')];

            return $request->expectsJson()
                ? response()->json($errorResponse, 401)
                : redirect()->back()->withInput($request->only('email', 'remember'))->withErrors($errorResponse);
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        Auth::login($user);

        return $this->authenticated($request, $user);
    }


    protected function authenticated(Request $request, $user)
    {
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'redirect_url' => url()->previous()]);
        }

        // For conventional requests, redirect to the intended location or default to the home page
        // return redirect()->intended('/');
        return redirect()->to(url()->previous());
    }


    public function showLinkRequestForm(Request $request, $token)
    {
        $country = 'us';
        $locale = $this->getLocaleByCountry($country);

        App::setLocale($locale);

        // Validate the token
        $tokenData = DB::table('password_resets')
            ->where('token', $token)
            // ->where('email', $request->email)
            ->first();

        if (!$tokenData) {
            // Token not found in the database
            return redirect('password/reset')->withErrors(['email' => 'The password reset token is invalid.']);
        }

        // Check if token has expired
        $tokenCreatedAt = \Carbon\Carbon::parse($tokenData->created_at);
        if ($tokenCreatedAt->addMinutes(config('auth.passwords.' . config('auth.defaults.passwords') . '.expire'))->isPast()) {
            // Token has expired
            return redirect('password/reset')->withErrors(['email' => 'The password reset token has expired.']);
        }

        // password_resets
        $user = User::where('email', $tokenData->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that e-mail address.']);
        }

        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        return view('auth.passwords.reset', [
            'country' => $country, 'menu' => $menu, 'sale' => $sale, 'search_query' => null,
            'token' => $token, 'email' => $request->email,
            'customer_id' => $user->customer_id
        ]);
    }


    public function showResetForm(Request $request)
    {
        $country = 'us';
        $validator = Validator::make($request->all(), [
            'customerId' => 'required|string|alpha_num|min:10|max:10', // Assuming clientId is between 8 and 20 characters
        ]);

        if ($validator->fails()) {
            abort(404); // Unprocessable Entity
        }

        $locale = $this->getLocaleByCountry($country);

        App::setLocale($locale);

        if (Auth::check()) {
            $user = Auth::user();
            $customer_id =  $user->customer_id;
        } elseif (isset($request->customerId)) {
            $customer_id = isset($request->customer_id) ? $request->customer_id : null;
        }

        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        return view('auth.passwords.email')->with(
            [
                'country' => $country,
                'customer_id' => $customer_id,
                'menu' => $menu,
                'sale' => $sale,
                'customer_id' => isset($user->customer_id) ? $user->customer_id : null,
                'search_query' => null
            ]
        );
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Validate the email
        $request->validate(['email' => 'required|email']);

        // Check if the user exists
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that e-mail address.']);
        }

        // Generate a token
        $token = Str::random(60);

        // Store the token in the database with the user's email and a timestamp
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Send the token to the user's email (this is a basic example, you'd use a queued job for better performance)
        Mail::send('emails.password', ['token' => $token,'customerId' => $user->customer_id], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Password Reset Request');
        });

        return back()->with('status', 'We have emailed your password reset link!');
    }

    public function reset(Request $request)
    {
        // Validate the request input
        $request->validate([
            '_token' => 'required|string',
            'reset_token' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $errors = [];

        // Verify if the token is valid and not older than 60 minutes
        $passwordReset = DB::table('password_resets')
            ->where('token', $request->reset_token)
            ->where('created_at', '>', now()->subMinutes(60))
            ->first();

        if (!$passwordReset) {
            $errors['reset_token'] = 'This password reset token is invalid or has expired.';
        }

        // Check if the user exists
        $user = User::where('email', $passwordReset->email ?? '')->first();
        if (!$passwordReset || !$user) {
            $errors['email'] = 'We can\'t find a user with that e-mail address.';
        }

        // If there are any errors, return with them
        if (!empty($errors)) {
            return back()->withErrors($errors);
        }

        // Reset the password
        DB::table('users')
            ->where('email', $passwordReset->email)
            ->update(['password' => Hash::make($request->password)]);

        // Delete the token
        DB::table('password_resets')->where('token', $request->reset_token)->delete();

        return redirect('/login')->with('status', 'Your password has been reset!');
    }
}
