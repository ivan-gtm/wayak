<?php

namespace App\Services;
use App\Services\UserPurchaseService;


class PayPalService
{
    protected $userPurchaseService;
    
    public function __construct(UserPurchaseService $userPurchaseService)
    {
        $this->userPurchaseService = $userPurchaseService;
    }

    public function getAccessToken()
    {
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_SECRET');
        $credentials = base64_encode($clientId . ":" . $clientSecret);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-m.sandbox.paypal.com/v1/oauth2/token',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials&ignoreCache=true&return_authn_schemes=true&return_client_metadata=true&return_unconsented_scopes=true',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: Basic ' . $credentials
            ),
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);
        $errorCode = curl_errno($curl);

        curl_close($curl);

        if ($errorCode) {
            // Handle cURL error scenario
            return [
                'success' => false,
                'error' => $error,
                'errorCode' => $errorCode
            ];
        }

        $responseArray = json_decode($response, true);

        // echo "<pre>";
        // echo "<pre>";
        // print_r($clientId);
        // echo "<br>";
        // print_r($clientSecret);
        // echo "<br>";
        // print_r($responseArray);
        // exit;

        if (isset($responseArray['access_token'])) {
            // If the request was successful and an access_token is present
            return [
                'success' => true,
                'access_token' => $responseArray['access_token'],
                'token_type' => $responseArray['token_type'],
                'expires_in' => $responseArray['expires_in']
            ];
        } else {
            // Handle scenario where response is successful but access_token is not present
            return [
                'success' => false,
                'response' => $responseArray
            ];
        }
    }

    public function validateOrder($orderID)
    {
        // Assuming you have a method in this service to get an access token from PayPal
        $accessToken = $this->getAccessToken();
        // $validationResult = $this->paypalService->generateAccessToken($clientId, $clientSecret);
        // echo "<pre>";
        // echo "<br>";
        // print_r($accessToken);
        // exit;

        $curl = curl_init("https://api-m.sandbox.paypal.com/v2/checkout/orders/$orderID");
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer ".$accessToken['access_token']
            ],
        ]);

        $response = curl_exec($curl);
        
        // echo "<pre>";
        // print_r($response);
        // exit;

        $error = curl_error($curl);
        curl_close($curl);

        if ($error) {
            return ['success' => false, 'error' => $error];
        }

        $orderDetails = json_decode($response, true);

        // echo "<pre>";
        // print_r($orderDetails);
        // exit;

        return ['success' => true];
    }
}
