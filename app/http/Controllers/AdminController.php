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

use App\Exports\MercadoLibreExport;
use Maatwebsite\Excel\Facades\Excel;

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
    function createCode($template_key){
        
        // Create a template replica, for final user.
        
        // echo "<pre>";
        // print_r($template_key);
        // print_r($template_temp_key);
        
        $purchase_code = rand(1111, 9999);

        $original_template_key = $template_key;
        $temporal_customer_key = 'temp:'.$purchase_code;
        
        Redis::set('temp:template:relation:temp:'.$purchase_code, $original_template_key);
        Redis::expire('temp:template:relation:temp:'.$purchase_code, 2592000); // Codigo valido por 30 dias - 60*60*24*30 = 2592000
        
        Redis::set('template:'.$temporal_customer_key.':jsondata' ,Redis::get('template:'.$original_template_key.':jsondata'));
        Redis::expire('template:'.$temporal_customer_key.':jsondata', 2592000); // Codigo valido por 30 dias - 60*60*24*30 = 2592000
		
        Redis::set('code:'.$purchase_code, $temporal_customer_key);
        Redis::expire('code:'.$purchase_code, 2592000); // Codigo valido por 30 dias - 60*60*24*30 = 2592000

		// return str_replace('http://localhost/design/','http://localhost:8000/design/', Redis::get($template_key) );
        // exit;
        // return view('generate_code');
        // Redis::keys()

        // return back()->with('success', 'Nuevo codigo generado con exito');
        return redirect()->action(
            'AdminController@manageCodes', []
        );
    }
    
    function manageCodes(){
        $codes = Redis::keys('code:*');
        
        // echo "<pre>";
        // print_r($codes);
        // exit;
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
            'codes' => $ejemplo
        ]);
    }
    
    function deleteCode($code){
        // admin/delete/code/{code}
        Redis::del('code:'.$code);
        
        return redirect()->action(
            'AdminController@manageCodes', []
        );
    }

    function manageTemplates(){

        $tmp_template_keys = Redis::keys('product:production_ready:*');
        $templates = [];
        foreach ($tmp_template_keys as $template) {
            $template_key = str_replace('product:production_ready:',null, $template);
            
            $thumb_info = DB::table('thumbnails')
                ->where('template_id','=',$template_key)
                ->first();

            // print_r($thumb_info->filename);
            if($thumb_info == false){
                echo $template_key;
                exit;
            }

            $product_info['key'] = $template_key;
            $product_info['thumbnail'] = asset( 'design/template/'. $template_key.'/thumbnails/'.$thumb_info->filename);
            $product_info['title'] = $thumb_info->title;
            $product_info['dimentions'] = $thumb_info->dimentions;
            $product_info['mercadopago'] = Redis::get('wayak:mercadopago:template:modelo:'.$template_key);

            $templates[] = $product_info;
        }
        
        // echo "<pre>";
        // print_r($templates);
        // exit;

        return view('admin.templates', [
            'templates' => $templates
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
    
    function createMPProduct($template_key){
        $thumb_info = DB::table('thumbnails')
                ->where('template_id','=',$template_key)
                ->first();
       
        $thumb_img_url = asset( 'design/template/'. $template_key.'/thumbnails/'.$thumb_info->filename);
        $modelo_id = self::generarModeloMercadoPago($template_key);
        $description = Redis::get('wayak:mercadopago:description_template');
        $titulo = 'Invitacion Digital *CAMBIAR* Whats Face';
        $ocasion = '';

        // Redis::set('mercadopago:template:metadata:'.$template_key, json_encode($request->all()));
        if( Redis::exists('mercadopago:template:metadata:'.$template_key) ){
            $product_metadata = Redis::get('mercadopago:template:metadata:'.$template_key);
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
            'product_images' => $thumb_img_url,
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
        $template_info['descripcion'] = str_replace('{{wayakCatalogUrl}}', url('mx/explorar' ), $template_info['descripcion']);
        $template_info['descripcion'] = str_replace('{{estyStoreName}}', 'Estudio Jazmin', $template_info['descripcion']);
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
        
        Redis::set('mercadopago:template:metadata:'.$template_key, json_encode( $template_info ) );
        
        return redirect()->action(
            'AdminController@manageTemplates', []
        );
    }

    function createDBProduct($template_key, Request $request){
        // echo "<pre>";
        // print_r( $template_key );
        // exit;
        // print_r( $request->all() );
        // '_token' => $request->_token;
        // 'title' => $request->title;
        // 'tags' => $request->tags;
        // 'primaryColor' => $request->primaryColor;
        // 'secondaryColor' => $request->secondaryColor;
        // 'occasion' => $request->occasion;
        // 'holiday' => $request->holiday;
        // 'description' => $request->description;

        Redis::set('template:'.$template_key.':metadata', json_encode($request->all()));
        
        return redirect()->action(
            'AdminController@manageTemplates', []
        );

    }

    function descriptionTemplate(){
        $description = null;

        if( Redis::exists('wayak:etsy:description_template') ){
            // && Redis::get('wayak:etsy:description_template') =! ''
            $description = Redis::get('wayak:etsy:description_template'); 
        }
        return view('admin.etsy_description_template', [
            'description' => $description
        ]);
    }

    function editDescriptionTemplate(Request $request){
        // echo "<pre>";
        // print_r( $request->all() );
        
        Redis::set('wayak:etsy:description_template', $request->description);
        return redirect()->action(
            'AdminController@editDescriptionTemplate', []
        );
    }

    function mercadoLibreExcel(){
        return Excel::download(new MercadoLibreExport, 'mercado_libre.xlsx');
    }
}
