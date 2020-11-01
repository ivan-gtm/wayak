<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

ini_set("max_execution_time", 0);   // no time-outs!
ini_set("request_terminate_timeout", 2000);   // no time-outs!
ini_set('memory_limit', -1);
ini_set('display_errors', 1);

ignore_user_abort(true);            // Continue downloading even after user closes the browser.
error_reporting(E_ALL);


class greenController extends Controller
{
    private $category_ids = [];

    /**
     * Show the application dashboard.
     */
    public function index(Request $request)
    {
        // self::parseCategoryAndProducts();
        // exit;

        echo "<pre>";
        $products = Redis::keys('*laravel_database_green:product:*');
        // print_r($products);
        
        foreach ($products as $product_key_name) {
            $product_id = str_replace('laravel_database_green:product:', null, $product_key_name);
            
            // print_r("\n");
            // print_r('laravel_database_green:product_metadata:'.$product_id);
            // print_r($product_id);
            // exit;

            $product_content = Redis::get('laravel_database_green:product_metadata:'.$product_id );
            
            // print_r($product_content);
            // exit;

            if( Redis::exists('laravel_database_green:product_metadata:'.$product_id) == false || 
                ( Redis::exists('laravel_database_green:product_metadata:'.$product_id) && $product_content == null) 
            ){
                // print_r("NO EXISTE");
                // print_r($product_id);
                // exit;

                $product = self::getProduct( $product_id );
                Redis::set('laravel_database_green:product_metadata:'.$product_id, $product );
            }
            
            $product = json_decode( $product_content );
            
            // $scrapper = new GreenScrapper();
            // $product = json_decode($scrapper->getProduct(16862));

            // print_r("<pre>");
            // print_r("\n");
            // print_r( $product );
            // exit;

            // $product_id = $product->config->id;
            if( isset($product->config->pages) ){
                foreach ($product->config->pages as $page) {
    
                    $img_url = 'https://www.greetingsisland.com'.$page->name;
                    $local_img_path = public_path($page->name);
                    $local_img_path = str_replace('\\','/' ,$local_img_path);
                    
                    
                    // echo "<pre>";
                    // echo "\n";
                    // print_r($local_img_path);
                    // exit;

                    if( file_exists( $local_img_path )  == false ){

                        self::downloadImage( $local_img_path, $img_url );
                    }
    
                    // print_r( 'https://www.greetingsisland.com'.$page->name );
    
                    foreach ($page->fields as $field) {
                        // print_r("\n");
                        // print_r($field->font);
                        Redis::SADD('laravel_database_green:template_fonts', $field->font);
                    }
    
                }
            } else {
                print_r("<pre>");
                print_r("\n <h1>PARSING</h1> \n");
                // print_r( $product_id );
                // print_r( Redis::get('laravel_database_green:product_metadata:'.$product_id ) );
                // print_r( json_decode(Redis::get('laravel_database_green:product:'.$product_id )) );
                // print_r( $product );
                // exit;
            }

            // $product = json_decode($product);
            // print_r("\n");
            // print_r($product);
            // exit;
            
        }
    }

    // Transfer current template
    function translateTemplate(){
        // echo $template_id;

        $base_json = '["{\"width\": 1728.00, \"height\": 2304.00, \"rows\": 1, \"cols\": 1}",{"version":"2.7.0","objects":[{"type":"image","version":"2.7.0","originX":"center","originY":"center","left":903.969858637,"top":1291.4128696969,"width":4878,"height":6757,"fill":"rgb(0,0,0)","stroke":null,"strokeWidth":0,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeMiterLimit":4,"scaleX":0.4035511785,"scaleY":0.4035511785,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","transformMatrix":null,"skewX":0,"skewY":0,"crossOrigin":"Anonymous","cropX":0,"cropY":0,"src":"https://dbzkr7khx0kap.cloudfront.net/11984_1548096343.png","locked":false,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"filters":[]},{"type":"textbox","version":"2.7.0","originX":"center","originY":"top","left":864,"top":1022.793,"width":521.6418220016,"height":257.414,"fill":"#666666","stroke":null,"strokeWidth":1,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeMiterLimit":4,"scaleX":1,"scaleY":1,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","transformMatrix":null,"skewX":0,"skewY":0,"text":"\nWelcome\n","fontSize":"67","fontWeight":"normal","fontFamily":"font30218","fontStyle":"normal","lineHeight":1.2,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"minWidth":20,"splitByGrapheme":false,"selectable":true,"editable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"styles":{}}],"overlay":{"type":"pattern","source":"function(){return patternSourceCanvas.setDimensions({width:80*scale,height:80*scale}),patternSourceCanvas.renderAll(),patternSourceCanvas.getElement()}","repeat":"repeat","crossOrigin":"","offsetX":0,"offsetY":0,"patternTransform":null,"id":32},"cwidth":1728,"cheight":2304}]';
        $base_json = json_decode($base_json);

        $base_json[0] = str_replace(1728, 480 , $base_json[0]);
        $base_json[0] = str_replace(2304, 672 , $base_json[0]);
        $base_json[1]->cwidth = 480;
        $base_json[1]->cheight = 672;
        
        // echo "<pre>";
        // print_r( $base_json );
        // exit;

        // Example image structure required for new json schema
        $base_img_obj = $base_json[1]->objects[0];
        
        // Example text structure required for new json schema
        $base_txt_obj = $base_json[1]->objects[1];

        // echo "<pre>";
        // print_r($base_txt_obj);
        // exit;

        echo "<pre>";
        // // print_r( Redis::keys('laravel_database_green:product:*') );
        $products = Redis::keys('laravel_database_green:product:*');
        
        // Parse green island product by product
        foreach ($products as $product_key_name) {
            // print_r("\n$product_key_name");
            
            $original_template_id = str_replace('laravel_database_green:product:', null, $product_key_name);
            
            if( Redis::exists('green:template:'.$original_template_id) ){
                $new_template_id = Redis::get('green:template:'.$original_template_id);
                // echo $new_template_id;
                // exit;
            } else {
                $new_template_id = self::randomNumber(15);
            }
            
            $original_template = json_decode( Redis::get('laravel_database_green:product_metadata:'.$original_template_id ) );
            
            // Transform object to known json format for wayak
            $page_objects = [];

            $thumb_url = str_replace('w=220', 'w=660', $original_template->config->thumbnail);
            $thumb_path = public_path('design/template/'.$new_template_id.'/thumbnails/'.$new_template_id.'_thumbnail.png');
            
            // $path_info = pathinfo($thumb_path);
            // print_r($original_template->config->title);
            // exit;

            // Download template thumbnail
            self::downloadImage(  $thumb_path, $thumb_url );
            // exit;

            foreach ($original_template->config->pages as $page) {

                $new_img_obj = self::transformToImgObj($new_template_id, $base_img_obj, 'http://localhost:8001'.$page->name);
                $page_objects[] = $new_img_obj;

                foreach ($page->fields as $tmp_obj) {
                    $new_txt_obj = self::transformToTxtObj($base_txt_obj, $tmp_obj);
                    $page_objects[] = $new_txt_obj;
                }

                // print_r($page_objects);
                // exit;

            }

            // $page_objects[] = $new_img_obj;
            // print_r($page_objects);
            // exit;

            $base_json[1]->objects = $page_objects;
            
            // if( $original_template_id == 19815){
            //     print_r( $original_template );
            //     print_r( $base_json );
            //     exit;
            // }

            $final_json_template = json_encode($base_json);
            $final_json_template = str_replace('~',"\\n",$final_json_template);
            
            // print_r( $base_json );
            // exit;

            // Saves template on wayak format
            Redis::set('template:'.$new_template_id.':jsondata', $final_json_template);
            Redis::set('green:template:'.$original_template_id, $new_template_id);

            $template_info['template_id'] = $new_template_id;
            $template_info['title'] = isset($original_template->config->title) ? $original_template->config->title : ' x ';
            $template_info['filename'] = $new_template_id.'_thumbnail.png';
            $template_info['dimentions'] = '4x7 in';
            
            self::registerThumbnailsOnDB($template_info);
            
            // print_r($template_info);
            // exit;
            
        }
        
    }

    function registerThumbnailsOnDB($template_info){
		$thumbnail = DB::table('thumbnails')
						->select('id')
						->where('template_id','=', $template_info['template_id'] )
						->first();

		if( isset( $thumbnail->id ) == false ){
			DB::table('thumbnails')->insert([
				'id' => null,
				'template_id' => $template_info['template_id'],
				'title' => htmlspecialchars_decode($template_info['title']),
				'filename' => $template_info['filename'],
				'tmp_original_url' => null,
				'dimentions' => $template_info['dimentions'],
				'tmp_templates' => $template_info['template_id'],
				'status' => 1
			]);
			return true;
		}
		return false;
	}
    
    function transformToImgObj($new_template_id, $base_img_obj, $background_img_url ){
        
        $tmp_obj = new \StdClass;;
        $tmp_obj = clone($base_img_obj);
        
        $img_path = public_path( str_replace('http://localhost:8001/', null, $background_img_url) );
        $img_path = str_replace('’', null, $img_path);
        $img_path = str_replace('ñ', 'n', $img_path);
        $img_path = str_replace('‘', null, $img_path);
        $img_path = str_replace('é', 'e', $img_path);

        $tmp_obj->src = $background_img_url;
        $tmp_obj->top = 0;
        $tmp_obj->left = 0;

        if( file_exists( $img_path ) ){

            if( filesize($img_path) == 0 ){
                echo $img_path;
                exit;
            }

            list($img_width, $img_height, $img_type, $img_attr) = getimagesize( $img_path );
            $tmp_obj->width = $img_width;
            $tmp_obj->height = $img_height;
            
            
            $original_path_info = pathinfo($img_path);
            // $template_id = self::randomNumber(10);
            $media_id = self::randomNumber(10);
            
            $full_file_path = public_path('design/template/'.$new_template_id.'/assets/'.$media_id.'.'.$original_path_info['extension']);
            $path_info = pathinfo($full_file_path);
            $path = $path_info['dirname'];
            
            @mkdir( $path_info['dirname'] , 0777, true);
            
            // echo "<pre>";
            // print_r($path_info);
            // print_r(  );
            // exit;
            
            if (!copy($img_path, $full_file_path)) {
                echo "failed to copy $file...\n";
                exit;
            }
            
            $tmp_obj->src = asset('design/template/'.$new_template_id.'/assets/'.$media_id.'.'.$original_path_info['extension']);

        }
        
        // echo "<pre>";
        // print_r($tmp_obj);
        // exit;

        return $tmp_obj;
    }

    function randomNumber($length = 15) {
		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return substr(str_shuffle($permitted_chars), 0, $length);
	}

    function transformToTxtObj($base_txt_obj, $old_obj){
        $tmp_obj = new \StdClass;;
        $tmp_obj = clone($base_txt_obj);

        $tmp_obj->text = trim($old_obj->text);
        $tmp_obj->textAlign = $old_obj->align;
        // $tmp_obj->fontFamily = $old_obj->font;
        $tmp_obj->fill = '#'.$old_obj->color;
        // falta mapear $old_obj->rotation
        $tmp_obj->fill = $old_obj->color;
        $tmp_obj->fontSize = $old_obj->size;
        $tmp_obj->fontFamily = 'font7';
        // $tmp_obj->left = $old_obj->x;
        $tmp_obj->top = $old_obj->y;
        $tmp_obj->left = 240;
        
        
        $tmp_obj->originY = 'center';

        // print_r($tmp_obj);
        // echo "<pre>";
        // print_r($tmp_obj->text);
        // print_r($old_obj->text);
        // print_r($tmp_obj);
        // exit;

        return $tmp_obj;
    }

    function parseCategoryAndProducts(){
        // $user = Redis::set('user:profile', "daniel");
        // $user = Redis::get('user:profile');

        // echo $user;
        // exit;

        // echo "<pre>";
        // echo "<style>body{ background-color:black;color:white;font-size:16px; }</style>";

        // $categories = self::getCategories();
        // Redis::set('laravel_database_green:categories', $categories);

        $cats_arr = [];
        $categories = json_decode(Redis::get('laravel_database_green:categories'));

        // print_r($categories);
        // exit;

        foreach($categories->CategoryTree as $category){
            self::parseCategoryIds($category);
        }

        // print_r("\n");
        // print_r( self::getCategoryIds() );
        // exit;

        $categoryIds = self::getCategoryIds();

        foreach ($categoryIds as $category_id) {
            // print_r("\n");
            // print_r( $category_id );
            $total_page_number = 100;
            $itemsPerPage = 14;
            
            for ($current_page=0; $current_page < $total_page_number; $current_page++) { 
                
                $product_result = self::getProducts($current_page, $itemsPerPage, $category_id);
                $total_page_number = ceil($product_result->ResultsCount / $itemsPerPage);

                // Store product´s resulset per page
                Redis::set('laravel_database_green:categories:'.$category_id.':page:'.$current_page, json_encode($product_result) );
                
                // print_r("\n");
                // print_r( "\n PARSING:: ". $current_page );
                // print_r( "\n TOTAL PAGES:: ". $total_page_number );
                // print_r("\n");
                // print_r( $product_result );
                foreach ($product_result->Results as $product) {
                    // echo '<img src="'.$product->PreviewImage.'">';
                    
                    Redis::set('laravel_database_green:category:'.$category_id.':product:'.$product->Id, json_encode($product) );
                    Redis::set('laravel_database_green:product:'.$product->Id, json_encode($product) );

                    // print_r("\n");
                    // print_r( $product );
                    // exit;
                    
                    // // $path_info = pathinfo($new_path); // dirname, filename, extension
                    // $template_id = $product->Id;
                    
                    // $path = 'design/template/'.$template_id.'/assets';
                    // $download_url = $product->PreviewImage;

                    // if( file_exists($path . '/preview.jpg')  == false ) {
                    //     // echo "existe";
                    //     // exit;
                    //     self::downloadImage( $template_id, 'preview.jpg', $download_url );
                    // }

                }
                // exit;
                
            }

            // exit;
        }

        // getProducts(1, 14, 592);
        // self::getTemplate(21389);

        // self::downloadImage( 23123, 'ejemplo.jpg', 'https://images.greetingsisland.com/images/invitations/wedding/garden%20wreath%20&%20rings1.jpg');
    }

    function getCategories(){
        
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.greetingsisland.com/mobile/GetMobileAppData?samVer=dev",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Host: www.greetingsisland.com",
            "accept: application/json, text/plain, */*",
            "origin: ionic://localhost",
            "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148",
            "accept-language: en-us",
            "Pragma: no-cache",
            "Cache-Control: no-cache",
            "Cookie: __cfduid=dcea7e29d5a091be256d9fd4fffc21dc51600427362; lang=en"
        ),
        ));
    
        $response = curl_exec($curl);
    
        curl_close($curl);
        
        // echo "<pre>";
        // echo "<style>body{ background-color:black;color:white;font-size:16px; }</style>";
        // print_r( json_decode($response) );
        // return json_decode($response);
        return $response;
    }
    
    function getProducts($pageNum = 0, $itemsPerPage=14, $categoryId = 592){
    
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.greetingsisland.com/mobile/search?&pageNum=$pageNum&itemsPerPage=$itemsPerPage&categoryId=$categoryId&samVer=dev",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Host: www.greetingsisland.com",
            "accept: application/json, text/plain, */*",
            "origin: ionic://localhost",
            "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148",
            "accept-language: en-us",
            "Pragma: no-cache",
            "Cache-Control: no-cache",
            "Cookie: __cfduid=dcea7e29d5a091be256d9fd4fffc21dc51600427362; lang=en"
        ),
        ));
    
        $response = curl_exec($curl);
    
        curl_close($curl);
    
        // echo "<pre>";
        // echo "<style>body{ background-color:black;color:white;font-size:16px; }</style>";
        return json_decode($response);
    }
    
    function getTemplate($cardId){
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.greetingsisland.com/mobile/getCardConfig?cardId=$cardId&samVer=dev",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Host: www.greetingsisland.com",
            "accept: application/json, text/plain, */*",
            "origin: ionic://localhost",
            "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148",
            "accept-language: en-us",
            "Pragma: no-cache",
            "Cache-Control: no-cache",
            "Cookie: __cfduid=dcea7e29d5a091be256d9fd4fffc21dc51600427362; lang=en"
        ),
        ));
    
        $response = curl_exec($curl);
    
        curl_close($curl);
        
        echo "<pre>";
        echo "<style>body{ background-color:black;color:white;font-size:16px; }</style>";
        print_r( json_decode($response) );
    
    }
    
    function downloadImage(  $local_img_path, $img_url ){
        
        $path_info = pathinfo($local_img_path);
        
        $path = $path_info['dirname'];

        // print_r("<pre>");
        // print_r($path_info['dirname']);
        // print_r($path);
        // print_r($path_info);
        // print_r('FUNCTION :::downloadImage');
        // print_r($local_img_path);
        // exit;
    
        @mkdir($path, 0777, true);
    
        set_time_limit(0);
    
        //This is the file where we save the    information
        $fp = fopen ($local_img_path, 'w+');
    
        //Here is the file we are downloading, replace spaces with %20
        $ch = curl_init(str_replace(" ","%20",$img_url));
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        
        // write curl response to file
        curl_setopt($ch, CURLOPT_FILE, $fp); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        // get curl response
        curl_exec($ch); 
        curl_close($ch);
        fclose($fp);
    }

    function parseCategoryIds($category, Request $request){
        
        // if( isset($category->Children) && sizeof($category->Children) > 0 ){
            foreach ($category->Children as $child) {
                self::parseCategoryIds($child);
            }
        // }

        // print_r($category);
        // print_r("\n\nCategoryId -- ");
        // print_r($category->CategoryId);
        // print_r("\n\n");

        // if( $category->CategoryId == 203 || $category->ParentCategoryId == 203 ){
            $this->category_ids[] = $category->CategoryId;
        // }
    }

    function getCategoryIds(){
        // echo "hi";
        return $this->category_ids;
    }

    function getProduct($product_id){
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.greetingsisland.com/mobile/getCardConfig?cardId=$product_id&samVer=dev",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Host: www.greetingsisland.com",
            "accept: application/json, text/plain, */*",
            "origin: ionic://localhost",
            "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148",
            "accept-language: en-us",
            "Pragma: no-cache",
            "Cache-Control: no-cache",
            "Cookie: __cfduid=dcea7e29d5a091be256d9fd4fffc21dc51600427362"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }

    /// MIGRATION
    /// MIGRATION
    /// MIGRATION
    /// MIGRATION
    /// MIGRATION
    /// MIGRATION
    /// MIGRATION

    function getFrontCategories(){
        $category_tree = $this->getREDISCategories();
        
        // echo "<pre>";
        // print_r($category_tree);
        // exit;

        return view('green_categories',[ 'category_tree' => $category_tree->CategoryTree ]);
    }

    function getREDISCategories(){
        return json_decode( Redis::get('laravel_database_green:categories') );
    }
    
    function getREDISCategoryProducts($category_id, $page = 0){
        $category_object = json_decode(Redis::get('laravel_database_green:categories:'.$category_id.':page:'.$page));
        return $category_object->Results;
    }

    function getTotalCategoryProductsPages($category_id){
        // echo "<pre>";
        return sizeof(Redis::keys('laravel_database_green:categories:'.$category_id.':page:*'));
    }

    function getFrontCategoryProducts($category_id, Request $request){
        // print_r( json_decode(Redis::get('laravel_database_green:categories:'.$category_id.':page:0')) );
        $page = $request->input('page');
        $total_pages = $this->getTotalCategoryProductsPages($category_id);
        $product_result = $this->getREDISCategoryProducts($category_id, $page);

        $product_result_size = sizeof($product_result);

        for ($i=0; $i < $product_result_size; $i++) { 
            $product_result[$i]->Id = Redis::get('green:template:'.$product_result[$i]->Id);
        }
        
        // echo "<pre>";
        // print_r($product_result);
        // exit;

        return view('green_products',[ 
            'total_pages' => $total_pages,
            'category_id' => $category_id,
            'product_result' => $product_result
        ]);
    }

    function getAllCategories(){
        $invitation_categories = Redis::sMembers('green:invitation_cats');

        return view('green_cats',[ 
            'categories' => $invitation_categories
        ]);
    }
    function getAllProducts(Request $request){
        // echo "<pre>";
        // print_r( Redis::sMembers('green:invitation_cats') );
        // print_r( $request->category_id );
        // exit;
        
        // 
        
        // $templates = Redis::keys('green:ready_template:*');
        // foreach ($templates as $template_key) {
        //     $template_id = str_replace('green:ready_template:', null,$template_key);
        //     Redis::rename($template_key, 'product:production_ready:'.$template_id);
        // }
        // echo "<pre>";
        // print_r( Redis::keys('product:production_ready:*') );
        // exit;
        
        
        $products = [];
        $category_id = $request->category_id;
        $total_pages = $this->getTotalCategoryProductsPages($category_id);
        
        for ($page=1; $page < $total_pages; $page++) { 
            $product_result = $this->getREDISCategoryProducts($category_id, $page);
            $product_result_size = sizeof($product_result);

            for ($i=0; $i < $product_result_size; $i++) { 
                $product_result[$i]->Id = Redis::get('green:template:'.$product_result[$i]->Id);
                
                if( Redis::exists('product:production_ready:'.$product_result[$i]->Id) ){
                    unset($product_result[$i]);
                }
            }

            $products = array_merge($products, $product_result);
            
        }

        return view('all_cat_products',[ 
            'total_pages' => $total_pages,
            'category_id' => $category_id,
            'product_result' => $products
        ]);
        
        echo "<pre>";
        print_r($products);
        exit;

        // Build unique array of categories for invitations
        $category_tree = $this->getREDISCategories();
        echo "<pre>";
        $categories_number = sizeof( $category_tree->CategoryTree );
        for ($i=0; $i < $categories_number; $i++) {
            if( $category_tree->CategoryTree[$i]->SectionName == 'Invitations' ){
                
                // print_r( $category_tree->CategoryTree[$i]->CategoryId);
                $cat_id = $category_tree->CategoryTree[$i]->CategoryId;
                Redis::sAdd('green:invitation_cats', $cat_id);
                
                if(isset($category_tree->CategoryTree[$i]->Children)){
                    $children = $category_tree->CategoryTree[$i]->Children;
                    $children_size = sizeof( $category_tree->CategoryTree[$i]->Children );

                    $child_cat_id = $category_tree->CategoryTree[$i]->CategoryId;
                    Redis::sAdd('green:invitation_cats', $child_cat_id);

                    for ($j=0; $j < $children_size; $j++) {
                        
                        // print_r($children[$j]);

                        if(isset($children[$j]->Children)){
                            $subchildren = $children[$j]->Children;
                            $subchildren_size = sizeof( $children[$j]->Children );

                            for ($k=0; $k < $subchildren_size; $k++) {
                                
                                // print_r($subchildren[$k]);

                                $subchild_cat_id = $subchildren[$k]->CategoryId;
                                Redis::sAdd('green:invitation_cats', $subchild_cat_id);

                            }

                        }
                    }
                }
            }
        }
        exit;
    }

}
