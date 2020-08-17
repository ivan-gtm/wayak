<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;

use SVG\SVG;
// use Image;

use SVG\Nodes\Shapes\SVGCircle;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Barryvdh\DomPDF\Facade as PDF;


class DesignerAppController extends Controller
{
	function getJSONTemplate($template_id){
		$template_key = 'template:'.$template_id.':jsondata';
		//  Redis::get($template_key);
		// return str_replace('http://localhost/design/','http://localhost:8000/design/', Redis::get($template_key) );
		return Redis::get($template_key);
	}

	function home(Request $request){
		$templates = $request['templates'];
		return view('home',[ 'templates' => $templates ]);
	}
	
	function index(Request $request){
		$template_urls = [];
		$templates = DB::table('d_templates')
					->select('id', 'template_id')
					->where('status','=',3)
					->orderBy('id','DESC')
					->limit(2)
					->get();
		
		// echo "<pre>";
		// print_r($templates);
		// exit;
 
        foreach ($templates as $template) {
			array_push($template_urls, 'http://localhost/open?templates='.$template->template_id );
		}

		// echo "<pre>";
		// print_r($template_urls);
		// exit;
		
    	return view('index',[ 'template_urls' => $template_urls ]);
	}

	function open(Request $request){
    	$templates = $request['templates'];
    	return view('home',[ 'templates' => $templates ]);
	}

	function convertPXtoIn($pixels){
		return round($pixels/96);
	}

	function randomNumber($length = 15) {
		// $length = 15;
		$result = '';
	
		for($i = 0; $i < $length; $i++) {
			$result .= mt_rand(0, 9);
		}
	
		return $result;
	}

	function update(Request $request){
		// echo "<pre>";
		// print_r( $request->all() );
		// exit;

		$template_obj = json_decode( $request->jsonData );
		$template_dimensions = $this->convertPXtoIn( $template_obj[1]->cwidth ).'x'.$this->convertPXtoIn($template_obj[1]->cheight).' in';
		$template_id = $request->templateid;
		$thumbnail_imgs = $this->createThumbnailFiles( $request->pngimageData, $template_id );
		
		$thumbnail_info = [
			'filename' => $thumbnail_imgs['thumbnail'],
			'template_id' => $template_id,
			'dimentions' => $template_dimensions,
			'status' => 1
		];
		$this->updateThumbnailsOnDB( $thumbnail_info );

		// echo "<pre>";
		// print_r( $template_id );
		// print_r( $thumbnail_info );
		// exit;

		$this->deleteCurrentThumbnails($template_info);
		$this->storeJSONTemplate($template_id, json_encode($template_obj));

		$response = [
			'id' => $template_id,
			'err' => 0,
			'msg' => 'Update exitoso'
		];

		return json_encode($response);

	}
	
	function saveAs(Request $request){
		$png_base64_thumb_data = $request['pngimageData'];

		$template_json = json_decode( $request->jsonData );
		$template_dimensions = $this->convertPXtoIn( $template_json[1]->cwidth ).'x'.$this->convertPXtoIn($template_json[1]->cheight).' in';
		$template_id = $this->randomNumber(8);
		// $collection_id = $request->tmp_templates;

		// Crreate thumbnail file, from base64 encoded data
		$thumbnail_paths = $this->createThumbnailFiles( $png_base64_thumb_data, $template_id );
		
		$thumbnail_info = [
			'title' => $request->filename,
			'filename' => $thumbnail_paths['thumbnail'],
			'template_id' => $template_id,
			'tmp_original_url' => null,
			'dimentions' => $template_dimensions,
			// 'tmp_templates' => $collection_id,
			'status' => 1
		];
		
		$request['tags']; // daniel,ejemplotag1,ejemplotag2
		$request['geofilterBackground']; // 0
		$request['instructionsId']; // 0
		$request['saveToAdminAccount']; // 0

		$template_config['demo_as_id'] = 0;
		$template_config['height'] = $template_json[1]->cheight;
		$template_config['width'] = $template_json[1]->cwidth;
		$template_config['metrics'] = $request['metrics']; // in
		$template_config['type'] = $request['type'];
		$template_config['design_as_id'] = $request['design_as_id'];
		$template_config['demo_templates'] = $template_id;
		$template_config['selectedFont'] = 'font42';
		$template_config['fillColor'] = 'Black';
		$template_config['geofilterBackgrounds'] = '{"id":0,"filename":"none"},{"id":"1","filename":"geo-wedding.jpg"},{"id":"2","filename":"geo-party.jpg"},{"id":"3","filename":"geo-cheers.jpg"},{"id":"4","filename":"geo-babygirl.jpg"}';
		$template_config['currentUserRole'] = 'designer';
		$template_config['hideVideoModal'] = 'false';
		$template_config['parentTemplateId'] = $template_id;

		$this->registerThumbnailsOnDB( $thumbnail_info );
		$this->registerNewTemplate( $template_id, $template_config, $template_json );
		// echo "<pre>";
		// // // print_r( $request->all() );
		// print_r( $template_json );
		// print_r( $template_dimensions );
		// exit;
		// $this->registerTemplateOnDB( $template_info );

		$response = [
			'id' => $template_id,
			'err' => 0,
			'msg' => 'Ajuuua'
		];
		return json_encode($response);

	}

	function registerNewTemplate($template_id, $template_config, $template_json){
		$template_id_query = DB::table('templates')
									->select('template_id')
									->where('template_id','=',$template_id)
									->first();
		
		// echo "<pre>";
		// print_r($template_id_query);
		// exit;

		// If template does not exists on db
		if( isset($template_id_query->template_id) == false 
			&& isset($template_json) 
			&& is_array($template_json) 
			&& is_object($template_json[1]) ){

			// echo "<pre>";
			// print_r("TEMPLATE ID NO EXISTE PREVIAMENTE");
			// print_r($template_config);
			// exit;

			// if(  ){
			$template_info = $this->generateTemplateMetadata($template_id, $template_config);
			
			$template_json = json_encode($template_json);
			$template_json = str_replace('https:\/\/dbzkr7khx0kap.cloudfront.net\/', 'http:\/\/localhost\/design\/template\/'.$template_id.'\/assets\/', $template_json);
			$template_json = json_decode($template_json);
			
			// echo "<pre>";
			// // print_r("template_info");
			// // print_r($template_info);
			// // print_r($template_json[1]->objects);
			// print_r($template_info['templateid']);
			// print_r($template_json);
			// exit;

			$objects = $template_json[1]->objects;

			foreach ($objects as $index => $object) {
				if($object->type == 'image'){
					echo '<br>'.$object->src;
					// $this->registerImagesOnDB($object->src, $template_info['templateid']);
				} elseif($object->type == 'path' && isset($object->src)){
					echo '<br>'.$object->src;
					// $this->registerSVGsOnDB($object->src, $template_info['templateid']);
				} elseif($object->type == 'textbox'){
					echo '<br>'.$object->fontFamily;
					// $this->registerFontsOnDB($object->fontFamily, $template_info['templateid']);
				}
			}

			echo "<pre>";
			print_r($template_id);
			print_r($template_json);
			print_r($template_info);
			exit;

			// Saves JSON Template on REDIS
			// $this->storeJSONTemplate($template_id, json_encode($template_json) );
			// $this->saveTemplateOnDB($template_info);

			// print_r($template_info['templateid']);
			// // print_r($template_json);
			// exit;

			return true;

			// } else {
			// 	DB::table('tmp_etsy_metadata')
			// 		->where('id', $etsy_template_id)
			// 			->update(['status' => 4 ]); // No se pudo descargar de la plataforma
			// }
		}

		return false;
	}

	private function generateTemplateMetadata($template_id, $template_config){
		$template_info['templateid'] = $template_id;
		$template_info['etsy_template_id'] = null;
		$template_info['pngimageData'] = 'null';
		$template_info['jsonData'] = 'null';
		$template_info['metrics'] = $template_config['metrics'];
		$template_info['crc'] = '582839465';
		$template_info['design_as_id'] = $template_config['design_as_id'];
		$template_info['type'] = $template_config['type'];
		$template_info['geofilterBackground'] = 0;
		$template_info['instructionsId'] = 0;
		$template_info['width'] = $template_config['width'];
		$template_info['height'] = $template_config['height'];
		$template_info['demo_as_id'] = $template_config['demo_as_id'];
		$template_info['demo_templates'] = $template_config['demo_templates'];
		$template_info['status'] = 10; // Status:: Created by user over Tuukul
		$template_info['selectedFont'] = $template_config['selectedFont'];
		$template_info['fillColor'] = $template_config['fillColor'];
		$template_info['geofilterBackgrounds'] = $template_config['geofilterBackgrounds'];
		$template_info['currentUserRole'] = $template_config['currentUserRole'];
		$template_info['hideVideoModal'] = $template_config['hideVideoModal'];
		$template_info['parentTemplateId'] = $template_config['parentTemplateId'];

		return $template_info;
	}

	private function storeJSONTemplate($template_id, $json_data){
		$template_key = 'template:'.$template_id.':jsondata';
		Redis::set($template_key, $json_data);
	}

	function registerDemoAsIDOnDB($username, $demo_as_id){
		
		DB::table('tmp_demo_as_id')->insert([
			'id' => null,
			'username' => $username,
			'demo_as_id' => $demo_as_id
		]);
	}

	function registerAssetOnDB($file_name, $template_path, $template_id){
		DB::table('images')->insert([
			'id' => null,
			'template_id' => $template_id,
			'tmp_path' => $template_path,
			'filename' => $file_name,
			'status' => 0 // Estado inicial, metadatos extraidos de etsy
		]);
	}

	function registerImagesOnDB($url, $template_id){
		$diagonal = strripos($url, '/')+1;
		$file_name = substr($url, $diagonal, strlen($url));
		
		$images_query = DB::table('images')
    		->select('template_id')
    		->where('template_id','=',$template_id)
    		->where('filename','=',$file_name)
    		->first();
		
		// If this image does not exists on db
		if( isset($images_query->template_id) == false ){
			$path = 'design/template/images/'.$template_id;
			$this->registerAssetOnDB($file_name, $path . '/'.$file_name, $template_id);
		}
	}

	function registerSVGsOnDB($url, $template_id){
		
		$diagonal = strripos($url, '/')+1;
		$file_name = substr($url, $diagonal, strlen($url));
		
		$svg_query = DB::table('images')
    		->select('template_id')
    		->where('template_id','=',$template_id)
    		->where('filename','=',$file_name)
    		->first();
		
		// If font id does not exists on db
		if( isset($svg_query->template_id) == false ){
			$path = 'design/template/images/'.$template_id;
			$this->registerAssetOnDB($file_name, $path . '/'.$file_name, $template_id);
		}
	}

	function registerFontsOnDB($font_id, $template_id){

		// Check if font/template relationship already exist
		$relationship_query = DB::table('template_has_fonts')
								->select('template_id')
								->where('template_id','=',$template_id)
								->where('font_id','=',$font_id)
								->first();

		// Create relationship between font and template, if it does not exists
		if( isset($relationship_query->template_id) == false ){
			$this->createFontTemplateRelationship($font_id, $template_id);
		}

		$font_query = DB::table('fonts')
						->select('font_id')
						->where('font_id','=',$font_id)
						->first();

		// If font id does not exists on db
		if( isset($font_query->font_id) ){
			// Update rest of templates to avoid double download
			DB::table('template_has_fonts')
				->where('font_id', $font_id)
				->update(['status' => 1]);
		}
	}

	function createFontTemplateRelationship($font_id, $template_id){
		DB::table('template_has_fonts')->insert([
			'id' => null,
			'template_id' => $template_id,
			'font_id' => $font_id,
			'status' => 0
		]);
	}

	function saveTemplateOnDB($template_info){
		$template_id_query = DB::table('templates')
			->select('template_id')
			->where('template_id','=',$template_info['templateid'])
			->first();

		// If font id does not exists on db
		if( isset($template_id_query->template_id) == false ) {
			return DB::table('templates')->insertGetId([
				"id" => null,
				"template_id" => $template_info['templateid'],
				"fk_etsy_template_id" => $template_info['etsy_template_id'],
				"parent_template_id" => $template_info['parentTemplateId'],
				"demo_as_id" => $template_info['demo_as_id'],
				"design_as_id" => $template_info['design_as_id'],
				"demo_templates" => $template_info['demo_templates'],
				"status" => $template_info['status'],
				"pngimageData" => $template_info['pngimageData'],
				"jsonData" => $template_info['jsonData'],
				"metrics" => $template_info['metrics'],
				"crc" => $template_info['crc'],
				"type" => $template_info['type'],
				"geofilterBackground" => $template_info['geofilterBackground'],
				"instructionsId" => $template_info['instructionsId'],
				"updateOriginal" => null,
				"width" => $template_info['width'],
				"height" => $template_info['height'],
				"selectedFont" => $template_info['selectedFont'],
				"fillColor" => $template_info['fillColor'],
				"geofilterBackgrounds" => $template_info['geofilterBackgrounds'],
				"currentUserRole" => $template_info['currentUserRole'],
				"hideVideoModal" => $template_info['hideVideoModal']
			]);
		}
	}

	function createThumbnailFiles( $image_data, $template_id ){
		/*
			$image = $image_data;  // your base64 encoded
			$image = str_replace('data:image/jpeg;base64,', '', $image);
			$image = str_replace(' ', '+', $image);
			// $imageName = str_random(10).'.'.'png';
			$imageName = 'ejemplo.jpeg';
			
			Storage::put('wthumbs/' . $imageName, base64_decode($image));
		*/
		
		$rand_filename_id = $this->randomNumber(6).'_'.$this->randomNumber(10);
		$image = $image_data;  // your base64 encoded
        $image = str_replace('data:image/jpeg;base64,', '', $image);
		$image = str_replace(' ', '+', $image);

		// Create image from base64 string
		$img = \Image::make(base64_decode($image));

		$img_path = 'design/template/'.$template_id.'/thumbnails/';
		$path = public_path($img_path);
		@mkdir($path, 0777, true);

		// Store mid-size thumbnail
		// $unique_id = Str::random(10);
		$full_thumbnail_path = public_path($img_path.$rand_filename_id.'_thumbnail.jpg');
		$img->save($full_thumbnail_path);

		// Guardar en S3
		// Storage::disk('s3')->put($img_path.$unique_id.'.jpg', $full_thumbnail_path);
		
		// Create mini thumbnail
		$img->resize(150, 210, function($constraint) {
			$constraint->aspectRatio();
		});

		$full_minithumbnail_path = public_path($img_path.$rand_filename_id.'_mini.jpg');
		$img->save($full_minithumbnail_path);

		return [
			'thumbnail' => $rand_filename_id.'_thumbnail.jpg',
			'mini' => $rand_filename_id.'_mini.jpg'
		];
	}

	function updateThumbnailsOnDB( $template_info ){
		$thumbnail = DB::table('thumbnails')
						->select('id')
						->where('template_id','=', $template_info['template_id'] )
						->first();

		if( isset( $thumbnail->id ) != false ){
			DB::table('thumbnails')
				->where('template_id','=', $template_info['template_id'] )
				->update([
					'filename' => $template_info['filename'],
					'dimentions' => $template_info['dimentions'],
					'status' => 1
				]);
			return true;
		}
		return false;
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
	
	function deleteCurrentThumbnails( $template_info ){
		
		$thumbnail = DB::table('d_thumbnails')
						->select('filename')
						->where('template_id','=', $template_info['template_id'] )
						->first();
		if( isset( $thumbnail->filename ) ){

			$img_folder = 'design/template/'.$template_info['template_id'].'/thumbnails/';
			$img_path = $img_folder.$thumbnail->filename;
			
			$thumbnail_path = public_path($img_path);
			$mini_thumbnail_path = str_replace('.jpg','_mini.jpg',$thumbnail_path);

			if(is_file($thumbnail_path)) {
				unlink( $thumbnail_path );
			}

			if(is_file($mini_thumbnail_path)) {
				unlink( $mini_thumbnail_path );
			}
		}
	}

    function getTemplateThumbnails(Request $request){
    	$template_ids = $request['demo_templates'];
    	// print_r($template_ids);
    	// exit;
		$thumbnails_html = '';
    	if( isset($template_ids) ){
			// $template_ids = explode(',', string)

			$template_thumbnails = DB::table('thumbnails')
	    		->select(['template_id', 'filename', 'title', 'dimentions'])
	    		->whereRAW('template_id IN('.$template_ids.')')
	    		->get();

	    	// echo "<pre>";
			
		    foreach($template_thumbnails as $thumbnail) {
		    	$img_url = url('design/template/'.$thumbnail->template_id.'/thumbnails/'.$thumbnail->filename);

		    	$thumbnails_html .= '<div class="col-xs-6 thumb" id="'.$thumbnail->template_id.'"><a class="thumbnail" data-target="'.$thumbnail->template_id.'"><span class="thumb-overlay"><h3>'.$thumbnail->title.'</h3></span><div class="expired-notice" style="display:none;">EXPIRED</div><img class="tempImage img-responsive" src="'.$img_url.'" alt="" style=""></a><div class="badge-container"><span class="badge dims">'.$thumbnail->dimentions.'</span><span class="badge tempId">ID: '.$thumbnail->template_id.'</span><i class="fa fa-trash-o deleteTemp" id="'.$thumbnail->template_id.'"></i></div></div>';
		    }

		    // echo "<pre>";
	    	// print_r($thumbnails_html);
	    	// print_r(" - kokoko");
	    	// exit;

			// if ($row = $mysqli->query($query)) {
			    /* obtener un array asociativo */
			// }

		}

		$response = array(
			'err' => 0,
		    'data' => $thumbnails_html
		);

		return json_encode($response);
	}
	
	function loadAdditionalAssets(){
		// Load assets associated with template, in order user can add extra assets for template
		// {
		// 	"success":true,
		// 	"images": [
		// 		{
		// 			"id":"1",
		// 			"filename":"name",
		// 			"img":"http://localhost/design/template/799782/assets/239585_1538902281.jpg",
		// 			"filename":"filename"
		// 		}
		// 	]
		// }

		return json_encode([
			"success" => true,
			"images" =>  []
		]);
	}

	function getBackgroundImages(){
		return '{"err":0,"data":[{"id":"15783","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1551377633.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1551377633.png","isownitem":"own","name":"Ombre Blush Pink Peach Background"},{"id":"11718","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1543510433.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1543510433.png","isownitem":"own","name":"Christmas Candy Cane BG"},{"id":"11634","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1543332034.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1543332034.png","isownitem":"own","name":"Gold Foil"},{"id":"7859","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1535289181.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1535289181.png","isownitem":"own","name":"Linen Background"},{"id":"7857","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1535288961.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1535288961.png","isownitem":"own","name":"Canvas Background"},{"id":"7856","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1535288921.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1535288921.png","isownitem":"own","name":"Watercolor Paper"},{"id":"7855","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1535288842.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1535288842.png","isownitem":"own","name":"Watercolor Paper"},{"id":"7854","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1535288720.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1535288720.png","isownitem":"own","name":"Watercolor Paper"},{"id":"7610","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1534723194.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1534723194.png","isownitem":"own","name":"Unicorn Background"},{"id":"7045","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1533408670.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1533408670.png","isownitem":"own","name":"Eucalyptus Background Pattern"},{"id":"6695","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532705763.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532705763.png","isownitem":"own","name":"Art Deco Gatsby Back"},{"id":"6536","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532405555.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532405555.png","isownitem":"own","name":"Baby First"},{"id":"6526","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532391374.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532391374.png","isownitem":"own","name":"Watercolor Wood Background"},{"id":"6518","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532389975.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532389975.png","isownitem":"own","name":"Watercolor Background"},{"id":"6484","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532297507.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532297507.png","isownitem":"own","name":"Black Stripes + Peonies Background"},{"id":"6483","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532297187.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532297187.png","isownitem":"own","name":"Beige watercolor ombre background"},{"id":"6482","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532295457.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532295457.png","isownitem":"own","name":"Black Stripes + Peonies"},{"id":"6481","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532294695.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532294695.png","isownitem":"own","name":"Under The Sea - Back"},{"id":"6480","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532294425.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532294425.png","isownitem":"own","name":"Under The Sea - Text Optimized"},{"id":"6478","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532294293.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532294293.png","isownitem":"own","name":"Under The Sea - No Bleed"},{"id":"6458","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532275816.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532275816.png","isownitem":"own","name":"B&W Couple"},{"id":"6457","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532275672.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532275672.png","isownitem":"own","name":"Background Couple Photo"},{"id":"6439","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532220748.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532220748.png","isownitem":"own","name":"White Muted Painted Background"},{"id":"2848","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/1_1518631904.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/1_1518631904.png","isownitem":"not-own","name":"Old Paper Wrinkled"}],"query":"SELECT * FROM background WHERE userid IN(1,173355)  ORDER BY userid=\'173355\' DESC, id DESC LIMIT 0, 24"}';
	}

	function loadSettings(){
		return '{"err":1,"msg":"Not allowed"}';
	}

	function loadTemplate(Request $request){

		$template_ids = isset($request['id']) ? $request['id'] : null;
		$array_final = [];
		$error = 1;
		$options = "";

		// echo $template_ids;
		// exit;


		// $array_final =  stripslashes(stripslashes($response));

		// $array_final =  str_replace('["','[', $array_final);

		// // $array_final =  str_replace('"]"',']', $array_final);
		// // $array_final =  str_replace('\\\"','"', $response);
		// // $array_final =  str_replace('\\"','"', $response);

		// $array_final =  str_replace('{\\','{', $array_final);
		// $array_final =  str_replace('"{','{', $array_final);
		// $array_final =  str_replace('}"','}', $array_final);
		// $array_final =  str_replace(']"',']', $array_final);
		// $array_final =  str_replace('\"','"', $array_final);

		

		$template = DB::table('templates')
				->select('*')
				->where('template_id','=',$template_ids)
				->first();

	    if(isset($template)){
			// printf("La selección devolvió %d filas.\n", $template->num_rows);

			// echo "<pre>";
			// print_r($template);
			// exit;


			$array_final = $this->getJSONTemplate($template->template_id);
			$array_final = str_replace("\n", '\\n', $array_final);
			// $array_final = preg_replace("/\"width\"/", '\\\"width\\\"', $array_final,1);
			// $array_final = preg_replace("/\"height\"/", '\\\"height\\\"', $array_final,1);
			// $array_final = preg_replace("/\"rows\"/", '\\\"rows\\\"', $array_final,1);
			// $array_final = preg_replace("/\"cols\"/", '\\\"cols\\\"', $array_final,1);

			// echo "<pre>";
			// print_r($template);
			// print_r( addslashes(json_encode($options)) );
			// exit;

			// $array_final =  str_replace('["{"','[{"', $array_final);
			// $array_final =  str_replace('",{',',{', $array_final);

			$options = array(
				'width' => $template->width,
				'height' => $template->height,
				'metrics' => $template->metrics,
				'type' => $template->type,
				'instructionsId' => $template->instructionsId,
				'scriptVersion' => 4
			);
			
			$options = json_encode($options);

			$error = 0;
		}

		return  json_encode(
			array(
				'err' => $error,
				'data' => $array_final,
				"metrics" => 'in',
				"options" => $options,
				"instructions" => ""
			)
		);
	}

	function loadRemainingDownloads(){
		return '{"success":true,"limit":0}';
	}

	function getWoffFontUrl(Request $request){
		// {"success":true,"url":"https:\/\/templett.com\/design\/fonts_new\/KG_Second_Chances_Solid_1537862439.woff"}
		$font_id = $request['font_id'];
		$success = false;
		$font_url = null;

		if( isset($font_id) ){

			$font_info = DB::table('fonts')
				->select('name')
				->where('font_id','=',$font_id)
				->where('status','=', 1)
				->first();

			// echo "<pre>";
			// print_r($font_info);
			// exit;

			if(isset($font_info->name)){
				$success = true;
				$font_url = url('design/fonts_new/'.$font_info->name);
			}

			return json_encode(array(
				'success' => $success,
				'url' => $font_url
			));
		}

	}

	function checkAllowRevertTemplate(){
		return '{"access":true}';
	}

	function getCSSFonts(Request $request){
		$templates = urldecode($request->templates);
		$values = array();
		$response = "";

		$templates = explode(",", $templates);
		$templates = "'".implode("','", $templates)."'";

		if( isset($templates) ){
			// $templates = json_decode($templates);
			// $templates = urldecode($request['templates']);
			// $templates = "'".implode("','", $templates)."'";
			
			// "SELECT * FROM fonts WHERE "
			$font_families = DB::Table('fonts')
								->select(['font_id','name'])
								->whereRAW('font_id IN('.$templates.')')
								->get();
		
		
			// header("Content-type: text/css");
			foreach( $font_families as $font ){
				$font_url = url('design/fonts_new/'.$font->name);
				
				$response .= '@font-face {
					font-family:\''.$font->font_id.'\';
					src:url(\''.$font_url.'\') format(\'woff\');
				}';
		
			}

			return (new Response($response, 200))
              ->header('Content-Type', "text/css");
		
		}
	}

	function generatePDF(Request $request){
		
		if ($_SERVER['REQUEST_METHOD']=='OPTIONS') {
			header('Access-Control-Allow-Origin : *');
			header('Access-Control-Allow-Methods : POST, GET, OPTIONS, PUT, DELETE');
			header('Access-Control-Allow-Headers : X-Requested-With, content-type');
		}
		
		// Writes SVG on disk
		$svg_content = json_decode($request['jsonData']);
		
		File::put(public_path('example.svg'),$svg_content);

		// READ CSV
		
		// echo substr_count($svg_content, 'clip-path=');
		// exit;
		// READ CSV
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://localhost:3000",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 0,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "GET",
		));

		$response = curl_exec($curl);

		curl_close($curl);

		// $dompdf = new Dompdf();
		// $dompdf->loadHtml('hello world');
		// $dompdf->setPaper('A4', 'landscape');
		// Render the HTML as PDF
		// $dompdf->render();
		// Output the generated PDF to Browser
		// return $dompdf->stream();

		$path = public_path('example.png');
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		$data = [ 'base64' => $base64 ];

		// PAPER SIZES
		// dompdf/dompdf/src/Adapter/CPDF.php
		$pdf = PDF::loadView('pdf_view', $data)
				->setPaper('a4', 'landscape')
				->save( public_path('invitation.pdf') );
		
		// $file_to_save = public_path('invitation.pdf');
		// file_put_contents($file_to_save, $pdf->output()); 
		
		$response = [
			'data' => 'invitation.pdf',
			'success' => true
			// 'msg' => 'Ajuuua'
		];

		return json_encode($response);
	}

	function downloadPDF(Request $request){
		$path = public_path('invitation.pdf');

		header("Content-Type: application/octet-stream");
		// http response headers to set composition and file to download
		header('Content-Disposition: attachment; filename="'.$request->filename.'"');
		// The length of the requested file need to download
		header("Content-Length: " . filesize($path));
		// Reads a file and writes it to the output buffer.
		readfile($path);
	}

	function registerTemplateDownload(Request $request){
		// echo "<pre>";
		// print_r($request->all());
		$request->templateId; //=> 29262
		$request->fileType; //=> JPEG
		$request->option; //=> {"saveBleed":false}
	}
}
