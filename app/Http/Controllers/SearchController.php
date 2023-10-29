<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Template;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function showSearchPage($country, Request $request)
    {
        $language_code = 'en';
        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        $searchTerm = $request->searchQuery ?? null;
        $category = $request->category ?? null;
        $minPrice = $request->minPrice ?? null;
        $maxPrice = $request->maxPrice ?? null;
        $author = $request->author ?? null;
        $productsInSale = $request->productsInSale ?? null;

        $user = Auth::user();
        if($user){
            $customer_id = $user->customer_id;
        } elseif( isset($request->customerId) ) {
            $customer_id = $request->customerId;
        }

        $page = $request->page ?? 1;
        $per_page = 100;
        $skip = $per_page * ($page - 1);

        $searchSlug = $this->generateSearchSlug($searchTerm);
        $this->saveGlobalSearchHistory($country, $searchSlug, $searchTerm);
        $this->updateUserSearchHistory($customer_id, $searchSlug);

        $result = (new Template())->filterDocuments(strtolower($searchTerm), $category, $minPrice, $maxPrice, $author, $productsInSale, $skip, $per_page);
        $total_documents = $result['total'];
        $search_result = $result['documents'];
        
        // echo "<pre>";
        // print_r(json_encode($result));
        // exit;

        $last_page = ceil($total_documents / $per_page);
        $from_document = $skip + 1;
        $to_document = $skip + $per_page;
        $templates = $this->prepareTemplates($search_result, $language_code);

        return view('content.search', [
            'country' => $country,
            'language_code' => $language_code,
            'menu' => $menu,
            'sale' => $sale,
            'search_query' => $searchTerm,
            'category' => $category,
            'current_page' => $page,
            'first_page' => 1,
            'pagination_begin' => max($page - 4, 1),
            'pagination_end' => min($page + 4, $last_page),
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
        $key = "wayak:user:{$customerId}:history:search";

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

    private function saveGlobalSearchHistory($country, $searchSlug, $searchQuery)
    {
        $analyticsController = new AnalyticsController();
        $analyticsController->registerPublicSearch($country, $searchSlug, $searchQuery);
    }

    private function prepareTemplates($search_result, $language_code)
    {
        $templates = [];
        foreach ($search_result as $template) {
            $template->preview_image = App::environment() == 'local'
                ? asset('design/template/' . $template->_id . '/thumbnails/' . $language_code . '/' . $template->previewImageUrls["carousel"])
                : Storage::disk('s3')->url('design/template/' . $template->_id . '/thumbnails/' . $language_code . '/' . $template->previewImageUrls["carousel"]);
            $templates[] = $template;
        }
        return $templates;
    }

    function getSerachTermBasedOnSlug($country, $searchSlug){
        if (Redis::hexists('wayak:' . $country . ':analytics:search:terms', $searchSlug)) {
            return Redis::hget('wayak:' . $country . ':analytics:search:terms', $searchSlug);
        }
    }

    function generateSearchSlug($searchTerm)
    {
        $searchTerm = str_replace(' ', '-', $searchTerm);

        // Remove all non-alphanumeric characters from the search term
        $cleanSearchTerm = preg_replace("/[^A-Za-z0-9-]/", "", $searchTerm);

        // Convert the cleaned search term to all lowercase
        $identifier = strtolower($cleanSearchTerm);

        return $identifier;
    }

    public function recommendSearches($customerId, $searchTerm)
    {
        // Fetch the user's search history from Redis
        $key = "wayak:user:{$customerId}:history:search";
        $userSearchHistory = Redis::hgetall($key);

        // Preprocess the user's recent search term and vectorize it
        $recentSearchVector = $this->vectorizeText($searchTerm);

        $recommendations = [];

        // Calculate similarity scores with previous searches
        foreach ($userSearchHistory as $searchTermSlug => $searchDataJSON) {
            // $searchData = json_decode($searchDataJSON, true);
            $searchTermId = $this->getSerachTermBasedOnSlug('us', $searchTermSlug);
            $previousSearchVector = $this->vectorizeText($searchTermId);

            // Calculate cosine similarity (you may use another similarity metric)
            $similarity = $this->calculateCosineSimilarity($recentSearchVector, $previousSearchVector);

            // Store similarity score and search term
            $recommendations[] = [
                'searchTerm' => $searchTermId,
                'similarity' => $similarity,
            ];
        }

        // Sort recommendations by similarity score in descending order
        usort($recommendations, function ($a, $b) {
            return $b['similarity'] <=> $a['similarity'];
        });

        // Filter out searches the user has already conducted
        $filteredRecommendations = array_filter($recommendations, function ($recommendation) use ($searchTerm) {
            return $recommendation['searchTerm'] !== $searchTerm;
        });

        // Return the top N recommendations
        $N = 10;
        $topRecommendations = array_slice($filteredRecommendations, 0, $N);

        return $topRecommendations;
    }

    function vectorizeText($text)
    {
        // Tokenize the text (split it into words)
        $words = str_word_count($text, 1);

        // Create a dictionary of unique words and their counts
        $wordCounts = array_count_values($words);

        // Calculate the TF-IDF vector
        $vector = [];
        $totalWords = count($words);

        foreach ($wordCounts as $word => $count) {
            // Calculate TF (Term Frequency)
            $tf = $count / $totalWords;

            // Assume you have a precomputed IDF value for each word
            // Replace 'idf' with your actual IDF calculation
            $idf = $this->calculateIDF($word);

            // Calculate TF-IDF for the word
            $tfidf = $tf * $idf;

            // Store the TF-IDF value in the vector
            $vector[$word] = $tfidf;
        }

        return $vector;
    }

    function calculateCosineSimilarity($vector1, $vector2)
    {
        // Calculate the dot product of the two vectors
        $dotProduct = 0;

        foreach ($vector1 as $word => $tfidf1) {
            if (isset($vector2[$word])) {
                $tfidf2 = $vector2[$word];
                $dotProduct += $tfidf1 * $tfidf2;
            }
        }

         // Calculate the magnitude (Euclidean norm) of each vector
        $magnitude1 = sqrt(array_sum(array_map(fn ($tfidf) => $tfidf ** 2, $vector1)));
        $magnitude2 = sqrt(array_sum(array_map(fn ($tfidf) => $tfidf ** 2, $vector2)));


        // Calculate the cosine similarity
        if ($magnitude1 > 0 && $magnitude2 > 0) {
            $similarity = $dotProduct / ($magnitude1 * $magnitude2);
        } else {
            $similarity = 0; // Handle division by zero
        }

        return $similarity;
    }

    function calculateIDF($word)
    {
        // Implement your IDF calculation logic here
        // You might use a precomputed IDF dictionary or calculate it from your corpus
        // For simplicity, assume we have a static IDF dictionary
        // $idfDictionary = [
        //     'word1' => 1.2,
        //     'word2' => 0.8,
        //     // Add more words and their IDF values as needed
        // ];

        

        // Return the IDF value for the word if it exists, or a default value
        if(Redis::hget('wayak:idf:dictionary', $word)){
            return Redis::hget('wayak:idf:dictionary', $word);
        }else{
            return 1.0;
        }
        // return $idfDictionary[$word] ?? 1.0; // Default IDF value
    }
}
