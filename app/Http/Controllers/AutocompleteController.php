<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class AutocompleteController extends Controller
{
    public function addTerm(Request $request)
    {
        $term = $request->input('term');

        // Store the term in a Redis set
        Redis::sAdd('wayak:us:terms', $term);

        // Generate all substrings and create an inverted index for each one
        $length = strlen($term);
        for ($i = 0; $i < $length; $i++) {
            for ($j = $i + 1; $j <= $length; $j++) {
                $substring = substr($term, $i, $j - $i);
                Redis::sAdd('wayak:us:index:' . $substring, $term);
            }
        }

        return response()->json(['message' => 'Term added successfully']);
    }

    public function getTopSearches(Request $request, $country)
    {
        $redisKey = 'wayak:' . $country . ':analytics:search:top-results';
        $data = Redis::get($redisKey);

        if (!$data) {
            return response()->json(['error' => 'No data found for the specified country.'], 404);
        }

        return response()->json(json_decode($data, true));
    }

    public function search(Request $request)
    {
        $query = $request->input('prefix');
        
        // Retrieve terms from the inverted index
        $results = Redis::sMembers('wayak:us:index:' . $query);

        return response()->json($results);
    }
}
