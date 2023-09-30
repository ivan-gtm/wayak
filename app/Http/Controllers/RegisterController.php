<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterRequest;
use App\Traits\LocaleTrait;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

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

        $locale = $this->getLocaleByCountry($country);

        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        return view('auth.register', [
            'menu' => $menu,
            'sale' => $sale, 
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
        
        // echo "<pre>";
        // print_r($userData);
        // exit;

        $user = User::create($userData);
        // $user = User::create($request->validated());
        

        
        auth()->login($user);


        $user->verification_token = $this->generateVerificationToken();

        $this->sendVerificationEmail($user);

        // Generate a verification code (you can also use your generateVerificationToken function)
        $verificationCode = rand(100000, 999999);

        // Store the code in your database (or cache)
        // ...

        // // Send the verification SMS
        // $smsStatus = $this->sendVerificationSms($user, $verificationCode);

        return redirect('/')->with('success', "Account successfully registered.");
    }

    public function sendVerificationEmail($user)
    {
        $verificationLink = url('/verify-email/' . $user->verification_token);

        Mail::send('emails.auth.verify', ['user' => $user, 'verificationLink' => $verificationLink], function ($message) use ($user) {
            $message->from(config('mail.from.address'), config('mail.from.name'));
            $message->to($user->email);
            $message->subject('243859 is your verification code');
        });

        if (Mail::failures()) {
            return 'Email not sent.';
        }

        return 'Email sent successfully';
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
