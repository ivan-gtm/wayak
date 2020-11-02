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

    function generateCode(){
        // echo "hihi";
        // return view('generate_code');
        // Redis::keys()

        $id = rand(1111, 9999);
        Redis::set('code:'.$id, 0);
        // exit;
        return back()->with('success', 'Nuevo codigo generado con exito');
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
        }

        // echo "<pre>";
        // print_r($ejemplo);
        // exit;

		return view('admin.generate_code', [
            'codes' => $ejemplo
        ]);
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

            $product_info['key'] = $template_key;
            $product_info['thumbnail'] = asset( 'design/template/'. $template_key.'/thumbnails/'.$thumb_info->filename);
            $product_info['title'] = $thumb_info->title;
            $product_info['dimentions'] = $thumb_info->dimentions;

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
}
