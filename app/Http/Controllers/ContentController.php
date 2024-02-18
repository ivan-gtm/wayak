<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\AnalyticsController;
use App\Traits\LocaleTrait;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use App\Services\UserPurchaseService;

use App\Models\Template;
use Storage;

class ContentController extends Controller
{
    use LocaleTrait;
    protected $userPurchaseService;

    public function __construct(UserPurchaseService $userPurchaseService)
    {
        $this->userPurchaseService = $userPurchaseService;
    }

    public function showHome($country = 'us', Request $request)
    {
        $locale = $this->getLocaleByCountry($country);

        // Early return if locale is not supported
        if (!in_array($locale, ['en', 'es'])) {
            abort(400, 'Unsupported locale.');
        }

        App::setLocale($locale);

        $redisPrefix = 'wayak:' . $country;
        $customerId = $this->getCustomerId($request);
        $carouselKeys = $this->getCarouselKeys($redisPrefix, $customerId);
        $redisResults = Redis::mget($carouselKeys);

        // echo "<pre>";
        // print_r( $redisResults );
        // exit;

        // Early return if there are no carousel results
        if ($customerId > 0 && !$redisResults[0]) {
            abort(404, 'Carousels not found.');
        }

        $carousels = $this->mergeCarousels($redisResults);
        $menu = json_decode(Redis::get("{$redisPrefix}:menu"));
        $sale = $this->getSaleDetails($redisPrefix, $request);

        // Get user if logged in
        $user = Auth::user();

        return view('content.home', [
            'language_code' => $locale,
            'country' => $country,
            'coupon' => $request->input('coupon', null),
            'menu' => $menu,
            'customer_id' => $user ? $user->customer_id : null,
            'sale' => $sale,
            'search_query' => '',
            'carousels' => $carousels,
        ]);
    }

    private function getCustomerId(Request $request)
    {
        // Cache authenticated user
        $user = auth()->user();

        if ($user) {
            return $user->customer_id;
        }

        // $customerId = $request->input('customer_id');
        // print_r($request->all());
        // exit;
        if ($request->customerId) {
            return $request->customerId;
        }

        return false;
    }

    private function getCarouselKeys($redisPrefix, $customerId)
    {
        return [
            "wayak:user:{$customerId}:recommendations:carousels",
            "{$redisPrefix}:home:carousels:trending-categories",
            "{$redisPrefix}:home:carousels",
        ];
    }

    private function mergeCarousels(array $redisResults)
    {
        return collect($redisResults)->map(fn($result) => json_decode($result))->collapse();
    }

    private function getSaleDetails($redisPrefix, Request $request)
    {
        $sale = Redis::hgetall("{$redisPrefix}:config:sales");
        $couponCode = $request->input('coupon');

        if ($couponCode) {
            $couponDetails = Redis::hgetall("wayak:admin:template:code:{$couponCode}");
            $sale = array_merge($sale, [
                'status' => 1,
                'sale_ends_at' => $couponDetails['expires_at'],
                'site_banner_txt' => 'Coupon applied!',
                'site_banner_btn' => 'Jjaja',
            ]);
        }

        return $sale;
    }
    
    public function showCategoryPage($country, $catLevel1_slug = null, $catLevel2_slug = null, $catLevel3_slug = null, Request $request)
    {

        $locale = $this->getLocaleByCountry($country);

        if (!in_array($locale, ['en', 'es'])) {
            abort(400);
        }

        App::setLocale($locale);

        $slugComponents = array_filter([$catLevel1_slug, $catLevel2_slug, $catLevel3_slug]);
        $slug = '/' . implode('/', $slugComponents);
        $category_redis_key = 'wayak:' . $locale . ':categories:' . ltrim($slug, '/');
        
        if (!Redis::exists($category_redis_key)) {
            abort(404);
        }
        
        $analyticsController = new AnalyticsController();
        $analyticsController->registerVisitCategory($country, ltrim($slug, '/'));
        
        $customer_id = $this->getCustomerId($request);
        // echo $customer_id;
        // exit;
        if ($customer_id) {
            $analyticsController->registerCategoryVisitByUser(ltrim($slug, '/'),$customer_id);
        }
        
        list($category_obj, $breadcrumbs_str, $menu) = array_map('json_decode', Redis::mget([$category_redis_key, $category_redis_key, 'wayak:' . $country . ':menu']));
        
        $breadcrumbs_obj = $breadcrumbs_str;
        self::getBreadCrumbs($breadcrumbs_obj);
        
        $url = "";
        $total_breads = sizeof($this->bread_array);
        for ($i = 0; $i < $total_breads; $i++) {
            $url .= '/' . $this->bread_array[$i]->slug;
            $this->bread_array[$i]->url = url($country . '/templates' . $url);
        }
        
        $page = $request->input('page', 1);
        $per_page = 100;
        $skip = $per_page * ($page - 1);

        $category_products = Template::whereIn('categories', [$slug])
            ->skip($skip)
            ->take($per_page)
            ->get([
                '_id',
                'title',
                'slug',
                'previewImageUrls',
                'studioName',
                'prices'
            ]);

        $templates = [];
        foreach ($category_products as $template) {
            $template->preview_image = App::environment() == 'local'
                ? asset('design/template/' . $template->_id . '/thumbnails/' . $locale . '/' . $template->previewImageUrls["carousel"])
                : Storage::disk('s3')->url('design/template/' . $template->_id . '/thumbnails/' . $locale . '/' . $template->previewImageUrls["carousel"]);

            $templates[] = $template;
        }

        
        $total_documents = Template::whereIn('categories', [$slug])->count();
        $last_page = ceil($total_documents / $per_page);
        
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');
        $customer_id = null;
        
        $couponCode = $request->input('coupon', null);
        if(isset($couponCode)){
            $couponDetails = Redis::hgetall('wayak:admin:template:code:' . $request->coupon);
            $sale['status'] = 1;
            $sale['sale_ends_at'] = $couponDetails['expires_at'];
            $sale['site_banner_txt'] = 'Coupon applied !';
            $sale['site_banner_btn'] = 'Jjaja';
        }
        
        // User is logged in
        if( Auth::check() ) {
            $user = Auth::user();
            $customer_id = isset($user->customer_id) ? $user->customer_id : null;
        }

        return view('content.category', [
            'country' => $country,
            'language_code' => $locale,
            'menu' => $menu,
            'sale' => $sale,
            'coupon' => $couponCode,
            'customer_id' => $customer_id,
            'search_query' => '',
            'category_obj' => $category_obj,
            'breadcrumbs' => $this->bread_array,
            'current_page' => $page,
            'pagination_begin' => max($page - 4, 1),
            'pagination_end' => min($page + 4, $last_page),
            'first_page' => 1,
            'last_page' => $last_page,
            'templates' => $templates,
            'current_url' => url()->current()
        ]);
    }

    public function showCreatePage($country)
    {
        return view('content.create', []);
    }

    public function showTemplatePage($country, Request $request, $slug)
    {

        // $language_code = 'en';
        $locale = $this->getLocaleByCountry($country);

        if (!in_array($locale, ['en', 'es','fr','pt'])) {
            abort(400);
        }

        App::setLocale($locale);

        $template_id = substr($slug, strrpos($slug, '-') + 1, strlen($slug));
        $search_query = '';

        if (isset($request->searchQuery)) {
            $search_query = $request->searchQuery;
        }

        $template = self::getTemplateMetadata($template_id);

        // Template not found
        if (isset($template->_id) == false) {
            abort(404);
        }

        $related_templates = self::getRelatedTemplates($template->mainCategory, $locale);
        // $related_templates = [];

        $analyticsController = new AnalyticsController();
        $analyticsController->registerProductView($template_id);
        
        $language_code = 'en'; // Temporal
        if (App::environment() == 'local') {
            $preview_image = asset('design/template/' . $template->_id . '/thumbnails/' . $language_code . '/' . $template->previewImageUrls["product_preview"]);
            // print_r($preview_image);
            // echo App::environment();
            // exit;
        } else {
            $preview_image = Storage::disk('s3')->url('design/template/' . $template->_id . '/thumbnails/' . $language_code . '/' . $template->previewImageUrls["product_preview"]);
        }

        $category_name = $template->mainCategory;
        $category_name = substr($template->mainCategory, 1, strlen($category_name));
        $breadcrumbs_str = Redis::get('wayak:en:categories:' . $category_name);
        $breadcrumbs_obj = json_decode($breadcrumbs_str);

        self::getBreadCrumbs($breadcrumbs_obj);

        $url = "";
        $total_breads = sizeof($this->bread_array);
        for ($i = 0; $i < $total_breads; $i++) {
            $url .= '/' . $this->bread_array[$i]->slug;
            $this->bread_array[$i]->url = url($country . '/templates' . $url);
        }

        $colors = $template->colors;

        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        $logged_id = 0;
        $isFavorite = false;

        if( Auth::check() ) {
            // User is logged in
            $logged_id = Auth::id();
            $user = Auth::user();

            $favoritesController = new FavoritesController();
            $isFavorite = $favoritesController->isFavorite($template->_id, $user->customer_id);
            $analyticsController->registerCategoryVisitByUser( substr($template->mainCategory, 1), $user->customer_id );
        }

        $customerId = $this->getCustomerId($request);
        $isPurchased = $this->userPurchaseService->isTemplateIdInPurchases($customerId, $template_id);
        
        $couponDetails = null;
        if( isset($request->coupon) ) {
            $couponCode = $request->coupon;
            $couponDetails = Redis::hgetall('wayak:admin:template:code:' . $couponCode);

            // echo "<pre>";
            // print_r($couponDetails['expires_at']);
            // exit;
            
            if( isset($couponDetails) && $couponDetails['discountType'] == "percentage" ){
                
                $prices = $template->prices; // Retrieve the current prices
                $prices['price'] = number_format($template->prices['original_price'] - ($couponDetails['percentage_discount'] * $template->prices['original_price']) / 100 );
                $prices['discount_percent'] = $couponDetails['percentage_discount'];
                $template->prices = $prices; // Set the modified array back to the model
                $sale['sale_ends_at'] = $couponDetails['expires_at'];
                // $sale['status'] = 1;
                // $sale['site_banner_txt'] = '';
                // $sale['site_banner_btn'] = '';
            } elseif( isset($couponDetails) && $couponDetails['discountType'] == "fixed") {
                $prices = $template->prices; // Retrieve the current prices
                $prices['price'] = $couponDetails['fixed_price'];
                $prices['discount_percent'] = number_format(100-(($couponDetails['fixed_price']*100)/$prices['original_price']));
                $template->prices = $prices; // Set the modified array back to the model
                $sale['sale_ends_at'] = $couponDetails['expires_at'];
                // $sale['status'] = 1;
                // $sale['site_banner_txt'] = '';
                // $sale['site_banner_btn'] = '';
            }
        }

        return view('content.product-detail', [
            'country' => $country,
            'preview_image' => $preview_image,
            'couponDetails' => $couponDetails,
            'language_code' => $locale,
            'search_query' => $search_query,
            'menu' => $menu,
            'sale' => $sale, 
            // campaignDetails
            'breadcrumbs' => $this->bread_array,
            'breadcrumb' => $breadcrumbs_obj,
            'template' => $template,
            'colors' => $colors,
            'logged_id' => $logged_id,
            'customer_id' => $customerId,
            'isFavorite' => $isFavorite,
            'isPurchased' => $isPurchased,
            'related_templates' => $related_templates
        ]);
    }

    function getTemplateMetadata($template_id)
    {
        $template = Template::where('_id', '=', $template_id)
            ->first([
                'categories',
                'createdAt',
                'format',
                'colors',
                'forSubscribers',
                'height',
                'preview_image',
                'mainCategory',
                'measureUnits',
                'prices',
                'previewImageUrls',
                'sales',
                'stars',
                'studioName',
                'title',
                'keywords',
                'localizedTitle',
                'width',
                'updatedAt'
            ]);

        return $template;
    }

    function getRelatedTemplates($mainCategory, $language_code)
    {

        $total = Template::where('mainCategory', '=', $mainCategory)->count();
        $per_page = 32;
        $tota_pages = floor($total / $per_page);
        $page = rand(1, $tota_pages);
        $skip = $page * $per_page;

        $related_content = Template::select([
            'title',
            'preview_image',
            'slug',
            'sales',
            'stars',
            'format',
            'categories',
            'mainCategory',
            'previewImageUrls',
            'width',
            'height',
            'forSubscribers',
            'measureUnits',
            'studioName',
            'createdAt',
            'updatedAt'
        ])
            ->where('mainCategory', '=', $mainCategory)
            ->orderBy('rand')
            ->skip($skip)
            ->take($per_page)
            ->get();

        $related_templates = [];
        foreach ($related_content as $related_template) {

            if (App::environment() == 'local') {
                $related_template->preview_image = asset('design/template/' . $related_template->_id . '/thumbnails/' . $language_code . '/' . $related_template->previewImageUrls["thumbnail"]);
            } else {
                $related_template->preview_image = Storage::disk('s3')->url('design/template/' . $related_template->_id . '/thumbnails/' . $language_code . '/' . $related_template->previewImageUrls["thumbnail"]);
            }

            $related_templates[] = $related_template;
        }

        return $related_templates;
    }

    public $bread_array = [];


    function getBreadCrumbs($breadcrumbs_obj)
    {

        if (isset($breadcrumbs_obj->parent)) {
            self::getBreadCrumbs($breadcrumbs_obj->parent);
        }

        $this->bread_array[] = $breadcrumbs_obj;

        // return  $bread_array;
    }

    public function getTotalDocumentsByCategory()
    {
        // Group by category and count the total number of documents in each category
        $categoryCounts = Template::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => '$category', // Group by category field
                        'total' => ['$sum' => 1] // Count the total number of documents
                    ]
                ],
                [
                    '$project' => [
                        'category' => '$_id',
                        'total' => 1,
                        '_id' => 0
                    ]
                ]
            ]);
        });

        // return $categoryCounts;
        // return response()->json($categoryCounts);
        echo "<pre>";
        print_r(json_encode($categoryCounts));
        exit;
    }

    public function sitemap($country)
    {

        $output = '<?xml version="1.0" encoding="utf-8"?>';
        $output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="https://www.w3.org/1999/xhtml" >';

        $output .= '
                <url>
                    <loc>' . url('/' . $country) . '</loc>
                    <lastmod>' . date("Y-m-d") . '</lastmod>
                    <changefreq>never</changefreq>
                    <priority>0.5</priority>
                </url>';

        $categories = Redis::keys('wayak:en:categories:*');
        foreach ($categories as $category) {
            $cat_params = [];
            $category_slug = str_replace('wayak:en:categories:', null, $category);

            // echo "<pre>";
            // print_r( $category_slug );
            // print_r( "\n<br>" );

            if (Template::whereNotNull('slug')->whereIn('categories', ['/' . $category_slug])->count() > 0) {
                $categorie_levels = explode('/', $category_slug);
                $categorie_levels_size = sizeof($categorie_levels);

                $cat_params['country'] = $country;

                for ($i = 1; $i <= $categorie_levels_size; $i++) {
                    $cat_params['catLevel' . $i] = $categorie_levels[$i - 1];
                }

                // echo "<pre>";
                // print_r( $category );
                // print_r( "\n<br>" );
                // print_r( $cat_params );
                // // exit;

                $url = route('showCategoryLevel' . $categorie_levels_size, $cat_params);

                // $date = '';
                $date = date("Y-m-d");
                $output .= '
                <url>
                    <loc>' . $url . '</loc>
                    <lastmod>' . $date . '</lastmod>
                    <changefreq>weekly</changefreq>
                    <priority>0.5</priority>
                </url>';
            }
        }

        $templates = Template::whereNotNull('slug')
            // ->take(10)
            ->get([
                'slug'
            ]);

        foreach ($templates as $template) {

            $url = route('template.productDetail', [
                'country' => $country,
                'slug' => stripslashes($template->slug)
            ]);

            // $date = '';
            $date = date("Y-m-d");
            $output .= '
            <url>
                <loc>' . $url . '</loc>
                <lastmod>' . $date . '</lastmod>
                <changefreq>monthly</changefreq>
                <priority>0.5</priority>
            </url>';
        }

        $output .= '</urlset>';

        header("Content-type: text/xml");
        echo $output;

        // Redis::set('wayak:sitemap:us', $output);
    }

    function search()
    {

        $products = DB::select(
            DB::raw(
                'SELECT * FROM `wayak`.`tmp_etsy_metadata`
            WHERE templett_url LIKE \'https://www.corjl.com/%\'
            ORDER BY id DESC 
            LIMIT 100'
            )
        );

        // foreach ($ready_for_title as $word) {
        //     $tmp_title[] = ucwords($word->word);
        // }

        return view('front.search', [
            'products' => $products
        ]);
    }

    public function getTemplate($country, $slug)
    {

        // $language_code = 'en';
        // $locale = $this->getLocaleByCountry($country);

        // if( !in_array($locale, ['en', 'es']) ){
        //     abort(400);
        // }

        // App::setLocale($locale);

        // $template_id = substr($slug, strrpos($slug, '-')+1, strlen($slug)  );
        // $search_query = '';

        // if( Redis::hexists('analytics:template:views',$template_id) ){
        //     Redis::hincrby('analytics:template:views',$template_id,1);
        // } else {
        //     Redis::hset('analytics:template:views',$template_id,1);
        // }

        // if( isset($request->searchQuery) ) {
        //     $search_query = $request->searchQuery;
        // }

        // $template = self::getTemplateMetadata($template_id);
        // $related_templates = self::getRelatedTemplates( $template->mainCategory, $language_code );

        // // Template not found
        // if( isset($template->_id) == false ){
        //     abort(404);
        // }
        // if( App::environment() == 'local' ){
        //     $preview_image = asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["product_preview"] );
        //     // print_r($preview_image);
        //     // echo App::environment();
        //     // exit;
        // } else {
        //     $preview_image = Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["product_preview"] );
        // }

        // // $template->price = rand(35,1000);
        // $category_name = $template->mainCategory;
        // $category_name = substr( $template->mainCategory,1, strlen($category_name) );
        // $breadcrumbs_str = Redis::get('wayak:en:categories:'.$category_name);
        // $breadcrumbs_obj = json_decode($breadcrumbs_str);

        // self::getBreadCrumbs( $breadcrumbs_obj ) ;

        // $url = "";
        // $total_breads = sizeof($this->bread_array);
        // for ($i=0; $i < $total_breads; $i++) { 
        //     $url .= '/'.$this->bread_array[$i]->slug;
        //     $this->bread_array[$i]->url = url($country.'/templates'.$url);
        // }

        // if( App::environment() == 'local' ){
        //     $thumb_path = public_path( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["product_preview"] );
        // } else {
        //     $thumb_path = $preview_image;
        // }

        // $palette = Palette::fromFilename( $thumb_path );
        // $extractor = new ColorExtractor($palette);
        // $colors = $extractor->extract(10);

        // for ($i=0; $i < sizeof($colors); $i++) { 
        //     $colors[$i] = Color::fromIntToHex($colors[$i]);
        // }

        // $menu = json_decode(Redis::get('wayak:'.$country.':menu'));

        // return view('content.product-detail',[
        //     'country' => $country,
        //     'preview_image' => $preview_image,
        //     'language_code' => $language_code,
        //     'search_query' => $search_query,
        //     'menu' => $menu,
        //     'breadcrumbs' => $this->bread_array,
        //     'breadcrumb' => $breadcrumbs_obj,
        //     'template' => $template,
        //     'colors' => $colors,
        //     'related_templates' => $related_templates
        // ]);

        /* 
        SELECT * FROM `wayak`.`tmp_etsy_metadata`
        WHERE templett_url LIKE 'https://www.corjl.com/%'
        ORDER BY id DESC 
        LIMIT 0,1000
        */

        $product = DB::table('tmp_etsy_metadata')->where('id', 196334)->first();
        $product->product_imgs = json_decode($product->product_imgs);

        // echo "<pre>";
        // print_r( $product );
        // // print_r( json_decode($product->product_imgs) );
        // exit;

        return view('front.product', [
            'country' => $country,
            'product' => $product
        ]);
    }

    function demo($country, $product_id)
    {
        // $product = DB::table('tmp_etsy_metadata')->where('id', $product_id)->first();

        return view('front.demo', [
            // 'demo_url' => $product->templett_url
            'demo_url' => "https://www.corjl.com/d/HN9KB"
        ]);
    }
}
