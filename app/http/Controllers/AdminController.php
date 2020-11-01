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


class AdminController extends Controller
{
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

		return view('generate_code', [
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

        return view('admin_templates', [
            'templates' => $templates
        ]);
    }
    
    function createProduct($template_key){
        
        $thumb_info = DB::table('thumbnails')
                ->where('template_id','=',$template_key)
                ->first();

        $thumb_img_url = asset( 'design/template/'. $template_key.'/thumbnails/'.$thumb_info->filename);
        return view('admin_create_prod', [
            'thumb_img_url' => $thumb_img_url
        ]);
    }

    function createDBProduct(Request $request){
        echo "<pre>";
        print_r( $request->all() );
    }
}
