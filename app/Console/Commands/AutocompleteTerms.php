<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class AutocompleteTerms extends Command
{
    protected $signature = 'utils:autocomplete-terms';

    protected $description = '';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // $this->info('Fetching up to 10 completed templates...');
        $country = 'us';
        $menu = $this->getMenu($country);
        
        foreach ($menu->templates as $category) {
            $term = $category->name;
            $this->addTerm($country,$term);
            $this->info("\nCAT >>".$category->name);
        }
        // print_r($menu);
    }

    private function getMenu($country) {
        $redisKey = 'wayak:'.$country.':menu';
        return json_decode(Redis::get($redisKey));
    }

    private function addTerm($country,$term)
    {
        $term = strtolower($term);

        // Store the term in a Redis set
        Redis::sAdd('wayak:'.$country.':terms', $term);

        // Generate all substrings and create an inverted index for each one
        $length = strlen($term);
        for ($i = 0; $i < $length; $i++) {
            for ($j = $i + 1; $j <= $length; $j++) {
                $substring = substr($term, $i, $j - $i);
                Redis::sAdd('wayak:'.$country.':index:' . $substring, $term);
            }
        }

        return response()->json(['message' => 'Term added successfully']);
    }
}
