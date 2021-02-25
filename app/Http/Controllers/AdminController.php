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
            
            $parsed_slug = str_replace('-',' ',substr($row->product_link_href, strripos($row->product_link_href, '/')+1, strlen($row->product_link_href)));
            $original_title = $row->thumb_title.' '.$row->title.' '.$row->product_title.' '.$parsed_slug;
            
            $tmp_title = [];
            preg_match_all('/([a-zA-Z])+/', $original_title, $final_title);
            
            if( isset($final_title[0]) ){
                $words = $final_title[0];
                
                // print_r($final_title[0]);
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
                
                // print_r($tmp_title[0]);
                // exit;

                $unique_keywords_title = array_unique($tmp_title);
                $final_title = implode(' ',$unique_keywords_title);

                
                $ready_for_slug = DB::select( DB::raw(
                    'SELECT * FROM `wayak`.`keywords` 
                    WHERE 
                    word IN('."'".implode( '\',\'',$words)."'".')
                    AND language_code = \'en\'
                    AND (
                        ( is_reviewed = 1 AND is_tag = 1 ) OR is_reviewed = 0)
                        ORDER BY counter DESC
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
                print_r( strlen($final_title).'>> ' );
                print_r( $final_title );
                print_r( "<br>" );
                print_r( strlen($final_slug).'>> ' );
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

    function createCode($country, $template_key){
        // echo $country;
        // exit;
        if( $country == 'mx' ){
            $language_code = 'es';
        } else {
            $language_code = 'en';
        }
        
        // Create a template replica, for final user.
        
        // echo "<pre>";
        // print_r($template_key);
        // print_r($template_temp_key);
        
        $purchase_code = rand(1111, 9999);

        $original_template_key = $template_key;
        $temporal_customer_key = 'temp:'.$purchase_code;
        
        Redis::set('temp:template:relation:temp:'.$purchase_code, $original_template_key);
        Redis::expire('temp:template:relation:temp:'.$purchase_code, 2592000); // Codigo valido por 30 dias - 60*60*24*30 = 2592000
        
        Redis::set('template:'.$language_code.':'.$temporal_customer_key.':jsondata' ,Redis::get('template:'.$language_code.':'.$original_template_key.':jsondata'));
        Redis::expire('template:'.$temporal_customer_key.':jsondata', 2592000); // Codigo valido por 30 dias - 60*60*24*30 = 2592000
		
        Redis::set('code:'.$purchase_code, $temporal_customer_key);
        Redis::expire('code:'.$purchase_code, 2592000); // Codigo valido por 30 dias - 60*60*24*30 = 2592000

		// return str_replace('http://localhost/design/','http://localhost:8000/design/', Redis::get($template_key) );
        // exit;
        // return view('generate_code');
        // Redis::keys()

        // return back()->with('success', 'Nuevo codigo generado con exito');
        return redirect()->action(
            [AdminController::class,'manageCodes'], [
                'country' => $country
            ]
        );
    }
    
    function manageCodes($country){

        // $codes = Redis::keys('*crello*');
        // $templates_to_delete = Redis::keys('*crello*');
        // foreach ($templates_to_delete as $template_key) {
            //     Redis::del( $template_key );
            // }
            
            // echo "<pre>";
            // print_r($templates_to_delete);
            // exit;
            
            
        $codes = Redis::keys('code:*');
        $ejemplo = [];
        $size_of_code = sizeof($codes);
        
        for ($i=0; $i < $size_of_code; $i++) { 
            $ejemplo[ $i ]['code'] = str_replace('code:', null ,$codes[$i]);
            $ejemplo[ $i ]['value'] = Redis::get( $codes[$i] );
            
            $template_key = Redis::get('temp:template:relation:temp:'.$ejemplo[ $i ]['code']);
            $template_key = str_replace('template:',null, $template_key);
            $template_key = str_replace(':jsondata',null, $template_key);
            
            // echo $template_key;
            // exit;
            // $purchase_code
            
            $thumb_info = DB::table('thumbnails')
                    ->where('template_id','=', $template_key )
                    ->first();

            // echo "<pre>";
            // print_r($template_key);
            // print_r($thumb_info);
            // exit;

            if($thumb_info){
                $thumb_img_url = asset( 'design/template/'. $template_key.'/thumbnails/'.$thumb_info->filename);
            } else {
                $thumb_img_url = null;
            }
            
            $ejemplo[ $i ]['template_img'] = $thumb_img_url;
        }

        // echo "<pre>";
        // print_r($ejemplo);
        // exit;

		return view('admin.generate_code', [
            'country' => $country,
            'codes' => $ejemplo
        ]);
    }
    
    function deleteCode($country, $code){
        
        Redis::del('code:'.$code);
        
        return redirect()->action(
            [AdminController::class,'manageCodes'], ['country' => $country]
        );
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
                    ->select('templates.template_id','format_ready','translation_ready','thumbnail_ready', 'filename','thumbnails.title', 'thumbnails.dimentions')
                    // ->where('template_id','=', $template_key )
                    ->where('thumbnails.language_code','=', $language_code )
                    // ->where('thumbnails.dimentions','=', '5 x 7 in' )
                    ->where('templates.status','=', 5 )
                    ->where('templates.format_ready','1')
                    ->where('templates.translation_ready','1')
                    ->where('templates.thumbnail_ready','1')
                    ->count();
                    
        $total_pages = ceil( $total_templates/$per_page );

        $translation_ready_templates = DB::table('templates')
                    ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
                    ->select('templates.template_id','format_ready','translation_ready','thumbnail_ready', 'filename','thumbnails.title', 'thumbnails.dimentions')
                    // ->where('template_id','=', $template_key )
                    ->where('thumbnails.language_code','=', $language_code )
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
            'language_code' => $language_code,
            'country' => $country
        ]);
    }
    
    function createProduct($template_key){
        $product_metadata = new \stdClass();
        if (Redis::exists('template:'.$template_key.':metadata')) {
            $product_metadata = Redis::get('template:'.$template_key.':metadata');
            $product_metadata = json_decode($product_metadata);
    
            // echo "<pre>";
            // print_r($product_metadata);
            // exit;
        }

        $product_metadata->title = (isset($product_metadata->title) && $product_metadata->title != '') ? $product_metadata->title : 'Invitation for | Birthday | 5x7';
        $product_metadata->description = (isset($product_metadata->description) && $product_metadata->description != '') ? $product_metadata->description : Redis::get('wayak:etsy:description_template') ;
        $product_metadata->tags = (isset($product_metadata->tags) && $product_metadata->tags != '') ? $product_metadata->tags : 'invitation,party,birthday';
        
        $thumb_info = DB::table('thumbnails')
                ->where('template_id','=',$template_key)
                ->first();

        $thumb_img_url = asset( 'design/template/'. $template_key.'/thumbnails/'.$thumb_info->filename);

        return view('admin.create_prod', [
            'template_key' => $template_key,
            'thumb_img_url' => $thumb_img_url,
            'metadata' => $product_metadata
        ]);
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
        // echo 'template:'.$template_key.':metadata';
        // exit;
        if( Redis::exists('template:'.$template_key.':metadata') ){
            $product_metadata = Redis::get('template:'.$template_key.':metadata');
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
        
        Redis::set('template:'.$template_key.':metadata', json_encode( $template_info ) );
        
        return redirect()->route('admin.ml.getMissingMetadataTemplates');
    }

    function adminHome(){
        return view('admin.home', [
        ]);
    }

    function createDBProduct($template_key, Request $request){
        // echo "<pre>";
        // print_r( $template_key );
        // exit;

        $template_info = $request->all();
        // echo "<pre>";
        // print_r( $template_info );
        // exit;

        $template_info['descripcion'] = str_replace('{{templateDemoUrl}}', url('mx/demo/'.$template_info['modelo'] ), $template_info['descripcion']);
        $template_info['descripcion'] = str_replace('{{wayakCatalogUrl}}', url('mx/plantillas' ), $template_info['descripcion']);
        $template_info['descripcion'] = str_replace('{{estyStoreName}}', 'jazmin.studio / wayak.app', $template_info['descripcion']);
        $template_info['descripcion'] = str_replace('{{template_id}}', $template_info['modelo'], $template_info['descripcion']);
        $template_info['descripcion'] = str_replace('https://www.mercadolibre.com.mx/perfil/DANIELGTM', 'https://www.mercadolibre.com.mx/perfil/JAZMIN.STUDIO', $template_info['descripcion']);

        Redis::set('template:'.$template_key.':metadata', json_encode( $template_info ));
        
        DB::table('templates')
				    ->where('template_id','=',$template_key)
				    ->update([
                        'metadata_ready' => 1
                    ]);
        
        return redirect()->route('admin.ml.getMissingMetadataTemplates');

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
                    ->select('templates.template_id','format_ready','translation_ready','thumbnail_ready', 'filename')
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
                    ->select('templates.template_id','format_ready','translation_ready','thumbnail_ready', 'filename')
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
    //         $template_info['metadata_ready'] = Redis::exists('template:'.$template_key.':metadata');
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
                    ->select('templates.template_id','format_ready','translation_ready','thumbnail_ready', 'filename')
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
                    ->select('templates.template_id','format_ready','translation_ready','thumbnail_ready', 'filename')
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
                    ->select('templates.template_id','format_ready','translation_ready','thumbnail_ready', 'filename')
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
                    ->select('templates.template_id','format_ready','translation_ready','thumbnail_ready', 'filename')
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
            ->select('templates.template_id','format_ready','translation_ready','thumbnail_ready', 'filename')
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
            ->select('templates.template_id','format_ready','translation_ready','thumbnail_ready', 'filename')
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
        $destination_lang = 'es';
        $current_page = 1;
        if( isset($request->page) ) {
            $current_page = $request->page;
        }

        $page = $current_page-1;
        $per_page = 2;
        $offset = $page*$per_page;

        $total_templates = DB::table('templates')
            ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
            ->select('templates.template_id','format_ready','translation_ready','thumbnail_ready', 'filename')
            // ->where('template_id','=', $template_key )
            ->where('thumbnails.language_code','=', $destination_lang )
            // ->where('thumbnails.dimentions','=', '5 x 7 in' )
            ->where('templates.status','=', 5 )
            ->where('templates.format_ready','1')
            ->where('templates.translation_ready','1')
            ->where('templates.thumbnail_ready','1')
            ->count();

        $total_pages = ceil( $total_templates/$per_page );
        
        $metadata_ready_templates = DB::table('templates')
            ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
            ->select('templates.template_id','format_ready','translation_ready','thumbnail_ready','metadata_ready', 'filename')
            // ->where('template_id','=', $template_key )
            ->where('thumbnails.language_code','=', $destination_lang )
            // ->where('thumbnails.dimentions','=', '5 x 7 in' )
            ->where('templates.status','=', 5 )
            ->where('templates.format_ready','1')
            ->where('templates.translation_ready','1')
            ->where('templates.thumbnail_ready','1')
            ->where('templates.metadata_ready','0')
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
            $template_info['metadata_ready'] = Redis::exists('template:'.$template_key.':metadata');
            
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
                    ->select('templates.template_id','format_ready','translation_ready','thumbnail_ready', 'filename')
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
            $template_key = $template->template_id;
            $source_template_key = 'template:'.$origin_lang.':'.$template_key.':jsondata';
            
            $source_template_exists = Redis::exists( $source_template_key );
            $template_format_ready = $template->format_ready;
            $template_translation_ready = $template->translation_ready;
            
            
            if( $source_template_exists
                && $template_format_ready 
                && $template_translation_ready == false 
                ){
                $template_text .= self::getTemplateHTMLText($source_template_key);
            }
        }

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
        // print_r( $template_obj );
        // exit;GET 

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
        
        $destination_lang = 'es';
        $limit = 10;
        $thumb_missing_product_preview = DB::table('templates')
            ->join('thumbnails', 'templates.template_id', '=', 'thumbnails.template_id')
            ->select('templates.template_id','format_ready','translation_ready','thumbnail_ready', 'filename')
            // ->where('template_id','=', $template_key )
            ->where('thumbnails.language_code','=', $destination_lang )
            // ->where('thumbnails.dimentions','=', '5 x 7 in' )
            ->where('templates.status','=', 5 )
            ->where('templates.format_ready','1')
            ->where('templates.translation_ready','1')
            ->where('templates.thumbnail_ready','1')
            ->limit($limit)
            ->orderBy('templates.id', 'asc')
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
            
            array_push($preview_images, self::processMockup($template_info,31) );
            array_push($preview_images, self::processMockup($template_info,10) );
            array_push($preview_images, self::processMockup($template_info,6) );
            array_push($preview_images, self::processMockup($template_info,2) );
            // array_push($preview_images, self::processMockup($template_info,18) );
            
            // echo "<pre>";
            // print_r($preview_images);
            // exit;

            DB::table('templates')
					->where('template_id','=', $template_key)
					->update([
						'preview_ready' => true
                    ]);

            Redis::set('product:preview_images:'.$template_info['key'], json_encode($preview_images));

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
        $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        
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

        $overlay_img->resize(null, 999, function ($constraint) {
            $constraint->aspectRatio();
        });

        $overlay_img->rotate(0);
        $mockup_img->insert($overlay_img, 'top-left', 410, 357);

        $mockup_img->resize(null, 547, function ($constraint) {
            $constraint->aspectRatio();
        });
        
        $mercadolibre_preview_path = public_path( 'product/preview-images/'. $product_info['key'] .'/');
        $filename = 'preview_3_'.rand(111111,999999).'.jpg';
        $preview_path = $mercadolibre_preview_path.$filename;
        @mkdir($mercadolibre_preview_path, 0777, true);
        $mockup_img->save( $preview_path );

        $url_path = asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename);

        // echo '<img src="'.asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename ).'">';
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

        $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        
        return asset('mockups/final_thumbs.jpg');
    }
    
    function generateMock6($product_info){
        $mockup_img_path = public_path('mockups/mockup_6.jpg');
        $overlay_img_path = $product_info['thumbnail'];
        
        $mockup_img = Image::make($mockup_img_path);
        $overlay_img = Image::make($overlay_img_path);
        $overlay_2_img = Image::make($overlay_img_path);

        $overlay_img->resize(null, 999, function ($constraint) {
            $constraint->aspectRatio();
        });

        $overlay_2_img->resize(null, 518, function ($constraint) {
            $constraint->aspectRatio();
        });

        $mockup_img->insert($overlay_img, 'top-left', 122, 283);
        $mockup_img->insert($overlay_2_img, 'top-left', 985, 520);

        $mockup_img->resize(null, 547, function ($constraint) {
            $constraint->aspectRatio();
        });

        $filename = 'preview_2_'.rand(111111,999999).'.jpg';
        $mercadolibre_preview_path = public_path( 'product/preview-images/'. $product_info['key'] .'/');
        $preview_path = $mercadolibre_preview_path.$filename;
        $url_path = asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename);
        @mkdir($mercadolibre_preview_path, 0777, true);
        $mockup_img->save( $preview_path );

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
        
        $overlay_img->resize(null, 1080, function ($constraint) {
            $constraint->aspectRatio();
        });

        $mockup_img->insert($overlay_img, 'top-left', 349, 303);

        $mockup_img->resize(null, 547, function ($constraint) {
            $constraint->aspectRatio();
        });

        $filename = 'preview_1_'.rand(111111,999999).'.jpg';
        $mercadolibre_preview_path = public_path( 'product/preview-images/'. $product_info['key'] .'/');
        $preview_path = $mercadolibre_preview_path.$filename;
        @mkdir($mercadolibre_preview_path, 0777, true);
        $mockup_img->save( $preview_path );
        $url_path = asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename);

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

        $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        
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

        $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        
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

        $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        
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
        $mockup_img->save( public_path('mockups/final_thumbs.jpg') );
        
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
        $mockup_img->insert($overlay_2_img, 'top-left', 417, 155);

        $filename = 'preview_0_'.rand(111111,999999).'.jpg';
        $mercadolibre_preview_path = public_path( 'product/preview-images/'. $product_info['key'] .'/');
        $preview_path = $mercadolibre_preview_path.$filename;
        @mkdir($mercadolibre_preview_path, 0777, true);
        $mockup_img->save( $preview_path );
        $url_path = asset( 'product/preview-images/'. $product_info['key'] .'/'.$filename);

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
            ->whereNull('templates.name')
            ->whereNotNull('templates.fk_etsy_template_id')
            ->select(
                'templates.id',
                'templates.name',
                'templates.slug',
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
}
