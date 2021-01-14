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

ini_set('memory_limit', -1);
ini_set("max_execution_time", 0);   // no time-outs!
ignore_user_abort(true);            // Continue downloading even after user closes the browser.

error_reporting(E_ALL);
ini_set('display_errors', 1);


class AdminController extends Controller
{
    function registerMissingTemplatesOnDB(){
        $template_keys = Redis::keys('template:*:jsondata');
        foreach ($template_keys as $template_key) {
            $template_key = str_replace('template:', null, $template_key);
            $template_key = str_replace(':jsondata', null, $template_key);

            $thumbnail_rows = DB::table('thumbnails')
                ->where('template_id','=',$template_key)
                ->count();

            if( $thumbnail_rows == 0 ){

                $path = public_path().'/design/template/' . $template_key.'/thumbnails/';
                $preview_path = public_path().'/design/template/' . $template_key.'/assets/';
                File::makeDirectory($path, $mode = 0777, true, true);
    
                if (file_exists( $preview_path . 'preview.jpg')) {
                    File::move($preview_path. 'preview.jpg', $path. 'preview.jpg');    
                }
                
                if( Redis::exists('crello:template:'.$template_key) ){
                    // echo "<pre>";
                    // print_r( json_decode( Redis::get('crello:template:'.$template_key) ) );
                    $template_obj = json_decode( Redis::get('crello:template:'.$template_key) );
                    
                    DB::table('thumbnails')->insert([
                        'id' => null,
                        'template_id' => $template_key,
                        'title' => htmlspecialchars_decode( $template_obj->title ),
                        'filename' => 'preview.jpg',
                        'tmp_original_url' => null,
                        'dimentions' => '4x7 in',
                        'tmp_templates' => $template_key,
                        'status' => 1
                    ]);

                }
                // exit;
            } else {
                // $thumbnail_info = DB::table('thumbnails')
                //     ->where('template_id','=',$template_key)
                //     ->first();
                // echo "<pre>";
                // print_r( $thumbnail_info );
                // exit;
            }

            // print_r($path);
            // // print_r($template_key);
            // exit;
            // print_r($thumb_info);
            // exit;
        }

        echo sizeof( Redis::keys('template:*:jsondata') );
    }

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

    // function generateCode($template_key){
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
}
