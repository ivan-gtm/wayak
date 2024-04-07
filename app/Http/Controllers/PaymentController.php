<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PayPalService;
use App\Services\UserPurchaseService;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    protected $paypalService;
    protected $userPurchaseService;

    public function __construct(UserPurchaseService $userPurchaseService, PayPalService $paypalService)
    {
        $this->userPurchaseService = $userPurchaseService;
        $this->paypalService = $paypalService;
    }

    public function validatePayment($country, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customerId' => 'required|string|alpha_num|min:10|max:10',
            'templateId' => 'required|string|alpha_num|min:10|max:10', // Assuming you'll send an array of template IDs.
            'orderID' => 'required|string|alpha_num|min:17|max:17', // Assuming you'll send an array of template IDs.
        ]);

        if ($validator->fails()) {
            return response()->json([
                'paymentValid' => false,
                'error' => 'Failed to validate request.'
            ], 400);
        }

        // echo "<pre>";
        // print_r( $request->all() );
        // exit;
        // // print_r($validationResult['config:cache']);

        // orderId:"39704775YW282013J"
        // payerId: "C7RLQ4M4JLSMU"
        
        $orderID = $request->orderID;
        // $orderID = "39704775YW282013J";

        // Validate the order ID
        $validationResult = $this->paypalService->validateOrder($orderID);
        
        // echo "<pre>";
        // print_r( $validationResult );
        // exit;

        if ($validationResult['success']) {
            
            // ($requestCustomerID, $requestTemplateId)
            if ($this->storePayment($request->customerId, $request->templateId)) {
                // Process the successful validation result
                return response()->json([
                    'paymentValid' => true,
                    'message' => 'Payment validated successfully.'
                ]);
            } else {
                // Handle validation failure
                return response()->json([
                    'paymentValid' => false,
                    'error' => 'Failed to validate payment.'
                ], 401);
            }

        } else {
            // Handle validation failure
            return response()->json([
                'paymentValid' => false,
                'error' => 'Failed to validate payment.'
            ], 400);
        }
    }

    // Store: Almacenar una nueva compra realizada por el usuario en la base de datos.
    public function storePayment($requestCustomerID, $requestTemplateId)
    {
        
        // Validate and retrieve the customer ID
        $customerId = $this->userPurchaseService->getCustomerId($requestCustomerID);
        
        
        if(strlen($customerId) == 0){
            return false;
        }
        
        // Store the template IDs in Redis under the user's purchases
        $this->userPurchaseService->storePurchaseInRedis($customerId, $requestTemplateId);
        return true;
    }
}
