<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;

use SVG\SVG;
// use Image;
// use Intervention\Image\ImageManagerStatic as Image;

use SVG\Nodes\Shapes\SVGCircle;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Barryvdh\DomPDF\Facade as PDF;
use Image;

// use Intervention\Image;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\App;

use App\Models\Template;

// use App\Exports\MercadoLibreExport;
// use Maatwebsite\Excel\Facades\Excel;

// ini_set('memory_limit', -1);
// ini_set("max_execution_time", 0);   // no time-outs!
// ignore_user_abort(true);            // Continue downloading even after user closes the browser.

// error_reporting(E_ALL);
// ini_set('display_errors', 1);


class AdminController extends Controller
{
    function generarModeloMercadoPago($template_key){
        // echo "<pre>";
        // print_r($template_key);
        // exit;

        // {
        //     "name": "Name",
        //     "btn_url": "http",
        //     "btn_text": "http", // default View All
        //     "language_code": "en",
        //     "items": [
        //         {
        //             img_src:
        //             alt_text:
        //             href:
        //         },
        //     ]
        // }

        $modelo_id = rand(1111, 9999);
        if( Redis::exists('wayak:mercadopago:template:modelo:'.$template_key) ){
            return Redis::get('wayak:mercadopago:template:modelo:'.$template_key);
        } else {
            Redis::set('wayak:mercadopago:template:modelo:'.$template_key, $modelo_id);
            Redis::set('wayak:mercadopago:modelo:'.$modelo_id, $template_key);
        }
        
        return $modelo_id;
    }

    function thumbnailGeneration(){
        $language_code = 'en';
        $country_code = 'mx';
        
        $current_page = 1;
        if( isset($request->page) ) {
            $current_page = $request->page;
        }
        $page = $current_page-1;
        $per_page = 2;
        $offset = $page*$per_page;

        $ready_for_sale_products = DB::select( DB::raw(
            "SELECT 
                thumbnails.template_id, thumbnails. filename 
            FROM 
                thumbnails,templates
            WHERE
                thumbnails.template_id = templates.template_id
                AND templates.source = 'templett'
                AND templates.status = 5
                AND thumbnails.language_code = 'en'
                AND thumbnails.thumbnail_ready IS NULL
            LIMIT 2000") 
        );

        return view('admin.thumbnail_generation', [
            'templates' => $ready_for_sale_products,
            'language_code' => $language_code,
            'country' => $country_code
        ]);

    }

    function autoRename(){
        
        $ready_for_sale_products = DB::select( DB::raw(
            'SELECT
                thumbnails.id,
                thumbnails.template_id,
                thumbnails.title as thumb_title,
                tmp_etsy_metadata.title, 
                tmp_etsy_product.title product_title, 
                tmp_etsy_product.product_link_href 
            FROM 
                thumbnails,
                templates,
                tmp_etsy_metadata,
                tmp_etsy_product
            WHERE 
                thumbnails.template_id = templates.template_id
                AND thumbnails.language_code = \'en\'
                AND thumbnails.product_name IS NULL
                AND templates.source = \'templett\'
                AND templates.fk_etsy_template_id = tmp_etsy_metadata.id
                AND tmp_etsy_metadata.fk_product_id = tmp_etsy_product.id
                AND templates.status = 5
            ') 
        );
        
        echo "<pre>";
        foreach($ready_for_sale_products as $row){
            // print_r($row);
            // exit;
            
            $parsed_slug = str_replace('-',' ',substr($row->product_link_href, strripos($row->product_link_href, '/')+1, strlen($row->product_link_href)));
            $original_title = $row->thumb_title.' '.$row->title.' '.$row->product_title.' '.$parsed_slug;
            
            $tmp_title = [];
            preg_match_all('/([a-zA-Z])+/', $original_title, $final_title);
            
            if( isset($final_title[0]) ){
                $words = $final_title[0];
                
                // print_r($original_title);
                // print_r("<br>");
                // print_r($words);
                // print_r("<br");
                // exit;
                
                $ready_for_title = DB::select( DB::raw(
                    'SELECT
                        word 
                    FROM
                        `wayak`.`keywords` 
                    WHERE
                        word IN ('."'".implode( '\',\'',$words)."'".') 
                        AND language_code = \'en\' 
                        AND (
                            ( is_reviewed = 1 AND is_valid_for_title = 1 ) 
                            OR is_reviewed = 0 
                        )') 
                );

                foreach ($ready_for_title as $word) {
                    $tmp_title[] = ucwords($word->word);
                }
                
                
                $unique_keywords_title = array_unique($tmp_title);
                $final_title = implode(' ',$unique_keywords_title);
                
                // print_r($tmp_title);
                // exit;
                
                $ready_for_slug = DB::select( DB::raw(
                    'SELECT * FROM `wayak`.`keywords` 
                    WHERE 
                    word IN('."'".implode( '\',\'',$words)."'".')
                    AND language_code = \'en\'
                    AND (
                        ( is_reviewed = 1 AND is_tag = 1 ) OR is_reviewed = 0)
                        LIMIT 20') 
                    );
                    
                $tmp_slug = [];
                $slug_length = 0;
                foreach ($ready_for_slug as $word) {
                    $slug_length = $slug_length + strlen($word->word) + 1;
                    $tmp_slug[] = strtolower($word->word);
                    
                    if( $slug_length > 80 ){
                        break;
                    }
                }

                $tmp_slug[] = $row->template_id;
                
                $unique_keywords_slug = array_unique($tmp_slug);
                $final_slug = implode('-',$unique_keywords_slug);
                
                // print_r( "<hr>original_title >>" );
                // print_r( $original_title );
                // print_r( "<br>" );
                // print_r( $row->id.'-'.substr($row->product_link_href, strripos($row->product_link_href, '/')+1, strlen($row->product_link_href)));
                // print_r( "<br>" );
                print_r( strlen($final_title).'>> TITLE >> ' );
                print_r( $final_title );
                print_r( "<br>" );
                print_r( strlen($final_slug).'>> SLUG >> ' );
                print_r( $final_slug );

                DB::table('thumbnails')
                ->where('id','=',$row->id)
                ->update([
                    'product_name' => $final_title,
                    'product_slug' => $final_slug
                ]);

                // exit;
            }
        }

        // $read
    }

    function getCountryLanguage($country){
        if( $country == 'mx' ){
            $language_code = 'es';
        } else {
            $language_code = 'en';
        }

        return $language_code;
    }

    function viewGallery($country, Request $request){

        $language_code = self::getCountryLanguage($country);
        $current_page = 1;
        
        $redis_key = 'wayak:'.$country.':config:sales';
        $active_campaign = Redis::hgetall($redis_key);

        if( isset($request->page) ) {
            $current_page = $request->page;
        }

        $page = $current_page-1;
        $per_page = 100;
        $offset = $page*$per_page;

        // Get all templates already formated
        // $formated_templates = Redis::keys('product:format_ready:*');
        // $formated_templates_total = sizeof($formated_templates);
        $total_templates = DB::table('templates')
                    ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
                    ->select('templates.template_id','templates.format_ready','templates.translation_ready','templates.thumbnail_ready', 'filename','thumbnails.title', 'thumbnails.dimentions')
                    // ->where('template_id','=', $template_key )
                    ->where('thumbnails.language_code','=', $language_code )
                    // ->where('thumbnails.dimentions','=', '5 x 7 in' )
                    // ->where('templates.status','=', 5 )
                    // ->where('templates.format_ready','1')
                    // ->where('templates.translation_ready','1')
                    // ->where('templates.thumbnail_ready','1')
                    ->count();
                    
        $total_pages = ceil( $total_templates/$per_page );

        $translation_ready_templates = DB::table('templates')
                    ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
                    ->select('templates.template_id','thumbnails.format_ready','thumbnails.translation_ready','thumbnails.thumbnail_ready', 'filename','thumbnails.title', 'thumbnails.dimentions')
                    // ->where('template_id','=', $template_key )
                    ->where('thumbnails.language_code','=', $language_code )
                    // ->where('thumbnails.dimentions','=', '5 x 7 in' )
                    // ->where('templates.status','=', 5 )
                    // ->where('thumbnails.format_ready','1')
                    // ->where('thumbnails.translation_ready','1')
                    // ->where('thumbnails.thumbnail_ready','1')
                    ->offset($offset)
                    ->limit($per_page)
                    ->get();

        // echo "<pre>";
        // print_r( $translation_ready_templates );
        // exit;

        $templates = [];
        foreach ($translation_ready_templates as $template) {
            $template_key = $template->template_id;
            
            $product_info['key'] = $template_key;
            $product_info['thumbnail'] = asset( 'design/template/'. $template_key.'/thumbnails/'.$language_code.'/'.$template->filename);
            $product_info['title'] = $template->title;
            $product_info['dimentions'] = $template->dimentions;
            $product_info['mercadopago'] = ( Redis::exists('wayak:mercadopago:template:modelo:'.$template_key) ) ? Redis::get('wayak:mercadopago:template:modelo:'.$template_key) : 0;
            $product_info['translation_ready'] = ( Redis::exists('template:'.$language_code.':'.$template_key.':jsondata') ) ? true : false;

            $templates[] = $product_info;
        }

        // echo "<pre>";
        // print_r($templates);
        // exit;

        return view('admin.templates', [
            'templates' => $templates,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            // 'templates' => $templates,
            // 'current_page' => $current_page,
            // 'total_pages' => $total_pages,
            'active_campaign' => $active_campaign,
            'language_code' => $language_code,
            'country' => $country
        ]);
    }

    function createProduct($template_key){
        
        $product_metadata = new \stdClass();
        $title_words = '';
        $autocomplete = [];
        $tmp_similar_titles = [];
        $tmp_similar_thumbs = [];
        
        // $template_key = 'WxtU57VQvgrE3IY';
        $template_titles = DB::select( DB::raw(
            "SELECT
                thumbnails.template_id,
                LOWER(CONCAT(
                    thumbnails.title,
                    ' ',
                    IF(tmp_etsy_metadata.title IS NULL,'',tmp_etsy_metadata.title),
                    ' ',
                    IF(tmp_etsy_product.title IS NULL,'',tmp_etsy_product.title)
                )) combined_title,
                thumbnails.title title,
				tmp_etsy_metadata.title title_2,
				tmp_etsy_product.title title_3
            FROM 
                thumbnails
                LEFT JOIN templates ON thumbnails.template_id = templates.template_id
                LEFT JOIN tmp_etsy_metadata ON templates.fk_etsy_template_id = tmp_etsy_metadata.id
                LEFT JOIN tmp_etsy_product ON tmp_etsy_metadata.fk_product_id = tmp_etsy_product.id
            WHERE 
                thumbnails.template_id = '".$template_key."'
            LIMIT 3"
        ));

        foreach ($template_titles as $db_title) {
            $full_title_words = ucwords($db_title->combined_title);
            $title_1 = ucwords($db_title->title);
            $title_2 = ucwords($db_title->title_2);
            $title_3 = ucwords($db_title->title_3);
        }

        preg_match_all('/(\w+)/', $full_title_words, $title_1_arr);
        $unique_title_keywords = array_unique($title_1_arr[1]);
        $unique_title_keywords = array_unique(array_merge(self::getTemplateText($template_key),$unique_title_keywords));
        

        // echo "<pre>";
        // print_r('<br>'.$full_title_words);
        // print_r('<br>'.$title_1);
        // print_r('<br>'.$title_2);
        // print_r('<br>'.$title_3);
        // print_r( $unique_title_keywords );
        // exit;

        if( empty($unique_title_keywords) == false ){

            $query_similar_keywords = "SELECT keywords.* FROM (SELECT template_keywords.keyword_id, COUNT(*) total FROM (SELECT
            template_id, keyword_id, COUNT(*) inlcuded_keys
            FROM
                template_keywords 
            WHERE
                keyword_id IN (
                SELECT
                    id 
                FROM
                    keywords 
                WHERE
                    keywords.word IN (
                            "."'".implode("','",$unique_title_keywords)."'"."
                            ) 
                        ) 
                    GROUP BY template_id, keyword_id
                    ORDER BY inlcuded_keys DESC 
                    LIMIT 10) rt,
                        template_keywords
                    WHERE
                        template_keywords.template_id = rt.template_id
                    GROUP BY template_keywords.keyword_id
                    ORDER BY total DESC 
                    LIMIT 30) related_keywords,
                    keywords
                    WHERE
                        keywords.id = related_keywords.keyword_id
                ";

            $similar_keywords = DB::select( DB::raw(
                $query_similar_keywords
            ));

            foreach ($unique_title_keywords as $keyword) {
                $tmp_related_keywords[] = trim(ucwords(strtolower($keyword)));
            }
            // foreach ($similar_keywords as $keyword) {
            //     $tmp_related_keywords[] = ucwords($keyword->word);
            // }
        
            // echo "<pre>";
            // // print_r( $unique_title_keywords );
            // // print_r( $tmp_keywords );
            // print_r( $tmp_related_keywords );
            // exit;


            $keywords_by_rank = DB::select( DB::raw(
                "SELECT keywords.* 
                FROM 
                keywords,
                (SELECT keyword_id, COUNT(*) total
                FROM template_keywords 
                WHERE keyword_id IN( SELECT
                    id 
                FROM
                    keywords 
                WHERE
                    keywords.word IN (
                        "."'".implode("','",$tmp_related_keywords)."'"."
                    ) )
                GROUP BY keyword_id
                ORDER BY total DESC ) templates_keys 
                WHERE templates_keys.keyword_id = keywords.id"
            ));

            foreach ($keywords_by_rank as $keyword) {
                $tmp_ranked_keywords[] = ucwords($keyword->word);
            }
            
            $query_title_recommendations = "SELECT
                thumbnails.title title,
                IF(tmp_etsy_metadata.title IS NULL,'',tmp_etsy_metadata.title) title_2,
                IF(tmp_etsy_product.title IS NULL,'',tmp_etsy_product.title) title_3
            FROM (SELECT
                template_id, keyword_id, COUNT(*) inlcuded_keys
            FROM
                template_keywords 
            WHERE
                keyword_id IN (
                SELECT
                    id 
                FROM
                    keywords 
                WHERE
                    keywords.word IN (
                        "."'".implode("','",$unique_title_keywords)."'"."
                    ) 
                ) 
            GROUP BY template_id, keyword_id
            ORDER BY inlcuded_keys DESC 
            LIMIT 30) related_templates, 
            templates,
            thumbnails,
            tmp_etsy_metadata,
            tmp_etsy_product
            WHERE 
                related_templates.template_id = templates.id
                AND templates.template_id = thumbnails.template_id
                AND templates.fk_etsy_template_id = tmp_etsy_metadata.id
                AND tmp_etsy_metadata.fk_product_id = tmp_etsy_product.id
            GROUP BY
                title,
                title_2,
                title_3
            LIMIT 20";

            $title_recommendations = DB::select( DB::raw(
                $query_title_recommendations
            ));

            // echo "<pre>";
            // print_r( $query_title_recommendations );
            // exit;
            $tmp_titles = [];
            foreach ($title_recommendations as $titles) {
                $tmp_titles[] = ucwords($titles->title);
                $tmp_titles[] = ucwords($titles->title_2);
                $tmp_titles[] = ucwords($titles->title_3);
            }

            $tmp_recomendation_titles = array_unique($tmp_titles);
        }

        if (Redis::exists('template:en:'.$template_key.':metadata')) {
            $product_metadata = Redis::get('template:en:'.$template_key.':metadata');
            $product_metadata = json_decode($product_metadata);
        }

        $thumb_info = DB::table('thumbnails')
                ->where('template_id','=',$template_key)
                ->first();        
        
        // echo "<pre>";
        // print_r( $tmp_related_keywords );
        // print_r( $tmp_ranked_keywords );
        // print_r( $tmp_recomendation_titles );

        // print_r('<br>'.$full_title_words);
        // print_r('<br>'.$title_1);
        // print_r('<br>'.$title_2);
        // print_r('<br>'.$title_3);
        // exit;
        
        $product_metadata->title = (isset($product_metadata->title) && $product_metadata->title != '') ? $product_metadata->title : $title_1;
        $product_metadata->description = (isset($product_metadata->description) && $product_metadata->description != '') ? $product_metadata->description : Redis::get('wayak:etsy:description_template') ;
        $product_metadata->tags = (isset($product_metadata->tags) && $product_metadata->tags != '') ? $product_metadata->tags : 'invitation,party,birthday';
        $product_metadata->related_keywords = $tmp_related_keywords;
        $product_metadata->keywords_by_rank = $tmp_ranked_keywords;
        $product_metadata->recomended_titles = $tmp_recomendation_titles;
        $product_metadata->title_1 = $title_1;
        $product_metadata->title_2 = $title_2;
        $product_metadata->title_3 = $title_3;
        $thumb_img_url = asset( 'design/template/'. $template_key.'/thumbnails/en/'.$thumb_info->filename);

        return view('admin.create_prod', [
            'template_key' => $template_key,
            'thumb_img_url' => $thumb_img_url,
            'metadata' => $product_metadata
        ]);
    }
    
    function getTemplateText($template_key){
        if( Redis::exists( 'template:en:'.$template_key.':jsondata' ) ){
            $json_template = json_decode( Redis::get( 'template:en:'.$template_key.':jsondata' ) );
            
            // echo "<pre>";
            // print_r( $json_template );
            // exit;
        
            if( isset( $json_template[0] ) ){
                unset( $json_template[0] );
            }
            
            if( sizeof($json_template) > 0){
                $ttext = "";
                foreach( $json_template as $page ) {
                    $txt_objects = [];
                    foreach ($page->objects as $object) {
                        if( isset($object->type) && $object->type == 'textbox' ){
                            $ttext .= " ".$object->text;
                            // $txt_objects[] = $tmp_obj;
                        }
                    }
    
                    // $tmp_page['text'] = isset($tmp_obj) ? $tmp_obj : null;
                    
                    // $template_objects['pages'][] = $tmp_page;
                }

                preg_match_all('/(\w+)/', $ttext, $title_1_arr);
                preg_match_all('/([a-zA-Z]\s)+/', $ttext, $words_space);
                $unique_title_keywords = array_unique($title_1_arr[1]);
                
                $final_keywords = [];
                foreach ($words_space[0] as $keyword) {
                    if( strlen($keyword) >= 3 ){
                        $final_keywords[] = str_replace( " ",null, $keyword );
                    }
                }
                
                foreach ($unique_title_keywords as $keyword) {
                    if( strlen($keyword) >= 3 ){
                        $final_keywords[] = $keyword;
                    }
                }

                // echo "<pre>";
                // // print_r( $ttext );
                // // print_r( $xxxx );
                // // print_r( $unique_title_keywords );
                // print_r( $final_keywords );
                // exit;

                return $final_keywords;
            }   
        }
    }

    function editMLMetadata($template_key){
        $thumb_info = DB::table('thumbnails')
                ->where('template_id','=',$template_key)
                ->where('language_code','=','es')
                ->first();

        $thumb_img_url = asset( 'design/template/'. $template_key.'/thumbnails/'.'es/'.$thumb_info->filename);
                
        $product_preview_imgs = Redis::get('product:preview_images:'.$template_key);
        $product_preview_imgs = json_decode($product_preview_imgs);

        // echo "<pre>";
        // print_r($product_preview_imgs);
        // exit;

        $product_preview_urls = implode(', ', $product_preview_imgs);
        $modelo_id = self::generarModeloMercadoPago($template_key);
        $description = Redis::get('wayak:mercadopago:description_template');
        $titulo = 'Invitacion Digital _CAMBIAR_ Whats Face';
        $ocasion = '';

        // Redis::set('mercadopago:template:metadata:'.$template_key, json_encode($request->all()));
        // echo 'template:en:'.$template_key.':metadata';
        // exit;
        if( Redis::exists('template:en:'.$template_key.':metadata') ){
            $product_metadata = Redis::get('template:en:'.$template_key.':metadata');
            $product_metadata = json_decode($product_metadata);
            
            // echo "<pre>";
            // print_r($product_metadata);
            // exit;

            $description = $product_metadata->descripcion;
            $titulo = $product_metadata->titulo;
            $ocasion = $product_metadata->ocasion;
            

        }
        
        // echo "<pre>";
        // print_r( $thumb_info );
        // print_r( self::generarModeloMercadoPago($template_key) );
        // exit;

        return view('admin.mp_create_product', [
            'thumb_img_url' => $thumb_img_url,
            'product_images' => $product_preview_urls,
            'titulo' => $titulo,
            'ocasion' => $ocasion,
            'modelo' => $modelo_id,
            'description' => $description,
            'template_key' => $template_key
        ]);
    }

    function editMPProduct($template_key, Request $request){

        $template_info = $request->all();
        
        $template_info['descripcion'] = str_replace('{{templateDemoUrl}}', url('mx/demo/'.$template_info['modelo'] ), $template_info['descripcion']);
        $template_info['descripcion'] = str_replace('{{wayakCatalogUrl}}', url('mx/plantillas' ), $template_info['descripcion']);
        $template_info['descripcion'] = str_replace('{{estyStoreName}}', 'wayak.app', $template_info['descripcion']);
        $template_info['descripcion'] = str_replace('{{template_id}}', $template_info['modelo'], $template_info['descripcion']);

        // Redis::set
        // $template_info['descripcion']

        // $template_info['modelo'] // Numero identificador para vender en mercado
        // $template_info['sku']

        // echo "<pre>";
        // print_r( $template_key );
        // print_r( $template_info );
        // print_r( $request->descripcion );
        
        // Redis::set('wayak:mercadopago:description_template',$request->descripcion );
        // Redis::set('wayak:mercadopago:description_template',$request->descripcion );
        
        Redis::set('template:en:'.$template_key.':metadata', json_encode( $template_info ) );
        
        return redirect()->route('admin.ml.getMissingMetadataTemplates');
    }

    function adminHome(){
        return view('admin.home', [
        ]);
    }
    
    function orders(){
        return view('admin.orders', [
        ]);
    }

    function generateRandString($length = 15) {
		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return substr(str_shuffle($permitted_chars), 0, $length);
	}
    
    function createDBProduct($template_key, Request $request){
        // echo "<pre>";
        // print_r( $template_key );
        // exit;

        $template_info = $request->all();
        
        // echo "<pre>";
        // print_r( $template_info );
        // exit;
        $template_info['demo_code'] = self::generateRandString(4);
        $template_info['description'] = str_replace('{{ templateDemoUrl }}', url('us/demo/'.$template_info['demo_code'] ), $template_info['description']);
        $template_info['description'] = str_replace('{{ wayakCatalogUrl }}', url(''), $template_info['description']);
        $template_info['description'] = str_replace('{{ estyStoreName }}', 'For more templates visit: https://wayak.app/', $template_info['description']);
        $template_info['description'] = str_replace('{{ etsyStoreCode }}', 'XXXetsyStoreCode', $template_info['description']);
        $template_info['description'] = str_replace('{{ template_id }}', $template_info['demo_code'], $template_info['description']);
        $template_info['description'] = str_replace('{{ etsyLinkStore }}', 'https://www.etsy.com/your/shops/wayakTemplateShop', $template_info['description']);
        // $template_info['description'] = str_replace('https://www.mercadolibre.com.mx/perfil/DANIELGTM', 'https://www.mercadolibre.com.mx/perfil/JAZMIN.STUDIO', $template_info['description']);

        // echo "<pre>";
        // print_r( $template_info );
        // exit;

        // Redis::set('template:en:'.$template_key.':metadata', json_encode( $template_info ));
        $id = DB::table('products')->insertGetId([
            'id' => null,
            'template_id' => $template_key,
            'title' => $template_info['title'],
            'tags' => $template_info['tags'],
            'primaryColor' => $template_info['primaryColor'],
            'secondaryColor' => $template_info['secondaryColor'],
            'occasion' => $template_info['occasion'],
            'holiday' => $template_info['holiday'],
            'description' => $template_info['description'],
        ]);

        // self::createEtsyPDF( $template_id, $request->canvaURLInput );
        self::createEtsyProductThumbs( $template_key );
        
        DB::table('templates')
				    ->where('template_id','=',$template_key)
				    ->update([
                        'metadata_ready' => 1
                    ]);
        
        return redirect()->route('admin.etsy.templatesGallery');

    }

    function etsyDescriptionTemplate(){
        $description = null;

        if( Redis::exists('wayak:etsy:description_template') ){
            // && Redis::get('wayak:etsy:description_template') =! ''
            $description = Redis::get('wayak:etsy:description_template'); 
        }
        return view('admin.etsy_description_template', [
            'description' => $description
        ]);
    }

    function editEtsyDescriptionTemplate(Request $request){
        // echo "<pre>";
        // print_r( $request->all() );
        
        Redis::set('wayak:etsy:description_template', $request->description);
        return redirect()->action(
            [AdminController::class,'etsyDescriptionTemplate'], []
        );
    }
    
    function mlDescriptionTemplate(){
        $description = null;

        if( Redis::exists('wayak:mercadopago:description_template') ){
            $description = Redis::get('wayak:mercadopago:description_template');
        }
        return view('admin.ml_description_template', [
            'description' => $description
        ]);
    }

    function updateURL(){
        $keys_to_update = Redis::keys('template:*:metadata');
        
        foreach ($keys_to_update as $key) {
            echo $key.'<br>';
            $template_info = json_decode(Redis::get($key));
            $template_info->descripcion = Redis::get('wayak:mercadopago:description_template');
            $template_info->descripcion = str_replace('{{templateDemoUrl}}', url('mx/demo/'.$template_info->modelo ), $template_info->descripcion);
            $template_info->descripcion = str_replace('{{wayakCatalogUrl}}', url('mx/plantillas' ), $template_info->descripcion);
            $template_info->descripcion = str_replace('{{estyStoreName}}', 'jazmin.studio / wayak.app', $template_info->descripcion);
            $template_info->descripcion = str_replace('{{template_id}}', $template_info->modelo, $template_info->descripcion);
            $template_info->descripcion = str_replace('https://www.mercadolibre.com.mx/perfil/DANIELGTM', 'https://www.mercadolibre.com.mx/perfil/JAZMIN.STUDIO', $template_info->descripcion);
            $template_info->descripcion = str_replace('♥', null, $template_info->descripcion);
            
            
            $template_key = str_replace('template:', null, $key);
            $template_key = str_replace(':metadata', null, $template_key);
            $product_preview_imgs = Redis::get('product:preview_images:'.$template_key);
            $product_preview_imgs = json_decode($product_preview_imgs);
            $product_preview_urls = implode(', ', $product_preview_imgs);
            $template_info->imagenes = $product_preview_urls;

            Redis::set($key, json_encode( $template_info ));
        }
    }

    function editMlDescriptionTemplate(Request $request){
        // echo "<pre>";
        // print_r( $request->all() );
        
        Redis::set('wayak:mercadopago:description_template', $request->description);
        return redirect()->action(
            [AdminController::class,'mlDescriptionTemplate'], []
        );
    }

    function facebookCSV(){
        $language_code = 'es';
        $translation_ready_templates = DB::table('templates')
                    ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
                    ->select('templates.template_id','filename')
                    // ->where('template_id','=', $template_key )
                    ->where('thumbnails.language_code','=', $language_code )
                    // ->where('thumbnails.dimentions','=', '5 x 7 in' )
                    ->where('templates.status','=', 5 )
                    ->where('templates.format_ready','1')
                    ->where('templates.translation_ready','1')
                    ->where('templates.thumbnail_ready','1')
                    ->where('templates.metadata_ready','1')
                    ->where('templates.preview_ready','1')
                ->get();

        // echo "<pre>";
        $document = [];
        foreach ($translation_ready_templates as $template) {
            
            // print_r( "\n".$template->template_id );
            $metadata = Redis::get('template:'.$template->template_id.':metadata');
            $metadata = json_decode($metadata);
            // print_r( $metadata );

            $row = [];
            // # Obligatorio | Identificador √∫nico del art√≠culo. Se recomienda usar el SKU. Ingresa cada identificador una sola vez; de lo contrario; no se subir√° el art√≠culo. En el caso de los anuncios din√°micos; debe coincidir exactamente con el identificador de contenido del mismo art√≠culo en el p√≠xel de Facebook. L√≠mite de caracteres: 100.
            // id
            $row[] = $template->template_id;

            // # Obligatorio | T√≠tulo espec√≠fico y relevante del art√≠culo. Incluye palabras clave; como la marca; caracter√≠sticas o el estado en que se encuentra. L√≠mite de caracteres: 150.
            // title
            $row[] = $metadata->titulo;
            
            // # Obligatorio | Descripci√≥n breve y relevante del art√≠culo. Incluye caracter√≠sticas del producto espec√≠ficas o exclusivas; como el material o el color. Usa texto sin formato y no escribas palabras enteras en may√∫sculas. L√≠mite de caracteres: 5.000.
            // description
            $row[] = $metadata->descripcion;

            // # Obligatorio | Disponibilidad actual del art√≠culo en tu tienda. | Supported values: in stock; available for order; preorder; out of stock; discontinued
            // availability
            $row[] = 'in stock';

            // # Obligatorio | Cantidad del art√≠culo en tu inventario. Las personas no podr√°n comprarlo si el inventario no es igual o superior a 1. Nota: En la tienda de la p√°gina; se indicar√° que un determinado art√≠culo est√° agotado si el inventario es 0; incluso si en el campo "Disponibilidad" figura como disponible.
            // inventory
            $row[] = $metadata->cantidad;

            // # Obligatorio | Estado en que se encuentra el art√≠culo. | Supported values: new; refurbished; used
            // condition
            $row[] = 'new';

            // # Obligatorio | Costo y divisa del art√≠culo. El precio es un n√∫mero seguido del c√≥digo de divisa de 3 d√≠gitos (est√°ndar ISO 4217). Usa un punto (".") como separador decimal.
            // price
            // 10.00 USD
            $row[] = '50 MXN';

            // # Obligatorio | URL de la p√°gina del producto espec√≠fica en la que las personas pueden comprar el art√≠culo. Si no tienes una URL; proporciona una alternativa; como un enlace a la p√°gina de Facebook de tu negocio.
            // link
            // https://www.facebook.com/facebook_t_shirt
            $row[] = url('mx/demo/'.$metadata->modelo );

            // # Obligatorio | URL de la imagen principal del art√≠culo. Usa una imagen en formato cuadrado (1:1) con una resoluci√≥n de 1.024 x 1.024 p√≠xeles o superior.
            // image_link
            $row[] = $metadata->imagenes;

            // # Obligatorio | Nombre de la marca; n√∫mero de pieza del fabricante (MPN) √∫nico o n√∫mero mundial de art√≠culo comercial (GTIN) del art√≠culo. Solo debes ingresar uno de estos datos; no todos. Para el GTIN; ingresa el UPC; EAN; JAN o ISBN del art√≠culo. L√≠mite de caracteres: 100.
            // brand
            $row[] = 'Wayak';

            // # Opcional | La categor√≠a de productos de Google para el art√≠culo. Obt√©n m√°s informaci√≥n sobre las categor√≠as de productos en https://www.facebook.com/business/help/526764014610932. Proporciona en los campos "fb_product_category" o "google_product_category"; o en ambos; una categor√≠a.
            // google_product_category
            $row[] = 'Arte y ocio > Fiestas y celebraciones > Productos para fiestas > Invitaciones';

            // # Opcional | La categor√≠a de productos de Facebook para el art√≠culo. Obt√©n m√°s informaci√≥n sobre las categor√≠as de productos en https://www.facebook.com/business/help/526764014610932. Proporciona una categor√≠a en los campos "fb_product_category" o "google_product_category"; o en ambos.
            // fb_product_category
            // Clothing & Accessories > Clothing > Baby Clothing

            // # Opcional | Precio con descuento y divisa del art√≠culo si est√° en oferta. El precio es un n√∫mero seguido del c√≥digo de divisa (est√°ndar ISO 4217). Usa un punto (".") como separador decimal. Es obligatorio indicar el precio de oferta si se quiere usar texto superpuesto para mostrar precios con descuento.
            // sale_price
            // $row[] = '30 MXN';

            // # Opcional | Intervalo del per√≠odo de oferta; incluidas la fecha; hora y zona horaria del inicio y la finalizaci√≥n de la oferta. Si no ingresas las fechas; los art√≠culos con el campo "sale_price" permanecer√°n en oferta hasta que elimines el precio de oferta. Usa este formato: YYYY-MM-DDT23:59+00:00/YYYY-MM-DDT23:59+00:00. Ingresa la fecha de inicio de la siguiente manera: YYYY-MM-DD. Escribe una "T". A continuaci√≥n; ingresa la hora de inicio en formato de 24 horas (00:00 a 23:59) seguida de la zona horaria UTC (-12:00 a +14:00). Escribe una barra ("/") y repite el mismo formato para la fecha y hora de finalizaci√≥n. En la siguiente fila de ejemplo se usa la zona horaria del Pac√≠fico (-08:00).
            // sale_price_effective_date
            // 2020-04-30T09:30-08:00/2020-05-30T23:59-08:00

            // # Opcional | Si el art√≠culo es una variante; usa esta columna para ingresar el mismo identificador de grupo para todas las variantes dentro del mismo grupo de productos. Por ejemplo; "camiseta de Facebook azul" es una variante de "camiseta de Facebook". Facebook seleccionar√° una variante para mostrar de cada grupo de productos en funci√≥n de su relevancia o popularidad. L√≠mite de caracteres: 100.
            // item_group_id
            // FB_T_Shirt

            // # Opcional | Sexo de una persona a la cual se dirige el art√≠culo. | Supported values: female; male; unisex
            // gender
            // unisex

            // # Opcional | Color del art√≠culo. Usa una o m√°s palabras para describir el color en lugar de un c√≥digo hexadecimal. L√≠mite de caracteres: 200.
            // color
            // royal blue

            // # Opcional | Tama√±o o talle del art√≠culo escrito como una palabra; abreviatura o n√∫mero; por ejemplo; peque√±o; XL o 12. L√≠mite de caracteres: 200.
            // size
            $row[] = $metadata->largo.' '.$metadata->unidad_largo.' x '.$metadata->ancho.' '.$metadata->unidad_ancho;

            // # Opcional | Grupo de edad al que se dirige el art√≠culo. | Supported values: adult; all ages; infant; kids; newborn; teen; toddler
            // age_group
            $row[] = 'all ages';

            // # Opcional | Material con el que se fabric√≥ el art√≠culo; como algod√≥n; denim o cuero. L√≠mite de caracteres: 200.
            // material
            $row[] = 'jpg,png,pdf';

            // # Opcional | Estampado o impresi√≥n gr√°fica del art√≠culo. L√≠mite de caracteres: 100.
            // pattern
            // stripes

            // # Opcional | Detalles de env√≠o del art√≠culo; escritos como "Pa√≠s:Regi√≥n:Servicio:Precio". Incluye el c√≥digo de divisa ISO de 3 d√≠gitos en el precio. Para usar el texto superpuesto "Env√≠o gratuito" en tus anuncios; ingresa un precio de "0.0". Usa ";" para separar varios detalles de env√≠o para distintas regiones o pa√≠ses. Solo las personas de una regi√≥n o pa√≠s especificado ver√°n los detalles de env√≠o correspondientes a su ubicaci√≥n. Puedes omitir la regi√≥n (conserva ambos signos "::") si los detalles de env√≠o son los mismos para todo el pa√≠s.
            // shipping
            // US:CA:Ground:9.99 USD,US:NY:Air:15.99 USD

            // # Opcional | Peso de env√≠o del art√≠culo expresado en lb; oz; g o kg.
            // shipping_weight
            // 0.3 kg

            $document[] = $row;
        }
        // print_r($document);
        // exit;

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="fb_catalogo_tienda.csv"');
        // $data = array(
        //         'aaa,bbb,ccc,dddd',
        //         '123,456,789',
        //         '"aaa","bbb"'
        // );
        
        $fp = fopen('php://output', 'wb');
        foreach ( $document as $line ) {
            // $val = explode(",", $line);
            fputcsv($fp, $line);
        }
        fclose($fp);
    }
    
    function getCanvaContributorCSV(){
        $language_code = 'es';
        $translation_ready_templates = DB::table('templates')
                    ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
                    ->select('templates.template_id','filename')
                    // ->where('template_id','=', $template_key )
                    ->where('thumbnails.language_code','=', $language_code )
                    // ->where('thumbnails.dimentions','=', '5 x 7 in' )
                    ->where('templates.status','=', 5 )
                    ->where('templates.format_ready','1')
                    ->where('templates.translation_ready','1')
                    ->where('templates.thumbnail_ready','1')
                    ->where('templates.metadata_ready','1')
                    ->where('templates.preview_ready','1')
                ->get();

        // echo "<pre>";
        $document = [];
        foreach ($translation_ready_templates as $template) {
            
            // print_r( "\n".$template->template_id );
            $metadata = Redis::get('template:'.$template->template_id.':metadata');
            $metadata = json_decode($metadata);
            // print_r( $metadata );

            $row = [];
            // # Obligatorio | Identificador √∫nico del art√≠culo. Se recomienda usar el SKU. Ingresa cada identificador una sola vez; de lo contrario; no se subir√° el art√≠culo. En el caso de los anuncios din√°micos; debe coincidir exactamente con el identificador de contenido del mismo art√≠culo en el p√≠xel de Facebook. L√≠mite de caracteres: 100.
            // id
            $row[] = $template->template_id;

            // # Obligatorio | T√≠tulo espec√≠fico y relevante del art√≠culo. Incluye palabras clave; como la marca; caracter√≠sticas o el estado en que se encuentra. L√≠mite de caracteres: 150.
            // title
            $row[] = $metadata->titulo;
            
            // # Obligatorio | Descripci√≥n breve y relevante del art√≠culo. Incluye caracter√≠sticas del producto espec√≠ficas o exclusivas; como el material o el color. Usa texto sin formato y no escribas palabras enteras en may√∫sculas. L√≠mite de caracteres: 5.000.
            // description
            $row[] = $metadata->descripcion;

            // # Obligatorio | Disponibilidad actual del art√≠culo en tu tienda. | Supported values: in stock; available for order; preorder; out of stock; discontinued
            // availability
            $row[] = 'in stock';

            // # Obligatorio | Cantidad del art√≠culo en tu inventario. Las personas no podr√°n comprarlo si el inventario no es igual o superior a 1. Nota: En la tienda de la p√°gina; se indicar√° que un determinado art√≠culo est√° agotado si el inventario es 0; incluso si en el campo "Disponibilidad" figura como disponible.
            // inventory
            $row[] = $metadata->cantidad;

            // # Obligatorio | Estado en que se encuentra el art√≠culo. | Supported values: new; refurbished; used
            // condition
            $row[] = 'new';

            // # Obligatorio | Costo y divisa del art√≠culo. El precio es un n√∫mero seguido del c√≥digo de divisa de 3 d√≠gitos (est√°ndar ISO 4217). Usa un punto (".") como separador decimal.
            // price
            // 10.00 USD
            $row[] = '50 MXN';

            // # Obligatorio | URL de la p√°gina del producto espec√≠fica en la que las personas pueden comprar el art√≠culo. Si no tienes una URL; proporciona una alternativa; como un enlace a la p√°gina de Facebook de tu negocio.
            // link
            // https://www.facebook.com/facebook_t_shirt
            $row[] = url('mx/demo/'.$metadata->modelo );

            // # Obligatorio | URL de la imagen principal del art√≠culo. Usa una imagen en formato cuadrado (1:1) con una resoluci√≥n de 1.024 x 1.024 p√≠xeles o superior.
            // image_link
            $row[] = $metadata->imagenes;

            // # Obligatorio | Nombre de la marca; n√∫mero de pieza del fabricante (MPN) √∫nico o n√∫mero mundial de art√≠culo comercial (GTIN) del art√≠culo. Solo debes ingresar uno de estos datos; no todos. Para el GTIN; ingresa el UPC; EAN; JAN o ISBN del art√≠culo. L√≠mite de caracteres: 100.
            // brand
            $row[] = 'Wayak';

            // # Opcional | La categor√≠a de productos de Google para el art√≠culo. Obt√©n m√°s informaci√≥n sobre las categor√≠as de productos en https://www.facebook.com/business/help/526764014610932. Proporciona en los campos "fb_product_category" o "google_product_category"; o en ambos; una categor√≠a.
            // google_product_category
            $row[] = 'Arte y ocio > Fiestas y celebraciones > Productos para fiestas > Invitaciones';

            // # Opcional | La categor√≠a de productos de Facebook para el art√≠culo. Obt√©n m√°s informaci√≥n sobre las categor√≠as de productos en https://www.facebook.com/business/help/526764014610932. Proporciona una categor√≠a en los campos "fb_product_category" o "google_product_category"; o en ambos.
            // fb_product_category
            // Clothing & Accessories > Clothing > Baby Clothing

            // # Opcional | Precio con descuento y divisa del art√≠culo si est√° en oferta. El precio es un n√∫mero seguido del c√≥digo de divisa (est√°ndar ISO 4217). Usa un punto (".") como separador decimal. Es obligatorio indicar el precio de oferta si se quiere usar texto superpuesto para mostrar precios con descuento.
            // sale_price
            // $row[] = '30 MXN';

            // # Opcional | Intervalo del per√≠odo de oferta; incluidas la fecha; hora y zona horaria del inicio y la finalizaci√≥n de la oferta. Si no ingresas las fechas; los art√≠culos con el campo "sale_price" permanecer√°n en oferta hasta que elimines el precio de oferta. Usa este formato: YYYY-MM-DDT23:59+00:00/YYYY-MM-DDT23:59+00:00. Ingresa la fecha de inicio de la siguiente manera: YYYY-MM-DD. Escribe una "T". A continuaci√≥n; ingresa la hora de inicio en formato de 24 horas (00:00 a 23:59) seguida de la zona horaria UTC (-12:00 a +14:00). Escribe una barra ("/") y repite el mismo formato para la fecha y hora de finalizaci√≥n. En la siguiente fila de ejemplo se usa la zona horaria del Pac√≠fico (-08:00).
            // sale_price_effective_date
            // 2020-04-30T09:30-08:00/2020-05-30T23:59-08:00

            // # Opcional | Si el art√≠culo es una variante; usa esta columna para ingresar el mismo identificador de grupo para todas las variantes dentro del mismo grupo de productos. Por ejemplo; "camiseta de Facebook azul" es una variante de "camiseta de Facebook". Facebook seleccionar√° una variante para mostrar de cada grupo de productos en funci√≥n de su relevancia o popularidad. L√≠mite de caracteres: 100.
            // item_group_id
            // FB_T_Shirt

            // # Opcional | Sexo de una persona a la cual se dirige el art√≠culo. | Supported values: female; male; unisex
            // gender
            // unisex

            // # Opcional | Color del art√≠culo. Usa una o m√°s palabras para describir el color en lugar de un c√≥digo hexadecimal. L√≠mite de caracteres: 200.
            // color
            // royal blue

            // # Opcional | Tama√±o o talle del art√≠culo escrito como una palabra; abreviatura o n√∫mero; por ejemplo; peque√±o; XL o 12. L√≠mite de caracteres: 200.
            // size
            $row[] = $metadata->largo.' '.$metadata->unidad_largo.' x '.$metadata->ancho.' '.$metadata->unidad_ancho;

            // # Opcional | Grupo de edad al que se dirige el art√≠culo. | Supported values: adult; all ages; infant; kids; newborn; teen; toddler
            // age_group
            $row[] = 'all ages';

            // # Opcional | Material con el que se fabric√≥ el art√≠culo; como algod√≥n; denim o cuero. L√≠mite de caracteres: 200.
            // material
            $row[] = 'jpg,png,pdf';

            // # Opcional | Estampado o impresi√≥n gr√°fica del art√≠culo. L√≠mite de caracteres: 100.
            // pattern
            // stripes

            // # Opcional | Detalles de env√≠o del art√≠culo; escritos como "Pa√≠s:Regi√≥n:Servicio:Precio". Incluye el c√≥digo de divisa ISO de 3 d√≠gitos en el precio. Para usar el texto superpuesto "Env√≠o gratuito" en tus anuncios; ingresa un precio de "0.0". Usa ";" para separar varios detalles de env√≠o para distintas regiones o pa√≠ses. Solo las personas de una regi√≥n o pa√≠s especificado ver√°n los detalles de env√≠o correspondientes a su ubicaci√≥n. Puedes omitir la regi√≥n (conserva ambos signos "::") si los detalles de env√≠o son los mismos para todo el pa√≠s.
            // shipping
            // US:CA:Ground:9.99 USD,US:NY:Air:15.99 USD

            // # Opcional | Peso de env√≠o del art√≠culo expresado en lb; oz; g o kg.
            // shipping_weight
            // 0.3 kg

            $document[] = $row;
        }
        // print_r($document);
        // exit;

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="fb_catalogo_tienda.csv"');
        // $data = array(
        //         'aaa,bbb,ccc,dddd',
        //         '123,456,789',
        //         '"aaa","bbb"'
        // );
        
        $fp = fopen('php://output', 'wb');
        foreach ( $document as $line ) {
            // $val = explode(",", $line);
            fputcsv($fp, $line);
        }
        fclose($fp);
    }

    function mercadoLibreExcel(){
        $helper = new Sample();
        
        if ($helper->isCli()) {
            $helper->log('This example should only be run from a Web Browser' . PHP_EOL);
            return;
        }

        $filename = 'ejemplo';
        $id = DB::table('ml_excel')->insertGetId([
            'id' => null,
            'created_at' => date('Y-m-d H:i'),
            'filename' => $filename
        ]);
        // echo $id;
        // exit;

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();
                    
        // Set document properties
        $spreadsheet->getProperties()->setCreator('Maarten Balliauw')
            ->setLastModifiedBy('Daniel Gutierrez')
            ->setTitle('Office 2007 XLSX Test Document')
            ->setSubject('Office 2007 XLSX Test Document')
            ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Test result file');


        $product_keys_metadata = Redis::keys('template:*:metadata');

        // echo "<pre>";
        // print_r( $product_keys_metadata );
        // exit;

        $row_number = 1;

        foreach ($product_keys_metadata as $template_key) {
            if( Redis::exists($template_key) ){
                
                $product_metadata = Redis::get($template_key);
                $product_metadata = json_decode($product_metadata);
                
                if( isset($product_metadata->codigo_universal) == false ){
                    echo $template_key.'<br>';
                    exit;
                }

                // echo "<pre>";
                // print_r($product_metadata);
                // exit;
    
                // $description = $product_metadata->descripcion;
                // $titulo = $product_metadata->titulo;
                // $ocasion = $product_metadata->ocasion;

                // Add some data
                // **Título
                // **Código universal de producto == "No aplica"
                // **Imágenes
                // **SKU
                // **Cantidad
                // **Precio
                // **Moneda == $
                // **Condición == Nuevo
                // **Descripción	
                // **Link de YouTube
                // **Tipo de publicación == Premium
                // **Forma de envío == Mercado Envíos
                // **Costo de envío  == Ofreces envío gratis
                // **Retiro en persona == Acepto
                // **Tipo de garantía
                // **Tiempo de garantía == 3
                // **Unidad de Tiempo de garantía == días
                // **Disponibilidad de stock [días] == XXXXX NO APLICA
                // **Ocasiones
                // **Marca == Wayak
                // **Modelo == XXX
                // **Fabricante == Jazmin
                // **Formato == Digital
                // **Material == null
                // **Largo
                // **Unidad de Largo
                // **Ancho
                // **Unidad de Ancho
                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A'.$row_number, $product_metadata->titulo)
                    ->setCellValue('B'.$row_number, $product_metadata->codigo_universal)
                    ->setCellValue('C'.$row_number, $product_metadata->imagenes)
                    ->setCellValue('D'.$row_number, $product_metadata->sku)
                    ->setCellValue('E'.$row_number, $product_metadata->cantidad)
                    ->setCellValue('F'.$row_number, $product_metadata->precio)
                    ->setCellValue('G'.$row_number, $product_metadata->moneda)
                    ->setCellValue('H'.$row_number, $product_metadata->condicion)
                    ->setCellValue('I'.$row_number, $product_metadata->descripcion)
                    ->setCellValue('J'.$row_number, '')// **Link de YouTube
                    ->setCellValue('K'.$row_number, $product_metadata->tipo_publicacion)
                    ->setCellValue('L'.$row_number, $product_metadata->forma_envio)
                    ->setCellValue('M'.$row_number, $product_metadata->costo_envio)
                    ->setCellValue('N'.$row_number, $product_metadata->retiro_persona)
                    ->setCellValue('O'.$row_number, $product_metadata->tipo_garantia)
                    ->setCellValue('P'.$row_number, $product_metadata->tiempo_garantia)
                    ->setCellValue('Q'.$row_number, $product_metadata->unidad_tiempo_garantia)
                    ->setCellValue('R'.$row_number, '')// **Disponibilidad de stock [días] == XXXXX NO APLICA
                    ->setCellValue('S'.$row_number, $product_metadata->ocasion)
                    ->setCellValue('T'.$row_number, $product_metadata->marca)
                    ->setCellValue('U'.$row_number, $product_metadata->modelo)
                    ->setCellValue('V'.$row_number, '') // ** frabricante NO APLICA
                    ->setCellValue('W'.$row_number, $product_metadata->formato)
                    ->setCellValue('X'.$row_number, $product_metadata->material)
                    ->setCellValue('Y'.$row_number, $product_metadata->largo)
                    ->setCellValue('Z'.$row_number, $product_metadata->unidad_largo)
                    ->setCellValue('AA'.$row_number, $product_metadata->ancho)
                    ->setCellValue('AB'.$row_number, $product_metadata->unidad_ancho);

                    // 
                    DB::table('ml_excel_products')->insert([
                        'excel_id' => $id,
                        'template_key' => $product_metadata->sku,
                        'added_at' => date('Y-m-d h:i')
                    ]);
        
                // // Miscellaneous glyphs, UTF-8
                // $spreadsheet->setActiveSheetIndex(0)
                //     ->setCellValue('A4', 'Miscellaneous glyphs')
                //     ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');

                $row_number++;
            }
        }

        
        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Simple');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');

        // return redirect()->action(
        //     [AdminController::class,'manageTemplates'], []
        // );

    }

    function translateTemplate(Request $request){
        if( $request->template_key && $request->template_data ){
            $translation_data = $request->template_data;
            $language_from = $request->language_from;
            $language_to = $request->language_to;
            
            $template_obj = json_decode( Redis::get('template:'.$language_from.':'.$request->template_key.':jsondata') );
            

            // echo "<pre>";
            // print_r( $request->all() );
            // print_r( $template_obj );
            // exit;

            
            $phrase_index = 0;
            for ($i=0; $i <= sizeof( $translation_data ); $i++) { 
                
                if( $template_obj[1]->objects[$i]->type == 'textbox' ){
                    
                    $template_obj[1]->objects[$i]->text =  str_replace(',', "\n", $translation_data[$phrase_index] ) ;
                    $template_obj[1]->objects[$i]->text =  str_replace( 'u0021', "!", urldecode($template_obj[1]->objects[$i]->text));
                    $phrase_index++;
                }

            }

            // echo "<pre>";
            // print_r( $template_obj );
            // // print_r( $language_to );
            // exit;
            
            Redis::set('template:'.$language_to.':'.$request->template_key.':jsondata', json_encode($template_obj) );
            
            $original_thumb_data = DB::table('thumbnails')
            ->where('template_id','=',$request->template_key)
            ->first();

            $destination_lang_template = DB::table('thumbnails')
            ->where('template_id','=',$request->template_key)
            ->where('language_code','=',$language_to)
            ->count();

            // print_r($destination_lang_template);
            // exit;

            if( $original_thumb_data && $destination_lang_template == 0 ){
                DB::table('thumbnails')->insert([
                    'id' => null,
                    'template_id' => $request->template_key,
                    'language_code' => $language_to,
                    'title' => $original_thumb_data->title,
                    'filename' => $original_thumb_data->filename,
                    'tmp_original_url' => null,
                    'dimentions' => $original_thumb_data->dimentions,
                    'tmp_templates' => $request->template_key,
                    'status' => 1
                ]);

            }
            
            // echo "<pre>";
            // print_r( $original_thumb_data );
            // exit;
        
            return response()->json($original_thumb_data);
            
        }
    }

    function saveTemplateTranslation( $template_info ){
        $language_from = 'en';
        $language_to = 'es';
        
        $template_key = str_replace('template:en:',null, $template_info['key']);
        $template_key = str_replace(':jsondata',null, $template_key);

        // echo $template_key;
        // exit;

        // $translations = Redis::keys(' template:es:*:jsondata');
        // foreach ($translations as $template_key) {
        //     Redis::del($template_key);
        // }
        // exit;

        if( isset($template_info['key']) && isset($template_info['template_text']) ){
            // $template_key = ;
            $template_obj = json_decode( Redis::get( $template_info['key'] ) );
            $template_objects = sizeof( $template_obj[1]->objects );

            // echo "<pre>";
            // print_r($template_info);
            // // print_r( $template_objects );
            // // print_r( $template_obj );
            // exit;

            
            $phrase_index = 0;
            for ($i=0; $i < $template_objects; $i++) { 
                
                if( $template_obj[1]->objects[$i]->type == 'textbox' ){
                    
                    $template_obj[1]->objects[$i]->text =  str_replace(',', "\n", $template_info['template_text'][$phrase_index] ) ;
                    $template_obj[1]->objects[$i]->text =  str_replace( 'u0021', "!", urldecode($template_obj[1]->objects[$i]->text));
                    $phrase_index++;
                }

            }

            // echo "<pre>";
            // print_r( $template_obj );
            // // print_r( $language_to );
            // exit;
            
            $destination_template_key = str_replace(':'.$language_from.':', ':'.$language_to.':', $template_info['key']);
            // print_r( $template_key );
            // exit;

            Redis::set($destination_template_key, json_encode($template_obj) );
            
            // Redis::set('product:translation_ready:'.$template_key, 1);
            DB::table('templates')
                ->where('template_id','=', $template_key)
                ->update([
                    'translation_ready' => true
                ]);

            
            $original_thumb_data = DB::table('thumbnails')
                ->where('template_id','=',$template_key)
                ->where('language_code','=',$language_from)
                ->first();

            $destination_lang_template = DB::table('thumbnails')
                ->where('template_id','=',$template_key)
                ->where('language_code','=',$language_to)
                ->count();

            // print_r( $template_info['key'] );
            // print_r($template_key);
            // print_r($original_thumb_data);
            // print_r($destination_lang_template);
            // exit;

            if( $original_thumb_data && $destination_lang_template == 0 ){
                DB::table('thumbnails')->insert([
                    'id' => null,
                    'template_id' => $template_key,
                    'language_code' => $language_to,
                    'title' => $original_thumb_data->title,
                    'filename' => $original_thumb_data->filename,
                    'tmp_original_url' => null,
                    'dimentions' => $original_thumb_data->dimentions,
                    'tmp_templates' => $template_key,
                    'status' => 1
                ]);
            }

            
            
            // echo "<pre>";
            // print_r( $original_thumb_data );
            // exit;
        
            return $original_thumb_data;
            
        }
    }
    
    function templatesReadyForSale(Request $request){
        $language_code = 'es';
        
        $current_page = 1;
        if( isset($request->page) ) {
            $current_page = $request->page;
        }
        $page = $current_page-1;
        $per_page = 2;
        $offset = $page*$per_page;

        // Get all templates already formated
        $total_pages = DB::table('templates')
                    ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
                    ->select('templates.template_id','templates.format_ready','templates.translation_ready','templates.thumbnail_ready', 'filename')
                    // ->where('template_id','=', $template_key )
                    ->where('thumbnails.language_code','=', $language_code )
                    // ->where('thumbnails.dimentions','=', '5 x 7 in' )
                    ->where('templates.status','=', 5 )
                    ->where('templates.format_ready','1')
                    ->where('templates.translation_ready','1')
                    ->where('templates.thumbnail_ready','1')
                    ->where('templates.metadata_ready','1')
                    ->where('templates.preview_ready','1')
                    ->count();

        $translation_ready_templates = DB::table('templates')
                    ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
                    ->select('templates.template_id','templates.format_ready','templates.translation_ready','templates.thumbnail_ready', 'filename')
                    // ->where('template_id','=', $template_key )
                    ->where('thumbnails.language_code','=', $language_code )
                    // ->where('thumbnails.dimentions','=', '5 x 7 in' )
                    ->where('templates.status','=', 5 )
                    ->where('templates.format_ready','1')
                    ->where('templates.translation_ready','1')
                    ->where('templates.thumbnail_ready','1')
                    ->where('templates.metadata_ready','1')
                    ->where('templates.preview_ready','1')
                    ->offset($offset)
                    ->limit($per_page)
                    ->get();

        // echo "<pre>";
        // print_r( $total_pages );
        // print_r( $translation_ready_templates );
        // exit;

        $arr_ready_for_sale = [];
        foreach ($translation_ready_templates as $template) {

            $template_key = $template->template_id;
            
            $template_info['key'] = $template_key;
            $template_info['mp_modelo'] = Redis::exists('wayak:mercadopago:template:modelo:'.$template_key);

            if ( $template_info['mp_modelo'] ){
                $images = json_decode( Redis::get('product:preview_images:'.$template_key) );
                $template_info['thumbnail']  = $images[0];
                $arr_ready_for_sale[] = $template_info;
            } else {
                echo "<pre>";
                print_r($template_info);
                exit;
            }
        }
        
        // echo "<pre>";
        // print_r($arr_ready_for_sale);
        // exit;

        return view('admin.templates_ready_for_sale', [
            'templates' => $arr_ready_for_sale,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'language_code' => 'es',
            'country' => 'mx'
        ]);
        
    }


    function mercadoLibreCatalog(){
        
        $files = DB::table('ml_excel')
            ->select('id','created_at', 'filename')
            ->get();

        return view('admin.ml.excel', [
            'files' => $files
        ]);
    }

    function mercadoLibreExcelProducts($excel_id){
        
        $excel_products = DB::table('ml_excel_products')
            ->select('template_key')
            ->get();
        
        foreach ($excel_products as $product) {
            $images = json_decode( Redis::get('product:preview_images:'.$product->template_key) );
            // echo "<pre>";
            // print_r($images);
            // exit;
            $template['thumbnail']  = $images[0];
            $template['template_key']  = $product->template_key;
            $arr_excel_products[] = $template;
        }

        return view('admin.ml.excel_products', [
            'excel_products' => $arr_excel_products
        ]);
    }

    // function missingMetadataTemplates(){
        
    //     // Get all templates already formated
    //     $formated_templates = Redis::keys('product:format_ready:*');
    //     $formated_templates_total = sizeof($formated_templates);
    //     $arr_ready_for_sale = [];

    //     // echo "<pre>";
    //     // print_r($formated_templates);
    //     // exit;
        
    //     for ($i=0; $i < $formated_templates_total; $i++) {

    //         $template_key = str_replace('product:format_ready:', null, $formated_templates[$i]);
    //         $template_info['key'] = $template_key;

    //         // Template elements has been formated
    //         $template_info['format_ready'] = Redis::exists('product:format_ready:'.$template_key);
    //         $template_info['translation_ready'] = Redis::exists('template:es:'.$template_key.':jsondata') && Redis::exists('product:translation_ready:'.$template_key);
    //         $template_info['metadata_ready'] = Redis::exists('template:en:'.$template_key.':metadata');
    //         $template_info['thumbnail_ready'] = Redis::exists('product:preview_images:'.$template_key);

    //         // $template_info['mp_modelo'] = Redis::exists('wayak:mercadopago:template:modelo:'.$template_key);

    //         if ( $template_info['format_ready']
    //             && $template_info['translation_ready'] 
    //             && $template_info['metadata_ready'] == false 
    //             && $template_info['thumbnail_ready'] ){
                
    //             $thumb_info = DB::table('thumbnails')
    //             ->where('template_id','=', $template_key )
    //             ->where('language_code','=', 'es' )
    //             ->first();

    //             if($thumb_info){
    //                 $template_info['thumbnail']  = asset( 'design/template/'. $template_key.'/thumbnails/'.$thumb_info->filename);
    //             } else {
    //                 $template_info['thumbnail']  = null;
    //             }
                
    //             $arr_ready_for_sale[] = $template_info;
    //         }
    //     }
        
    //     // echo "<pre>";
    //     // print_r($arr_ready_for_sale);
    //     // exit;

    //     return view('admin.templates_ready_for_sale', [
    //         'templates' => $arr_ready_for_sale,
    //         'language_code' => 'es',
    //         'country' => 'mx'
    //     ]);
        
    // }
    
    function getFormatReadyTemplates(Request $request){

        $format_ready_keys = Redis::keys('product:production_ready:*');
        foreach ($format_ready_keys as $template_key) {
            Redis::rename($template_key, str_replace(':production_ready:', ':format_ready:',$template_key ) );
        }
        
        $current_page = 1;
        if( isset($request->page) ) {
            $current_page = $request->page;
        }

        $page = $current_page-1;
        $per_page = 100;
        $offset = $page*$per_page;

        $total_templates = DB::table('templates')
                    ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
                    ->select('templates.template_id','templates.format_ready','templates.translation_ready','templates.thumbnail_ready', 'filename')
                    // ->where('template_id','=', $template_key )
                    ->where('thumbnails.language_code','=', 'en' )
                    // ->where('thumbnails.dimentions','=', '5 x 7 in' )
                    ->where('templates.status','=', 5 )
                    ->where('templates.format_ready','1')
                    ->where('templates.translation_ready','0')
                    ->count();

        $total_pages = ceil( $total_templates/$per_page );
        
        $format_ready_templates = DB::table('templates')
                    ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
                    ->select('templates.template_id','templates.format_ready','templates.translation_ready','templates.thumbnail_ready', 'filename')
                    // ->where('template_id','=', $template_key )
                    ->where('thumbnails.language_code','=', 'en' )
                    // ->where('thumbnails.dimentions','=', '5 x 7 in' )
                    ->where('templates.status','=', 5 )
                    ->where('templates.format_ready','1')
                    ->where('templates.translation_ready','0')
                    ->offset($offset)
                    ->limit($per_page)
                    ->get();

        // echo "<pre>";
        // print_r($format_ready_templates);
        // exit;

        // Get all templates already formated
        $arr_ready_for_sale = [];
        
        foreach ($format_ready_templates as $template) {
            $template_key = $template->template_id;
            
            if( $template->filename ){
                $template->thumbnail  = asset( 'design/template/'. $template_key.'/thumbnails/'.'en/'.$template->filename);
            } else {
                $template->thumbnail  = null;
            }
            
            $arr_ready_for_sale[] = $template;
        }

        return view('admin.templates_format_ready', [
            'templates' => $arr_ready_for_sale,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'language_code' => 'en',
            'country' => 'mx'
        ]);

    }
    
    function getMissingTranslationTemplates(){
        
        // Get all templates already formated
        $formated_templates = Redis::keys('product:format_ready:*');
        $formated_templates_total = sizeof($formated_templates);
        $arr_ready_for_sale = [];
        
        for ($i=0; $i < $formated_templates_total; $i++) { 
            $template_key = str_replace('product:format_ready:', null, $formated_templates[$i]);
            
            $template_info['key'] = $template_key;
            // Template elements has been formated
            $template_info['format_ready'] = Redis::exists('product:format_ready:'.$template_key);
            $template_info['translation_ready'] = Redis::exists('template:es:'.$template_key.':jsondata') && Redis::exists('product:translation_ready:'.$template_key);
            // Has metadata for mercado pago product description
            // $template_info['metadata_ready'] = Redis::exists('mercadopago:template:metadata:'.$template_key);
            $template_info['mp_modelo'] = Redis::exists('wayak:mercadopago:template:modelo:'.$template_key);

            if ( $template_info['format_ready'] 
                && $template_info['translation_ready'] == false ){
                
                $thumb_info = DB::table('thumbnails')
                ->where('template_id','=', $template_key )
                ->first();

                if($thumb_info){
                    $template_info['thumbnail']  = asset( 'design/template/'. $template_key.'/thumbnails/'.$thumb_info->filename);
                } else {
                    $template_info['thumbnail']  = null;
                }
                
                $arr_ready_for_sale[] = $template_info;
            }
        }
        
        return view('admin.templates_ready_for_sale', [
            'templates' => $arr_ready_for_sale,
            'language_code' => 'es',
            'country' => 'mx'
        ]);
        
    }
    
    function getTranslationReadyTemplates(Request $request){
        // $translations = Redis::keys('template:es:*');
        // foreach ($translations as $template_key) {
        //     Redis::del($template_key);
        // }
        // exit;

        $language_code = 'en';

        $current_page = 1;
        if( isset($request->page) ) {
            $current_page = $request->page;
        }

        $page = $current_page-1;
        $per_page = 10;
        $offset = $page*$per_page;

        $total_templates = DB::table('templates')
                    ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
                    ->select('templates.template_id','templates.format_ready','templates.translation_ready','templates.thumbnail_ready', 'filename')
                    // ->where('template_id','=', $template_key )
                    ->where('thumbnails.language_code','=', $language_code )
                    // ->where('thumbnails.dimentions','=', '5 x 7 in' )
                    ->where('templates.status','=', 5 )
                    ->where('templates.format_ready','1')
                    ->where('templates.translation_ready','1')
                    ->where('templates.thumbnail_ready','0')
                    ->count();

        $total_pages = ceil( $total_templates/$per_page );
        
        $translation_ready_templates = DB::table('templates')
                    ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
                    ->select('templates.template_id','templates.format_ready','templates.translation_ready','templates.thumbnail_ready', 'filename')
                    // ->where('template_id','=', $template_key )
                    ->where('thumbnails.language_code','=', $language_code )
                    // ->where('thumbnails.dimentions','=', '5 x 7 in' )
                    ->where('templates.status','=', 5 )
                    ->where('templates.format_ready','1')
                    ->where('templates.translation_ready','1')
                    ->where('templates.thumbnail_ready','0')
                    ->offset($offset)
                    ->limit($per_page)
                    ->get();

        // echo "<pre>";
        // print_r( $translation_ready_templates );
        // exit;
        $arr_ready_for_sale = [];
        foreach ($translation_ready_templates as $template) {
            $template_key = $template->template_id;
            $template_info['key'] = $template_key;
            // Template elements has been formated
            $template_info['format_ready'] = $template->format_ready;
            $template_info['translation_ready'] = $template->translation_ready;
            $template_info['thumbnail_ready'] = $template->thumbnail_ready;
            
            if( $template->filename ){
                $template_info['thumbnail']  = asset( 'design/template/'. $template_key.'/thumbnails/'.$language_code.'/'.$template->filename);
            } else {
                $template_info['thumbnail']  = null;
            }

            $arr_ready_for_sale[] = $template_info; 
        }

        // echo "<pre>";
        // print_r( $template_info );
        // exit;
        
        return view('admin.templates_ready_translation', [
            'templates' => $arr_ready_for_sale,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'language_code' => 'es',
            'country' => 'mx'
        ]);
        
    }
    
    function getThumbnailReady(Request $request){
        
        // Get all templates already formated
        $destination_lang = 'es';
        $current_page = 1;
        if( isset($request->page) ) {
            $current_page = $request->page;
        }

        $page = $current_page-1;
        $per_page = 10;
        $offset = $page*$per_page;

        $total_templates = DB::table('templates')
            ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
            ->select('templates.template_id','templates.format_ready','templates.translation_ready','templates.thumbnail_ready', 'filename')
            // ->where('template_id','=', $template_key )
            ->where('thumbnails.language_code','=', $destination_lang )
            // ->where('thumbnails.dimentions','=', '5 x 7 in' )
            ->where('templates.status','=', 5 )
            ->where('templates.format_ready','1')
            ->where('templates.translation_ready','1')
            ->where('templates.thumbnail_ready','1')
            ->count();

        $total_pages = ceil( $total_templates/$per_page );
        
        $thumb_ready_templates = DB::table('templates')
            ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
            ->select('templates.template_id','templates.format_ready','templates.translation_ready','templates.thumbnail_ready', 'filename')
            // ->where('template_id','=', $template_key )
            ->where('thumbnails.language_code','=', $destination_lang )
            // ->where('thumbnails.dimentions','=', '5 x 7 in' )
            ->where('templates.status','=', 5 )
            ->where('templates.format_ready','1')
            ->where('templates.translation_ready','1')
            ->where('templates.thumbnail_ready','1')
            ->offset($offset)
            ->limit($per_page)
            ->get();

        // echo "<pre>";
        // print_r( $translation_ready_templates );
        // exit;
        $arr_ready_for_sale = [];
        foreach ($thumb_ready_templates as $template) {
            $template_key = $template->template_id;
            
            $template_info['key'] = $template_key;
            // Template elements has been formated
            // $template_info['format_ready'] = $template->format_ready;
            $template_info['translation_ready'] = $template->translation_ready;
            // $template_info['thumbnail_ready'] = $template->thumbnail_ready;

            if( $template->filename ){
                $template_info['thumbnail']  = asset( 'design/template/'.$template_key.'/thumbnails/'.$destination_lang.'/'.$template->filename);
            } else {
                $template_info['thumbnail']  = null;
            }
            $arr_ready_for_sale[] = $template_info;
        }

        // echo "<pre>";
        // print_r( $template_info );
        // exit;
        
        return view('admin.thumbnail_ready', [
            'templates' => $arr_ready_for_sale,
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'language_code' => 'es',
            'country' => 'mx'
        ]);
        
    }
    
    function getMissingMetadataTemplates(Request $request){
        
        // Get all templates already formated
        $destination_lang = 'en';

        $current_page = 1;
        if( isset($request->page) ) {
            $current_page = $request->page;
        }

        $page = $current_page-1;
        $per_page = 2;
        $offset = $page*$per_page;

        $total_templates = DB::table('templates')
            ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
            ->select('templates.template_id','templates.format_ready','templates.translation_ready','templates.thumbnail_ready', 'filename')
            // ->where('template_id','=', $template_key )
            ->where('thumbnails.language_code','=', $destination_lang )
            // ->where('thumbnails.dimentions','=', '5 x 7 in' )
            
            // ->where('templates.status','=', 5 )
            ->where('templates.format_ready','1')
            // ->where('templates.translation_ready','1')
            // ->where('templates.thumbnail_ready','1')
            ->count();

        $total_pages = ceil( $total_templates/$per_page );
        
        $metadata_ready_templates = DB::table('templates')
            ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
            ->select('templates.template_id','templates.format_ready','templates.translation_ready','templates.thumbnail_ready','templates.metadata_ready', 'filename')
            // ->where('template_id','=', $template_key )
            ->where('thumbnails.language_code','=', $destination_lang )
            // ->where('thumbnails.dimentions','=', '5 x 7 in' )
            ->where('templates.status','=', 5 )
            ->where('templates.format_ready','1')
            // ->where('templates.translation_ready','1')
            // ->where('templates.thumbnail_ready','1')
            // ->where('templates.metadata_ready','0')
            ->offset($offset)
            ->limit($per_page)
            ->get();

        foreach ($metadata_ready_templates as $template) {
            $template_key = $template->template_id;
            
            $template_info['key'] = $template_key;
            $template_info['format_ready'] = $template->format_ready;
            $template_info['translation_ready'] = $template->translation_ready;
            $template_info['thumbnail_ready'] = $template->thumbnail_ready;
            $template_info['metadata_ready'] = $template->metadata_ready;
            $template_info['thumbnail']  = asset( 'design/template/'. $template_key.'/thumbnails/'.$destination_lang.'/'.$template->filename);

            $arr_missing_metadata[] = $template_info;
        }
        
        return view('admin.missing_metadata', [
            'current_page' => $current_page,
            'total_pages' => $total_pages,
            'templates' => $arr_missing_metadata,
            'language_code' => 'es',
            'country' => 'mx'
        ]);
        
    }

    function refactor(){
        
        // $language_code = 'es';
        // $format_ready_templates = Redis::keys('template:'.$language_code.':*:jsondata');
        // // echo "<pre>";
        // // print_r($format_ready_templates);
        // // exit;

        // echo "<pre>";

        // foreach ($format_ready_templates as $template_key) {
        //     $template_key = str_replace('template:'.$language_code.':', null, $template_key);
        //     $template_key = str_replace(':jsondata', null, $template_key);
        //     // print_r("\n".$template_key);
        //     // exit;

        //     $thumb = DB::table('thumbnails')
    	// 	->select('filename')
    	// 	->where('template_id','=',$template_key)
    	// 	->where('language_code','=',$language_code)
        //     ->first();

        //     if( isset($thumb->filename) ){
        //         $old_img_path = 'design/template/'.$template_key.'/thumbnails/';
        //         $new_img_path = 'design/template/'.$template_key.'/thumbnails/'.$language_code.'/';
                
        //         $old_img_path = public_path($old_img_path);
        //         $new_img_path = public_path($new_img_path);
                

        //         // $path = pathinfo($new_path); // dirname, filename, extension
        //         if (file_exists($old_img_path.$thumb->filename)) {
        //             print_r("\n PARSING >>>".$thumb->filename);
        //             print_r("\n".$old_img_path);
        //             print_r("\n".$new_img_path);

        //             @mkdir( $new_img_path, 0777, true);

        //             if (!@rename($old_img_path.$thumb->filename, $new_img_path.$thumb->filename)) {
        //                 echo "<pre>";
        //                 echo "copy failed \n";
        //                 print_r("\n".$thumb->filename);
        //                 print_r("\n".$old_img_path);
        //                 print_r("\n".$new_img_path);
        //                 exit;
        //             }
        //         }
                
        //     }
        // }

        // exit;

        $template_info = [];

        $format_ready_templates = Redis::keys('template:en:*:jsondata');
        // echo "<pre>";
        // print_r($format_ready_templates);
        // exit;

        foreach ($format_ready_templates as $template_key) {
            $template_key = str_replace('template:en:', null, $template_key);
            $template_key = str_replace(':jsondata', null, $template_key);
            // print_r("\n".$template_key);
            // exit;

            $template_info['format_ready'] = Redis::exists('product:format_ready:'.$template_key);
            $template_info['translation_ready'] = Redis::exists('template:es:'.$template_key.':jsondata') && Redis::exists('product:translation_ready:'.$template_key);
            $template_info['thumbnail_ready'] = Redis::exists('product:thumbnail_ready:'.$template_key);
            $template_info['preview_ready'] = Redis::exists('product:preview_images:'.$template_key);
            $template_info['metadata_ready'] = Redis::exists('template:en:'.$template_key.':metadata');
            
            $template_metadata = DB::table('templates')
    		->select('id','template_id')
    		->where('template_id','=',$template_key)
			->first();
		
            if( isset($template_metadata->id) ){
                print_r("\nUPDATING >> $template_key");
                // print_r($template_info);
                // print_r($template_metadata);
                // exit;
                DB::table('templates')
				    ->where('template_id', '=',$template_key)
				    ->update([
                        'format_ready' => $template_info['format_ready'],
                        'translation_ready' => $template_info['translation_ready'],
                        'thumbnail_ready' => $template_info['thumbnail_ready'],
                        'preview_ready' => $template_info['preview_ready'],
                        'metadata_ready' => $template_info['metadata_ready']
                    ]);
            } else {
                print_r("\nINSERTING >> $template_key");
                DB::table('templates')->insert([
                    'id' => null,
                    'template_id' => $template_key,
                    'status' => 5,
                    'format_ready' => $template_info['format_ready'],
                    'translation_ready' => $template_info['translation_ready'],
                    'thumbnail_ready' => $template_info['thumbnail_ready'],
                    'preview_ready' => $template_info['preview_ready'],
                    'metadata_ready' => $template_info['metadata_ready']
                ]);
            }
        }
    }

    function setIMGKeywords( $img_id, Request $request ){
        
        if( isset( $request->title ) 
            && isset( $request->keywords )
        ){
            // echo "<pre>";
            // // print_r( $request->all() );
            // print_r( $request->img_id );
            // exit;

            foreach ($request->keywords as $keyword) {
                $db_keyword = DB::table('keywords')
                    ->select('id')
                    ->where('word', '=', trim(strtolower($keyword)) )
                    ->first();

                if( isset($db_keyword->id) == false ){
                    $keyword_id = DB::table('keywords')->insertGetId([
                        'id' => null,
                        'word' => trim(strtolower($keyword)),
                        'language_code' => 'en',
                    ]);
                } else {
                    $keyword_id = $db_keyword->id;
                }

                $db_image_has_keyword = DB::table('image_keywords')
                    ->select('id')
                    ->where('image_id', '=', $request->img_id)
                    ->where('keyword_id', '=', $keyword_id)
                    ->first();
                
                if( isset($db_image_has_keyword->id) == false ){
                    DB::table('image_keywords')->insert([
                        'id' => null,
                        'image_id' => $request->img_id,
                        'keyword_id' => $keyword_id,
                    ]);
                }
            }

            DB::table('images')
			->where('id','=', $request->img_id)
            ->update([
                'title' => $request->title,
                'status' => 2
            ]);

            echo 0;
            exit;
            // return redirect()->action(
            //     [AdminController::class,'manageKeywords'], []
            // );
        }

        $title_words = '';
        $autocomplete = [];
        $tmp_similar_titles = [];
        $tmp_similar_thumbs = [];

        $db_image = DB::table('images')
                    ->select('thumb_path','original_path','title','file_type','source','id','template_id')
                    ->where('id', '=', $img_id)
                    ->first();

        if( $db_image->source == 'placeit' ){
            $img_tags = self::getPlaceitKeywords($db_image->template_id);
        }

        $template_info = DB::select( DB::raw(
            "SELECT
                templates.source,
                templates.template_id,
                LOWER(CONCAT(
                thumbnails.title,
                ' ',
                tmp_etsy_metadata.title,
                ' ',
                tmp_etsy_product.title
                )) title
            FROM 
                templates,
                thumbnails,
                tmp_etsy_metadata,
                tmp_etsy_product
            WHERE 
                templates.template_id = '".$db_image->template_id."'
                AND thumbnails.template_id = templates.template_id
                AND templates.fk_etsy_template_id = tmp_etsy_metadata.id
                AND tmp_etsy_metadata.fk_product_id = tmp_etsy_product.id
            LIMIT 1"
        ));
        
        if( $db_image->source == 'placeit' ){
            $keywords_arr = [];
            foreach ($img_tags as $word) {
                $keywords_arr[] = ucwords( str_replace(',','',$word) );
            }
            $title_words_arr[1] = $keywords_arr;

        } else {
            foreach ($template_info as $db_title) {
                $title_words = ucwords($db_title->title);
            }
            preg_match_all('/(\w+)/', $title_words, $title_words_arr);
        }

        $unique_keywords = array_unique($title_words_arr[1]);
        $tmp_recomendations = [];

        // echo "<pre>";
        // print_r( $keywords_arr );
        // exit;

        // echo "<pre>";
        // print_r( $unique_keywords );
        // exit;
        
        if( empty($unique_keywords) == false ){
            
            // $recomendations = DB::select( DB::raw(
            //     "SELECT keywords.word, COUNT(*) total FROM image_keywords, keywords WHERE image_id IN (
            //         SELECT id FROM images WHERE template_id IN(
            //             SELECT template_id FROM images
            //             WHERE id IN(
            //                 SELECT id FROM (SELECT image_id FROM image_keywords WHERE keyword_id IN(
            //                     SELECT id FROM (SELECT * FROM keywords WHERE word IN(
            //                     "."'".implode("','",$unique_keywords)."'"."
            //                     )) keywords_ids
            //                 )) iamges_with_keywords
            //             ) 
            //         ) 
            //     )
            //     AND image_keywords.keyword_id = keywords.id
            //     GROUP BY keywords.word
            //     ORDER BY total DESC"
            // ));

            // foreach ($recomendations as $recomendation) {
            //     $tmp_recomendations[] = ucwords($recomendation->word);
            // }
            
            $db_similar_titles = DB::select( DB::raw(
                "SELECT title 
                FROM images 
                WHERE
                    title IS NOT NULL
                    AND template_id IN(
                            SELECT template_id FROM images
                            WHERE id IN(
                                SELECT * FROM (SELECT image_id FROM image_keywords WHERE keyword_id IN(
                                    SELECT id FROM (SELECT * FROM keywords WHERE word IN(
                                        "."'".implode("','",$unique_keywords)."'"."
                                    )) keywords_ids
                                )) iamges_with_keywords
                            ) 
                        )"
            ));
    
            foreach ($db_similar_titles as $similar_title) {
                $tmp_similar_titles[] = ucwords($similar_title->title);
            }
    
            $db_similar_thumb = DB::select( DB::raw(
                "SELECT title 
                FROM thumbnails 
                WHERE 
                template_id IN(
                            SELECT template_id FROM images
                            WHERE id IN(
                                SELECT * FROM (SELECT image_id FROM image_keywords WHERE keyword_id IN(
                                    SELECT id FROM (SELECT * FROM keywords WHERE word IN(
                                        '".implode("','",$unique_keywords)."'
                                    )) keywords_ids
                                )) iamges_with_keywords
                            ) 
                        )"
            ));
    
            foreach ($db_similar_thumb as $similar_thumb) {
                $tmp_similar_thumbs[] = ucwords($similar_thumb->title);
            }
    
            $autocomplete = array_merge($tmp_recomendations,$unique_keywords);
        }


        // print_r( $db_image->template_id );
        // print_r( '<br>' );
        // print_r( $title_words_arr[1] );
        
        // print_r( '<pre>' );
        // print_r( $unique_keywords );
        // print_r( $tmp_recomendations );
        // print_r( $autocomplete );

        // print_r( $tmp_similar_titles );
        // print_r( $tmp_similar_thumbs );
        // print_r( '</pre>' );

        $img_src = asset(  str_replace('/application/public/',null, $db_image->thumb_path) );
        $img_path = asset(  str_replace('/application/public/',null, $db_image->original_path) );

        $existing_keywords = DB::table('image_keywords')
                    ->join('keywords', 'image_keywords.keyword_id', '=', 'keywords.id')
                    ->select('keywords.word')
                    ->where('image_id','=', $img_id )
                    ->get();

        $comma_keywords = array();
        foreach ($existing_keywords as $keyword) {
            array_push($comma_keywords, ucfirst($keyword->word) );
        }
        $comma_keywords = implode(',',$comma_keywords);
        
        return view('admin.assign_keywords', [
            'unique_keywords' => $unique_keywords,
            'tmp_recomendations' => $tmp_recomendations,
            'autocomplete' => $autocomplete,
            
            'tmp_similar_titles' => $tmp_similar_titles,
            'tmp_similar_thumbs' => $tmp_similar_thumbs,

            'img_src' => $img_src,
            'img_path' => $img_path,
            'file_type' => strtoupper($db_image->file_type),
            'source' => strtoupper($db_image->source),
            'title' => $db_image->title,
            'img_id' => $img_id,
            'image_keywords' => $existing_keywords,
            'comma_keywords' => $comma_keywords,
        ]);
    }

    function downloadImage(){
        //PDF file is stored under project/public/download/info.pdf
        // $file= public_path(). "/download/info.pdf";
        // $headers = [
        //     'Content-Type' => 'application/pdf',
        //  ];
        // return response()->download($file, 'filename.pdf', $headers);

        return Storage::download(public_path().'/instagram/thumbs/XF76rNksvh9bolJ.png');
    }

    function staticGallery(Request $request){
        
        $itemsPerPage = 200;
        $current_page = isset($request->page) ? $request->page : 1;
        $imgs = [];
        $pages = [];
        
        $templates = DB::table('images')
            ->select('id','template_id','thumb_path','file_type','filename','status','original_path')
            // ->where('source','=','crello')
    		// ->where('source','=','green')
            // ->where('source','!=','placeit')
            // ->where('file_type','!=','svg')
            // ->whereNull('status')
            // ->where('source','=','templett')
            ->where('source','=','corjl')
            ->where('status','=','2')
            ->whereNotNull('thumb_path')
            ->offset( ($current_page-1) *$itemsPerPage)
            ->limit($itemsPerPage)
            ->orderBy('id', 'desc')
            ->get();

        $total_templates = DB::table('images')
                            // ->where('source','=','templett')
                            // ->where('status','=','1')
                            ->where('source','=','corjl')
                            ->where('status','=','2')
                            ->whereNotNull('thumb_path')
                            // ->where('file_type','!=','svg')
                            // ->whereNull('status')
                            ->count();

        // echo $total_templates;
        // exit;

        // $templates = DB::select( DB::raw(
        //     "SELECT id,template_id, thumb_path, file_type, filename, status, original_path
        //         FROM images
        //     WHERE
        //         -- `status` IS NULL AND 
        //         template_id IN(
        //             SELECT 
        //                 templates.template_id
        //             FROM templates
        //                 -- LEFT JOIN templates ON images.template_id = templates.template_id
        //                 LEFT JOIN thumbnails ON templates.template_id = thumbnails.template_id AND thumbnails.language_code = 'en'
        //                 LEFT JOIN tmp_etsy_metadata ON tmp_etsy_metadata.id = fk_etsy_template_id
        //                 LEFT JOIN tmp_etsy_product ON tmp_etsy_product.id = tmp_etsy_metadata.fk_product_id
                    
        //             WHERE 
        //                 tmp_etsy_product.title LIKE '%Balloon%'
        //                 OR tmp_etsy_metadata.title LIKE '%Balloon%'
        //                 OR thumbnails.title LIKE '%Balloon%'
        //             GROUP BY templates.template_id
        //         )
        //     "
        // ));
        
        $first_page = $current_page;
        $last_page = ( $current_page+10 < round($total_templates/$itemsPerPage) ) ? $current_page+10 : round($total_templates/$itemsPerPage);
        
        // echo $first_page;
        // echo '<br>';
        // echo round($total_templates/100);
        // echo '<br>';
        // echo $last_page;
        // exit;

        for ($i=$first_page; $i <= $last_page; $i++) { 
            $pages[] = $i;
        }

        foreach ($templates as $template) {
            // print_r('<img src="'.asset(  str_replace('/application/public/',null, $template->thumb_path) ).'">');
            // echo '<br>';
            $tmp_img = new \stdClass();
            $tmp_img->src = asset(  str_replace('/application/public/',null, $template->thumb_path) );
            $tmp_img->path = asset(  str_replace('/application/public/',null, $template->original_path) );
            $tmp_img->status = $template->status;
            $tmp_img->id = $template->id;

            $imgs[] = $tmp_img;
        }

        // echo "<pre>";
        // print_r($imgs);
        // exit;

        return view('admin.assets', [
            'total_templates' => $total_templates,
            'current_page' => $current_page,
            'last_page' => floor($total_templates/$itemsPerPage),
            'pages' => $pages,
            'imgs' => $imgs
        ]);

        /*
        $scan = scandir( public_path('/over/templates/') );
        foreach($scan as $folder) {
            if( strlen($folder) > 3 
                && $folder != '.DS_Store' 
                && strpos($folder, ".zip") == 0 ) {

                // echo $folder;
                // echo '<br>';
                
                $scan_img = scandir( public_path('/over/templates/'.$folder.'/thumbnails/') );
                foreach($scan_img as $img_path) {
                    if( strlen($img_path) > 3 
                        && $img_path != '.DS_Store' 
                        && strpos($img_path, ".jpg") > 0 ) {
                        
                        echo '<br>';
                        print_r('<img width="300" src="'.asset(  '/over/templates/'.$folder.'/thumbnails/'.$img_path ).'">');
                        
                        // $source = public_path('/over/templates/'.$folder.'/'.$img_path);
                        // $destination = public_path('/over/templates/'.$folder.'/thumbnails/'.$img_path);
                        // if ( file_exists( $source ) == true ) {
                        //     @mkdir(public_path('/over/templates/'.$folder.'/thumbnails/'), 0777, true);
                        //     if ( file_exists( $source ) == true ) {
                        //         copy($source, $destination);
                        //         unlink($source);
                        //     }
                        // }

                    }
                }
                // $source = public_path('/over/templates/'.$folder.".zip");
                // $destination = public_path('/over/templates/'.$folder.'/assets/'.$folder.".zip");

                // if ( file_exists( $source ) == true ) {
                //     echo '<br>';
                //     echo $source;
                //     echo '<br>';
                //     echo $destination;
                //     echo '<br>';
                    
                //     @mkdir(public_path('/over/templates/'.$folder.'/assets/'), 0777, true);
                    
                //     // self::recurseCopy($source, $destination);
                //     if ( file_exists( $source ) == true ) {
                //         copy($source, $destination);
                //         unlink($source);
                //         // exit;
                //     }
                // }
            }
        }
        exit;
        */
    }

    function getTemplatesByVendor( $vendor ){
        // $vendors = [
        //     'desygner',
        //     // 'foco',
        //     // 'artory',
        //     // 'adobe',
        //     // 'magisto'
        // ];
        $vendors[] = $vendor;
        
        foreach($vendors as $vendor) {
            if( is_dir( public_path($vendor.'/design/template/') ) ){
    
                $scan = scandir( public_path($vendor.'/design/template/') );
                foreach($scan as $folder) {
                    // echo public_path('canva/instagram-story/design/template'.$folder).'<br>';
                    // exit;
                    if( strlen($folder) > 3 
                        && $folder != '.DS_Store'
                        && $folder != '._.DS_Store'
                        ) {
                        
                        if( $vendor == 'desygner' ){
                            $thumbnails_folder = '/thumbnails/en/';
                        } elseif( $vendor == 'foco' ){
                            $thumbnails_folder = '/assets/';
                        } else {
                            $thumbnails_folder = '/thumbnails/';
                        }

                        $subscan = scandir( public_path($vendor.'/design/template/'.$folder.$thumbnails_folder) );
                        foreach($subscan as $subfolder) {        
                            if( strlen($subfolder) > 3 && $subfolder != '.DS_Store') {    
                                print_r('<img src="'.asset( $vendor.'/design/template/'.$folder.$thumbnails_folder.$subfolder ).'">');
                                echo '<br>';
                            }
                        }
                        // echo '<br>';
                        // print_r( asset( 'design/template/'.$template->template_id.'/assets/'.$folder ) );
                        // && is_dir( public_path('canva/instagram-story/design/template/'.$folder) ) 
                    }
                }
            }
        }
    }
    
    function getTemplateObjects(){
        $json_template = json_decode( Redis::get( 'template:en:q5LV6RnbzdYcMht:jsondata' ) );
    
        if( isset( $json_template[0] ) ){
            unset( $json_template[0] );
        }
        
        if( sizeof($json_template) > 0){
            foreach( $json_template as $page ) {
                $txt_objects = [];
                foreach ($page->objects as $object) {
                    if( $object->type == 'image' ){
                        $tmp_obj = [];
                        $tmp_obj['y'] = $object->top;
                        $tmp_obj['x'] = $object->left;
                        $tmp_obj['src'] = $object->src;

                        $path = public_path('design/template/h8dImHgQnfoFxvL/assets/QgKYN8L8UhmQRh9RGFbGZc30AYat6Ot01RvI3cx2.png');
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

                        $tmp_obj['encoded_img'] = $base64;
                        $img_objects[] = $tmp_obj;
                        // echo "<pre>";
                        // print_r( $object );
                        // print_r( $tmp_obj );
                        // exit;

                    } elseif( $object->type == 'textbox' ){
                        $tmp_obj = [];
                        $tmp_obj['color'] = $object->fill;
                        $tmp_obj['text'] = $object->text;
                        $tmp_obj['fontSize'] = $object->fontSize;
                        $tmp_obj['y'] = $object->top;
                        $tmp_obj['x'] = $object->left;
                        $txt_objects[] = $tmp_obj;
                    }
                }

                $tmp_page['text'] = $txt_objects;
                $tmp_page['images'] = $img_objects;
                
                $page_obj['pages'][] = $tmp_page;
            }

            return response()->json( $page_obj );
        }
        
        return response()->json([]);
    }

    function getKeywordRecomendations( $search_param ){
        $keyword_recomendations = DB::select( DB::raw(
                "SELECT
                    keywords.word,
                    COUNT(keywords.word) total  
                FROM
                    images,
                    image_keywords,
                    keywords 
                WHERE
                    images.title LIKE '%".$search_param."%' 
                    AND image_keywords.image_id = images.id 
                    AND keywords.id = image_keywords.keyword_id 
                GROUP BY
                    word
            UNION
                SELECT
                    keywords.word,
                    COUNT(keywords.word) total  
                FROM
                    images,
                    image_keywords,
                    keywords 
                WHERE
                    images.id IN( SELECT id FROM (SELECT
                    images.id
                FROM
                    keywords,
                    image_keywords,
                    images
                WHERE
                    keywords.word LIKE '%".$search_param."%'
                    AND images.id = image_keywords.image_id
                    AND image_keywords.keyword_id = keywords.id
                ) ss )
                    AND image_keywords.image_id = images.id 
                    AND keywords.id = image_keywords.keyword_id 
                GROUP BY
                    word
                ORDER BY total DESC
                LIMIT 20"
        ));

        foreach ($keyword_recomendations as $recomendation) {
            $tmp_recomendations[] = ucwords($recomendation->word);
            // $tmp_titles[] = ucwords($recomendation->title);
        }

        return response()->json([
            'keywords' => array_unique($tmp_recomendations)
            // 'title' => array_unique($tmp_titles)
        ]);
    }

    function createEtsyPDF( $template_id ){
        $canva_url = 'lasdlakdlaksdlaskd';
        
        $pdf_html = '
        <style>@page { margin: 0px; }body { margin: 0px; }</style>
        <style>
            .center {
                height: 200px;
                position: relative;
              }
              
              .center p {
                margin: 0;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                text-align: center;
              }
        </style>
        <body style="background-color:#fff;padding:0;margin:0">
            <div style="background-color:#F4E2D8;
            text-align: center;
            padding:80px 0px;
            wigth: 100px;
            margin-top: 340px;
            margin-right: 80px;
            margin-left: 80px;">
                <div>
                    <p style="text-align: center;font-size:50px;color:#91641B">
                        Links for Canva Template
                    </p>
                    WAYAK STUDIO
                </div>
            </div>

            <div class="page_break" style="page-break-before: always;"></div>

            <h2 style="text-align:center;padding-top:380px;color:#91641B;font-size:30px;">THANK YOU!</h2>
            
            <div style="margin:20px;padding:20px 80px;">
                <p style="text-align: center;">Thank you for purchasing the Infopreneur Graphic Pack. We hope you enjoy your purchase.
                In order to access your templates, simply click the button
                below.</p>
            </div>

            <center>
                <div style="background-color:#E1D0C0;margin:20px 20%;padding:20px 30px;">
                    <a href="'.$canva_url.'" style="color:#91641B;font-size:30px;text-decoration:none;">
                        EDIT TEMPLATE ON CANVA
                    </a>
                </div>
            </center>
            
            <div class="page_break" style="page-break-before: always;"></div>

            <div class="center">
                <p>
                    <a href="https://wayak.app/" style="color:#222222;font-size:30px;text-decoration:none;">
                        WAYAK.APP
                    </a>
                    <br><br>
                    Thanks for your purchase! Hope you like it!<br>
                    I will be grateful for your review.
                </p>
            </div>

        </body>
        ';

        $dompdf = new Dompdf();
		$dompdf->loadHtml($pdf_html);
		$dompdf->setPaper('A4', 'portrait');
		// Render the HTML as PDF
		$dompdf->render();
		
        // Output the generated PDF to Browser
		// return $dompdf->stream();

        $output = $dompdf->output();
        $path = public_path('etsy_store/products/'.$template_id.'/pdf/');
        // echo $path;
        // exit;
        @mkdir($path, 0777, true);
        $template_id_path = $path.$template_id.'.pdf';
        file_put_contents( $template_id_path, $output);
        
        return redirect()->action(
            [AdminController::class,'getTemplateDashboard'], [
                
            ]
        );
    }

    function etsyGallery(Request $request){
        
        $itemsPerPage = 200;
        $current_page = isset($request->page) ? $request->page : 1;
        $vendor = isset($request->vendor) ? $request->vendor : 'green';
        $imgs = [];
        $pages = [];

        $destination_lang = 'en';
        $template_metadata = DB::table('templates')
            ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
            ->select('templates.template_id','thumbnails.original_template_id','templates.source', 'thumbnails.title', 'thumbnails.filename', 'templates.canva_url')
            ->where('thumbnails.language_code','=', 'en' )
    		->where('templates.source','=',$vendor)
    		// ->whereRaw('thumbnails.title LIKE \'%hallo%\'')
            ->orderBy('thumbnails.id', 'desc')
            ->offset( ($current_page-1) *$itemsPerPage)
            ->limit($itemsPerPage)
            ->get();
        
        $total_templates = DB::table('templates')
            ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
            ->select('templates.template_id')
            ->where('thumbnails.language_code','=', 'en' )
    		->where('templates.source','=',$vendor)
            // ->whereRaw('thumbnails.title LIKE \'%hallo%\'')
    		->count();
        
        $first_page = $current_page;
        $last_page = ( $current_page+10 < round($total_templates/$itemsPerPage) ) ? $current_page+10 : round($total_templates/$itemsPerPage);

        for ($i=$first_page; $i <= $last_page; $i++) { 
            $pages[] = $i;
        }

        $templates = [];
        foreach ($template_metadata as $template) {
            $template_key = $template->template_id;
            
            $template_info['key'] = $template_key;
            
            if( $template->source == 'crello' ){
                $template_info['thumbnail']  = asset( 'design/template/'. $template_key.'/thumbnails/'.$template->filename );
            } else if( $template->source == 'templett' ){
                $template_info['thumbnail']  = asset( 'design/template/'.$template->original_template_id.'/thumbnails/en/'.$template->filename );
            } else if( $template->source == 'placeit' OR $template->source == 'corjl' OR $template->source == 'green' ){
                $template_info['thumbnail']  = asset( 'design/template/'.$template->template_id.'/thumbnails/en/'.$template->filename );
            } else {
                $template_info['thumbnail']  = asset( 'design/template/'. $template_key.'/thumbnails/'.$template->filename );
            }
            
            $tmp_img = new \stdClass();
            $tmp_img->src = $template_info['thumbnail'];
            // $tmp_img->href = '/admin/etsy/gallery/template-assets/'.$template->source.'/'.$template->template_id;
            $tmp_img->href = route('admin.etsy.templateDashboard',[
                'app' => $template->source,
                'template_id' => $template->template_id
            ]);
            $tmp_img->source = $template->source;
            $tmp_img->title = $template->title;
            $tmp_img->path = 'open /Volumes/BACKUP/wayak/public/design/template/'.$template->template_id.'/assets';
            $tmp_img->original_template_id = $template->original_template_id;
            $tmp_img->template_id = $template->template_id;
            $tmp_img->canva_url = $template->canva_url;

            $templates[] = $tmp_img;
        }

        return view('admin.template_gallery', [
            'vendor' => $vendor,
            'total_templates' => $total_templates,
            'current_page' => $current_page,
            'last_page' => floor($total_templates/$itemsPerPage),
            'pages' => $pages,
            'templates' => $templates
        ]);

        // echo "<pre>";
        // print_r($templates);
        // exit;
    }

    function createEtsyProductThumbs( $template_id ){
        
        // $template = DB::table('thumbnails')
        //             ->select('template_id','filename','original_template_id')
        //             ->where('template_id','=', $template_id )
        //             ->where('language_code','=', 'en' )
        //             ->first();

        // // $template_key = $template_id;
        // $app = 'green';
        // $template_info['key'] = $template_id;
        
        // if( $app == 'crello' ){
        //     $template_info['thumbnail']  = public_path( 'design/template/'.$template->template_id.'/thumbnails/'.$template->filename );
        // } else if( $app == 'templett' ){
        //     $template_info['thumbnail']  = public_path( 'design/template/'.$template->original_template_id.'/thumbnails/en/'.$template->filename );
        // } else if( $app == 'placeit' OR $app == 'corjl' OR $app == 'green' ){
        //     $template_info['thumbnail']  = public_path( 'design/template/'.$template->template_id.'/thumbnails/en/'.$template->filename );
        // } else {
        //     $template_info['thumbnail']  = public_path( 'design/template/'.$template->template_id.'/thumbnails/'.$template->filename );
        // }

        $template_info['key'] = $template_id;
        $template_info['thumbnail'] = public_path( 'product/new/preview.jpg' );
        
        // echo "<pre>";
        // print_r($template_info);
        // exit;
        // echo public_path( 'design/template/xxx/thumbnails/' );
        
        // self::emptyFolder($template_id);

        $preview_images = [];
        // 'etsy_store/canva_pdf/'
        array_push($preview_images, self::processMockup($template_info,2) );
        array_push($preview_images, self::processMockup($template_info,31) );
        array_push($preview_images, self::processMockup($template_info,10) );
        array_push($preview_images, self::processMockup($template_info,6) );
        array_push($preview_images, self::processMockup($template_info,5) );
        array_push($preview_images, self::processMockup($template_info,12) );
        array_push($preview_images, self::processMockup($template_info,14) );
        array_push($preview_images, self::processMockup($template_info,15) );
        array_push($preview_images, self::processMockup($template_info,16) );
        
        // DB::table('templates')
        // 		->where('template_id','=', $template_key)
        // 		->update([
        // 			'preview_ready' => true
        //         ]);
    }

    function getTemplateDashboard($app, $template_id, Request $request){

        if(isset($request->canvaURLInput)){
            // echo $request->canvaURLInput;
            
            self::createEtsyPDF( $template_id, $request->canvaURLInput );
            
            self::createEtsyProductThumbs( $template_id );

            DB::table('templates')
					->where('template_id','=', $template_id)
					->update([
						'canva_url' => $request->canvaURLInput
                    ]);
        }
        
        $template = DB::table('templates')
            ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
            ->select(
                'templates.template_id',
                'thumbnails.original_template_id',
                'templates.source',
                'templates.thumbnail_ready',
                'templates.metadata_ready',
                'templates.pdf_ready',
                'templates.canva_url',
                'thumbnails.title',
                'thumbnails.filename')
            ->where('thumbnails.language_code','=', 'en' )
            ->where('templates.template_id','=', $template_id)
            ->first();

        if( $app == 'crello' ){
            $template_info['thumbnail']  = asset( 'design/template/'.$template->template_id.'/thumbnails/'.$template->filename );
        } else if( $app == 'templett' ){
            $template_info['thumbnail']  = asset( 'design/template/'.$template->original_template_id.'/thumbnails/en/'.$template->filename );
        } else if( $app == 'placeit' OR $app == 'corjl' OR $app == 'green' ){
            $template_info['thumbnail']  = asset( 'design/template/'.$template->template_id.'/thumbnails/en/'.$template->filename );
        } else {
            $template_info['thumbnail']  = asset( 'design/template/'.$template->template_id.'/thumbnails/'.$template->filename );
        }
        
        return view('admin.template_dashboard', [
            'app' => $app,
            'template_info' => $template_info,
            'title' => $template->title,
            // 'pdf_url' => asset( 'etsy_store/canva_pdf/'.$template->template_id.'.pdf' ),
            'pdf_url' => route( 'admin.etsy.getPDF', [
                'template_id' => $template->template_id
            ] ),
            'thumbnail_ready' => $template->thumbnail_ready,
            'metadata_ready' => $template->metadata_ready,
            'pdf_ready' => $template->pdf_ready,
            'canva_url' => $template->canva_url,
            'template_id' => $template_id
        ]);
    }

    function getPlaceitKeywords( $template_id ){
        
        $db_template = DB::table('thumbnails')
                                    ->select('*')
                                    ->where('template_id', '=', $template_id )
                                    ->first();
 
        // $key_template = 'placeit:template:'.$db_template->original_template_id.':metadata';
        // $original_metadata = json_decode(Redis::get($key_template));
            
        $key_template = 'placeit:template:'.$db_template->original_template_id.':jsondata';
        $template_metadata = json_decode(Redis::get($key_template));
            
        $xtags = [];

        foreach ($template_metadata->graphic as $img_arr) {
            foreach ($img_arr->layers as $layer) {
                // print_r( $layer );
                if( isset($layer->tags) ){
                    $xtags = array_merge($xtags, $layer->tags );
                }
            }
        }

        // echo "<pre>";
        // print_r( $xtags );
        // exit;
        return $xtags;
    }
    
    function getTemplateAssets($app, $template_id){

        if( Redis::exists( 'template:en:'.$template_id.':jsondata' ) ){
            
            $template = DB::table('templates')
                ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
                ->select('templates.template_id','thumbnails.original_template_id','templates.source', 'thumbnails.title', 'thumbnails.filename')
                ->where('thumbnails.language_code','=', 'en' )
                ->where('templates.template_id','=', $template_id)
                ->first();
    
            if( $app == 'crello' ){
                $template_info['thumbnail']  = asset( 'design/template/'.$template->template_id.'/thumbnails/'.$template->filename );
            } else if( $app == 'templett' ){
                $template_info['thumbnail']  = asset( 'design/template/'.$template->original_template_id.'/thumbnails/en/'.$template->filename );
            } else if( $app == 'placeit' OR $app == 'corjl' OR $app == 'green' ){
                $template_info['thumbnail']  = asset( 'design/template/'.$template->template_id.'/thumbnails/en/'.$template->filename );
            } else {
                $template_info['thumbnail']  = asset( 'design/template/'.$template->template_id.'/thumbnails/'.$template->filename );
            }
    
            $json_template = json_decode( Redis::get( 'template:en:'.$template->template_id.':jsondata' ) );
            
            // echo "<pre>";
            // print_r( $json_template );
            // exit;
        
            if( isset( $json_template[0] ) ){
                unset( $json_template[0] );
            }
            
            if( sizeof($json_template) > 0){
                foreach( $json_template as $page ) {
                    $txt_objects = [];
                    foreach ($page->objects as $object) {
                        if( isset($object->type) && ($object->type == 'image' || $object->type == 'group' || $object->type == 'path') ){
                            $tmp_obj = [];
                            $tmp_obj['y'] = $object->top;
                            $tmp_obj['x'] = $object->left;
                            $tmp_obj['src'] = str_replace('http://localhost/','http://localhost:8001/', str_replace('https://wayak.app/','http://localhost:8001/',$object->src) );
    
                            // $path = public_path('design/template/h8dImHgQnfoFxvL/assets/QgKYN8L8UhmQRh9RGFbGZc30AYat6Ot01RvI3cx2.png');
                            // $type = pathinfo($path, PATHINFO_EXTENSION);
                            // $data = file_get_contents($path);
                            // $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                            // $tmp_obj['encoded_img'] = $base64;
                            
                            $img_objects[] = $tmp_obj;
    
                        } elseif( isset($object->type) && $object->type == 'textbox' ){
                            $tmp_obj = [];
                            $tmp_obj['color'] = str_replace('##', '#', '#'.$object->fill);
                            $tmp_obj['text'] = $object->text;
                            $tmp_obj['fontSize'] = $object->fontSize;
                            $tmp_obj['y'] = $object->top;
                            $tmp_obj['x'] = $object->left;
                            $txt_objects[] = $tmp_obj;
                        }
                    }
    
                    $tmp_page['text'] = isset($txt_objects) ? $txt_objects : null;
                    $tmp_page['images'] = isset($img_objects) ? $img_objects : null;
                    
                    $template_objects['pages'][] = $tmp_page;
                }
            }
            
            // echo '<pre>';
            // print_r( $template_objects );
            // exit;
    
            if( is_dir( public_path('design/template/'.$template->template_id.'/assets') ) ){
                $scan = scandir( public_path('design/template/'.$template->template_id.'/assets') );
                $template_index = 0;
                
                $tmp_page['images'] = [];
                $tmp_page['text'] = [];

                foreach($scan as $folder) {
                    if( strlen($folder) > 3 ) {
                        // echo '<br>';
                        // echo $folder;
                        // echo '<br>';
                        // echo public_path('design/template/'.$template->template_id.'/assets'.$folder).'<br>';
                        // echo "<br>";
                        // print_r( asset( 'design/template/'.$template->template_id.'/assets/'.$folder ) );
                        // echo '<br>';
                        // echo '<img width="500" src="'.asset( 'design/template/'.$template->template_id.'/assets/'.$folder ).'">';
                        // && is_dir( public_path('canva/instagram-story/design/template/'.$folder) ) 
                        $tmp_obj = [];
                        $tmp_obj['src'] = asset( 'design/template/'.$template->template_id.'/assets/'.$folder );
                        $tmp_page['images'][] = $tmp_obj;
                    }
                }
                $template_objects['pages'][] = $tmp_page;
            }
            // exit;
    
            return view('admin.template_assets', [
                'template_info' => $template_info,
                'path' => 'open /Volumes/BACKUP/wayak/public/design/template/'.$template->template_id.'/assets',
                'template_objects' => $template_objects
            ]);
        } else {
            echo "Template Does not Exists";
        }
        
    }

    function updateAssetStatus(Request $request){

        if( isset($request->img_id) ){
            DB::table('images')
                ->where('id','=', $request->img_id)
                ->update([
                    'status' => 2
                ]);
        }

        // echo "<pre>";
        print_r( $request->all() );
        // exit;
        
    }

    function bulkTranslate($origin_lang, $destination_lang, Request $request){

        // Save translated Google data on database
        if( isset($request->templates_text) ){
            $templates_metadata = $request->templates_text;
            foreach ($templates_metadata as $template_info) {
                self::saveTemplateTranslation( $template_info );
            }
        }

        // echo "<pre>";
        // print_r( $request->all() );
        // exit;

        $limit = 30;
        // Get format ready templates
        $ready_for_translation = DB::table('templates')
                    ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
                    ->select('templates.template_id','templates.format_ready','templates.translation_ready','templates.thumbnail_ready', 'filename')
                    // ->where('template_id','=', $template_key )
                    ->where('thumbnails.language_code','=', 'en' )
                    // ->where('thumbnails.dimentions','=', '5 x 7 in' )
                    ->where('templates.status','=', 5 )
                    ->where('templates.format_ready','1')
                    ->where('templates.translation_ready','0')
                    ->limit($limit)
                    ->get();
        
        // echo "<pre>";
        // print_r( $ready_for_translation );
        // exit;

        $template_text = '';
        
        // $templates_on_page = 0;
        foreach ($ready_for_translation as $template) {

            // echo "<pre>";
            // print_r( $template );
            // exit;
            
            $template_key = $template->template_id;
            $source_template_key = 'template:'.$origin_lang.':'.$template_key.':jsondata';

            // echo $template_key.'<br>';
            // echo $source_template_key.'<br><br>';
            
            $source_template_exists = Redis::exists( $source_template_key );
            $template_format_ready = $template->format_ready;
            $template_translation_ready = $template->translation_ready;
            
            if( $source_template_exists
                && $template_format_ready 
                && $template_translation_ready == false 
                ){
                
                // print_r( $source_template_key );
                // exit;
                $template_text .= self::getTemplateHTMLText($source_template_key);
                // print_r($template_text);
                // exit;
            }
        }

        // print_r($template_text);
        // exit;

        return view('admin.bulk_translate', [
            'template_key' => $template_key,
            'template_text' => $template_text,
            'from' => $origin_lang,
            'to' => $destination_lang
        ]);
    }

    function getTemplateHTMLText($template_key){

        $template_obj = json_decode( Redis::get($template_key) );

        // echo "<pre>";
        // print_r( $template_key );
        // print_r( $template_obj );
        // exit;

        if(isset($template_obj[1]->objects) == false){
            echo $template_key;
            exit;
        }
        
        // echo "<pre>";
        // // print_r( $template_key );
        // print_r( $template_obj );
        // exit;
        
        $template_text = '<ul class="template-content" data-template-id="'.$template_key.'">';
        $text_i = 0;

        foreach($template_obj[1]->objects as $object ){
            if( $object->type == 'textbox'){
                // echo '<span>'.$object->text.'</span>';
                // exit;
                $text = $object->text;
                
                $text = str_replace('sat.','saturday,',$text);
                $text = str_replace('sun.','sunday,',$text);

                if( strpos($text, '  ') ){
                    // echo "Tiene doble espacio";
                    // exit;
                    $text = str_replace('  ','_',$text);
                    $text = str_replace(' ',null,$text);
                    $text = str_replace('_',' ',$text);
                    // $text = strtolower($text);
                }
                // $text = str_replace(' ','_',$object->text);
                
                // $text = ucfirst($text);
                // $text = ucwords(strtolower($text));
                // $text = preg_replace('/(\s  )+/', '', $text);

                $tmp = '<li lang="en" data-index="'.$text_i.'">'.$text.' </li>';
                $template_text .= str_replace("\n", ', ', $tmp);
                $text_i++;
            }
        }

        $template_text .= '</ul>';

        return $template_text;
    }
    
    function translateTemplateForm($template_key, $from, $to){
        
        $template_text = self::getTemplateHTMLText($template_key);
        
        // echo $template_key;
        // echo $template_text;
        // exit;
        
		return view('admin.translate_template', [
            'template_key' => $template_key,
            'template_text' => $template_text,
            'from' => $from,
            'to' => $to
        ]);
    }
    
    function generateProductThumbnails() {
        
        $destination_lang = 'en';
        $limit = 1;
        $thumb_missing_product_preview = DB::table('templates')
            ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
            ->select('templates.template_id','templates.format_ready','templates.translation_ready','templates.thumbnail_ready', 'filename')
            // ->where('template_id','=', $template_key )
            // ->where('thumbnails.language_code','=', $destination_lang )
            // ->where('thumbnails.dimentions','=', '5 x 7 in' )
            ->where('templates.source','=', 'green' )
            // ->where('templates.status','=', 5 )
            // ->where('templates.format_ready','1')
            // ->where('templates.translation_ready','1')
            ->where('templates.thumbnail_ready','0')
            ->limit($limit)
            ->orderBy('templates.id', 'desc')
            ->get();

        // echo "<pre>";
        // print_r( $thumb_missing_product_preview );
        // exit;

        $arr_missing_metadata = [];

        foreach ($thumb_missing_product_preview as $template) {
            $template_key = $template->template_id;
            $template_info['key'] = $template_key;
            
            
            if( $template->filename ){
                $filename = $template->filename;
                // $filename = str_replace('_thumbnail.jpg', '_large.jpg', $filename);
                $template_info['thumbnail']  = public_path( 'design/template/'. $template_key.'/thumbnails/'.$destination_lang.'/'.$filename);
            } else {
                $template_info['thumbnail']  = null;
            }

            if ( file_exists($template_info['thumbnail']) == false ) {
                echo "The file does not exist\n<br>";
                echo $template_info['thumbnail'];
                exit;
            }
            
            self::emptyFolder($template_key);

            $preview_images = [];
            
            // array_push($preview_images, self::processMockup($template_info,2) );
            // array_push($preview_images, self::processMockup($template_info,31) );
            // array_push($preview_images, self::processMockup($template_info,10) );
            // array_push($preview_images, self::processMockup($template_info,6) );
            // array_push($preview_images, self::processMockup($template_info,18) );

            array_push($preview_images, self::processMockup($template_info,2) );
            array_push($preview_images, self::processMockup($template_info,31) );
            array_push($preview_images, self::processMockup($template_info,10) );
            array_push($preview_images, self::processMockup($template_info,6) );
            array_push($preview_images, self::processMockup($template_info,5) );
            array_push($preview_images, self::processMockup($template_info,12) );
            array_push($preview_images, self::processMockup($template_info,14) );
            array_push($preview_images, self::processMockup($template_info,15) );
            array_push($preview_images, self::processMockup($template_info,16) );
            
            // echo "<pre>";
            // print_r($preview_images);
            // exit;

            // DB::table('templates')
			// 		->where('template_id','=', $template_key)
			// 		->update([
			// 			'preview_ready' => true
            //         ]);

            // Redis::set('product:preview_images:'.$template_info['key'], json_encode($preview_images));

            // self::processMockup($template_info,18);
            // 10, 2, 6, 18
            // exit;
            
            $arr_missing_metadata[] = $template_info;
        }

        echo "<pre>";
        print_r($arr_missing_metadata);
        exit;
        

    }

    function emptyFolder($template_id){
        $folter_to_clean = public_path( 'product/preview-images/'. $template_id .'/*');
        // echo "<pre>";
        // print_r($folter_to_clean);
        // exit;

        $files = glob( $folter_to_clean ); // get all file names
        
        foreach($files as $file){ // iterate files
            if(is_file($file)) {
                unlink($file); // delete file
            }
        }

    }

    function processMockup($template_info, $mockup_variant){
        $mock_option = $mockup_variant;

        switch ($mock_option) {
            case 1:
                $img_url = self::generateMock1($template_info);
                break;
            case 2:
                $img_url = self::generateMock2($template_info);
                break;
            
            case 3:
                $img_url = self::generateMock3($template_info);
                break;
            
            case 4:
                $img_url = self::generateMock4($template_info);
                break;
            
            case 5:
                $img_url = self::generateMock5($template_info);
                break;
            
            case 6:
                $img_url = self::generateMock6($template_info);
                break;
            
            case 7:
                $img_url = self::generateMock7($template_info);
                break;
            
            case 8:
                $img_url = self::generateMock8($template_info);
                break;
            
            case 9:
                $img_url = self::generateMock9($template_info);
                break;
            
            case 10:
                $img_url = self::generateMock10($template_info);
                break;
            
            case 11:
                $img_url = self::generateMock11($template_info);
                break;
            
            case 12:
                $img_url = self::generateMock12($template_info);
                break;
            
            case 13:
                $img_url = self::generateMock13($template_info);
                break;
            
            case 14:
                $img_url = self::generateMock14($template_info);
                break;
            
            case 15:
                $img_url = self::generateMock15($template_info);
                break;
            
            case 16:
                $img_url = self::generateMock16($template_info);
                break;
            
            case 18:
                $img_url = self::generateMock18($template_info);
                break;
            
            case 31:
                $img_url = self::generateMock31($template_info);
                break;
            
            default:
                $img_url = self::generateMock1($template_info);
                break;
        }
        
        return $img_url;

    }

    function createImagePreview(){
        $img = \Image::make($decoded_image);
        $img_path = 'design/template/'.$template_id.'/thumbnails/';
        $path = public_path($img_path);

        // print_r( $path );
        // exit;

        @mkdir($path, 0777, true);

        // Store mid-size thumbnail
        // $unique_id = Str::random(10);
        $full_thumbnail_path = public_path($img_path.$rand_filename_id.'_thumbnail.jpg');
        $img->save($full_thumbnail_path);
    }

    function generateMock1($product_info){
        $mockup_img_path = public_path('mockups/mockup_1.jpg');    
        $overlay_img_path = $product_info['thumbnail'];
    
            
        // create new Intervention Image
        $mockup_img = Image::make($mockup_img_path);
        
        $overlay_img = Image::make($overlay_img_path);

        $overlay_img->resize(null, 1270, function ($constraint) {
            $constraint->aspectRatio();
        });

        $mockup_img->insert($overlay_img, 'top-left', 445, 230);
        // $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        
        $mercadolibre_preview_path = public_path( 'product/preview-images/'. $product_info['key'] .'/');
        $filename = 'preview_4_'.rand(111111,999999).'.jpg';
        $preview_path = $mercadolibre_preview_path.$filename;
        @mkdir($mercadolibre_preview_path, 0777, true);
        $mockup_img->save( $preview_path );
        $url_path = asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename);

        // echo '<img src="'.asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename ).'">';
        // exit;
        
        return asset('mockups/final_thumbs.jpg');
        
        // // create a new Image instance for inserting
        // $watermark = Image::make('public/watermark.png');
        // $img->insert($watermark, 'center');

        // // insert watermark at bottom-right corner with 10px offset
        // $img->insert('public/watermark.png', 'bottom-right', 10, 10);
    }

    function generateMock2($product_info){
        $mockup_img_path = public_path('mockups/mockup_2.png');
        $overlay_img_path = $product_info['thumbnail'];
        
        // create new Intervention Image
        $mockup_img = Image::make($mockup_img_path);
        $overlay_img = Image::make($overlay_img_path);

        $overlay_img->resize(null, 1040, function ($constraint) {
            $constraint->aspectRatio();
        });

        $overlay_img->rotate(0);
        $mockup_img->insert($overlay_img, 'top-left', 410, 357);

        // $mockup_img->resize(null, 547, function ($constraint) {
        //     $constraint->aspectRatio();
        // });
        
        $mercadolibre_preview_path = public_path( 'product/preview-images/'. $product_info['key'] .'/');
        $filename = 'preview_3_'.rand(111111,999999).'.jpg';
        $preview_path = $mercadolibre_preview_path.$filename;
        @mkdir($mercadolibre_preview_path, 0777, true);
        $mockup_img->save( $preview_path );

        $url_path = asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename);

        echo '<img src="'.asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename ).'">';
        // exit;
        return $url_path;
    }

    function generateMock3($product_info){
        $mockup_img_path = public_path('mockups/mockup_3.jpg');
        $overlay_img_path = $product_info['thumbnail'];
        
        // create new Intervention Image
        $mockup_img = Image::make($mockup_img_path);
        $overlay_img = Image::make($overlay_img_path);

        $overlay_img->resize(null, 800, function ($constraint) {
            $constraint->aspectRatio();
        });

        $overlay_img->rotate(0);
        $mockup_img->insert($overlay_img, 'top-left', 319, 280);
        $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        
        return asset('mockups/final_thumbs.jpg');
    }
    
    function generateMock4($product_info){
        $mockup_img_path = public_path('mockups/mockup_4.jpg');
        $overlay_img_path = $product_info['thumbnail'];
        
        // create new Intervention Image
        $mockup_img = Image::make($mockup_img_path);
        $overlay_img = Image::make($overlay_img_path);

        $overlay_img->resize(null, 1100, function ($constraint) {
            $constraint->aspectRatio();
        });

        $overlay_img->rotate(0);
        $mockup_img->insert($overlay_img, 'top-left', 360, 220);
        $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        
        return asset('mockups/final_thumbs.jpg');
    }

    function generateMock5($product_info){
        $mockup_img_path = public_path('mockups/mockup_5.jpg');
        $overlay_img_path = $product_info['thumbnail'];
        
        $mockup_img = Image::make($mockup_img_path);
        $overlay_img = Image::make($overlay_img_path);

        $overlay_img->resize(null, 1690, function ($constraint) {
            $constraint->aspectRatio();
        });

        $mockup_img->insert($overlay_img, 'top-left', 542, 180);

        // $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        $mercadolibre_preview_path = public_path( 'product/preview-images/'. $product_info['key'] .'/');
        $filename = 'preview_3_'.rand(111111,999999).'.jpg';
        $preview_path = $mercadolibre_preview_path.$filename;
        @mkdir($mercadolibre_preview_path, 0777, true);
        $mockup_img->save( $preview_path );
        
        echo '<img src="'.asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename ).'">';

        return asset('mockups/final_thumbs.jpg');
    }
    
    function generateMock6($product_info){
        $mockup_img_path = public_path('mockups/mockup_6.jpg');
        $overlay_img_path = $product_info['thumbnail'];
        
        $mockup_img = Image::make($mockup_img_path);
        $overlay_img = Image::make($overlay_img_path);
        $overlay_2_img = Image::make($overlay_img_path);

        $overlay_img->resize(null, 1080, function ($constraint) {
            $constraint->aspectRatio();
        });

        $overlay_2_img->resize(null, 518, function ($constraint) {
            $constraint->aspectRatio();
        });

        $mockup_img->insert($overlay_img, 'top-left', 122, 283);
        $mockup_img->insert($overlay_2_img, 'top-left', 990, 520);

        // $mockup_img->resize(null, 547, function ($constraint) {
        //     $constraint->aspectRatio();
        // });

        $filename = 'preview_2_'.rand(111111,999999).'.jpg';
        $mercadolibre_preview_path = public_path( 'product/preview-images/'. $product_info['key'] .'/');
        $preview_path = $mercadolibre_preview_path.$filename;
        $url_path = asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename);
        @mkdir($mercadolibre_preview_path, 0777, true);
        $mockup_img->save( $preview_path );

        echo '<img src="'.asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename ).'">';

        return $url_path;
    }
    
    function generateMock7($product_info){
        $mockup_img_path = public_path('mockups/mockup_7.png');
        $overlay_img_path = $product_info['thumbnail'];
        
        $mockup_img = Image::make($mockup_img_path);
        $overlay_img = Image::make($overlay_img_path);

        $overlay_img->resize(null, 890, function ($constraint) {
            $constraint->aspectRatio();
        });

        $mockup_img->insert($overlay_img, 'top-left', 275, 200);

        $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        
        return asset('mockups/final_thumbs.jpg');
    }

    function generateMock8($product_info){
        $mockup_img_path = public_path('mockups/mockup_8.png');
        $overlay_img_path = $product_info['thumbnail'];
        $overlay_dedo = public_path('mockups/mockup_8_dedo.png');
        
        $mockup_img = Image::make($mockup_img_path);
        $overlay_img = Image::make($overlay_img_path);
        $overlay_dedo_img = Image::make($overlay_dedo);

        $overlay_img->resize(null, 535, function ($constraint) {
            $constraint->aspectRatio();
        });

        $overlay_img->rotate(355);

        $mockup_img->insert($overlay_img, 'top-left', 400, 380);
        $mockup_img->insert($overlay_dedo_img, 'top-left', 300, 780);

        $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        
        return asset('mockups/final_thumbs.jpg');
    }

    function generateMock9($product_info){
        $mockup_img_path = public_path('mockups/mockup_9.jpg');
        $overlay_img_path = $product_info['thumbnail'];
        
        
        $mockup_img = Image::make($mockup_img_path);
        $overlay_img = Image::make($overlay_img_path);
        

        $overlay_img->resize(null, 1158, function ($constraint) {
            $constraint->aspectRatio();
        });

        // $overlay_img->rotate(359);

        $mockup_img->insert($overlay_img, 'top-left', 330, 310);

        $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        
        return asset('mockups/final_thumbs.jpg');
    }

    function generateMock10($product_info){
        $mockup_img_path = public_path('mockups/mockup_10.png');
        $overlay_img_path = $product_info['thumbnail'];
        
        $mockup_img = Image::make($mockup_img_path);
        $overlay_img = Image::make($overlay_img_path);
        
        $overlay_img->resize(null, 1150, function ($constraint) {
            $constraint->aspectRatio();
        });

        $mockup_img->insert($overlay_img, 'top-left', 349, 303);

        // $mockup_img->resize(null, 547, function ($constraint) {
        //     $constraint->aspectRatio();
        // });

        $filename = 'preview_1_'.rand(111111,999999).'.jpg';
        $mercadolibre_preview_path = public_path( 'product/preview-images/'. $product_info['key'] .'/');
        $preview_path = $mercadolibre_preview_path.$filename;
        @mkdir($mercadolibre_preview_path, 0777, true);
        $mockup_img->save( $preview_path );
        $url_path = asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename);
        
        echo '<img src="'.asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename ).'">';

        return $url_path;
    }

    function generateMock11($product_info){
        $mockup_img_path = public_path('mockups/mockup_11.jpg');
        $overlay_img_path = $product_info['thumbnail'];
        
        
        $mockup_img = Image::make($mockup_img_path);
        $overlay_img = Image::make($overlay_img_path);
        

        $overlay_img->resize(null, 980, function ($constraint) {
            $constraint->aspectRatio();
        });

        // $overlay_img->rotate(359);

        $mockup_img->insert($overlay_img, 'top-left', 500, 397);

        $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        
        return asset('mockups/final_thumbs.jpg');
    }

    function generateMock12($product_info) {
        $mockup_img_path = public_path('mockups/mockup_12.jpg');
        $overlay_img_path = $product_info['thumbnail'];
        
        
        $mockup_img = Image::make($mockup_img_path);
        $overlay_img = Image::make($overlay_img_path);
        

        $overlay_img->resize(null, 880, function ($constraint) {
            $constraint->aspectRatio();
        });

        // $overlay_img->rotate(359);

        $mockup_img->insert($overlay_img, 'top-left', 300, 307);

        // $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        $mercadolibre_preview_path = public_path( 'product/preview-images/'. $product_info['key'] .'/');
        $filename = 'preview_3_'.rand(111111,999999).'.jpg';
        $preview_path = $mercadolibre_preview_path.$filename;
        @mkdir($mercadolibre_preview_path, 0777, true);
        $mockup_img->save( $preview_path );

        echo '<img src="'.asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename ).'">';
        
        return asset('mockups/final_thumbs.jpg');
    }

    function generateMock13($product_info){
        $mockup_img_path = public_path('mockups/mockup_13.jpg');
        $overlay_img_path = $product_info['thumbnail'];
        
        
        $mockup_img = Image::make($mockup_img_path);
        $overlay_img = Image::make($overlay_img_path);
        

        $overlay_img->resize(null, 972, function ($constraint) {
            $constraint->aspectRatio();
        });

        // $overlay_img->rotate(359);

        $mockup_img->insert($overlay_img, 'top-left', 302, 100);

        $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        
        return asset('mockups/final_thumbs.jpg');
    }

    function generateMock14($product_info){
        $mockup_img_path = public_path('mockups/mockup_14.jpg');
        $overlay_img_path = $product_info['thumbnail'];
        
        
        $mockup_img = Image::make($mockup_img_path);
        $overlay_img = Image::make($overlay_img_path);
        

        $overlay_img->resize(null, 783, function ($constraint) {
            $constraint->aspectRatio();
        });

        // $overlay_img->rotate(359);

        $mockup_img->insert($overlay_img, 'top-left', 332, 210);

        // $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        $mercadolibre_preview_path = public_path( 'product/preview-images/'. $product_info['key'] .'/');
        $filename = 'preview_3_'.rand(111111,999999).'.jpg';
        $preview_path = $mercadolibre_preview_path.$filename;
        @mkdir($mercadolibre_preview_path, 0777, true);
        $mockup_img->save( $preview_path );

        echo '<img src="'.asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename ).'">';
        
        return asset('mockups/final_thumbs.jpg');
    }

    function generateMock15($product_info){
        $mockup_img_path = public_path('mockups/mockup_15.jpg');
        $overlay_img_path = $product_info['thumbnail'];
        
        
        $mockup_img = Image::make($mockup_img_path);
        $overlay_img = Image::make($overlay_img_path);
        

        $overlay_img->resize(null, 900, function ($constraint) {
            $constraint->aspectRatio();
        });

        $mockup_img->insert($overlay_img, 'top-left', 392, 350);

        // $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        $mercadolibre_preview_path = public_path( 'product/preview-images/'. $product_info['key'] .'/');
        $filename = 'preview_3_'.rand(111111,999999).'.jpg';
        $preview_path = $mercadolibre_preview_path.$filename;
        @mkdir($mercadolibre_preview_path, 0777, true);
        $mockup_img->save( $preview_path );

        echo '<img src="'.asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename ).'">';
        
        return asset('mockups/final_thumbs.jpg');
    }

    function generateMock16($product_info){
        $mockup_img_path = public_path('mockups/mockup_16.jpg');
        $overlay_img_path = $product_info['thumbnail'];
        
        
        $mockup_img = Image::make($mockup_img_path);
        $overlay_img = Image::make($overlay_img_path);
        

        $overlay_img->resize(null, 830, function ($constraint) {
            $constraint->aspectRatio();
        });

        // $overlay_img->rotate(359);

        $mockup_img->insert($overlay_img, 'top-left', 458, 455);
        $mockup_img->encode('jpg', 10);
        // $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        $mercadolibre_preview_path = public_path( 'product/preview-images/'. $product_info['key'] .'/');
        $filename = 'preview_3_'.rand(111111,999999).'.jpg';
        $preview_path = $mercadolibre_preview_path.$filename;
        @mkdir($mercadolibre_preview_path, 0777, true);
        $mockup_img->save( $preview_path );

        echo '<img src="'.asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename ).'">';
        
        return asset('mockups/final_thumbs.jpg');
    }

    function generateMock18($product_info){
        $mockup_img_path = public_path('mockups/mockup_18.png');
        // $overlay_img_path = $product_info['thumbnail'];
        
        // create new Intervention Image
        $mockup_img = Image::make($mockup_img_path);
        // $overlay_img = Image::make($overlay_img_path);

        // $overlay_img->resize(null, 999, function ($constraint) {
        //     $constraint->aspectRatio();
        // });

        // $overlay_img->rotate(0);
        // $mockup_img->insert($overlay_img, 'top-left', 410, 357);
        
        $mercadolibre_preview_path = public_path( 'product/preview-images/'. $product_info['key'] .'/');
        $filename = 'preview_4_'.rand(111111,999999).'.jpg';
        $preview_path = $mercadolibre_preview_path.$filename;
        @mkdir($mercadolibre_preview_path, 0777, true);
        $mockup_img->save( $preview_path );
        $url_path = asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename);

        // echo '<img src="'.asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename ).'">';
        // exit;

        return $url_path;
    }

    function generateMock31($product_info){
        $mockup_img_path = public_path('mockups/mockup_31.jpg');
        $overlay_img_path = $product_info['thumbnail'];
        
        $mockup_img = Image::make($mockup_img_path);
        $overlay_img = Image::make($overlay_img_path);
        $overlay_2_img = Image::make($overlay_img_path);
        
        $overlay_img->resize(325, null, function ($constraint) {
            $constraint->aspectRatio();
        });
        
        $overlay_2_img->resize(null, 169, function ($constraint) {
            $constraint->aspectRatio();
        });

        $overlay_img->rotate(4);

        $mockup_img->insert($overlay_img, 'top-left', 22, 40);
        $mockup_img->insert($overlay_2_img, 'top-left', 420, 155);

        $filename = 'preview_0_'.rand(111111,999999).'.jpg';
        $mercadolibre_preview_path = public_path( 'product/preview-images/'. $product_info['key'] .'/');
        $preview_path = $mercadolibre_preview_path.$filename;
        @mkdir($mercadolibre_preview_path, 0777, true);
        $mockup_img->save( $preview_path );
        $url_path = asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename);

        echo '<img src="'.asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename ).'">';

        return $url_path;
    }

    function manageKeywords(Request $request){
        $db_word = DB::table('keywords')
                        ->where('language_code','=','en')
                        ->whereRaw('`is_reviewed` = false')
                        ->orderBy('counter','desc')
                        ->first();
        
        if( isset($request->_token) ){
            // print_r($request->all());
            // exit;
            $is_valid_for_title = 0;
            $is_tag = 0;

            if($request->is_valid_for_title == "on"){
                $is_valid_for_title = 1;
            }
            
            if($request->is_tag == "on"){
                $is_tag = 1;
            }
            
            DB::table('keywords')
            ->where('id','=',$request->id)
            ->update([
                'is_valid_for_title' => $is_valid_for_title,
                'is_tag' => $is_tag,
                'is_reviewed' => 1
            ]);
            
            return redirect()->action(
                [AdminController::class,'manageKeywords'], []
            );
        }

        if( isset($db_word->id) ){
            // print_r($db_word);
            
            return view('admin.keywords.manage_keywords', [
                'word' => $db_word
            ]);
        }
    }

    function editProductName(Request $request){
        $language_code = 'en';
        $template = DB::table('templates')
            ->join('tmp_etsy_metadata', 'tmp_etsy_metadata.id', '=', 'templates.fk_etsy_template_id')
            ->join('thumbnails', 'thumbnails.template_id', '=', 'templates.template_id')
            ->where('thumbnails.language_code','=',$language_code)
            ->where('templates.status','=',5)
            // ->whereNull('templates.name')
            ->whereNotNull('templates.fk_etsy_template_id')
            ->select(
                'templates.id',
                // 'templates.name',
                // 'templates.slug',
                'templates.template_id',
                'templates.width',
                'templates.height',
                'templates.metrics',
                'tmp_etsy_metadata.title',
                'tmp_etsy_metadata.username',
                'thumbnails.filename',
                'thumbnails.title as title_',
                'thumbnails.dimentions'
            )
            ->first();

        $title = $template->title.' '.$template->title_;
        $tmp_title = "";
        $slug = "";
        preg_match_all('/([a-zA-Z])+/', $title, $final_title);

        if( isset($final_title[0]) ){
            $words = $final_title[0];
            foreach ($words as $word) {
                
                $word = trim( strtolower($word) );
                
                $db_word = DB::table('keywords')
                    ->where('word','=',$word)
                    // ->where('language_code','=','en')
                    // ->where('is_valid_for_title','=','1')
                    // ->where('is_reviewed','=','1')
                    ->first();
                
                if( ( isset($db_word->is_reviewed) 
                    && $db_word->is_reviewed == 1
                    && $db_word->is_valid_for_title == 1)
                    || ( isset($db_word->is_reviewed) 
                    && $db_word->is_reviewed == 0)
                ){
                    $tmp_title = $tmp_title.' '.ucwords($db_word->word);
                    $slug = $slug.'-'.$db_word->word;
                }
    
            }
        }

        $thumbnail = asset( 'design/template/'. $template->template_id.'/thumbnails/'.$language_code.'/'.$template->filename);
        
        if( isset($request->id) ){
            // echo "<pre>";
            // print_r($request->all());
            // exit;
            
            DB::table('templates')
            ->where('id', '=', $request->id)
            ->update([
                'name' => trim($request->name),
                'slug' => trim($request->slug)
            ]);
            
            return redirect()->action(
                [AdminController::class,'editProductName'], []
            );
        }

        if( isset($request->id) ){

        }
        return view('admin.content.metadata', [
            'language_code' => $language_code,
            'thumbnail' => $thumbnail,
            'template' => $template,
            'title' => trim($tmp_title),
            'slug' => trim($slug)
        ]);
            // print_r($db_word);
    }

    function saveMultipleKeywords(Request $request){
        if( isset( $request->img_ids ) 
            && isset( $request->keywords )
        ){
            echo "<pre>";
            print_r( $request->all() );
            exit;

            foreach ($request->keywords as $keyword) {
                $db_keyword = DB::table('keywords')
                    ->select('id')
                    ->where('word', '=', trim(strtolower($keyword)) )
                    ->first();

                if( isset($db_keyword->id) == false ){
                    $keyword_id = DB::table('keywords')->insertGetId([
                        'id' => null,
                        'word' => trim(strtolower($keyword)),
                        'language_code' => 'en',
                    ]);
                } else {
                    $keyword_id = $db_keyword->id;
                }

                $db_image_has_keyword = DB::table('image_keywords')
                    ->select('id')
                    ->where('image_id', '=', $request->img_id)
                    ->where('keyword_id', '=', $keyword_id)
                    ->first();
                
                if( isset($db_image_has_keyword->id) == false ){
                    DB::table('image_keywords')->insert([
                        'id' => null,
                        'image_id' => $request->img_id,
                        'keyword_id' => $keyword_id,
                    ]);
                }
            }

            DB::table('images')
			->where('id','=', $request->img_id)
            ->update([
                'title' => $request->title,
                'status' => 2
            ]);

            echo 0;
        }
    }

    function sortArrayDescending($array) {
        arsort($array);
        return $array;
    }

    function analyticsCategories(Request $request){
        $country = 'us';
        $language_code = self::getCountryLanguage($country);
        
        // $redis_key = 'wayak:'.$country.':config:sales';
        $redis_key = 'wayak:'.$country.':analytics:categories';
        $categories = Redis::hgetall($redis_key);
        
        $sortedArray = self::sortArrayDescending($categories);
        
        print_r( "<pre>" );
        $ranked_categories = [];
        foreach ($sortedArray as $key => $value) {
            
            $cat_metadata = json_decode(Redis::get('wayak:en:categories:'.$key));
            $ranked_categories['categories'][] = [
                'name' => $cat_metadata->name,
                'url' => url($country."/templates/".$key),
                'hits' => $value
            ];
        }

        Redis::set( 'wayak:en:categories:top', json_encode($ranked_categories) );
    
        print_r($sortedArray);
        print_r($categories);
        print_r($ranked_categories);
        exit;

    }
   
    function analyticsTemplates(Request $request) {
        $country = 'us';
        $language_code = self::getCountryLanguage($country);
        
        $redis_key = 'analytics:template:views';
        $categories = Redis::hgetall($redis_key);
        
        $sortedArray = self::sortArrayDescending($categories);
        
        $template_ids = array('gmnftcCJWK','yrysql8YyT','OFyIDlIvkG','aTtcHnvaBr','tsQbtkgxLr','cDk6PoOeo8','4S37KjHURz','aztfeXdCEt','4Ai3Ak2JVf','uoRsAPqteB','3C3J5ujdjf','uR70SeIPYB','XQS65WJjap','BBdK85daDU','gfCq5C9Gyx','J9Fb7PlM3x','MtcWrJRC4D','1zTtpb9DsY','CN0otBDwk8','4thbJHAgi7','PA4SzDDJNx','YRFIR0baDi','1hHGmielw4');
        
        $search_result = Template::whereIn('_id', $template_ids)
            // ->take($total_items_per_carousel)
            ->get([
                'title',
                'slug',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'previewImageUrls'
            ]);
        
        $templates = array();
        foreach ($search_result as $template) {
            
            if( App::environment() == 'local' ){
                $template->preview_image_url = asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls['product_preview'] );
            } else {
                $template->preview_image_url = Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls['product_preview'] );
            }
            $templates[] = $template;
        }

        // print_r( "<pre>" );
        // $ranked_categories = [];
        // foreach ($sortedArray as $key => $value) {
        //     $cat_metadata = json_decode(Redis::get('wayak:en:categories:'.$key));
        //     $ranked_categories['categories'][] = [
        //         'name' => $cat_metadata->name,
        //         'url' => url($country."/templates/".$key),
        //         'hits' => $value
        //     ];
        // }
    
        echo "<pre>";
        // print_r(array_keys($sortedArray));
        // print_r($sortedArray);
        print_r($templates);
        // print_r($categories);
        // print_r($ranked_categories);
        exit;

    }

    function getCarouselItemsPreview(Request $request){
        $language_code = 'en';
        $search_result = Template::whereIn('_id', explode(",",str_replace(' ','',$request->ids)) )
                            ->get([
                                'title',
                                'prices',
                                'slug',
                                'in_sale',
                                'studioName',
                                'previewImageUrls'
                            ]);

        foreach ($search_result as $template) {
            if( App::environment() == 'local' ){
                $template->preview_image = asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["carousel"] );
            } else {
                $template->preview_image = Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["carousel"] );
            }
            $templates[] = $template;
        }

        // print_r( $request->ids );
        // print_r( "<br>" );
        print_r( json_encode($templates) );
    }

    function carouselItemsCreate(){
        $country = 'us';
        $language_code = 'en';
        
        $json_request = '{
            "idQueue":[
               "u4CyigMzGe",
               "j7TmTKLpx8",
               "Gex24O3Ser",
               "BObLhn7pRe",
               "fOBBmZ2YeQ",
               "FTjYUsQxKr",
               "NDqdF6wBT7",
               "Eo3BmSfnS9",
               "FOKYdu6hjY",
               "DUuSaSCQqR",
               "GFLOdtafFt",
               "YntHIu2NOJ",
               "QchpgDZVEQ",
               "9ms0IqL2hZ",
               "RpUeUNHgrt",
               "LpZrKzaJxl",
               "VVsEOKd396",
               "x3B3mJhSa2",
               "9dydZQozYU",
               "eRiXOTqsZc",
               "oOmZB1xKp7",
               "GGr4KWS22K",
               "EsY4bSMEV5",
               "Tkv6BpMfYm",
               "0qTaQ8HgR5",
               "hEZmfouklj",
               "SU6rcVWXem",
               "9syiwP3tty",
               "aTtcHnvaBr",
               "CI5j1h1hoB",
               "l2Lo1tB3V6",
               "DGTcbWLq33",
               "3PctckCySG",
               "voReKAnIwj",
               "PbNeybdIhQ",
               "4CvASVoCGS",
               "k2bGXfjGl4",
               "GjAxrc9jnx",
               "3ua2sK6ntc",
               "E74WGP4p8R",
               "JCYKhD9lvM",
               "gmnftcCJWK",
               "tQphXryIyq",
               "VDWfZcNz7b",
               "aztfeXdCEt"
            ],
            "carouselTitle":"mensaje",
            "searchQuery":"cow"
         }';

        $json_carousel_info = json_decode($json_request);
        $search_result = Template::whereIn('_id', $json_carousel_info->idQueue )
                            ->get([
                                'title',
                                'slug',
                                'previewImageUrls',
                                'width',
                                'height',
                                'forSubscribers',
                                'previewImageUrls'
                            ]);

        foreach ($search_result as $tmp_item) {
            if( App::environment() == 'local' ){
                $tmp_item->preview_image_url = asset( 'design/template/'.$tmp_item->_id.'/thumbnails/'.$language_code.'/'.$tmp_item->previewImageUrls['product_preview'] );
            } else {
                $tmp_item->preview_image_url = Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$tmp_item->previewImageUrls['product_preview'] );
            }
            $carousel_items[] = $tmp_item;
        }
        
        $carousels = json_decode( Redis::get('wayak:'.$country.':home:carousels') );
        $carousels[] = [
            'slider_id' => Str::random(5),
            'title' => $json_carousel_info->carouselTitle,
            'search_term' => $json_carousel_info->searchQuery,
            'items' => $carousel_items
        ];

        $carousels = json_encode($carousels);

        Redis::set('wayak:'.$country.':home:carousels', $carousels);
        
        // echo "<pre>";
        // print_r( $carousels );
        print_r( $carousels );
        // exit;

    }

    public function carouselsSelectItems($country, Request $request){
        // echo "<pre>";
        // print_r( json_decode( Redis::get('wayak:us:home:carousels') ) );
        // print_r( $request->all() );
        // exit;
        
        $language_code = 'en';
        $carousel_title = null;
        $search_query = '';
        
        $page = 1;
        $per_page = 100;
        $skip = 0;
        
        if( isset($request->carouselTitle) && isset($request->searchQuery) ) {
            $carousel_title = $request->carouselTitle;
            $search_query = $request->searchQuery;
        } else {
            abort(404);
        }

        if( isset($request->page) ) {
            $page = $request->page;
            $skip = $per_page*($page-1);
        }
                
        // $search_query = str_replace(' ','%',$search_query);
        $search_result = Template::whereRaw(array('$text'=>array('$search'=> $search_query)))
        // $search_result = Template::where('title', 'like', '%'.$search_query.'%')
            ->skip($skip)
            ->take($per_page)
            ->get([
                'title',
                'prices',
                'slug',
                'in_sale',
                'studioName',
                'previewImageUrls'
            ]);
        
        $total_documents = Template::whereRaw(array('$text'=>array('$search'=> $search_query)))
                                    ->count();
        $from_document = $skip + 1;
        $to_document = $skip + $per_page;
        $last_page = ceil( $total_documents / $per_page );
        
        // echo "<br>";
        // print_r( $request->carouselTitle );
        // echo "<br>";
        // print_r( $search_query );
        // echo "<br>";
        // print_r( $total_documents );
        // echo "<br>";
        // print_r( $from_document );
        // echo "<br>";
        // print_r( $to_document );
        // exit;

        $templates = [];
        foreach ($search_result as $template) {
            if( App::environment() == 'local' ){
                $template->preview_image = asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["carousel"] );
            } else {
                $template->preview_image = Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls["carousel"] );
            }
            $templates[] = $template;
        }

        $full_search_results = Template::whereRaw(['$text' => ['$search' => $search_query]])->get([
            'id'
        ]);

        // Number of items to select randomly
        $numberOfItemsToSelect = 30;

        // Select 'n' items randomly and get the _id values
        $default_template_ids = self::selectRandomIdsFromArray($full_search_results, $numberOfItemsToSelect);

        
        // echo "<pre>";
        // print_r($default_template_ids);
        // // print_r($full_search_results);
        // // print_r( $templates );
        // exit;

        $sale = Redis::hgetall('wayak:'.$country.':config:sales');
        
        return view('admin.carousel_items',[
            'country' => $country,
            'language_code' => $language_code,
            'carousel_title' => $carousel_title,
            'sale' => $sale,
            'search_query' => $search_query,
            'current_page' => $page,
            'first_page' => 1,
            'pagination_begin' => (($page - 4) > 0) ? $page-4 : 1,
            'pagination_end' => (($page + 4) < $last_page) ? $page+4 : $last_page,
            'last_page' => $last_page,
            'from_document' => $from_document,
            'to_document' => $to_document,
            'total_documents' => $total_documents,
            'templates' => $templates,
            'default_template_ids' => json_encode($default_template_ids)
        ]);
    }

    function selectRandomIdsFromArray($inputArray, $n): array {
        // Convert the Collection to a regular PHP array
        $regularArray = $inputArray->toArray();
    
        // Check if the number of items to select is greater than the array size
        if ($n >= count($regularArray)) {
            return array_column($regularArray, '_id');
        }
    
        // Randomly select 'n' keys from the array
        $randomKeys = array_rand($regularArray, $n);
    
        // If 'n' is 1, array_rand returns just a single key, so we need to convert it into an array
        if (!is_array($randomKeys)) {
            $randomKeys = [$randomKeys];
        }
    
        // Retrieve the _id values using the selected keys
        $randomIds = [];
        foreach ($randomKeys as $key) {
            $randomIds[] = $regularArray[$key]['_id'];
        }
    
        return $randomIds;
    }
    
    
    public function carouselsSetName($country, Request $request){
        
        $language_code = 'en';
        $search_query = '';
        $category = '';
        
        if( isset($request->searchQuery) ) {
            $search_query = $request->searchQuery;
        // } else {
        //     abort(404);
        }
        
        $menu = json_decode(Redis::get('wayak:'.$country.':menu'));
        $sale = Redis::hgetall('wayak:'.$country.':config:sales');
        $current_title = '';

        return view('admin.carousel_name',[
            'country' => $country,
            'language_code' => $language_code,
            'menu' => $menu,
            'current_title' => $current_title,
            'search_query' => $search_query
        ]);
    }
    
    public function updateHomeCarousel($country, Request $request){
        $carousels = json_encode( $request->all() );
        Redis::set('wayak:'.$country.':home:carousels', $carousels);
        // print_r( json_encode($request->all()) );
        print_r( 'wayak:'.$country.':home:carousels' );
    }

    public function carouselsManage($country, Request $request){
        
        $language_code = 'en';
        $carousels = Redis::get('wayak:'.$country.':home:carousels');

        return view('admin.carousel_manage',[
            'country' => $country,
            'language_code' => $language_code,
            'carousels' => $carousels
        ]);
    }

    function deleteItem(Request $request) {
        return response()->json([]);
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


