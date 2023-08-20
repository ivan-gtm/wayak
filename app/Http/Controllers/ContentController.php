<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;

use App\Models\Template;
use Storage;

// ini_set("max_execution_time", 0);   // no time-outs!
// ini_set("request_terminate_timeout", 2000);   // no time-outs!
// ini_set('memory_limit', -1);
// ini_set('display_errors', 1);

// ignore_user_abort(true);            // Continue downloading even after user closes the browser.
// error_reporting(E_ALL);


class ContentController extends Controller
{
    
    public function showHome() {
        
        $country = 'us';
        $locale = 'en';

        App::setLocale($locale);

        $carousels = json_decode(Redis::get('wayak:'.$country.':home:carousels'));
        $menu = json_decode(Redis::get('wayak:'.$country.':menu'));
        $sale = Redis::hgetall('wayak:'.$country.':config:sales');

        return view('content.home',[
            'search_term' => '',
            'language_code' => $locale,
            'country' => $country,
            'menu' => $menu,
            'sale' => $sale,
            'search_query' => '',
            'carousels' => $carousels
        ]);

    }
   
    public function showHomePerPage( $country ) {
        if( in_array($country, ['us', 'ca']) ){
            $locale = 'en';
        } elseif( in_array($country, ['es','mx','co','ar','bo','ch','cu','do','sv','hn','ni', 'pe', 'uy', 've','py','pa','gt','pr','gq']) ){
            $locale = 'es';
        } else {
            $locale = 'en';
        }

        if( !in_array($locale, ['en', 'es']) ){
            abort(400);
        }

        App::setLocale($locale);

        if( Redis::exists('wayak:'.$country.':home:carousels') ){
            
            $carousels = json_decode(Redis::get('wayak:'.$country.':home:carousels'));
            $menu = json_decode(Redis::get('wayak:'.$country.':menu'));
            $sale = Redis::hgetall('wayak:'.$country.':config:sales');
            
            // echo "<pre>";
            // print_r(json_encode($menu));
            // exit;
            
            return view('content.home',[
                'language_code' => $locale,
                'country' => $country,
                'menu' => $menu,
                'sale' => $sale,
                'search_query' => '',
                'carousels' => $carousels
            ]);
            
        } else {
            abort(404);
        }
    }

    public function filterBySearchTermAndPrice(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $minPrice = $request->input('minPrice');
        $maxPrice = $request->input('maxPrice');

        $documents = (new Document())->filterBySearchTermAndPrice($searchTerm, $minPrice, $maxPrice);

        return response()->json($documents);
    }

    public function showCategoryPage($country, $cat_lvl_1_slug = null, $cat_lvl_2_slug = null, $cat_lvl_3_slug = null, Request $request){
        
        if( in_array($country, ['us', 'ca']) ){
            $locale = 'en';
        } elseif( in_array($country, ['es','mx','co','ar','bo','ch','cu','do','sv','hn','ni', 'pe', 'uy', 've','py','pa','gt','pr','gq']) ){
            $locale = 'es';
        } else {
            $locale = 'en';
        }
        
        if( !in_array($locale, ['en', 'es']) ){
            abort(400);
        }
        
        App::setLocale($locale);

        $slug = '/'.$cat_lvl_1_slug;
        
        if( $cat_lvl_2_slug != null ){
            $slug .=  '/'.$cat_lvl_2_slug;
        }
        
        if( $cat_lvl_3_slug != null ){
            $slug .=  '/'.$cat_lvl_3_slug;
        }

        $category_redis_key = 'wayak:'.$locale.':categories:'. substr($slug, 1,strlen($slug));
        $category_slug_id = substr($slug, 1,strlen($slug));
        
        if(Redis::exists( $category_redis_key ) == false){
            echo "CATEGORY DOES NOT EXISTS.";
            exit;
        }

        if( Redis::hexists('wayak:'.$country.':analytics:categories',$category_slug_id) ){
            Redis::hincrby('wayak:'.$country.':analytics:categories',$category_slug_id,1);
        } else {
            Redis::hset('wayak:'.$country.':analytics:categories',$category_slug_id,1);
        }

        $category_obj = json_decode( Redis::get($category_redis_key) );
        
        // $category_name = $category_obj->slug;
        $breadcrumbs_str = Redis::get($category_redis_key);
        $breadcrumbs_obj = json_decode($breadcrumbs_str);

        self::getBreadCrumbs( $breadcrumbs_obj ) ;
        
        $url = "";
        $total_breads = sizeof($this->bread_array);
        for ($i=0; $i < $total_breads; $i++) { 
            $url .= '/'.$this->bread_array[$i]->slug;
            $this->bread_array[$i]->url = url($country.'/templates'.$url);
        }

        $language_code = 'en';
        $page = 1;
        $per_page = 100;
        $skip = 0;

        if( isset($request->page) ) {
            // print_r($page);
            // exit;
            $page = $request->page;
            $skip = $per_page*($page-1);
        }

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
            if( App::environment() == 'local' ){
                // $preview_image = asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["product_preview"] );
                $template->preview_image = asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["carousel"] );
            } else {
                $template->preview_image = Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["carousel"] );
            }
            $templates[] = $template;
        }
        
        $total_documents = Template::whereIn('categories', [$slug])->count();
        $last_page = ceil( $total_documents / $per_page );

        $from_document = $skip + 1;
        $to_document = $skip + $per_page;

        $menu = json_decode(Redis::get('wayak:'.$country.':menu'));
        $sale = Redis::hgetall('wayak:'.$country.':config:sales');
        
        // echo "<pre>";
        // print_r($category_obj);
        // exit;
        
        return view('content.category',[
            'country' => $country,
            'language_code' => $language_code,
            'menu' => $menu,
            'sale' => $sale,
            'search_query' => '',
            'category_obj' => $category_obj,
            'breadcrumbs' => $this->bread_array,
            'current_page' => $page,
            'pagination_begin' => (($page - 4) > 0) ? $page-4 : 1,
            'pagination_end' => (($page + 4) < $last_page) ? $page+4 : $last_page,
            'first_page' => 1,
            'last_page' => $last_page,
            // 'from_document' => $from_document,
            // 'to_document' => $to_document,
            // 'total_documents' => $total_documents,
            'templates' => $templates,
            'current_url' => url()->current()
        ]);
    }

    public function showCreatePage($country){
        return view('content.create',[]);
    }

    function getLocale($country){
        if( in_array($country, ['us', 'ca']) ){
            $locale = 'en';
        } elseif( in_array($country, ['es','mx','co','ar','bo','ch','cu','do','sv','hn','ni', 'pe', 'uy', 've','py','pa','gt','pr','gq']) ){
            $locale = 'es';
        } else {
            $locale = 'en';
        }
        
        return $locale;
    }

    public function showTemplatePage($country, $slug){

        $language_code = 'en';
        $locale = self::getLocale($country);
        
        if( !in_array($locale, ['en', 'es']) ){
            abort(400);
        }
        
        App::setLocale($locale);
        
        $template_id = substr($slug, strrpos($slug, '-')+1, strlen($slug)  );
        $search_query = '';

        
        if( isset($request->searchQuery) ) {
            $search_query = $request->searchQuery;
        }
        
        $template = self::getTemplateMetadata($template_id);
        
        // Template not found
        if( isset($template->_id) == false ){
            abort(404);
        }
        
        $related_templates = self::getRelatedTemplates( $template->mainCategory, $language_code );
        // $related_templates = [];
        
        if( Redis::hexists('analytics:template:views',$template_id) ){
            Redis::hincrby('analytics:template:views',$template_id,1);
        } else {
            Redis::hset('analytics:template:views',$template_id,1);
        }

        if( App::environment() == 'local' ){
            $preview_image = asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["product_preview"] );
            // print_r($preview_image);
            // echo App::environment();
            // exit;
        } else {
            $preview_image = Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["product_preview"] );
        }

        $category_name = $template->mainCategory;
        $category_name = substr( $template->mainCategory,1, strlen($category_name) );
        $breadcrumbs_str = Redis::get('wayak:en:categories:'.$category_name);
        $breadcrumbs_obj = json_decode($breadcrumbs_str);

        // echo $category_name;
        // exit;

        self::getBreadCrumbs( $breadcrumbs_obj ) ;
        
        $url = "";
        $total_breads = sizeof($this->bread_array);
        for ($i=0; $i < $total_breads; $i++) { 
            $url .= '/'.$this->bread_array[$i]->slug;
            $this->bread_array[$i]->url = url($country.'/templates'.$url);
        }
        
        if( App::environment() == 'local' ){
            $thumb_path = public_path( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["product_preview"] );
        } else {
            $thumb_path = $preview_image;
        }
        
        $palette = Palette::fromFilename( $thumb_path );
        $extractor = new ColorExtractor($palette);
        $colors = $extractor->extract(10);

        for ($i=0; $i < sizeof($colors); $i++) { 
            $colors[$i] = Color::fromIntToHex($colors[$i]);
        }

        $menu = json_decode(Redis::get('wayak:'.$country.':menu'));
        $sale = Redis::hgetall('wayak:'.$country.':config:sales');

        // echo "<pre>";
        // print_r($sale);
        // exit;

        return view('content.product-detail',[
            'country' => $country,
            'preview_image' => $preview_image,
            'language_code' => $language_code,
            'search_query' => $search_query,
            'menu' => $menu,
            'sale' => $sale,
            'breadcrumbs' => $this->bread_array,
            'breadcrumb' => $breadcrumbs_obj,
            'template' => $template,
            'colors' => $colors,
            'related_templates' => $related_templates
        ]);
    }

    function getTemplateMetadata($template_id){
        $template = Template::where('_id','=',$template_id)
            ->first([
                'categories',
                'createdAt',
                'format',
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
                'width',
                'updatedAt'
            ]);
        return $template;

    }

    

    function getRelatedTemplates($mainCategory, $language_code){

        $total = Template::where('mainCategory','=', $mainCategory )->count();
        $per_page = 32;
        $tota_pages = floor( $total / $per_page );
        $page = rand( 1, $tota_pages );
        $skip = $page * $per_page;
        
        $related_content = Template::select([
                'title',
                'preview_image',
                'slug',
                'format',
                'categories',
                'mainCategory',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'measureUnits',
                'createdAt',
                'updatedAt'
            ])
            ->where('mainCategory','=', $mainCategory )
            ->orderBy('rand')
            ->skip($skip)
            ->take($per_page)
            ->get();
        
        $related_templates = [];
        foreach ($related_content as $related_template) {
            
            if( App::environment() == 'local' ){
                $related_template->preview_image = asset( 'design/template/'.$related_template->_id.'/thumbnails/'.$language_code.'/'.$related_template->previewImageUrls["thumbnail"] );
            } else {
                $related_template->preview_image = Storage::disk('s3')->url( 'design/template/'.$related_template->_id.'/thumbnails/'.$language_code.'/'.$related_template->previewImageUrls["thumbnail"] );
            }

            $related_templates[] = $related_template;
        }

        return $related_templates;
    }
    
    public $bread_array = [];

    
    function getBreadCrumbs( $breadcrumbs_obj ){
        
        if( isset( $breadcrumbs_obj->parent ) ){
            self::getBreadCrumbs( $breadcrumbs_obj->parent );
        }

        $this->bread_array[] = $breadcrumbs_obj;

        // return  $bread_array;
    }

    function generateIdentifier($searchTerm) {
        $searchTerm = str_replace(' ','-',$searchTerm);

        // Remove all non-alphanumeric characters from the search term
        $cleanSearchTerm = preg_replace("/[^A-Za-z0-9-]/", "", $searchTerm);
        
        // Convert the cleaned search term to all lowercase
        $identifier = strtolower($cleanSearchTerm);

        return $identifier;
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

    public function getTotalDocumentsByCategory()
    {
        // Group by category and count the total number of documents in each category
        $categoryCounts = Template::raw(function($collection) {
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

    public function getFormatsTotals()
    {
        $formatCounts = (new Template())->getTotalDocumentsByFormat();
        return response()->json($formatCounts);
        // echo "<pre>";
        // print_r(json_encode($formatCounts));
        // exit;
    }

    public function showSearchPage($country, Request $request){
        $language_code = 'en';
        $search_query = $request->searchQuery ?? '';
        $category = '';
        $page = $request->page ?? 1;
        $per_page = 100;
        $skip = $per_page * ($page - 1);
        
        $search_id = $this->generateSearchId($request->searchQuery);
        $this->recordSearchAnalytics($country, $search_id, $request->searchQuery);
        
        $category = null;
        $minPrice = null;
        $maxPrice = null;
        
        $result = (new Template())->filterDocuments($request->searchQuery, $category, $minPrice, $maxPrice,$request->sale, $skip, $per_page);
        $total_documents = $result['total'];
        $search_result = $result['documents'];
    
        $last_page = ceil($total_documents / $per_page);
        $from_document = $skip + 1;
        $to_document = $skip + $per_page;
        $templates = $this->prepareTemplates($search_result, $language_code);
    
        $menu = json_decode(Redis::get('wayak:'.$country.':menu'));
        $sale = Redis::hgetall('wayak:'.$country.':config:sales');
        
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
    
    private function generateSearchId($searchQuery) {
        return self::generateIdentifier($searchQuery);
    }
    
    private function recordSearchAnalytics($country, $search_id, $searchQuery) {
        if (Redis::hexists('wayak:'.$country.':analytics:search:results', $search_id)) {
            Redis::hincrby('wayak:'.$country.':analytics:search:results', $search_id, 1);
        } else {
            Redis::hset('wayak:'.$country.':analytics:search:terms', $search_id, $searchQuery);
            Redis::hset('wayak:'.$country.':analytics:search:results', $search_id, 1);
        }
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
    

    public function sitemap($country){
        
        $output = '<?xml version="1.0" encoding="utf-8"?>';
        $output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="https://www.w3.org/1999/xhtml" >';
        
        $output .= '
                <url>
                    <loc>'.url('/'.$country).'</loc>
                    <lastmod>'.date("Y-m-d").'</lastmod>
                    <changefreq>never</changefreq>
                    <priority>0.5</priority>
                </url>';

        $categories = Redis::keys('wayak:en:categories:*');
        foreach($categories as $category) {
            $cat_params = [];
            $category_slug = str_replace( 'wayak:en:categories:',null, $category);

            // echo "<pre>";
            // print_r( $category_slug );
            // print_r( "\n<br>" );

            if( Template::whereNotNull('slug')->whereIn('categories', ['/'.$category_slug])->count() > 0 ){
                $categorie_levels = explode('/',$category_slug);
                $categorie_levels_size = sizeof($categorie_levels);
                
                $cat_params['country'] = $country;

                for ($i=1; $i <= $categorie_levels_size; $i++) { 
                    $cat_params['cat_lvl_'.$i] = $categorie_levels[$i-1];
                }

                // echo "<pre>";
                // print_r( $category );
                // print_r( "\n<br>" );
                // print_r( $cat_params );
                // // exit;

                $url = route( 'showCategoryLevel'.$categorie_levels_size, $cat_params );

                // $date = '';
                $date = date("Y-m-d");
                $output .= '
                <url>
                    <loc>'.$url.'</loc>
                    <lastmod>'.$date.'</lastmod>
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
            
            $url = route( 'template.productDetail',[
                'country' => $country,
                'slug' => stripslashes( $template->slug )
            ] );

            // $date = '';
            $date = date("Y-m-d");
            $output .= '
            <url>
                <loc>'.$url.'</loc>
                <lastmod>'.$date.'</lastmod>
                <changefreq>monthly</changefreq>
                <priority>0.5</priority>
            </url>';
        }

        $output .= '</urlset>';
        
        header("Content-type: text/xml");
        echo $output;

        // Redis::set('wayak:sitemap:us', $output);
    }

    function search(){
        
        $products = DB::select( DB::raw(
            'SELECT * FROM `wayak`.`tmp_etsy_metadata`
            WHERE templett_url LIKE \'https://www.corjl.com/%\'
            ORDER BY id DESC 
            LIMIT 100')
        );

        // foreach ($ready_for_title as $word) {
        //     $tmp_title[] = ucwords($word->word);
        // }

        return view('front.search',[
            'products' => $products
        ]);
    }

    public function getTemplate($country, $slug){

        // $language_code = 'en';
        // $locale = self::getLocale($country);
        
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

        return view('front.product',[
            'country' => $country,
            'product' => $product
        ]);
    }

    function demo($country,$product_id){
        // $product = DB::table('tmp_etsy_metadata')->where('id', $product_id)->first();
        
        return view('front.demo',[
            // 'demo_url' => $product->templett_url
            'demo_url' => "https://www.corjl.com/d/HN9KB"
        ]);

    }
}
