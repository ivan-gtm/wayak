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


class CorjlController extends Controller
{
    private $category_ids = [];

    /**
     * Show the application dashboard.
     */
    public function index(Request $request)
    {
        self::generateWayakTemplate();
        exit;
        // self::parseFonts();
        // exit;
        // echo "<pre>";
        // print_r(json_decode(Redis::get('template:en:PKGMWt7qdkH35fZ:jsondata')));
        // exit;

        // echo "<pre>";
        // print_r(json_decode(self::svgToJSON()));
        // exit;
        // self::parseCategoryAndProducts();
        // exit;

        echo "<pre>";
        // $product = Redis::keys('corjl:*');
        $product = Redis::keys('corjl:45IK5');
        // print_r( $product );
        // exit;
        
        $i=0;
        foreach ($product as $product_key) {
            $collection_ids = [];
            $templates_obj = json_decode(Redis::get($product_key));
            $product_key = str_replace('corjl:', null, $product_key);
            
            $fk_metadata = DB::table('tmp_etsy_metadata')
                ->select('id','templett_url')
                ->where('templett_url', 'like', '%'.$product_key)
                ->first();
            
            $total_products = sizeof($templates_obj->templates);
            for ($template_index=0; $template_index < $total_products; $template_index++) { 
                $total_pages = sizeof($templates_obj->templates[$template_index]->pages);
                for ($page_index=1; $page_index <= $total_pages; $page_index++) {
                    $template_id = $product_key;
                    // $templates_obj->templates[$template_index]->pages
                    $svg_filename = 'svg_template_'.$template_index.'_page_'.$page_index.'.svg';
                    echo "\n\n\n\n".$svg_filename.'<hr>';
                    $svg_file_path = public_path().'/corjl/public/design/template/'.$template_id.'/'.$svg_filename;
                    $template_svg_content = self::openSVGTemplate($svg_file_path);
                    
                    $template_json_content = json_decode(self::svgToJSON($template_svg_content));

                    $template_metadata = self::extractPageMetadata($template_json_content);

                    // print_r($template_json_content);
                    // exit;
                }
                # code...
            }
            // print_r( $templates_obj );
            exit;
            
            // print_r( '%'.$product_key );
            // print_r( $metadata_id );
            // exit;
            $parent_template_id = null;
            
            foreach ($templates_obj->templates as $template) {
                $template_id = '3P6DCN';
                // $template_id = self::generateRandString();
                $parent_template_id = ( $parent_template_id == null ) ? $template_id : $parent_template_id;
                // print_r( $template_id );
                // exit;

                // $page->total_pages;
                // $page;
                
                if( isset($template->thumb_url) ){
                    $local_img_path = public_path().'/corjl/public/design/template/'.$template_id.'/thumbnails/en/';
                    $file_name = self::downloadImage( $template->thumb_url, $local_img_path,  $template_id);
                    self::registerThumbOnDB($template_id, $template->name, $file_name, $template->dimentions, $product_key);
                    // exit;
                }

                self::parseTemplatePages($template->pages, $template_id);
                $collection_ids[] = $template_id;

                $db_template_ids[] = self::registerTemplate($template_id, $template->name, $fk_metadata->id, $parent_template_id);
            }


            print_r( "\n\nTEMPLATE KEY >>" . $product_key ."\n");
            print_r( $templates_obj );

            $i++;

            if($i == 10){
                exit;
            }
            // exit;
        }
    }

    function generateWayakTemplate() {
        
        echo "<pre>";
        $product = Redis::keys('corjl:*');
        
        foreach ($product as $product_key) {
            $collection_ids = [];
            $templates_obj = json_decode(Redis::get($product_key));
            $original_product_key = str_replace('corjl:', null, $product_key);
            $parent_template_id = null;
            
            // print_r( $templates_obj );
            // exit;
            
            $fk_etsy_template_id = DB::table('tmp_etsy_metadata')
                ->select('id','templett_url')
                ->where('templett_url', 'like', '%'.$original_product_key)
                ->first();

            if(isset($templates_obj->templates)){
 
                $total_products = sizeof($templates_obj->templates);

                for ($template_index=0; $template_index < $total_products; $template_index++) {
                    $new_template_id = self::generateRandString();
                    $templates_name = $templates_obj->templates[$template_index]->name;
                    $dimentions = str_replace(' x ','x',$templates_obj->templates[$template_index]->dimentions);
                    $parent_template_id = ( $parent_template_id == null ) ? $new_template_id : $parent_template_id;

                    // echo "<pre>";
                    $tdimentions_arr = explode(' ',$dimentions);
                    $dimentions_arr = explode('x',$tdimentions_arr[0]);
                    $measureUnits = $tdimentions_arr[1];
                    $original_width = $dimentions_arr[0];
                    $original_height = $dimentions_arr[1];
                    // print_r( $dimentions_arr  );
                    // print_r( $templates_obj );
                    // exit;

                    $base_json = '["{\"width\": 1728.00, \"height\": 2304.00, \"rows\": 1, \"cols\": 1}",{"version":"2.7.0","objects":[{"type":"image","version":"2.7.0","originX":"center","originY":"center","left":903.969858637,"top":1291.4128696969,"width":4878,"height":6757,"fill":"rgb(0,0,0)","stroke":null,"strokeWidth":0,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeMiterLimit":4,"scaleX":0.4035511785,"scaleY":0.4035511785,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","transformMatrix":null,"skewX":0,"skewY":0,"crossOrigin":"Anonymous","cropX":0,"cropY":0,"src":"https://dbzkr7khx0kap.cloudfront.net/11984_1548096343.png","locked":false,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"filters":[]},{"type":"textbox","version":"2.7.0","originX":"center","originY":"top","left":864,"top":1022.793,"width":521.6418220016,"height":257.414,"fill":"#666666","stroke":null,"strokeWidth":1,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeMiterLimit":4,"scaleX":1,"scaleY":1,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","transformMatrix":null,"skewX":0,"skewY":0,"text":"\nWelcome\n","fontSize":"67","fontWeight":"normal","fontFamily":"font30218","fontStyle":"normal","lineHeight":1.2,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"minWidth":20,"splitByGrapheme":false,"selectable":true,"editable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"styles":{}}],"overlay":{"type":"pattern","source":"function(){return patternSourceCanvas.setDimensions({width:80*scale,height:80*scale}),patternSourceCanvas.renderAll(),patternSourceCanvas.getElement()}","repeat":"repeat","crossOrigin":"","offsetX":0,"offsetY":0,"patternTransform":null,"id":32},"cwidth":1728,"cheight":2304}]';
                    $base_json = json_decode($base_json);
                    
                    if($measureUnits == 'in'){
                        $base_json[0] = str_replace(1728, ceil($original_width *100) , $base_json[0]);
                        $base_json[0] = str_replace(2304, ceil($original_height *100 ) , $base_json[0]);

                        $width = ceil( $original_width *100);
                        $height = ceil( $original_height *100);    
                    } else {
                        $base_json[0] = str_replace(1728, ceil( $original_width  / 3.125) , $base_json[0]);
                        $base_json[0] = str_replace(2304, ceil( $original_height  / 3.125) , $base_json[0]);
        
                        $width = ceil( $original_width / 3.125);
                        $height = ceil( $original_height / 3.125);
                    }

                    // $base_json[0] = str_replace(1728, 480 , $base_json[0]);
                    // $base_json[0] = str_replace(2304, 672 , $base_json[0]);
                    $base_page = $base_json[1];
                    unset($base_json[1]);
                    $base_json = array_values($base_json);
                    // print_r( $base_json );
                    // exit;

                    if( isset( $templates_obj->templates[$template_index]->pages )
                        && is_array( $templates_obj->templates[$template_index]->pages )
                     ) {
                        $total_pages = sizeof( $templates_obj->templates[$template_index]->pages );

                        for ($page_index=1; $page_index <= $total_pages; $page_index++) {
                            $page_objects = [];

                            $new_page_obj = clone($base_page);
                            
                            $new_page_obj->cwidth = $width;
                            $new_page_obj->cwidth = $height;
                            
                            // Example image structure required for new json schema
                            $base_img_obj = $new_page_obj->objects[0];
                            
                            // Example text structure required for new json schema
                            $base_txt_obj = $new_page_obj->objects[1];
                            
                            $svg_filename = 'svg_template_'.$template_index.'_page_'.$page_index.'.svg';
                            // echo "\n\n\n\n PARSING >>".$svg_filename.'<hr>';
                            $svg_file_path = public_path().'/corjl/public/design/template/'.$original_product_key.'/'.$svg_filename;
                            
                            $template_svg_content = self::openSVGTemplate($svg_file_path);
                            $template_json_content = json_decode(self::svgToJSON($template_svg_content));

                            self::extractPageMetadata($template_json_content);

                            $page_metadata = Redis::get('wayak:tmp:corjl:template:metadata');
                            $page_metadata = json_decode($page_metadata);
                            Redis::del('wayak:tmp:corjl:template:metadata');

                            // print_r( "page_metadata>>" );
                            // print_r( $page_metadata );
                            // exit;
                            if(isset($page_metadata->images)){
                                foreach ($page_metadata->images as $page_img) {
                                    
                                    // print_r( $page_img->url );
                                    // exit;
                                    if( isset($page_img->url) ){
                                        $local_img_path = public_path().'/design/template/'.$new_template_id.'/assets/';
                                        self::downloadImage( $page_img->url, $local_img_path,  $new_template_id);
                                    }
                                    
                                    $path_info = pathinfo($page_img->url);
                                    $new_img_obj = self::transformToImgObj($new_template_id, $base_img_obj, $path_info['basename'], $page_img );
            
                                    $page_objects[] = $new_img_obj;
                                }
                            }

                            if(isset($page_metadata->text)){
                                foreach ($page_metadata->text as $page_txt_obj) {
                                    // print_r( $page_txt_obj );
                                    // exit;
                                    $new_txt_obj = self::transformToTxtObj($base_txt_obj, $page_txt_obj, $measureUnits);
                                    $page_objects[] = $new_txt_obj;
                                }
                            }

                            // echo "METADATA >>";
                            $new_page_obj->objects = $page_objects;
                            $new_page_obj->cwidth = $width;
                            $new_page_obj->cheight = $height;

                            $base_json[] = $new_page_obj;
                        }

                        // DOWNLOAD THUMBNAIL 
                        $thumb_url = $templates_obj->templates[$template_index]->thumb_url;
                        $local_img_path = public_path().'/design/template/'.$new_template_id.'/thumbnails/en/';
                        $file_name = self::downloadImage( $thumb_url, $local_img_path,  $new_template_id);

                        // print_r($base_json);
                        // exit;

                        $final_json_template = json_encode($base_json);
                        
                        // print_r($base_json);
                        // print_r($final_json_template);
                        
                        // Saves template on wayak format
                        Redis::set('template:en:'.$new_template_id.':jsondata', $final_json_template);

                        print_r("\n".'  template:en:'.$new_template_id.':jsondata');
            
                        $template_info['template_id'] = $new_template_id;
                        $template_info['title'] = isset($original_template->config->title) ? $original_template->config->title : ' x ';
                        $template_info['filename'] = $new_template_id.'_thumbnail.png';
                        $template_info['dimentions'] = $dimentions;
                        
                        self::registerThumbOnDB($new_template_id, $templates_name, $file_name, $dimentions, $original_product_key);
                        self::registerTemplateOnDB($new_template_id, $templates_name, $fk_etsy_template_id, $parent_template_id, $width, $height, $measureUnits);

                    } else {
                        print_r($templates_obj->templates[$template_index]->pages);
                    }
                }
            }
        }
    }

    function transformToTxtObj($base_txt_obj, $old_obj, $measureUnits){
        $tmp_obj = new \StdClass;;
        $tmp_obj = clone($base_txt_obj);

        // print_r($old_obj->{'font-size'});

         $fonts = DB::table('fonts')
                ->select('font_id','name')
                ->where('name', '=', $old_obj->{'font-family'})
                ->first();

        $tmp_obj->text = trim($old_obj->text);
        $tmp_obj->textAlign = 'center';
        $tmp_obj->originX = 'left';
        // $tmp_obj->originY = 'top';
        if( isset( $fonts->font_id ) ){
            $tmp_obj->fontFamily = $fonts->font_id;
        }
        $tmp_obj->fill = $old_obj->{'fill'};
        
        $font_size = str_replace('px', null, $old_obj->{'font-size'});
        // print_r($old_obj->{'font-size'});

        // if($measureUnits == 'in'){
            $tmp_obj->fontSize = ceil( $font_size / 3.125 );
            $tmp_obj->top = ceil( $old_obj->y / 3.125 );
            $tmp_obj->left = ceil( $old_obj->x / 3.125 );
        // } else {
        //     $tmp_obj->fontSize = ceil($font_size/ 3.125);
        //     $tmp_obj->top = ceil( (( isset($old_obj->y) == false ) ? $old_obj->position->top : $old_obj->y ) / 3.125 );
        //     $tmp_obj->left = ceil((( isset($old_obj->x) == false ) ? $old_obj->position->left : $old_obj->x) / 3.125);
        // }

        $tmp_obj->width = null;
        $tmp_obj->height = null;
        
        // $tmp_obj->left = $old_obj->x;
        // $tmp_obj->top = $old_obj->y;
        
        // echo "<pre>";
        // print_r($old_obj);
        // print_r($tmp_obj);
        // exit;

        return $tmp_obj;
    }

    function parseFonts() {
        // $keys = Redis::keys('corjl:cssfile:*');
        // foreach ($keys as $key) {
        //     Redis::del($key);
        // }
        // exit; 
        
        $global_css_path_urls = public_path().'/corjl/urls/font_css_urls.txt';
        $css_fonts_url = file($global_css_path_urls);
        
        // echo "<pre>";
        // print_r($css_fonts_url);
        
        // DOWNLOAD CSS FONT FILES
        // foreach ($css_fonts_url as $file_url) {
        //     $id = str_replace('https://api.corjl.com/api/font/get-css/', null,$file_url);
        //     $id = str_replace("\n", null,$id);
        //     $file_url = str_replace("\n", null, $file_url);
        //     self::getCSSFontContent($id, $file_url);
        // }
        
        // Parse CSS files in search of font name and url, all matches get registered on database
        // $css_font_files = Redis::keys('corjl:cssfile:*');
        // foreach ($css_font_files as $file_key) {
        //     $css_content = Redis::get($file_key);
        //     preg_match_all("/\{ font-family\: \'(.*)\'; src\: url\(\'(.*)\'\)/",$css_content,$fonts_array);
        //     // echo "<pre>";
        //     // print_r($out);
        //     $total_fonts = sizeof($fonts_array[1]);
        //     for ($i=0; $i < $total_fonts; $i++) { 
        //         $font_name = $fonts_array[1][$i];
        //         $url = $fonts_array[2][$i];
        //         self::registerFontOnDB($font_name, $url);
        //     }
        //     // exit;
        // }

        // Bulk font download
        $ready_for_download = DB::table('fonts')
                        ->select('id','name', 'url','filename')
                        ->where('status','=', 0)
                        ->where('source','=', 'corjl')
                        ->orderby('id','desc')
                        // ->limit(10)
                        ->get();
        echo "<pre>";
        foreach ($ready_for_download as $font) {
            print_r("\n".$font->url);

            // $url_info = pathinfo($font->url);
            // $font_filename = $url_info['basename'];

            // DB::table('fonts')
            // ->where('id', $font->id)
            // ->update(['filename' => $font_filename]);

            // print_r($full_local_font_path);
            $font_url = str_replace("\n",null, $font->url);
            $local_font_path = public_path('design/fonts_new/');
            $filesize = self::downloadFont( $font_url, $local_font_path);
            
            if($filesize > 0){
                DB::table('fonts')
                ->where('id', $font->id)
                ->update(['status' => 1]);
            } else {
                echo "\nDEJAMOS DE RECIBIR ARCHIVOS EN $font->id";
                exit;
            }
        }

    }

    function transformToImgObj($new_template_id, $base_img_obj, $file_name, $img_obj){
        
        $tmp_obj = new \StdClass;;
        $tmp_obj = clone($base_img_obj);
        
        // $img_path = public_path( str_replace('http://localhost:8001/', null, $file_name) );
        // print_r($tmp_obj );
        // print_r($img_obj );
        // exit;

        $tmp_obj->originX = 'left';
        $tmp_obj->originY = 'top';
        // $tmp_obj->top = ceil( $img_obj->y / 3.125 );
        // $tmp_obj->left = ceil( $img_obj->x / 3.125 );
        $tmp_obj->top = 0;
        $tmp_obj->left = 0;
        
        $tmp_obj->scaleX = 0.1528156055;
        $tmp_obj->scaleY = 0.1528156055;

        
        $path_info = pathinfo($img_obj->url);
        $img_path = public_path('/design/template/'.$new_template_id.'/assets/'.$path_info['basename']);

        if( file_exists($img_path) && filesize($img_path) > 0) {
            list($width, $height, $type, $attr) = getimagesize($img_path);
            
            // print_r(getimagesize($img_path));
            // exit;

        }

        $tmp_obj->width = $width;
        $tmp_obj->height = $height;
        $tmp_obj->src = asset('design/template/'.$new_template_id.'/assets/'.$file_name);
        
        // echo "<pre>";
        // print_r($tmp_obj);
        // exit;

        return $tmp_obj;
    }

    function downloadFont( $font_url, $local_font_path){

        $url_info = pathinfo($font_url);
        $full_local_font_path = $local_font_path.$url_info['basename'];

        $path_info = pathinfo($full_local_font_path);
        $path = $path_info['dirname'];
        $file_name = $path_info['basename'];

        if (file_exists($full_local_font_path) == false 
            OR (
                file_exists($full_local_font_path)
                && filesize($full_local_font_path) == 0
            )) {

            // print_r("\n\n".$font_url.'-');
            // print_r("\n\n".$full_local_font_path.'-');
            // exit;
            
            
            @mkdir($path, 0777, true);
        
            set_time_limit(0);
        
            //This is the file where we save the    information
            $fp = fopen ($path . '/'.$file_name, 'w+');
            //Here is the file we are downloading, replace spaces with %20
            $ch = curl_init(str_replace(" ","%20",$font_url));
            curl_setopt($ch, CURLOPT_TIMEOUT, 50);
            // write curl response to file
            curl_setopt($ch, CURLOPT_FILE, $fp); 
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            // get curl response
            curl_exec($ch); 
            curl_close($ch);
            fclose($fp);
        }

        return filesize($full_local_font_path);
    }

    function getCSSFontContent($id, $css_file_url) {
        if( Redis::exists('corjl:cssfile:'.$id) == false ){
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "$css_file_url",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Cookie: corjl_session=eyJpdiI6ImZDYnZqTzg2RWhxY0NsNXF2RENnUUE9PSIsInZhbHVlIjoiWGRSWFBHNERiWVpxUXJOWTJGRHdXZjhUbk1nMnRtQ281NnVBY3NYM1k3NW1FNzc1dWNTdkliMTRFYk5ZeG0yOCIsIm1hYyI6Ijc4NzdlMWI2ZDQ1OTM4OTc2YjZmOTJjZGUyYmM1ZGNlNTUxMmNmYzY4MmVmYzgwNzFlMmVjYWU2MGY1NjBjMTcifQ%3D%3D"
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
            Redis::set('corjl:cssfile:'.$id, $response);
        }

    }

    function extractPageMetadata( $template_obj ) {
        
        if(isset($template_obj->children)){
            foreach( $template_obj->children as $node){
                
                $template_metadata = json_decode( Redis::get('wayak:tmp:corjl:template:metadata') );

                if( isset($node->tagName) && $node->tagName == 'image' ){
                    // echo "\n\nSCRAPPER IMAGE FOUND >>- ";
                    // echo "\n href:>>".$node->properties->{'xlink:href'};
                    // echo "\n width:>>".$node->properties->width;
                    // echo "\n heigth:>>".$node->properties->height;
                    // echo "\n x:>>".$node->properties->x;
                    // echo "\n y:>>".$node->properties->y;
                    $node_info = [
                        'url' => $node->properties->{'xlink:href'},
                        'width' => $node->properties->width,
                        'height' => $node->properties->height,
                        'x' => isset($node->properties->x) ? $node->properties->x : 0,
                        'y' => isset($node->properties->y) ? $node->properties->y : 0
                    ];
                    
                    
                    
                    if( $template_metadata == '' ){
                        $template_metadata = new \stdClass();    
                    }
                    $template_metadata->images[] = $node_info;
                    Redis::set('wayak:tmp:corjl:template:metadata', json_encode( $template_metadata ) );
                    // print_r($template_metadata);
                    // exit;
                    // $template_metadata = ;

                } elseif( isset($node->tagName) && $node->tagName == 'text'){
                    
                    $node_info = [
                        'font-family' => trim(str_replace("&quot;", null, str_replace(", 'Times'",null,$node->properties->{'font-family'}))),
                        'x' => isset($node->properties->{'x'}) ? $node->properties->{'x'} : 0,
                        'y' => isset($node->properties->{'y'}) ? $node->properties->{'y'} : 0,
                        'fill' => isset($node->properties->{'fill'}) ? $node->properties->{'fill'} : null,
                        'font-size' => $node->properties->{'font-size'},
                        'family' => trim( str_replace("&quot;", null, str_replace(", 'Times'",null,$node->properties->{'family'}))),
                        'size' => $node->properties->{'size'}
                    ];

                    if(isset($node->properties->{'font-weight'})) {
                        $node_info['font-weight'] = $node->properties->{'font-weight'};
                    }
                    
                    if(isset( $node->properties->{'letter-spacing'} )) {
                        $node_info['letter-spacing'] = $node->properties->{'letter-spacing'};
                    }
                    
                    self::getText($node);
                    $node_info['text'] = urldecode(Redis::get('wayak:tmp:corjl:text'));
                    Redis::del('wayak:tmp:corjl:text');
                    
                    if( $template_metadata == '' ){
                        $template_metadata = new \stdClass();    
                    }

                    $template_metadata->text[] = $node_info;
                    Redis::set('wayak:tmp:corjl:template:metadata', json_encode( $template_metadata ) );
                    
                }

                self::extractPageMetadata( $node );
            }
        }
    }

    function getText($node) {
        
        if(isset($node->type) && $node->type == 'text'){
            $db_text = Redis::get('wayak:tmp:corjl:text');
            Redis::set('wayak:tmp:corjl:text', $db_text."\n".$node->value);
        }

        if(isset($node->children)){
            foreach ($node->children as $child_node) {
                // echo ' x >>'.$$child_node->properties->{'x'};
                // echo ' dy >>'.$$child_node->properties->{'dy'};
                self::getText($child_node);
                // if( isset($child_node->children) ){
                // }
    
            }
        }
    }
    
    function openSVGTemplate($svg_file_path) {
        $svg_content = file_get_contents($svg_file_path);
        return $svg_content;
    }

    function generateRandString($length = 15) {
		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return substr(str_shuffle($permitted_chars), 0, $length);
	}

    function parseTemplatePages( $pages,$template_id ){
        foreach ($pages as $page) {
            // if( isset($page->thumbnail) ){
            //     $local_img_path = public_path().'/design/template/'.$template_id.'/thumbnails/en/';
            //     $file_name = self::downloadImage( $template->thumb_url,$local_img_path, $template_id);
            //     // self::registerThumbOnDB($template_id, $template->name, $file_name, $template->dimentions);
            // }

            foreach ($page->images as $image_url) {
                // echo $image_url;
                // exit;
                $local_img_path = public_path().'/corjl/public/design/template/'.$template_id.'/assets/';
                $file_name = self::downloadImage( $image_url,$local_img_path, $template_id);
            }
        }
    }
    
    function registerThumbOnDB($template_id, $title, $filename,$dimentions, $product_key){
        
        $thumbnail_rows = DB::table('thumbnails')
                            ->where('template_id','=',$template_id)
                            ->count();
    
        if( $thumbnail_rows == 0 ){
            DB::table('thumbnails')->insert([
                'id' => null,
                'template_id' => $template_id,
                'title' => htmlspecialchars_decode( $title ),
                'filename' => $filename,
                'dimentions' => $dimentions,
                'tmp_templates' => $template_id,
                'language_code' => 'en',
                'status' => 1,
                'original_template_id' => $product_key
            ]);
        }
    }
    
    function registerTemplateOnDB($template_id, $name, $fk_etsy_template_id,$parent_template_id, $width, $height, $measureUnits){
        
        $thumbnail_rows = DB::table('templates')
                            ->where('template_id','=',$template_id)
                            ->count();
    
        if( $thumbnail_rows == 0 ){
            DB::table('templates')->insert([
                'id' => null,
                'source' => 'corjl',
                'template_id' => $template_id,
                // 'name' => htmlspecialchars_decode( $name ),
                'fk_etsy_template_id' => $fk_etsy_template_id->id,
                'status' => 0,
                'parent_template_id' => $parent_template_id,
                'width' => $width,
                'height' => $height,
                'metrics' => $measureUnits
            ]);
        }
    }
    
    function registerFontOnDB($name, $url){
        
        $thumbnail_rows = DB::table('fonts')
                            ->where('name','=',$name)
                            ->count();
    
        if( $thumbnail_rows == 0 ){
            $font_id = self::generateRandString(10);

            DB::table('fonts')->insert([
                'id' => null,
                'name' => $name,
                'url' => $url,
                'font_id' => $font_id,
                'status' => 1,
                'source' => 'corjl'
            ]);
        }
    }
    
    function registerTemplate($template_id, $name, $fk_metadata,$parent_template_id){
        $id = 0;
        $thumbnail_rows = DB::table('templates')
                            ->where('template_id','=',$template_id)
                            ->count();
    
        if( $thumbnail_rows == 0 ){
            $id = DB::table('templates')->insertGetId([
                'id' => null,
                'template_id' => $template_id,
                'name' => htmlspecialchars_decode( $name ),
                'slug' => null,
                'fk_etsy_template_id' => $fk_metadata,
                'parent_template_id' => $parent_template_id,
                // 'demo_templates' => $demo_templates,
                'status' => 1,
                // 'width' => 1,
                // 'heigth' => 1,
                // 'metrics' => 'in'
            ]);
        }
        
        return $id;
    }

    function downloadImage( $img_url, $local_img_path, $template_id ){
        $url_info = pathinfo($img_url);
        $full_local_img_path = $local_img_path.$url_info['basename'];
       
        $path_info = pathinfo($full_local_img_path);
        $path = $path_info['dirname'];
        $file_name = $path_info['basename'];

        if (file_exists($full_local_img_path) == false) {
            
            
            @mkdir($path, 0777, true);
        
            set_time_limit(0);
        
            //This is the file where we save the    information
            $fp = fopen ($path . '/'.$file_name, 'w+');
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

        return $file_name;
    }
    
   

    function svgToJSON($svg_content){
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "nodejs:8080/api/svg2json",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "svg_content=".urlencode($svg_content),
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/x-www-form-urlencoded"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        return $response;

    }
    
}
