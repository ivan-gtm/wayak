<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class AutocompleteController extends Controller
{
    public function addTerm(Request $request)
    {
        $term = $request->input('term');

        for ($i = 1; $i <= strlen($term); $i++) {
            $prefix = substr($term, 0, $i);
            Redis::zAdd('wayak:us:autocomplete', 0, $prefix);
        }

        Redis::zAdd('wayak:us:autocomplete', 0, "$term*");

        return response()->json(['message' => 'Term added successfully']);
    }

    public function search(Request $request)
    {
        $prefix = $request->input('prefix');
        $results = Redis::zRangeByLex('wayak:us:autocomplete', "[$prefix", "[$prefix\xff");

        // Filter out results that don't match the exact prefix
        $matches = [];
        foreach ($results as $result) {
            if (strpos($result, '*') !== false) {
                $matches[] = str_replace('*', '', $result);
            }
        }

        return response()->json($matches);
    }
}
