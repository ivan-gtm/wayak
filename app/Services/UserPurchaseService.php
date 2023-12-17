<?php

namespace App\Services;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPurchaseService
{
    public function getPurchases($customerId)
    {
        // Construct the Redis key for the user's purchases
        $redisKey = 'wayak:user:' . $customerId . ':purchases';

        // Use Redis to retrieve the list of template IDs purchased by the user
        $purchaseTemplateIds = Redis::smembers($redisKey);

        // Return the list of purchased template IDs as JSON response
        return $purchaseTemplateIds;
    }

    public function isTemplateIdInPurchases($customerId, $templateId) {
        $purchases = $this->getPurchases($customerId);
        return in_array($templateId, $purchases);
    }

    public function storePurchaseInRedis($customerId, $templateId)
    {
        $redisKey = 'wayak:user:' . $customerId . ':purchases';
        Redis::sadd($redisKey, $templateId);
    }

    public function validateAndGetCustomerId(Request $request)
    {
        $user = Auth::user();
        
        if ($user) {
            return $user->customer_id;
        } elseif ($request->filled('customerId')) {
            return $request->input('customerId');
        } else {
            abort(404); // Not Found
        }
    }
}
