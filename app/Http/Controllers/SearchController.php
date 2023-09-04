<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\App;

class SearchController extends Controller
{
    public function showSearchPage($country, Request $request){
        $language_code = 'en';
        $menu = json_decode(Redis::get('wayak:'.$country.':menu'));
        $sale = Redis::hgetall('wayak:'.$country.':config:sales');
        
        $search_query = $request->searchQuery ?? null;
        $category = $request->category ?? null;
        $minPrice = $request->minPrice ?? null;
        $maxPrice = $request->maxPrice ?? null;
        
        $customer_id = $request->customerId ?? null;
        
        $page = $request->page ?? 1;
        $per_page = 100;
        $skip = $per_page * ($page - 1);

        $search_id = $this->generateSearchId($search_query);
        $this->recordSearchAnalytics($country, $search_id, $search_query);
        $this->updateUserSearchHistory($customer_id, $search_id);
        
        $result = (new Template())->filterDocuments($search_query, $category, $minPrice, $maxPrice,$request->sale, $skip, $per_page);
        $total_documents = $result['total'];
        $search_result = $result['documents'];

        // echo "<pre>";
        // print_r($result);
        // exit;
    
        $last_page = ceil($total_documents / $per_page);
        $from_document = $skip + 1;
        $to_document = $skip + $per_page;
        $templates = $this->prepareTemplates($search_result, $language_code);
    
        return view('content.search',[
            'country' => $country,
            'language_code' => $language_code,
            'menu' => $menu,
            'sale' => $sale,
            'search_query' => $search_query,
            'category' => $category,
            'current_page' => $page,
            'first_page' => 1,
            'pagination_begin' => max($page-4, 1),
            'pagination_end' => min($page+4, $last_page),
            'last_page' => $last_page,
            'from_document' => $from_document,
            'to_document' => $to_document,
            'total_documents' => $total_documents,
            'templates' => $templates
        ]);
    }

    
    public function updateUserSearchHistory($customerId, $searchTermId)
    {
        /// Make $customerId and $searchTermId required
        if (!$customerId || !$searchTermId) {
            return response()->json(['message' => 'customerId and searchTermId are required'], 400);
        }

        // Define the Redis key for storing the search history of this customer
        $key = "wayak:user:{$customerId}:history:navigation";
        
        // Fetch the current data for this search term from Redis
        $existingDataJSON = Redis::hget($key, $searchTermId);
        $existingData = $existingDataJSON ? json_decode($existingDataJSON, true) : null;

        // Generate current Unix timestamp
        $currentTime = time();

        if ($existingData) {
            // If data exists, increment the counter and update the timestamp
            $existingData['lastSearched'] = $currentTime;
            $existingData['counter']++;
        } else {
            // If data doesn't exist, initialize it
            $existingData = [
                'lastSearched' => $currentTime,
                'counter' => 1
            ];
        }

        // Save the updated search term data back to Redis as a JSON-encoded string
        Redis::hset($key, $searchTermId, json_encode($existingData));

        return response()->json(['message' => 'User search history updated successfully']);
        
    }

    public function searchByTitle(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $documents = (new Template())->searchByTitle($searchTerm);
        return response()->json($documents);
    }

    public function searchByTitleAndCategory(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $category = $request->input('category');
        $documents = (new Template())->searchByTitleAndCategory($searchTerm, $category);
        return response()->json($documents);
    }

    public function getFormatsTotals()
    {
        $formatCounts = (new Template())->getTotalDocumentsByFormat();
        return response()->json($formatCounts);
        // echo "<pre>";
        // print_r(json_encode($formatCounts));
        // exit;
    }

    public function filterBySearchTermAndPrice(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $minPrice = $request->input('minPrice');
        $maxPrice = $request->input('maxPrice');

        $documents = (new Template())->filterBySearchTermAndPrice($searchTerm, $minPrice, $maxPrice);

        return response()->json($documents);
    }

    private function recordSearchAnalytics($country, $search_id, $searchQuery) {
        if (Redis::hexists('wayak:'.$country.':analytics:search:results', $search_id)) {
            Redis::hincrby('wayak:'.$country.':analytics:search:results', $search_id, 1);
        } else {
            Redis::hset('wayak:'.$country.':analytics:search:terms', $search_id, $searchQuery);
            Redis::hset('wayak:'.$country.':analytics:search:results', $search_id, 1);
        }
    }

    private function generateSearchId($searchQuery) {
        return self::generateIdentifier($searchQuery);
    }

    private function prepareTemplates($search_result, $language_code) {
        $templates = [];
        foreach ($search_result as $template) {
            $template->preview_image = App::environment() == 'local'
                ? asset('design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["carousel"])
                : Storage::disk('s3')->url('design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["carousel"]);
            $templates[] = $template;
        }
        return $templates;
    }

    function generateIdentifier($searchTerm) {
        $searchTerm = str_replace(' ','-',$searchTerm);

        // Remove all non-alphanumeric characters from the search term
        $cleanSearchTerm = preg_replace("/[^A-Za-z0-9-]/", "", $searchTerm);
        
        // Convert the cleaned search term to all lowercase
        $identifier = strtolower($cleanSearchTerm);

        return $identifier;
    }
}
