<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class StorePopularSearches extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:popular-searches {country}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store top 10 popular searches in a new Redis key';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $country = $this->argument('country');

        $this->getTop10PopularSearches($country);

        // // Store the results in a new Redis key
        // $newRedisKey = 'wayak:' . $country . ':top10:popular:searches';
        // Redis::set($newRedisKey, $popularSearches);

        $this->info('Top 10 popular searches have been stored in Redis.');

        return 0;
    }

    function getTop10PopularSearches($country)
    {
        try {
            $redisKeyResults = 'wayak:' . $country . ':analytics:search:results';
            $redisKeyTerms = 'wayak:' . $country . ':analytics:search:terms';

            // Fetch all searches and their counts
            $searchCounts = Redis::hgetall($redisKeyResults);

            // Sort the searches by counts in descending order
            arsort($searchCounts);

            // Take top 10 searches
            $topSearches = array_slice($searchCounts, 0, 10, true);

            $result = [];
            foreach ($topSearches as $slug => $count) {
                $term = Redis::hget($redisKeyTerms, $slug);
                $result[] = [
                    'slug' => $slug,
                    'term' => $term,
                    'count' => $count
                ];
            }

            // return json_encode($result);
            Redis::set('wayak:' . $country . ':analytics:search:top-results',json_encode($result));

        } catch (Exception $e) {
            // Consider logging the exception for debugging purposes
            return json_encode(['error' => 'Failed to fetch popular searches']);

        }
    }
}
