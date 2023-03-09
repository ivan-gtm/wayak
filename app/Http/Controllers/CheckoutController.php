<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;



class CheckoutController extends Controller
{
    public function cart(){
        return view('cart.checkout', [
        ]);
    }

    public function generateAccessToken(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api-m.paypal.com/v1/oauth2/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'grant_type=client_credentials&ignoreCache=true&return_authn_schemes=true&return_client_metadata=true&return_unconsented_scopes=true',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic QVV2OHJyY19QLUViUDJFMG1wYjQ5QlY3ckZ0M1Vzci12ZFVaTzhWR09ualJlaEdIQlhrU3pjaHIzN1NZRjJHTmRRRllTcDcyamg1UVVoekc6RU1uQVdlMDZpb0d0b3VKczdnTFlUOWNoSzktMmpKLS03TUtSWHBJOEZlc21ZXzJLcC1kXzdhQ3FmZjdNOW1vRUpCdnVYb0JPNGNsS3RZMHY=',
            'Content-Type: application/x-www-form-urlencoded'
        ),
        ));

        $response = curl_exec($curl);
                
        curl_close($curl);
        
        $response_obj = json_decode($response);
        
        echo "<pre>";
        print_r($response_obj);
        exit;
        return $response_obj->access_token;
    }
    
    public function createOrder(){
        $access_token = self::generateAccessToken();
        // exit;

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api-m.paypal.com/v2/checkout/orders',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "intent": "CAPTURE",
            "purchase_units": [
                {
                    "items": [
                        {
                            "name": "T-Shirt",
                            "description": "Green XL",
                            "quantity": "1",
                            "unit_amount": {
                                "currency_code": "USD",
                                "value": "1"
                            }
                        }
                    ],
                    "amount": {
                        "currency_code": "USD",
                        "value": "1",
                        "breakdown": {
                            "item_total": {
                                "currency_code": "USD",
                                "value": "1"
                            }
                        }
                    }
                }
            ],
            "application_context": {
                "return_url": "https://example.com/return",
                "cancel_url": "https://example.com/cancel"
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Prefer: return=representation',
            // 'PayPal-Request-Id: b102f3a0-ec48-48f0-9a8f-943665e23674',
            'Authorization: Bearer '.$access_token
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        echo $response;
        // $response_obj = json_decode($response);
        // echo "<pre>";
        // print_r($response_obj);

    }
    
    public function capturePayment(Request $request){
        $access_token = self::generateAccessToken();
        $order_id = $request->order_id;
        // echo $request->order_id;
        // exit;

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api-m.paypal.com/v2/checkout/orders/'.$order_id.'/capture',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Prefer: return=representation',
            'PayPal-Request-Id: 888c7e0c-bf08-419b-8593-87e19ef64c0a',
            'Authorization: Bearer '.$access_token
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function handleResponse(){

    }
}
