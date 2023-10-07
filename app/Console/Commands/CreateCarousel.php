<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redis;
use App\Models\Template;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CreateCarousel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'carousel:create {customerId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a carousel for a given customer based on their product view history';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $customerId = $this->argument('customerId');

        $this->buildCarouselPopularCategories();
        // $this->buildCarouselTrendingNow();
        // $this->buildFavoritesCarousels($customerId);
        // $this->buildSearchBasedCarousels($customerId);
        // $this->buildRecentlyViewedProductsCarousel($customerId);
    }

    // Global user preferences
    function buildCarouselTrendingNow()
    {
        try {
            // Fetch all template views
            $views = Redis::hgetall('analytics:template:views');
            $limit = 30;
            $language_code = 'en';
            $country = 'us';

            // Sort the templates by views in descending order
            arsort($views);

            // Return the top $limit template_ids
            $mostVisitedProductIDs = array_slice(array_keys($views), 0, $limit);
            // print_r($most_visited);
            // exit;

            $products = Template::whereIn('_id', $mostVisitedProductIDs)->get([
                'title',
                'slug',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'previewImageUrls'
            ]);

            // Convert the products into a suitable format for the carousel
            $carouselItems = [];
            foreach ($products as $product) {

                if (App::environment() == 'local') {
                    $product->preview_image_url = asset('design/template/' . $product->_id . '/thumbnails/' . $language_code . '/' . $product->previewImageUrls['product_preview']);
                } else {
                    $product->preview_image_url = Storage::disk('s3')->url('design/template/' . $product->_id . '/thumbnails/' . $language_code . '/' . $product->previewImageUrls['product_preview']);
                }

                $carouselItems[] = [
                    '_id' => $product->_id,
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'width' => $product->width,
                    'height' => $product->height,
                    'forSubscribers' => $product->forSubscribers,
                    'previewImageUrls' => $product->previewImageUrls,
                    'preview_image_url' => $product->preview_image_url
                ];
            }

            // Construct the carousel JSON object
            $carousel = [
                'slider_id' => Str::random(5),
                'title' => 'Trending Now',
                'search_term' => 'Favorites',
                'items' => $carouselItems
            ];

            // Store the JSON object in Redis
            $redisCarouselKey = 'wayak:' . $country . ':home:carousels:trending';
            Redis::set($redisCarouselKey, json_encode($carousel));

            $this->info('Carousel created successfully ');
        } catch (Exception $e) {
            // Consider logging the exception for debugging purposes
            // Log::error("Error fetching top visited templates: " . $e->getMessage());
            return [];
        }
    }

    function buildCarouselPopularCategories()
    {
        $country = 'us';
        $redisKey = 'wayak:' . $country . ':analytics:categories';
        $views = Redis::hgetall($redisKey);
        $limit = 10;
        $language_code = 'en';

        // Sort the categories by views in descending order
        arsort($views);

        // Return the top $limit category_ids
        $mostVisitedCategories = array_slice(array_keys($views), 0, $limit);

        $carousels = [];
        foreach ($mostVisitedCategories as $category) {
            $rawCategory = json_decode( Redis::get('wayak:en:categories:'.$category) );
            $categoryName = $rawCategory->name;

            $category = '/'.$category;

            // Fetch 30 random templates matching the category
            $randomProducts = DB::connection('mongodb')->collection('templates')
                ->raw(function ($collection) use ($category) {
                    return $collection->aggregate([
                        [
                            '$match' => [
                                '$or' => [
                                    ['mainCategory' => $category],
                                    ['categories' => $category]
                                ]
                            ]
                        ],
                        ['$sample' => ['size' => 30]]
                    ]);
                });
            
            $carouselItems = [];
            foreach ($randomProducts as $product) {
                $urlPath = 'design/template/' . $product->_id . '/thumbnails/' . $language_code . '/' . $product->previewImageUrls['product_preview'];
                $product->preview_image_url = App::environment() == 'local' ? asset($urlPath) : Storage::disk('s3')->url($urlPath);

                $carouselItems[] = [
                    '_id' => $product->_id,
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'width' => $product->width,
                    'height' => $product->height,
                    'forSubscribers' => $product->forSubscribers,
                    'previewImageUrls' => $product->previewImageUrls,
                    'preview_image_url' => $product->preview_image_url
                ];
            }

            // Construct the carousel JSON object
            $carousels[] = [
                'slider_id' => Str::random(5),
                'title' => $categoryName,
                'search_term' => 'Favorites',
                'items' => $carouselItems
            ];
        }

        print_r($carousels);

        // Store the JSON object in Redis
        $redisCarouselKey = 'wayak:' . $country . ':home:carousels:trending-categories';
        Redis::set($redisCarouselKey, json_encode($carousels));

        $this->info('Carousel created successfully ');
    }



    function buildFavoritesCarousels($customerId)
    {

        $language_code = 'en';
        $favoriteProductIds = $this->getFavorites($customerId);
        $products = Template::whereIn('_id', $favoriteProductIds)->get([
            'title',
            'slug',
            'previewImageUrls',
            'width',
            'height',
            'forSubscribers',
            'previewImageUrls'
        ]);

        // Convert the products into a suitable format for the carousel
        $carouselItems = [];
        foreach ($products as $product) {

            if (App::environment() == 'local') {
                $product->preview_image_url = asset('design/template/' . $product->_id . '/thumbnails/' . $language_code . '/' . $product->previewImageUrls['product_preview']);
            } else {
                $product->preview_image_url = Storage::disk('s3')->url('design/template/' . $product->_id . '/thumbnails/' . $language_code . '/' . $product->previewImageUrls['product_preview']);
            }

            $carouselItems[] = [
                '_id' => $product->_id,
                'title' => $product->title,
                'slug' => $product->slug,
                'width' => $product->width,
                'height' => $product->height,
                'forSubscribers' => $product->forSubscribers,
                'previewImageUrls' => $product->previewImageUrls,
                'preview_image_url' => $product->preview_image_url
            ];
        }

        // Construct the carousel JSON object
        $carousel = [
            'slider_id' => Str::random(5),
            'title' => 'Favorites',
            'search_term' => 'Favorites',
            'items' => $carouselItems
        ];

        // Store the JSON object in Redis
        $redisCarouselKey = "wayak:user:{$customerId}:carousels:favorites";
        Redis::set($redisCarouselKey, json_encode($carousel));

        $this->info('Carousel created successfully for customer: ' . $customerId);

        return 0;
    }

    function getFavorites($customerId)
    {
        $collections = Redis::keys('wayak:user:favorites:' . $customerId . ':*');
        $favorites = [];

        foreach ($collections as $collection_key) {
            $collection_name = substr($collection_key, strrpos($collection_key, ":") + 1);
            $favorites[$collection_name] = Redis::smembers($collection_key);
        }

        $flattenedArray = array_merge(...array_values($favorites));

        return $flattenedArray;
    }

    public function buildSearchBasedCarousels($customerId)
    {

        $language_code = 'en';
        $total_items_per_carousel = 30;

        // Fetch serach history from Redis
        $redisKey = "wayak:user:{$customerId}:history:search";
        $serachHistory = Redis::hgetall($redisKey);

        // Convert product history data from JSON strings to associative arrays
        $serachHistoryArray = [];
        foreach ($serachHistory as $productId => $data) {
            $serachHistoryArray[$productId] = json_decode($data, true);
        }

        // // Sort the product history based on view count in descending order
        // uasort($serachHistoryArray, function ($a, $b) {
        //     return $b['count'] <=> $a['count'];
        // });


        // Sort the product history based on "lastSearched" date in descending order
        uasort($serachHistoryArray, function ($a, $b) {
            return $b['lastSearched'] <=> $a['lastSearched'];
        });

        // print_r($serachHistoryArray);
        // exit;

        $carousels = [];
        foreach ($serachHistoryArray as $slug => $search_info) {
            $searchTerm = Redis::hget('wayak:us:analytics:search:terms', $slug);

            $products = (new Template())->filterDocuments(strtolower($searchTerm), null, null, null, null, null, 0, $total_items_per_carousel);

            // print_r(array_keys($products));
            // exit;

            // Convert the products into a suitable format for the carousel
            $carouselItems = [];
            foreach ($products['documents'] as $product) {

                if (App::environment() == 'local') {
                    $product->preview_image_url = asset('design/template/' . $product->_id . '/thumbnails/' . $language_code . '/' . $product->previewImageUrls['product_preview']);
                } else {
                    $product->preview_image_url = Storage::disk('s3')->url('design/template/' . $product->_id . '/thumbnails/' . $language_code . '/' . $product->previewImageUrls['product_preview']);
                }

                $carouselItems[] = [
                    '_id' => $product->_id,
                    'title' => $product->title,
                    'slug' => $product->slug,
                    'width' => $product->width,
                    'height' => $product->height,
                    'forSubscribers' => $product->forSubscribers,
                    'previewImageUrls' => $product->previewImageUrls,
                    'preview_image_url' => $product->preview_image_url
                ];
            }

            // Construct the carousel JSON object
            $carousels[] = [
                'slider_id' => Str::random(5),
                'title' => 'Beacuse you search "' . $searchTerm . '"',
                'search_term' => $searchTerm,
                'items' => $carouselItems
            ];
        }

        // Store the JSON object in Redis
        $redisCarouselKey = "wayak:user:{$customerId}:carousels:search";
        Redis::set($redisCarouselKey, json_encode($carousels));
        $this->info('Carousel created successfully for customer: ' . $customerId);

        return 0;
    }

    public function buildRecentlyViewedProductsCarousel($customerId)
    {
        $language_code = 'en';
        $isLocal = App::environment() == 'local';
        $redisKey = "wayak:user:{$customerId}:history:navigation";

        // Fetch and decode product history in one step
        $productHistoryArray = collect(Redis::hgetall($redisKey))->mapWithKeys(function ($data, $productId) {
            return [$productId => json_decode($data, true)];
        })->toArray();

        // Sort by lastVisited
        uasort($productHistoryArray, fn ($a, $b) => $b['lastVisited'] <=> $a['lastVisited']);

        // Fetch necessary fields from MongoDB
        $products = Template::whereIn('_id', array_keys($productHistoryArray))
            ->get(['_id', 'title', 'slug', 'width', 'height', 'forSubscribers', 'previewImageUrls']);

        // Process products and generate URLs based on environment
        $carouselItems = $products->map(function ($product) use ($isLocal, $language_code) {
            $urlPath = 'design/template/' . $product->_id . '/thumbnails/' . $language_code . '/' . $product->previewImageUrls['product_preview'];

            if ($isLocal) {
                $product->preview_image_url = asset($urlPath);
            } else {
                $product->preview_image_url = Storage::disk('s3')->url($urlPath);
            }

            return [
                '_id' => $product->_id,
                'title' => $product->title,
                'slug' => $product->slug,
                'width' => $product->width,
                'height' => $product->height,
                'forSubscribers' => $product->forSubscribers,
                'previewImageUrls' => $product->previewImageUrls,
                'preview_image_url' => $product->preview_image_url
            ];
        })->toArray();

        // Construct and store carousel JSON
        Redis::set("wayak:user:{$customerId}:carousels:product-history", json_encode([
            'slider_id' => Str::random(5),
            'title' => 'Recently viewed products',
            'search_term' => 'recently viewed',
            'items' => $carouselItems
        ]));

        $this->info('Carousel created successfully for customer: ' . $customerId);

        return 0;
    }
}
