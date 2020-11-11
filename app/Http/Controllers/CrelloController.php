<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

ini_set("max_execution_time", 0);   // no time-outs!
ini_set("request_terminate_timeout", 2000);   // no time-outs!
ini_set('memory_limit', -1);
ini_set('display_errors', 1);

ignore_user_abort(true);            // Continue downloading even after user closes the browser.
error_reporting(E_ALL);

class CrelloController extends Controller
{
    public function index(){
        // $this->parseAllSearchResults();
        // exit;

        // for ($page=0; $page <= 156; $page++) {
        //     $search_results = $this->getLocalSearchResults($page);
        //     // print_r("\n");
        //     // print_r($search_results->results);
        //     // exit;
        //     // print_r('---\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\---');
        //     foreach($search_results->results as $template){
        //         $this->getTemplate($template->id);
        //     }
        // }
        // exit;

        // $categories = [
        //     'EO',
        //     'MM',
        //     'HC',
        //     'BG',
        //     'SM',
        //     'SMA',
        //     'AN',
        // ];
        // print_r("\n");
        // print_r($categories);
        // print_r('---\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\---');
        // exit;

        $templates = Redis::keys('crello:template:*');

        echo "<pre>";
        // print_r("\n");
        // print_r($templates);
        // exit;

        // $templates = [
        //     'crello:template:5e4facf41cc98b350aeffff1'
        // ];

        foreach($templates as $template_key) {

			$template_obj = json_decode(Redis::get($template_key));

            if( isset($template_obj->template) ){

				// echo "<pre>";
                print_r("\n\nPARSING::>>".$template_obj->id );

				$template_id = $template_obj->id;
				$this->downloadTemplateThumbnail( $template_id );
				
				foreach ($template_obj->template as $template) {
                    foreach ( $template->elements as $page_element ) {

                        if( isset($page_element->type) ){

                            // if( $page_element->type == 'maskElement' ){
							// 	echo "\n >>> <pre>";
                            //     print_r( $page_element );
                            //     exit;
                            // }

                            if( $page_element->type == 'imageElement' ){
								$this->downloadImageAsset($template_id, $page_element->mediaId);
                            } elseif( $page_element->type == 'svgElement' ){
								$this->downloadSVGAsset($template_id, $page_element->mediaId);
							} elseif( $page_element->type == 'videoElement1' ){
								$this->downloadMP4Asset($template_id, $page_element->mediaId);
							}

                            if( isset($page_element->elements) ){

                                foreach ( $page_element->elements as $subelement_type ) {
                                    if( $subelement_type->type == 'imageElement' ){
                                        $this->downloadImageAsset($template_id, $subelement_type->mediaId);
                                        // exit;
                                    } elseif( $subelement_type->type == 'svgElement' ){
                                        $this->downloadSVGAsset($template_id, $subelement_type->mediaId);
                                        // exit;
                                    } elseif( $page_element->type == 'videoElement1' ){
                                        $this->downloadMP4Asset($template_id, $page_element->mediaId);
                                        // exit;
                                    }
                                }

                            }
                            //     case 'textElement1':
                            //     case 'coloredBackground1':
                            //     case 'maskElement1'
                            //     case 'persistGroupElement1':
                        }

                    }
                }
            }
        }
        echo "TERMINE";
    }

    function explore(Request $request){
        
        // echo "<pre>";
        // for ($current_page_number=1; $current_page_number < $total_pages_number; $current_page_number++) {
            // print_r($product_result);
            // }
        $page = $request->page;
        
        $page_from = $request->page;
        $page_to = $request->page + 10;

        $total_pages_number = sizeof(Redis::keys('crello:search:results:page*'));
        $product_result = json_decode(Redis::get('crello:search:results:page:'.$page));

        // echo "<pre>";
        // print_r($product_result);
        // exit;
        
        return view('crello.products',[ 
            'page_from' => $page_from,
            'page_to' => $page_to,
            'total_pages' => $total_pages_number,
            'product_result' => $product_result
        ]);
    }

    function translateTemplate(){
        

        $base_json = '["{\"width\": 1728.00, \"height\": 2304.00, \"rows\": 1, \"cols\": 1}",{"version":"2.7.0","objects":[{"type":"image","version":"2.7.0","originX":"center","originY":"center","left":903.969858637,"top":1291.4128696969,"width":4878,"height":6757,"fill":"rgb(0,0,0)","stroke":null,"strokeWidth":0,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeMiterLimit":4,"scaleX":0.4035511785,"scaleY":0.4035511785,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","transformMatrix":null,"skewX":0,"skewY":0,"crossOrigin":"Anonymous","cropX":0,"cropY":0,"src":"https://dbzkr7khx0kap.cloudfront.net/11984_1548096343.png","locked":false,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"filters":[]},{"type":"textbox","version":"2.7.0","originX":"center","originY":"top","left":864,"top":1022.793,"width":521.6418220016,"height":257.414,"fill":"#666666","stroke":null,"strokeWidth":1,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeMiterLimit":4,"scaleX":1,"scaleY":1,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","transformMatrix":null,"skewX":0,"skewY":0,"text":"\nWelcome\n","fontSize":"67","fontWeight":"normal","fontFamily":"font30218","fontStyle":"normal","lineHeight":1.2,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"minWidth":20,"splitByGrapheme":false,"selectable":true,"editable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"styles":{}}],"overlay":{"type":"pattern","source":"function(){return patternSourceCanvas.setDimensions({width:80*scale,height:80*scale}),patternSourceCanvas.renderAll(),patternSourceCanvas.getElement()}","repeat":"repeat","crossOrigin":"","offsetX":0,"offsetY":0,"patternTransform":null,"id":32},"cwidth":1728,"cheight":2304}]';
        $base_json = json_decode($base_json);
        
        // Example image structure required for new json schema
        $base_img_obj = $base_json[1]->objects[0];
        // Example text structure required for new json schema
        $base_txt_obj = $base_json[1]->objects[1];
        $base_SVG_obj = json_decode('{"type":"group","version":"2.7.0","originX":"center","originY":"center","left":540,"top":960,"width":1087.8,"height":1087.8,"fill":"rgb(0,0,0)","stroke":null,"strokeWidth":0,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeMiterLimit":4,"scaleX":1,"scaleY":1,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","transformMatrix":null,"skewX":0,"skewY":0,"src":"http://localhost:8001/design/template/ejemplo/5a2fb0dbd8141396fe9b528b.svg","svg_custom_paths":[],"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"objects":[],"path":[]}');

        $total_pages_number = sizeof(Redis::keys('crello:search:results:page*'));
        
        // print_r($total_pages_number);
        // exit;


        echo "<pre>";
        for ($current_page_number=1; $current_page_number < $total_pages_number; $current_page_number++) {
            
            $product_result = json_decode(Redis::get('crello:search:results:page:'.$current_page_number));
            $total_products_per_page = sizeof($product_result->results);

            for ($template_index=0; $template_index < $total_products_per_page; $template_index++) {
                $dummy_template = $base_json;
                $template_info = $product_result->results[$template_index];

                $template_obj = json_decode(Redis::get('crello:template:'.$template_info->id));
                // $template_obj = json_decode(Redis::get('crello:template:590af68595a7a863ddcd6a90'));
                
                if( isset($template_obj->id) ){
                    $template_id = $template_obj->id;
                } else {
                    // print_r($template_obj);
                    // exit;
                    continue;
                }
                
                if($template_obj->measureUnits == 'inch'){
                    $dummy_template[0] = str_replace(1728, ceil($template_obj->width *100) , $dummy_template[0]);
                    $dummy_template[0] = str_replace(2304, ceil($template_obj->height *100 ) , $dummy_template[0]);

                    $dummy_template[1]->cwidth = ceil($template_obj->width *100);
                    $dummy_template[1]->cheight = ceil($template_obj->height *100);    
                } else {
                    $dummy_template[0] = str_replace(1728, ceil($template_obj->width  / 3.125) , $dummy_template[0]);
                    $dummy_template[0] = str_replace(2304, ceil($template_obj->height  / 3.125) , $dummy_template[0]);
    
                    $dummy_template[1]->cwidth = ceil($template_obj->width / 3.125);
                    $dummy_template[1]->cheight = ceil($template_obj->height / 3.125);
                }

                // // print_r($template_obj);
                // print_r($dummy_template);
                // echo "<br>";


                $page_objects = [];

                foreach( $template_obj->template as $template_pages ){
                    foreach( $template_pages->elements as $element ){
                        // print_r($element);
                        // exit;
                        if( $element->type == 'imageElement'){
                            $new_img_obj = self::transformToImgObj($base_img_obj, $template_id, $element, $template_obj->measureUnits );
                            $page_objects[] = $new_img_obj;
                        } elseif( $element->type == 'maskElement'){
                            
                            if( isset( $element->elements ) ){
                                
                                foreach ($element->elements as $subelement) {
                                    if( $subelement->type == 'imageElement'){
    
                                        $subelement->top = $element->top;
                                        $subelement->left = $element->left;
                                        
    
                                        // print_r($subelement);
                                        // exit;
    
                                        $new_img_obj = self::transformToImgObj($base_img_obj, $template_id, $subelement, $template_obj->measureUnits);
                                        $page_objects[] = $new_img_obj;
                                    } elseif( $subelement->type == 'textElement'){
                                        $new_txt_obj = self::transformToTxtObj($base_txt_obj, $subelement, $template_obj->measureUnits );
                                        $page_objects[] = $new_txt_obj;
                                    }
                                }
                            } else {
                                // print_r( $element );
                                // exit;
                            }

                        } elseif( $element->type == 'svgElement'){
                            $new_SVG_obj = self::transformToSVGObj($base_SVG_obj, $template_id, $element, $template_obj->measureUnits );
                            $page_objects[] = $new_SVG_obj;
                        } elseif( $element->type == 'textElement'){
                            $new_txt_obj = self::transformToTxtObj($base_txt_obj, $element, $template_obj->measureUnits );
                            $page_objects[] = $new_txt_obj;
                        }
                    }
                }

                $dummy_template[1]->objects = $page_objects;


                // Redis::set('template:18625:jsondata', json_encode($dummy_template));
                Redis::set('template:'.$template_id.':jsondata', json_encode($dummy_template));
                
                // print_r("dummy_template");
                // print_r($dummy_template);
                // exit;
                
            }
        }
    }

    function downloadTemplateSource($template_id, $downloadUrl, $filename){

        set_time_limit(0);

        $full_file_path = public_path('design/template/'.$template_id.'/source/'.$filename);
        $path_info = pathinfo($full_file_path);
        $path = $path_info['dirname'];

        if( file_exists( $full_file_path )  == false ){

            $curl = curl_init();

            @mkdir($path, 0777, true);

            //This is the file where we save the    information
            $fp = fopen ($full_file_path, 'w+');

            curl_setopt_array($curl, array(
                CURLOPT_URL => $downloadUrl,
                // CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                // write curl response to file
                CURLOPT_FILE => $fp,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "authority: cdn.crello.com",
					"origin: https://crello.com",
					"user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36",
					"accept: image/avif,image/webp,image/apng,image/*,*/*;q=0.8",
					"sec-fetch-site: same-site",
					"sec-fetch-mode: cors",
					"sec-fetch-dest: image",
					"referer: https://crello.com/",
					"accept-language: es"
                ),
            ));

            curl_exec($curl);

            curl_close($curl);

            fclose($fp);
        }

	}

    function transformToSVGObj($base_SVG_obj, $template_id, $element, $unit ){
        $tmp_obj = new \StdClass;;
        $tmp_obj = clone($base_SVG_obj);
        
        // $tmp_obj->left = ( isset($element->left) == false ) ? $element->position->left : $element->left ;
        // $tmp_obj->top = ( isset($element->top) == false ) ? $element->position->top : $element->top ;
        // $tmp_obj->width = $element->width;
        // $tmp_obj->height = $element->height;

        if($unit == 'inch'){
            $tmp_obj->top = ceil( (( isset($element->top) == false ) ? $element->position->top : $element->top) *1.125 ) ;
            $tmp_obj->left = ceil( (( isset($element->left) == false ) ? $element->position->left : $element->left) *1.125 );
            $tmp_obj->width = ceil( $element->width *1.125);
            $tmp_obj->height = ceil( $element->height*1.125 );
        } else {
            $tmp_obj->top = ceil( (( isset($element->top) == false ) ? $element->position->top : $element->top) / 3.125 ) ;
            $tmp_obj->left = ceil( (( isset($element->left) == false ) ? $element->position->left : $element->left) / 3.125 );
            $tmp_obj->width = ceil( $element->width / 3.125);
            $tmp_obj->height = ceil( $element->height/ 3.125 );
        }

        $asset_id = $element->mediaId;
        $tmp_obj->src = 'http://localhost:8001/design/template/'.$template_id.'/assets/'.$asset_id.'.svg';

        $tmp_obj->angle = isset( $element->angle ) ? $element->angle : null;
        $tmp_obj->opacity = isset($element->opacity) ? $element->opacity : 1;

        // echo "<pre>";
        // print_r($tmp_obj);
        // exit;

        // echo "<pre>";
        // // print_r($base_img_obj);
        // print_r($tmp_obj);
        // exit;

        return $tmp_obj;
    }

    function transformToImgObj($base_img_obj, $template_id, $element, $unit ){
        $tmp_obj = new \StdClass;;
        $tmp_obj = clone($base_img_obj);

        $asset_id = $element->mediaId;

        $tmp_obj->src = 'http://localhost:8001/design/template/'.$template_id.'/assets/'.$asset_id.'.jpg';
        
        $file_exists = false;
        
        if( file_exists( public_path('/design/template/'.$template_id.'/assets/'.$asset_id.'.jpg') ) ){
            print_r('PARSING:>> '.'/design/template/'.$template_id.'/assets/'.$asset_id.'.jpg'."\n");
            try {
                list($img_width, $img_height, $img_type, $img_attr) = getimagesize(public_path('/design/template/'.$template_id.'/assets/'.$asset_id.'.jpg'));
            } catch (\Throwable $th) {
                echo "Error >> ".public_path('/design/template/'.$template_id.'/assets/'.$asset_id.'.jpg');
                Redis::set('crello:missing_assets:'.$template_id.':'.$asset_id,1);
                // throw $th;
                if($unit == 'inch'){
                    $img_width = ceil( $element->width *1.125);
                    $img_height = ceil( $element->height*1.125 );
                } else {
                    $img_width = ceil( $element->width / 3.125);
                    $img_height = ceil( $element->height/ 3.125 );
                }

            }
        } else {
            
            Redis::set('crello:missing_assets:'.$template_id,1);

            if($unit == 'inch'){
                $img_width = ceil( $element->width *1.125);
                $img_height = ceil( $element->height*1.125 );
            } else {
                $img_width = ceil( $element->width / 3.125);
                $img_height = ceil( $element->height/ 3.125 );
            }
        }

        if($unit == 'inch'){
            $tmp_obj->top = ceil( (( isset($element->top) == false ) ? $element->position->top : $element->top) *1.125 ) ;
            $tmp_obj->left = ceil( (( isset($element->left) == false ) ? $element->position->left : $element->left) *1.125 );
        } else {
            $tmp_obj->top = ceil( (( isset($element->top) == false ) ? $element->position->top : $element->top) / 3.125 ) ;
            $tmp_obj->left = ceil( (( isset($element->left) == false ) ? $element->position->left : $element->left) / 3.125 );
        }

        $tmp_obj->width = $img_width;
        $tmp_obj->height = $img_height;
        $tmp_obj->angle = isset( $element->angle ) ? $element->angle : null;
        $tmp_obj->opacity = isset($element->opacity) ? $element->opacity : 1;

        return $tmp_obj;
    }

    function transformToTxtObj($base_txt_obj, $old_obj, $unit){
        $tmp_obj = new \StdClass;;
        $tmp_obj = clone($base_txt_obj);

        $tmp_obj->text = trim($old_obj->text);
        $tmp_obj->textAlign = $old_obj->textAlign;
        
        $tmp_obj->originX = 'center';
        $tmp_obj->originY = 'center';

        // $tmp_obj->fontFamily = $old_obj->font;
        $tmp_obj->fontFamily = 'font7';
        $tmp_obj->fill = '#'.$old_obj->colorMap[0]->value;
        // falta mapear $old_obj->rotation
        // $tmp_obj->left = $old_obj->x;
        
        if($unit == 'inch'){
            $tmp_obj->fontSize = ceil($old_obj->fontSize*1.3);
            $tmp_obj->top = ceil( (( isset($old_obj->top) == false ) ? $old_obj->position->top : $old_obj->top ) *1.125 );
            $tmp_obj->left = ceil((( isset($old_obj->left) == false ) ? $old_obj->position->left : $old_obj->left) *1.125);
            $tmp_obj->width = ceil( $old_obj->width *1.125 );
            $tmp_obj->height = ceil( $old_obj->height *1.125 );
        } else {
            $tmp_obj->fontSize = ceil($old_obj->fontSize/ 3.125);
            $tmp_obj->top = ceil( (( isset($old_obj->top) == false ) ? $old_obj->position->top : $old_obj->top ) / 3.125 );
            $tmp_obj->left = ceil((( isset($old_obj->left) == false ) ? $old_obj->position->left : $old_obj->left) / 3.125);
            $tmp_obj->width = ceil( $old_obj->width / 3.125 );
            $tmp_obj->height = ceil( $old_obj->height / 3.125 );
        }

        // $tmp_obj->angle = isset( $element->angle ) ? $element->angle : null;
        $tmp_obj->opacity = isset($old_obj->opacity) ? $old_obj->opacity : 1;
        
        if( isset($old_obj->lineHeight) ){
            $tmp_obj->lineHeight = $old_obj->lineHeight;
        }


        // $tmp_obj->originY = 'center';

        // echo "<pre>";
        // print_r($old_obj);
        // print_r($tmp_obj);
        // exit;

        return $tmp_obj;
    }

    function getTemplate( $template_id ){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://crello.com/api/templates/$template_id",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "authority: crello.com",
            "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36",
            "accept: */*",
            "sec-fetch-site: same-origin",
            "sec-fetch-mode: cors",
            "sec-fetch-dest: empty",
            "referer: https://crello.com/user/projects/5f810cf90bff316d4bf8ab80/",
            "accept-language: es"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        Redis::set('crello:template:'.$template_id, $response);
    }

    function getLocalSearchResults($page){
        return json_decode(Redis::get('crello:search:results:page:'.$page));
    }

    function parseAllSearchResults(){

        $perpage = 60;
        $limit = 60;
        $skip = 0;
        $total_pages = 10;

        for ($page=0; $page <= $total_pages; $page++) {

            // $search_results = $this->getSearchResult( $limit, $skip, $page);
            $total_pages = ceil( 9360 / $perpage );

            print_r("\n");
            print_r('---\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\---');
            print_r("\nPARSING PAGE >>".$total_pages);
            print_r("\nPAGE::".$page);
            print_r("\nSKIP::".$skip);
            print_r("\n\n---\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\---");

            $skip = $perpage * ($page+1);
        }
    }

    public function getSearchResult( $limit, $skip, $page){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://crello.com/api/v2/search/templates?limit=$limit&skip=$skip&templateType=regular%2Canimated&searchByKeyword=false&group=&format=&sort=-order%2C-acceptedAt",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "authority: crello.com",
            "accept: application/json",
            "_ga: GA1.2.646585340.1602305896",
            "traceparent: 00-fe9bc2fca2816674a017308c86638db3-6d54564a6424b0c2-01",
            "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36",
            "sec-fetch-site: same-origin",
            "sec-fetch-mode: cors",
            "sec-fetch-dest: empty",
            "referer: https://crello.com/es/templates/",
            "accept-language: es",
            "cookie: langKey=es; _gcl_au=1.1.355941730.1602305889; __cfduid=d4333dd71061fcef5f6c803659b2c1d6d1602305887; AMP_TOKEN=%24NOT_FOUND; _ga=GA1.2.646585340.1602305896; _gid=GA1.2.1503329357.1602305896; features=%7B%22split5%22%3A%22group2%22%7D; _hjid=e23ce939-1d4f-474d-9725-45210f49adfb; iwidth=1920; iheight=1920; _hjIncludedInPageviewSample=1; _hjAbsoluteSessionInProgress=1; _gat_UA-11492843-19=1; __cfduid=d8fd0c52d898439e78e0e287b6bd318281602309284"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        Redis::set('crello:search:results:page:'.$page, $response);
        return json_decode($response);
    }

    function getImage($template_id){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://cdn.crello.com/api/media/$template_id/screen",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "authority: cdn.crello.com",
            "origin: https://crello.com",
            "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36",
            "accept: image/avif,image/webp,image/apng,image/*,*/*;q=0.8",
            "sec-fetch-site: same-site",
            "sec-fetch-mode: cors",
            "sec-fetch-dest: image",
            "referer: https://crello.com/",
            "accept-language: es",
            "Cookie: __cfduid=d8fd0c52d898439e78e0e287b6bd318281602309284"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }

    function getThumbnail($template_id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://static.crello.com/api/templates/$template_id/thumbnails/0?size=360",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Referer: https://crello.com/",
            "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36",
            "Cookie: __cfduid=d8fd0c52d898439e78e0e287b6bd318281602309284"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }

    function downloadTemplateThumbnail($template_id){

        set_time_limit(0);

        $full_file_path = public_path('design/template/'.$template_id.'/assets/preview.jpg');
        $path_info = pathinfo($full_file_path);
        $path = $path_info['dirname'];

        // echo "file_path\n\n\n\n";
        // echo $full_file_path;
        // echo "info\n\n\n\n";
        // print_r($path);
        // exit;
        if( file_exists( $full_file_path )  == false ){

            $curl = curl_init();

            @mkdir($path, 0777, true);

            //This is the file where we save the    information
            $fp = fopen ($full_file_path, 'w+');

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://static.crello.com/api/templates/$template_id/thumbnails/0?size=720",
                // CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                // write curl response to file
                CURLOPT_FILE => $fp,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Referer: https://crello.com/",
					"User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36",
					"Cookie: __cfduid=d8fd0c52d898439e78e0e287b6bd318281602309284"
                ),
            ));

            curl_exec($curl);

            curl_close($curl);

            fclose($fp);
        }

	}

	function downloadImageAsset($template_id, $media_id){

        set_time_limit(0);

        $full_file_path = public_path('design/template/'.$template_id.'/assets/'.$media_id.'.jpg');
        $path_info = pathinfo($full_file_path);
        $path = $path_info['dirname'];

        // echo "file_path\n\n\n\n";
        // echo $full_file_path;
        // echo "info\n\n\n\n";
        // print_r($path);
        // exit;
        if( file_exists( $full_file_path )  == false ){

            $curl = curl_init();

            @mkdir($path, 0777, true);

            //This is the file where we save the    information
            $fp = fopen ($full_file_path, 'w+');

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://cdn.crello.com/api/media/$media_id/screen",
                // CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                // write curl response to file
                CURLOPT_FILE => $fp,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "authority: cdn.crello.com",
					"origin: https://crello.com",
					"user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36",
					"accept: image/avif,image/webp,image/apng,image/*,*/*;q=0.8",
					"sec-fetch-site: same-site",
					"sec-fetch-mode: cors",
					"sec-fetch-dest: image",
					"referer: https://crello.com/",
					"accept-language: es"
                ),
            ));

            curl_exec($curl);

            curl_close($curl);

            fclose($fp);
        }

	}

	function downloadSVGAsset($template_id, $media_id){

        set_time_limit(0);

        $full_file_path = public_path('design/template/'.$template_id.'/assets/'.$media_id.'.svg');
        $path_info = pathinfo($full_file_path);
        $path = $path_info['dirname'];

        // echo "file_path\n\n\n\n";
        // echo $full_file_path;
        // echo "info\n\n\n\n";
        // print_r($path);
        // exit;
        if( file_exists( $full_file_path )  == false ){

            $curl = curl_init();

            @mkdir($path, 0777, true);

            //This is the file where we save the    information
            $fp = fopen ($full_file_path, 'w+');

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://cdn.crello.com/api/media/$media_id/screen",
                // CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                // write curl response to file
                CURLOPT_FILE => $fp,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "authority: cdn.crello.com",
					"origin: https://crello.com",
					"user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36",
					"accept: image/avif,image/webp,image/apng,image/*,*/*;q=0.8",
					"sec-fetch-site: same-site",
					"sec-fetch-mode: cors",
					"sec-fetch-dest: image",
					"referer: https://crello.com/",
					"accept-language: es"
                ),
            ));

            curl_exec($curl);

            curl_close($curl);

            fclose($fp);
        }

	}

	function downloadMP4Asset($template_id, $media_id){

        set_time_limit(0);

        $full_file_path = public_path('design/template/'.$template_id.'/assets/'.$media_id.'.mp4');
        $path_info = pathinfo($full_file_path);
        $path = $path_info['dirname'];

        // echo "file_path\n\n\n\n";
        // echo $full_file_path;
        // echo "info\n\n\n\n";
        // print_r($path);
        // exit;
        if( file_exists( $full_file_path )  == false ){

            $curl = curl_init();

            @mkdir($path, 0777, true);

            //This is the file where we save the    information
            $fp = fopen ($full_file_path, 'w+');

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://cdn.crello.com/api/media/$media_id/screen",
                // CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                // write curl response to file
                CURLOPT_FILE => $fp,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "authority: cdn.crello.com",
					"origin: https://crello.com",
					"user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36",
					"accept: image/avif,image/webp,image/apng,image/*,*/*;q=0.8",
					"sec-fetch-site: same-site",
					"sec-fetch-mode: cors",
					"sec-fetch-dest: image",
					"referer: https://crello.com/",
					"accept-language: es"
                ),
            ));

            curl_exec($curl);

            curl_close($curl);

            fclose($fp);
        }

    }
}
