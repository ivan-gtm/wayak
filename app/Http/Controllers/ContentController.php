<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

// use Illuminate\Support\Facades\DB;
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
    
    public function showHome(Request $request) {
        $country = 'us';
        $language_code = 'en';

        $search_query = '';
        if( isset($request->searchQuery) ) {
            $search_query = $request->searchQuery;
        }

        $carousels = json_decode(Redis::get('wayak:'.$country.':home:carousels'));
        $menu = json_decode(Redis::get('wayak:'.$country.':menu'));
        
        // echo "<pre>";
        // print_r($menu);
        // exit;

        return view('content.home',[
            'language_code' => $language_code,
            'country' => $country,
            'menu' => $menu,
            'search_query' => $search_query,
            'carousels' => $carousels
        ]);
    }

    public function showCategoryPage($country, $cat_lvl_1_slug = null, $cat_lvl_2_slug = null, $cat_lvl_3_slug = null, Request $request){
        
        // $template_key = 'template:en:'.'682087'.':jsondata';
        // $pages = Redis::get($template_key);
        // $pages = json_decode($pages);
        // echo "<pre>";
        // print_r($pages);
        // exit;

        $search_query = '';
        if( isset($request->searchQuery) ) {
            $search_query = $request->searchQuery;
        }

        
        $slug = '/'.$cat_lvl_1_slug;
        
        if( $cat_lvl_2_slug != null ){
            $slug .=  '/'.$cat_lvl_2_slug;
        }
        
        if( $cat_lvl_3_slug != null ){
            $slug .=  '/'.$cat_lvl_3_slug;
        }

        $category_redis_key = 'wayak:categories:'. substr($slug, 1,strlen($slug));
        if(Redis::exists( $category_redis_key ) == false){
            echo "CATEGORY DOES NOT EXISTS.";
            exit;
        }

        $category_obj = json_decode( Redis::get($category_redis_key) );
        
        // echo "<pre>";
        // print_r($category_obj);
        // exit;

        $language_code = 'en';
        $page = 1;
        $per_page = 30;
        $skip = 0;

        if( isset($request->page) ) {
            $page = $request->page;
            $skip = $per_page*($page-1);

            $category_products = Template::whereIn('categories', [$slug])
            ->skip($skip)
            ->take($per_page)
            ->get([
                '_id',
                'title',
                'slug',
                'forSubscribers',
                'categoryCaption',
                // 'category',
                'previewImageUrls'
            ]);

            // echo $page;
            $response = '';
            foreach ($category_products as $template) {
                
                $template->preview_image = Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["carousel"] );

                $response .= '<div class="grid__item template">
                        <a href="'.route( 'template.productDetail', [
                            'country' => $country,
                            'slug' => $template->slug
                        ] ).'">
                            <img class="img-fluid" loading="lazy" 
                                    src="'.$template->preview_image.'" 
                                    alt="'.$template->title.'">
                        </a>
                    </div>';
            }
            echo $response;
            exit;
        }

        $category_products = Template::whereIn('categories', [$slug])
            ->skip($skip)
            ->take($per_page)
            ->get([
                '_id',
                'title',
                'slug',
                'forSubscribers',
                'categoryCaption',
                'previewImageUrls'
            ]);
        
        $templates = [];
        foreach ($category_products as $template) {
            $template->preview_image = Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["carousel"] );
            $templates[] = $template;
        }
        // echo "jasdasd";
        // exit;
        
        $total_documents = Template::whereIn('categories', [$slug])->count();

        $from_document = $skip + 1;
        $to_document = $skip + $per_page;

        $menu = json_decode(Redis::get('wayak:'.$country.':menu'));
        
        // echo $total_documents;
        // echo "<pre>";
        // print_r($menu);
        // exit;
        $url_params = [];
        $url_params['slugs']['country'] = $country;

        if( strlen($cat_lvl_1_slug) > 0 ){
            $url_params['slugs']['cat_lvl_1'] = $cat_lvl_1_slug;
        }

        if( strlen($cat_lvl_2_slug) > 0 ){
            $url_params['slugs']['cat_lvl_2'] = $cat_lvl_2_slug;
        }

        if( strlen($cat_lvl_3_slug) > 0 ){
            $url_params['slugs']['cat_lvl_3'] = $cat_lvl_3_slug;
        }
        
        $url_params['cat_lvl'] = sizeof($url_params['slugs']) - 1;
        
        // echo "<pre>";
        // print_r($url_params);
        // exit;
        
        return view('content.category',[
            'country' => $country,
            'language_code' => $language_code,
            'menu' => $menu,
            'search_query' => $search_query,
            'category_obj' => $category_obj,
            'page' => $page,
            'from_document' => $from_document,
            'to_document' => $to_document,
            'total_documents' => $total_documents,
            'templates' => $templates,
            'url_params' => $url_params
        ]);
    }

    public function showCreatePage($country){
        return view('content.create',[]);
    }

    public function showTemplatePage($country, $slug){
        $language_code = 'en';
        $template_id = substr($slug, strrpos($slug, '-')+1, strlen($slug)  );
        $search_query = '';
        if( isset($request->searchQuery) ) {
            $search_query = $request->searchQuery;
        }

        $template = Template::where('_id','=',$template_id)
            ->first([
                'title',
                'preview_image',
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
            ]);

        if( App::environment() == 'locals' ){
            $preview_image = asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["product_preview"] );
        } else {
            $preview_image = Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["product_preview"] );
        }
        // print_r($preview_image);
        // print_r("<br>");
        // print_r(  );
        // print_r("<br>");
        
        // // Storage::disk('local')->put('helloworld.txt', 'xx');

        // print_r( Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["product_preview"] ) );
        // exit;

        $category_name = $template->mainCategory;
        $category_name = substr( $template->mainCategory,1, strlen($category_name) );
        $breadcrumbs_str = Redis::get('wayak:categories:'.$category_name);
        $breadcrumbs_obj = json_decode($breadcrumbs_str);

        // $x = [
        //     'name' => 'Bridal Shower',
        //     'slug' => 'invitations/wedding/bridal-shower',
        //     'children' => []
        // ];

        // Redis::set('wayak:categories:'.$category_name, json_encode($x) );

        // echo "<pre>";
        // print_r( $category_name );
        // echo "\n";
        // print_r( $breadcrumbs_obj );
        // exit;

        $breadcrumbs_arr = self::getBreadCrumbs( $breadcrumbs_obj ) ;

        // print_r($breadcrumbs_str);
        // exit;
        
        $url = "";
        $total_breads = sizeof($this->bread_array);
        for ($i=0; $i < $total_breads; $i++) { 
            $url .= '/'.$this->bread_array[$i]->slug;
            $this->bread_array[$i]->url = url($country.'/templates'.$url);
        }
        
        // echo "<pre>";
        // print_r($template->previewImageUrls['thumbnail']);
        // exit;

        // $thumb_path = public_path( 'design/template/'. $template_id.'/thumbnails/en/'.$template->previewImageUrls['thumbnail']);
        $thumb_path = $preview_image;
        
        $palette = Palette::fromFilename( $thumb_path );
        $extractor = new ColorExtractor($palette);
        $colors = $extractor->extract(10);

        for ($i=0; $i < sizeof($colors); $i++) { 
            $colors[$i] = Color::fromIntToHex($colors[$i]);
        }
        
        $menu = json_decode(Redis::get('wayak:'.$country.':menu'));

        return view('content.product-detail',[
            'country' => $country,
            'preview_image' => $preview_image,
            'language_code' => $language_code,
            'search_query' => $search_query,
            'menu' => $menu,
            'breadcrumbs' => $this->bread_array,
            'breadcrumb' => $breadcrumbs_obj,
            'template' => $template,
            'colors' => $colors
        ]);
    }
    
    public $bread_array = [];

    
    function getBreadCrumbs( $breadcrumbs_obj ){
        
        if( isset( $breadcrumbs_obj->parent ) ){
            self::getBreadCrumbs( $breadcrumbs_obj->parent );
        }

        $this->bread_array[] = $breadcrumbs_obj;

        // return  $bread_array;
    }

    public function showSearchPage($country, Request $request){
        $language_code = 'en';
        $search_query = '';
        
        $page = 1;
        $per_page = 100;
        $skip = 0;

        if( isset($request->searchQuery) ) {
            $search_query = $request->searchQuery;
            // print_r($search_query);
            // exit;
        }

        if( isset($request->page) ) {
            // print_r($page);
            // exit;
            $page = $request->page;
            $skip = $per_page*($page-1);
        }

        $search_result = Template::where('title', 'like', '%'.$search_query.'%')
            ->skip($skip)
            ->take($per_page)
            ->get([
                'title',
                'forSubscribers',
                // 'category',
                // 'categoryCaption',
                'previewImageUrls'
            ]);
        
        $total_documents = Template::where('title', 'like', '%'.$search_query.'%')->count();
        $from_document = $skip + 1;
        $to_document = $skip + $per_page;
        
        // echo $total_documents;
        // exit;
        $menu = json_decode(Redis::get('wayak:'.$country.':menu'));
        
        return view('content.search',[
            'country' => $country,
            'language_code' => $language_code,
            'menu' => $menu,
            'search_query' => $search_query,
            'page' => $page,
            'from_document' => $from_document,
            'to_document' => $to_document,
            'total_documents' => $total_documents,
            'templates' => $search_result
        ]);
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

        $categories = Redis::keys('wayak:categories:*');
        foreach($categories as $category) {
            $cat_params = [];
            $category_slug = str_replace( 'wayak:categories:',null, $category);

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
}
