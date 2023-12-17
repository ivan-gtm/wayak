<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Traits\LocaleTrait;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;
use Aws\Exception\AwsException;
use Aws\Sns\SnsClient;
use Aws\Ses\SesClient;
use Aws\Ses\Exception\SesException;

class RegisterController extends Controller
{
    use LocaleTrait;

    /**
     * Display register page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $country = 'us';
        $locale = $this->getLocaleByCountry($country);
        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        return view('auth.register', [
            'menu' => $menu,
            'sale' => $sale, 
            'customer_id' => null,
            'country' => $country,
            'search_query' => ''
        ]);
    }

    /**
     * Handle account registration request
     * 
     * @param RegisterRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $userData = $request->validated();
        $userData['customer_id'] = $request->input('customerId');
        $userData['verification_token'] = $this->generateVerificationToken();
    
        DB::beginTransaction();
    
        try {
            $user = User::create($userData);
    
            $emailStatus = $this->sendVerificationEmail($user);
    
            if ($emailStatus !== true) {
                throw new Exception('Failed to send verification email.');
            }
    
            DB::commit();
            return redirect('/')->with('success', 'Account successfully registered. Please check your email to verify.');
    
        } catch (Exception $e) {
            DB::rollBack();
            return redirect('/')->with('error', $e->getMessage());
        }
    }
    
    public function sendVerificationEmail($user)
    {
        $verificationLink = url('/verify-email/' . $user->verification_token);

        try {
            Mail::send('emails.auth.verify', ['user' => $user, 'verificationLink' => $verificationLink], function ($message) use ($user) {
                $message->from(config('mail.from.address'), config('mail.from.name'));
                $message->to($user->email);
                $message->subject('Please verify your email');
            });

            if (Mail::failures()) {
                throw new Exception('Email not sent.');
            }

            return true;
        } catch (Exception $e) {
            report($e);
            return false;
        }
    }


    public function verifyEmail($verificationToken)
    {
        // Find the user by the verification token
        $user = User::where('verification_token', $verificationToken)->first();

        if (!$user) {
            // No user was found with this verification token
            return redirect('/')->with('error', 'Invalid verification link.');
        }

        // Update the user's verification status
        $user->email_verified_at = now();
        $user->verification_token = null; // Clear the verification token
        $user->save();

        // Optionally, automatically log the user in
        auth()->login($user);

        // Redirect to a verified page or with a success message
        return redirect('/')->with('success', 'Email successfully verified.');
    }

    public function generateVerificationToken()
    {
        return Str::random(32);
    }

    public function sendVerificationSms($user, $verificationCode)
    {
        $snsClient = new SnsClient([
            'region' => config('AWS_DEFAULT_REGION'),
            'version' => 'latest',
            'credentials' => [
                'key' => config('AWS_ACCESS_KEY_ID'),
                'secret' => config('AWS_SECRET_ACCESS_KEY'),
            ]
        ]);

        $message = "Your verification code is: {$verificationCode}";

        try {
            $result = $snsClient->publish([
                'Message' => $message,
                'PhoneNumber' => $user->phone_number, // Make sure this is a valid phone number in E.164 format
            ]);

            return 'SMS sent successfully';
        } catch (AwsException $e) {
            return 'SMS not sent. ' . $e->getAwsErrorMessage();
        }
    }

    public function registerByPhoneNumber(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        auth()->login($user);

        $user->verification_token = $this->generateVerificationToken();

        $this->sendVerificationSms($user, $user->verification_token);

        return redirect('/')->with('success', "Account successfully registered.");
    }
}
