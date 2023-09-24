<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Exception;

class AnalyticsController extends Controller
{
    function registerVisitCategory($country, $category_slug_id)
    {
        try {
            $redisKey = 'wayak:' . $country . ':analytics:categories';

            // Use Redis transaction
            Redis::transaction(function ($tx) use ($redisKey, $category_slug_id) {
                if ($tx->hexists($redisKey, $category_slug_id)) {
                    $tx->hincrby($redisKey, $category_slug_id, 1);
                } else {
                    $tx->hset($redisKey, $category_slug_id, 1);
                }
            });

            return true;
        } catch (Exception $e) {
            // Consider logging the exception for debugging purposes
            return false;
        }
    }

    function registerPublicSearch($country, $searchSlug, $searchQuery)
    {
        try {
            $redisKeyResults = 'wayak:' . $country . ':analytics:search:results';
            $redisKeyTerms = 'wayak:' . $country . ':analytics:search:terms';

            if (Redis::hexists($redisKeyResults, $searchSlug)) {
                Redis::hincrby($redisKeyResults, $searchSlug, 1);
            } else {
                // Use pipelining for multiple Redis commands
                Redis::pipeline(function ($pipe) use ($redisKeyResults, $redisKeyTerms, $searchSlug, $searchQuery) {
                    $pipe->hset($redisKeyTerms, $searchSlug, $searchQuery);
                    $pipe->hset($redisKeyResults, $searchSlug, 1);
                });
            }
            return true;
        } catch (Exception $e) {
            // Consider logging the exception for debugging purposes
            return false;
        }
    }

    function registerProductView($template_id)
    {
        try {
            // Directly increment the value. If the key doesn't exist, Redis will create it.
            Redis::hincrby('analytics:template:views', $template_id, 1);
        } catch (Exception $e) {
            // Consider logging the exception for debugging purposes
            // Log::error("Error registering product view: " . $e->getMessage());
        }
    }
}
