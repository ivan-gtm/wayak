<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
// use App\Models\Template;
use Artisan;


class SalesManagerController extends Controller {

    const REDIS_KEY_PREFIX = 'wayak';
    const DEFAULT_COUNTRY = 'us';

    public function manageCampaign(Request $request) {
        $country = self::DEFAULT_COUNTRY;
        $languageCode = $this->getCountryLanguage($country);
        $redisKey = $this->getRedisKey($country);

        $activeCampaign = $this->getActiveCampaign($redisKey);

        if ($request->has('delete_campaign')) {
            $this->deleteCampaign($redisKey);
        } elseif ($request->has('discount_percentage')) {
            $this->updateCampaign($redisKey, $request);
        }

        return view('admin.sales_manager', [
            'language_code' => $languageCode,
            'country' => $country,
            'active_campaign' => $activeCampaign
        ]);
    }
    
    private function getRedisKey($country) {
        return self::REDIS_KEY_PREFIX . ':' . $country . ':config:sales';
    }

    private function getActiveCampaign($redisKey) {
        return Redis::hgetall($redisKey);
    }

    private function deleteCampaign($redisKey) {
        Redis::del($redisKey);
    }

    private function updateCampaign($redisKey, $request) {
        // Additional validation can be added here
        Redis::hset($redisKey, 'site_banner_txt', $request->site_banner_txt);
        Redis::hset($redisKey, 'site_banner_btn', $request->site_banner_btn);
        Redis::hset($redisKey, 'discount_percentage', $request->discount_percentage);
        Redis::hset($redisKey, 'sale_ends_at', $request->sale_ends_at);
        Redis::hset($redisKey, 'status', 0);
        
        $discountPercentage = $request->discount_percentage;
    
        // Dispatch the command
        Artisan::queue('campaign:update-templates', [
            'redisKey' => $redisKey,
            'discountPercentage' => $discountPercentage
        ]);

        // $this->updateTemplatesWithCampaignDetails($request->discount_percentage);

        $remainingSeconds = $this->remainingSecondsUntilUtcDate($request->sale_ends_at);
        Redis::expire($redisKey, $remainingSeconds);
    }

    /**
     * Calculates the remaining seconds until a given UTC date.
     *
     * @param string $dateString The date in a format understandable by strtotime.
     * @return int The number of remaining seconds, or false on failure.
     */
    private function remainingSecondsUntilUtcDate($dateString) {
        $targetTimestamp = strtotime($dateString);
        if ($targetTimestamp === false) {
            // Handle invalid date string
            return false;
        }

        $currentTimestamp = time();
        $remainingSeconds = $targetTimestamp - $currentTimestamp;

        return $remainingSeconds;
    }

    private function getCountryLanguage($country){
        if( $country == 'mx' ){
            $language_code = 'es';
        } else {
            $language_code = 'en';
        }

        return $language_code;
    }

    // private function updateTemplatesWithCampaignDetails($discountPercentage) {
    //     $newPriceCalculation = function ($template) use ($discountPercentage) {
    //         return $template->prices['original_price'] * (1 - $discountPercentage / 100);
    //     };

    //     Template::all()->each(function ($template) use ($newPriceCalculation, $discountPercentage) {
    //         $newPrice = $newPriceCalculation($template);
    //         $template->update([
    //             'prices.price' => $newPrice,
    //             'prices.discount_percent' => $discountPercentage
    //         ]);
    //     });
    // }

}
