<?php

namespace App\Services;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\HomeCarouselsService;

class UserPurchaseService
{
    protected $homeCarouselService;

    public function __construct(HomeCarouselsService $homeCarouselService)
    {
        $this->homeCarouselService = $homeCarouselService;
    }

    public function getPurchases($customerId)
    {
        // Construct the Redis key for the user's purchases
        $redisKey = 'wayak:user:'.$customerId.':purchases';

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
        $this->homeCarouselService->buildPurchasesCarousels($customerId, $templateId);
    }

    public function getCustomerId($requestCustomerId)
    {
        $user = Auth::user();
        if ($user) {
            return $user->customer_id;
        }

        return $requestCustomerId;
    }
}
