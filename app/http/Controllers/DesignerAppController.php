<?php

// Party
// Holidays
// Wedding
// Babies & Kids
// Announcements


// Instagram Post
// Youtube Thumbnail
// Flyer
// Animated Social Media
// Facebook Post
// Presentation
// Invitation
// Ticket
// Instagram Story
// Poster
// Video
// Logo
// Infographic
// Facebook Cover
// Card
// Brochure
// Photo Collage
// Resume
// Business Card
// Blog Banner
// Youtube Channel Art
// Book Cover
// Desktop Wallpaper
// Certificate
// Menu
// Letterhead
// CD Cover
// ID Card
// Newsletter
// Calendar
// Postcard
// Label
// Announcement
// Gift Certificate
// Tag
// Program
// Bookmark
// Class Schedule
// Coupon
// Report
// Proposal
// Media Kit
// Worksheet
// Invoice
// Recipe Card
// Rack Card
// Planner
// Report Card
// Letter
// Lesson Plan

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


class DesignerAppController extends Controller
{
	function home1(){
		return view('home1',[ 'templates' => null ]);
	}

	function product(){
		return view('product',[ 'templates' => null ]);
	}

	function category(){
		return view('category',[ 'templates' => null ]);
	}

	function wayak(){

		// $templates = Redis::keys('laravel_database_green:category:209:product:*');
		// echo "<pre>";
		// print_r($templates);
		// exit;

		// $template = Redis::keys('laravel_database_green:category:209:product:*');
		// // $template = json_decode($template);

		// echo "<pre>";
		// print_r($template);
		// exit;

		// $templates = Redis::keys('laravel_database_template:*:jsondata');

		// echo "<pre>";
		// print_r($templates);
		// exit;

		// $template = Redis::get('laravel_database_template:g13780:jsondata');
		// echo "<pre>";
		// print_r(json_decode($template));
		// exit;

		return view('wayak',[ 'templates' => null ]);
	}

	function getJSONTemplate($template_id) {
		$template_key = 'template:'.$template_id.':jsondata';
		//  Redis::get($template_key);
		// return str_replace('http://localhost/design/','http://localhost:8000/design/', Redis::get($template_key) );
		return Redis::get($template_key);
	}

	function home(Request $request){
		// echo Redis::type('ejemplo');
		// echo "blunt";
		// exit;
		$purchase_code = $request['purchase_code'];
		$templates = $request['templates'];
		$demo_as_id = rand(1,999999);

		if( Redis::exists('code:'.$purchase_code) == true && Redis::get('code:'.$purchase_code) == 0 ){
			
			$demo_as_id = 0;
			$user_role = 'customer';

			return view('home',[ 
				'templates' => $templates, 
				'purchase_code' => $purchase_code,
				'demo_as_id' => $demo_as_id,
				'user_role' => $user_role
			]);
			
		} elseif( $purchase_code == 'administrator' ){
			
			$demo_as_id = 0;
			$user_role = 'designer';
			$purchase_code = 9999;

			return view('home',[ 
				'templates' => $templates, 
				'purchase_code' => $purchase_code,
				'demo_as_id' => $demo_as_id,
				'user_role' => $user_role
			]);

		} else {
			return redirect()->action(
				'DesignerAppController@validateCode', [ 'templates' => $templates ]
			);
		}

		// echo Redis::get('code:'.$purchase_code);
		// exit;
		
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
		// // $length = 15;
		// $result = '';

		// for($i = 0; $i < $length; $i++) {
		// 	$result .= mt_rand(0, 9);
		// }

		// return $result;

		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return substr(str_shuffle($permitted_chars), 0, $length);

	}

	function update(Request $request){

		$template_obj = json_decode( $request->jsonData );
		$template_dimensions = $this->convertPXtoIn( $template_obj[1]->cwidth ).'x'.$this->convertPXtoIn($template_obj[1]->cheight).' in';
		$template_id = $request->templateid;

		// echo "<pre>";
		// print_r( $template_id );
		// exit;

		$this->deleteCurrentThumbnails($template_id);


		$thumbnail_imgs = $this->createThumbnailFiles( $request->pngimageData, $template_id );

		$thumbnail_info = [
				'filename' => $thumbnail_imgs['thumbnail'],
				'template_id' => $template_id,
				'dimentions' => $template_dimensions,
				'status' => 1
		];
		// exit;

		$this->updateThumbnailsOnDB( $thumbnail_info );

		// echo "<pre>";
		// print_r( $template_id );
		// print_r( $thumbnail_info );
		// exit;

		$this->storeJSONTemplate($template_id, json_encode($template_obj));

		Redis::set('green:ready_template:'.$template_id, 1);

		$response = [
			'id' => $template_id,
			'err' => 0,
			'msg' => 'Update exitoso'
		];

		return json_encode($response);

	}

	function uploadImage(Request $request){

		// $extension = $request->file->extension();


		// echo "<pre>";
		// // print_r($extension);
		// print_r($request->file('nombre'));
		// print_r(Str::slug($request->input('name')).'_'.time());
		// print_r( $image->getClientOriginalExtension() );

		// $request->validate([
        //     'name'              =>  'required',
        //     'profile_image'     =>  'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        // ]);

        // Check if a profile image has been uploaded
        if ($request->has('nombre')) {
            // Get image file
            $image = $request->file('nombre');

			// Make a image name based on user name and current timestamp
            $name = Str::slug('ejemplo_'.time());
            // Define folder path
            $folder = '/design/template/ejemplo/';
            // Make a file path where image will be stored [ folder path + file name + file extension]
            $filePath = $folder . $name. '.' . $image->getClientOriginalExtension();
            // Upload image
			$this->uploadOne($image, $folder, 'public', $name);
			$response = [
				"id" =>1,
				"msg" =>'Hola Mundo',
				"success" => true
			];
			return json_encode($response);
            // Set user profile image path in database to filePath
            // $user->nombre = $filePath;
        }
	}

	public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null)
    {
        $name = !is_null($filename) ? $filename : Str::random(25);

        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);
		// echo $folder;
		// echo $name;
        return $file;
	}

	function getUploadedImage($image_resource_id){
		return json_encode([
			'success' => true,
			'img' => asset('design/template/ejemplo/5a2fb0dbd8141396fe9b528b.svg')
		]);
	}

	function saveAs(Request $request){
		$png_base64_thumb_data = $request['pngimageData'];

		$template_json = json_decode( $request->jsonData );
		$template_dimensions = $this->convertPXtoIn( $template_json[1]->cwidth ).'x'.$this->convertPXtoIn($template_json[1]->cheight).' in';
		$template_id = $this->randomNumber(20);
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

		// $file_name = $request->filename; // Engagement party, floral, pinaple
		// $tags = $request->tags; // engagement,party,tags
		// $metrics = $request->metrics; // in
		// $design_as_id = $request->design_as_id; // 243578
		// $type = $request->type; // single
		// $geofilterBackground = $request->geofilterBackground; // 0
		// $instructionsId = $request->instructionsId; // 80
		// $saveToAdminAccount = $request->saveToAdminAccount; // 0

		// echo "<pre>";
		// print_r($request->all());
		// // print_r($thumbnail_info);
		// exit;

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
					// echo '<br>'.$object->src;
					$this->registerImagesOnDB($object->src, $template_info['templateid']);
				} elseif($object->type == 'path' && isset($object->src)){
					// echo '<br>'.$object->src;
					$this->registerSVGsOnDB($object->src, $template_info['templateid']);
				} elseif($object->type == 'textbox'){
					// echo '<br>'.$object->fontFamily;
					$this->registerFontsOnDB($object->fontFamily, $template_info['templateid']);
				}
			}

			// echo "<pre>";
			// print_r($template_id);
			// print_r($template_json);
			// print_r($template_info);
			// exit;

			// Saves JSON Template on REDIS
			$this->storeJSONTemplate($template_id, json_encode($template_json) );

			// exit;
			$this->saveTemplateOnDB($template_info);

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
		// print_r(imagick_info());
		// exit;
		// $image_data = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFgAAAAXCAYAAACPm4iNAAAKqmlDQ1BJQ0MgUHJvZmlsZQAASImVlwdUU8kax+fe9EYLREBK6B3pVXoNRZAONkISQigxJAQBGyqLK7iiiIiADV1pCq4FkEVFLIiyCChgXxBRUdfFgqiovBt5xN2z57133nfPZH7nyzfffDN35pz/BYB8iykQpMJyAKTxM4Rhfp70mNg4Ou4xIAB55NEGEJMlEniEhgYBxOb6v9v7QQBJ+ptmklz//P+/mjybI2IBAIUinMAWsdIQPoW0NpZAmAEASoD4dVZlCCRcgrCiECkQ4RoJc2e5TcIJs9z7LSYizAvhxwDgyUymkAsAaQLx0zNZXCQPGVktsOCzeXyE3RF2ZSUx2QjnImyalrZSwkcRNkz4Sx7u33ImSHMymVwpz67lm+G9eSJBKjP7/9yO/21pqeK5OXSQRk4S+odJ5pPsW8rKQCnzExaFzDGPPVuThJPE/pFzzBJ5xc0xm+kdKB2buihojhN5vgxpngxGxBwLV4ZJ83NEPuFzzBR+n0ucEukhnZfDkObMSYqInuNMXtSiORalhAd+j/GS+oXiMGnNiUJf6RrTRH9ZF48hjc9IivCXrpH5vTaOKEZaA5vj7SP18yOlMYIMT2l+QWqoNJ6T6if1izLDpWMzkMP2fWyodH+SmQGhcwx4IBgwASuDk5UhKdhrpSBbyOMmZdA9kBvDoTP4LHNTupWFlQUAkvs3+3rf0r7dK4h27bsvvR0AxwLEyf3uYyLn4MwTAKjvv/t03iBHYzsAZ3tZYmHmrA8t+cEAIpAFikAFaCDnxxCYAStgB5yBO/ABASAERIBYsBywQBJIA0KwCqwBG0A+KATbwS5QDvaDQ6AGHAMnQDNoAxfAFXAd9IIBcA8MgzHwAkyA92AagiAcRIGokAqkCelBJpAV5AC5Qj5QEBQGxULxEBfiQ2JoDbQJKoSKoXLoIFQL/QKdgS5AXVAfdAcagcahN9AnGAWTYUVYHdaHF8AOsAccCEfAy2AunA7nwHnwNrgMroKPwk3wBfg6PAAPwy/gSRRAkVA0lBbKDOWA8kKFoOJQiSghah2qAFWKqkI1oFpRnaibqGHUS9RHNBZNRdPRZmhntD86Es1Cp6PXobeiy9E16Cb0JfRN9Ah6Av0VQ8GoYUwwThgGJgbDxazC5GNKMUcwpzGXMQOYMcx7LBZLwxpg7bH+2FhsMnY1dit2L7YR247tw45iJ3E4nArOBOeCC8ExcRm4fNwe3FHceVw/bgz3AU/Ca+Kt8L74ODwfvxFfiq/Dn8P345/ipwlyBD2CEyGEwCZkE4oIhwmthBuEMcI0UZ5oQHQhRhCTiRuIZcQG4mXifeJbEomkTXIkLSbxSLmkMtJx0lXSCOkjWYFsTPYiLyWLydvI1eR28h3yWwqFok9xp8RRMijbKLWUi5SHlA8yVBlzGYYMW2a9TIVMk0y/zCtZgqyerIfsctkc2VLZk7I3ZF/KEeT05bzkmHLr5CrkzsgNyU3KU+Ut5UPk0+S3ytfJd8k/U8Ap6Cv4KLAV8hQOKVxUGKWiqDpULyqLuol6mHqZOqaIVTRQZCgmKxYqHlPsUZxQUlCyUYpSylKqUDqrNExD0fRpDFoqrYh2gjZI+zRPfZ7HPM68LfMa5vXPm1Ker+yuzFEuUG5UHlD+pEJX8VFJUdmh0qzyQBWtaqy6WHWV6j7Vy6ov5yvOd57Pml8w/8T8u2qwmrFamNpqtUNq3WqT6hrqfuoC9T3qF9VfatA03DWSNUo0zmmMa1I1XTV5miWa5zWf05XoHvRUehn9En1CS03LX0usdVCrR2ta20A7UnujdqP2Ax2ijoNOok6JTofOhK6mbrDuGt163bt6BD0HvSS93XqdelP6BvrR+pv1m/WfGSgbMAxyDOoN7htSDN0M0w2rDG8ZYY0cjFKM9hr1GsPGtsZJxhXGN0xgEzsTnslekz5TjKmjKd+0ynTIjGzmYZZpVm82Yk4zDzLfaN5s/mqB7oK4BTsWdC74amFrkWpx2OKepYJlgOVGy1bLN1bGViyrCqtb1hRrX+v11i3Wr21MbDg2+2xu21Jtg20323bYfrGztxPaNdiN2+vax9tX2g85KDqEOmx1uOqIcfR0XO/Y5vjRyc4pw+mE05/OZs4pznXOzxYaLOQsPLxw1EXbhely0GXYle4a73rAddhNy43pVuX2yF3Hne1+xP2ph5FHssdRj1eeFp5Cz9OeU15OXmu92r1R3n7eBd49Pgo+kT7lPg99tX25vvW+E362fqv92v0x/oH+O/yHGOoMFqOWMRFgH7A24FIgOTA8sDzwUZBxkDCoNRgODgjeGXx/kd4i/qLmEBDCCNkZ8iDUIDQ99NfF2MWhiysWPwmzDFsT1hlODV8RXhf+PsIzoijiXqRhpDiyI0o2amlUbdRUtHd0cfRwzIKYtTHXY1VjebEtcbi4qLgjcZNLfJbsWjK21HZp/tLBZQbLspZ1LVddnrr87ArZFcwVJ+Mx8dHxdfGfmSHMKuZkAiOhMmGC5cXazXrBdmeXsMc5LpxiztNEl8TixGdcF+5O7niSW1Jp0kueF6+c9zrZP3l/8lRKSEp1ykxqdGpjGj4tPu0MX4Gfwr+0UmNl1so+gYkgXzCc7pS+K31CGCg8IoJEy0QtGYqI0OkWG4p/EI9kumZWZH5YFbXqZJZ8Fj+rO9s4e0v20xzfnJ9Xo1ezVnes0VqzYc3IWo+1B9dB6xLWdazXWZ+3fizXL7dmA3FDyobfNlpsLN74blP0ptY89bzcvNEf/H6oz5fJF+YPbXbevP9H9I+8H3u2WG/Zs+VrAbvgWqFFYWnh562srdd+svyp7KeZbYnbeorsivZtx27nbx/c4bajpli+OKd4dGfwzqYSeklBybtdK3Z1ldqU7t9N3C3ePVwWVNayR3fP9j2fy5PKByo8Kxor1Sq3VE7tZe/t3+e+r2G/+v7C/Z8O8A7cPuh3sKlKv6r0EPZQ5qEnh6MOd/7s8HPtEdUjhUe+VPOrh2vCai7V2tfW1qnVFdXD9eL68aNLj/Ye8z7W0mDWcLCR1lh4HBwXH3/+S/wvgycCT3ScdDjZcErvVOVp6umCJqgpu2miOal5uCW2pe9MwJmOVufW07+a/1rdptVWcVbpbNE54rm8czPnc85PtgvaX17gXhjtWNFx72LMxVuXFl/quRx4+eoV3ysXOz06z191udrW5dR15prDtebrdtebum27T/9m+9vpHruephv2N1p6HXtb+xb2net3679w0/vmlVuMW9cHFg30DUYO3h5aOjR8m3372Z3UO6/vZt6dvpd7H3O/4IHcg9KHag+rfjf6vXHYbvjsiPdI96PwR/dGWaMvHosefx7Le0J5UvpU82ntM6tnbeO+473PlzwfeyF4Mf0y/w/5PypfGb469af7n90TMRNjr4WvZ95sfavytvqdzbuOydDJh+/T3k9PFXxQ+VDz0eFj56foT0+nV33GfS77YvSl9Wvg1/szaTMzAqaQ+U0KoJAGJyYC8KYaAEosoh0Q3UxcMquPvxk0q+m/EfhPPKuhv5kdANXuAETmAhCEaJR9SNNDmIz0EhkU4Q5ga2tp+7eJEq2tZnOREdWI+TAz81YdAFwrAF+EMzPTe2dmvhxGir0DQHv6rC6XGBbR7wfIEuoyUPrH98a/AHGaBh4nS4iFAAABm2lUWHRYTUw6Y29tLmFkb2JlLnhtcAAAAAAAPHg6eG1wbWV0YSB4bWxuczp4PSJhZG9iZTpuczptZXRhLyIgeDp4bXB0az0iWE1QIENvcmUgNS40LjAiPgogICA8cmRmOlJERiB4bWxuczpyZGY9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPgogICAgICA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIgogICAgICAgICAgICB4bWxuczpleGlmPSJodHRwOi8vbnMuYWRvYmUuY29tL2V4aWYvMS4wLyI+CiAgICAgICAgIDxleGlmOlBpeGVsWERpbWVuc2lvbj44ODwvZXhpZjpQaXhlbFhEaW1lbnNpb24+CiAgICAgICAgIDxleGlmOlBpeGVsWURpbWVuc2lvbj4yMzwvZXhpZjpQaXhlbFlEaW1lbnNpb24+CiAgICAgIDwvcmRmOkRlc2NyaXB0aW9uPgogICA8L3JkZjpSREY+CjwveDp4bXBtZXRhPgqtaqGmAAAF9ElEQVRYCe1YX0hbVxj/dVqv4EX7Z8GAMS29gY2sVGUNC1SQ1gdLS1raBlz1IRDqIC1l1UFTsMuDrAOhmx1lfZg1NA+xKvrQCqUKOgJ9sK6wdrSZggFbM7DYqZUUjFW275yb21yTaLhp89QcuDnnfuf7d3/fn3N0i9Fo/A+5kTUEPsma5pxijkAO4CwnQg7gHMBZRiDL6nMZnAM4ywhkWX2GGSyg1GbT5FqJzQXpoKRJJj2zDmWnXSgtF9KzZsQhYdcpJ0q2q4UFsulBxRk3PU4UbVXvJa8zBFhCTZMLJcn6UHqhBycv2hN2JNQ2u9F4OpGewKb1tdwJR5MbtXUfOnAxR8rtcJzz4Pgps8ozA76w2XG8wUWPBwa9aivFUjPAZQTgxdF7+Fw049vRabTcuoo8lWLRZMVek05FkZerK8ByZC6J/l6EyBJWSUHk5QfWqzg1cw1dv7ZiwBdUKDSHMNywD20dY7SOquipl/mpyRtQJQ8cx6yYuOtHfnUVnnQGINUVgynJt/nwXXNNTNCNi/fdKCyYQ6/DgskZIhPAhSYnnHcp6iKBPTuGLsfX+PctUHp5BA5zCL80fMNdLrv8AI3mIH5qaMX+WyOoMxZzvYuzYRTqDSgE6W2uxuQLcID3NlHAm3VEB6ZGW9H9g59WOnxFsgfIh0VRSrK582wPHHYryBU+wo+98LW0YY2/6XCgewQ1Oyh4K0t4OD+Mh7+vD6JQEBNMM2nK4DyTxMF8NjCIRTI8NdSOey2tHJQoOdjb0YZHs2RxNoABinxv5zVMs3caLNMgGhAZbYOvf4yAsqLWLpfeNgaaXsd1Mza25g+KUaoncOcDuDMaBuN72u/FNIFXYZbbAtObLwoIdJxH73gYpkNXcMTGKohkdxRD1EspbYpGHWbHvehyO9DVHcCnlU40XlASZA5Pfe0YuBvENvK5jPzJdGgCeG3IiwnKxHpfD6z6KtT/fB1lUuyAmQkgNOhFaD6K1cgYrf2YvO1HlDKUjXwW8Vk/+q558fzGeTwiPQZLFd9j7YOVGw8CWya8L78YxJM/wrSxhGc32hGKALstVsbJgxKmrH04OIjJSyfwmGQr62K9fhObzy/Vovd2EKKlhrKYspx06U3xXvt6iPzvHAaZeq+hrUUggL7DFpSd8eBogw27K20wddagt2kfJkOyH5spXJ5nILERaysFculz8OWN1L+Mb/xPCkAVCrdGEZ6K8qxlzMzeq7+VHilBJFDfBYr2UtsU8OWtv3DUKFAyLOEVBYWdVREeWFoogypjs+9R2DabNWWwrGgO/9xsQ5jaQPuhVopwMSoOxiMvl6y2U/3VlNzf1MAkOb0wFwdO1f+YjFiqlHCIWherFjlwSToUwnYnagncie4j+PHYPvxmt/CKShVo2afkw2w1ItNW06S4JoCFUz1o6e+hg82ObQU67D1r44fE4ozqAFghw/oafHbQipIK87obhvJ9ibN8C7DCaiN+C12LKqntMKBijMqcKKe8m+xXsIvuwiVnrmM/gT8xPqhspZ4pa5dpRzSyNqPDLjpkmVw8wAKKJAlFlQbug1heBaHcDEF1510bHyMdAg40u7CT2kzRurty3Gw63+OctIpODWN65QIa3XL/M1Gre3q/FcNDcYBDHXSwdXpQ/30Pk6BbxGf8FrGcUH6877JgMK77fkw4quiufA+19M4/lPjZzK93nI/1eurTsZ6u9G2WQCIkOHyTtKIyn/Ljzk3WMiRsaPOtH0OPXaiv9sAz6uFy/CfmTx6/EcnfyOi7D1+F+zAFrvMI+qhv87HgxcADOxqr3ThXTXtUDX3crryt/G7J7B/uZpzsv4IR+wm8VjS990xZUyFhNRh8dzBqUZlHGcauhW9C8WCnld9uRtGOKMnEDpC0Apsx6FBiMb+rOoVTUwYrQmx++SKsKin1TqZr+tAnymGlXcfaTBBvtIotkMyCVqEN+OmvynPtriSAM8zgDYx81GQBeeUG6lFL61DIOIPXacm9EAJRrM0ktxpNt4gcjtoR0ATwnj17tFv4yCX+BwtT8IHsQyPfAAAAAElFTkSuQmCC';
		// $image_data = urldecode($image_data);
		$croppie_code = $image_data;

		if (preg_match('/^data:image\/(\w+);base64,/', $croppie_code, $type)) {

			$rand_filename_id = $this->randomNumber(6).'_'.$this->randomNumber(10);
			$encoded_base64_image = substr($croppie_code, strpos($croppie_code, ',') + 1);
			$decoded_image = base64_decode($encoded_base64_image);
			// $type = strtolower($type[1]);
			// echo $encoded_base64_image;

			$img = \Image::make($decoded_image);
			// exit;
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
		// $image = str_replace('data:image/jpeg;base64,', '', $image);
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

	function deleteCurrentThumbnails( $template_id ){

		$thumbnail = DB::table('thumbnails')
						->select('filename')
						->where('template_id','=', $template_id )
						->first();
		if( isset( $thumbnail->filename ) ){

			$img_folder = 'design/template/'.$template_id.'/thumbnails/';
			$img_path = $img_folder.$thumbnail->filename;

			$thumbnail_path = public_path($img_path);
			$mini_thumbnail_path = str_replace('_thumbnail.jpg','_mini.jpg',$thumbnail_path);

			if(is_file($thumbnail_path)) {
				unlink( $thumbnail_path );
			}

			if(is_file($mini_thumbnail_path)) {
				unlink( $mini_thumbnail_path );
			}
		}
	}

    function getTemplateThumbnails(Request $request){
		// $template_ids = $request['demo_templates'];
		// $response = array(
		// 	'err' => 0,
		//     'data' => '<div class="col-xs-6 thumb" id="987654"><a class="thumbnail" data-target="'.$template_ids.'"><span class="thumb-overlay"><h3>EJEMPLO</h3></span><div class="expired-notice" style="display:none;">EXPIRED</div><img class="tempImage img-responsive" src="http://localhost:8001/design/template/'.$template_ids.'/assets/preview.jpg" alt="" style=""></a><div class="badge-container"><span class="badge dims">5x7</span><span class="badge tempId">ID: xxxxx</span><i class="fa fa-trash-o deleteTemp" id="12345"></i></div></div>'
		// );

		// return json_encode($response);
		// exit;

		$template_ids = $request['demo_templates'];
    	$thumbnails_html = '';

		if( isset($template_ids) ){

			$template_thumbnails = DB::table('thumbnails')
	    		->select(['template_id', 'filename', 'title', 'dimentions'])
	    		->whereRAW('template_id IN(\''.$template_ids.'\')')
				->get();

	    	foreach($template_thumbnails as $thumbnail) {
		    	$img_url = url('design/template/'.$thumbnail->template_id.'/thumbnails/'.$thumbnail->filename);

		    	$thumbnails_html .= '<div class="col-xs-6 thumb" id="'.$thumbnail->template_id.'"><a class="thumbnail" data-target="'.$thumbnail->template_id.'"><span class="thumb-overlay"><h3>'.$thumbnail->title.'</h3></span><div class="expired-notice" style="display:none;">EXPIRED</div><img class="tempImage img-responsive" src="'.$img_url.'" alt="" style=""></a><div class="badge-container"><span class="badge dims">'.$thumbnail->dimentions.'</span><span class="badge tempId">ID: '.$thumbnail->template_id.'</span><i class="fa fa-trash-o deleteTemp" id="'.$thumbnail->template_id.'"></i></div></div>';
		    }
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
		// $array_final = [];
		// $error = 1;
		// $options = "";

		// // echo $template_ids;
		// // exit;

		// // $array_final =  stripslashes(stripslashes($response));

		// // $array_final =  str_replace('["','[', $array_final);

		// // // $array_final =  str_replace('"]"',']', $array_final);
		// // // $array_final =  str_replace('\\\"','"', $response);
		// // // $array_final =  str_replace('\\"','"', $response);

		// // $array_final =  str_replace('{\\','{', $array_final);
		// // $array_final =  str_replace('"{','{', $array_final);
		// // $array_final =  str_replace('}"','}', $array_final);
		// // $array_final =  str_replace(']"',']', $array_final);
		// // $array_final =  str_replace('\"','"', $array_final);

		// $template = DB::table('templates')
		// 		->select('*')
		// 		->where('template_id','=',$template_ids)
		// 		->first();

	    // if(isset($template)){
		// 	// printf("La selección devolvió %d filas.\n", $template->num_rows);

		// 	// echo "<pre>";
		// 	// print_r($template);
		// 	// exit;


			$array_final = $this->getJSONTemplate($template_ids);
			// $array_final = str_replace("\n", '\\n', $array_final);
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

			// $options = array(
			// 	'width' => 200,
			// 	'height' => 400,
			// 	'metrics' => '9x7',
			// 	'type' => '',
			// 	'instructionsId' => '',
			// 	'scriptVersion' => 4
			// );

			// $options = json_encode($options);

			// $error = 0;
		// }

		echo json_encode(
			array(
				'err' => 0,
				'data' => $array_final,
				'metrics' => 'in',
				'options' => "{\"width\":1728,\"height\":2304,\"metrics\":\"in\",\"type\":\"single\",\"instructionsId\":\"80\",\"scriptVersion\":4}",
				'instructions' => ""
			)
		);
	}

	function loadRemainingDownloads(){
		
		return response()->json([
			'success' => true,
			'msg' => 'No downloads remaining',
			'limit' => 10,
			'remaining' => 0
		]);
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

		// if ($_SERVER['REQUEST_METHOD']=='OPTIONS') {
		// 	header('Access-Control-Allow-Origin : *');
		// 	header('Access-Control-Allow-Methods : POST, GET, OPTIONS, PUT, DELETE');
		// 	header('Access-Control-Allow-Headers : X-Requested-With, content-type');
		// }

		// Writes SVG on disk
		$svg_content = json_decode($request['jsonData']);

		File::put(public_path('example.svg'),$svg_content);

		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://nodejs:8080/",
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

		echo $response;



		echo "<pre>";
		// print_r($request->all());
		print_r($response);
		exit;


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
		DB::table('orders')->insert([
			'template_id' => $request->templateId,
			'filetype' => $request->filetype,
			'option' => $request->option,
			'purchase_code' => $request->purchase_code
		]);

		// if()
		Redis::set('code:'.$request->purchase_code, 1);

		return response()->json([
			'success' => true,
			'limit' => 10,
			'remaining' => 0
		]);

	}

	function validateCode(Request $request){
		if( isset( $request->templates ) ){
			$templates = $request->templates;
		} else {
			$templates = 0;
		}
		return view('validate_code', ['templates' => $templates]);
	}
	function validatePurchaseCode(Request $request){
		
		$purchase_code = $request->digit1.$request->digit2.$request->digit3.$request->digit4;
		
		if( Redis::exists('code:'.$purchase_code) == true && Redis::get('code:'.$purchase_code) == 0 ){
			// echo "<pre>";
			// print_r($request->all());
			// exit;
			// echo 'code:'.$purchase_code;
			// print_r(Redis::exists('code:'.$purchase_code));

			// echo "exit0";
			// exit;
			
			return redirect()->action(
				'DesignerAppController@home', ['templates' => $request->templates, 'purchase_code' => $purchase_code]
			);
		}

		return redirect()->action(
			'DesignerAppController@validateCode', ['code_validation' => 0, 'templates' => $request->templates]
		);

	}
}
