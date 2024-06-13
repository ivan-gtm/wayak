<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Dompdf\Dompdf;
use Dompdf\Options as DomOptions;

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
use Illuminate\Support\Facades\App;
use App\Services\UserPurchaseService;
use App\Services\PayPalService;
// use Illuminate\Support\Facades\Response;


// use Barryvdh\DomPDF\Facade as PDF;
// use Barryvdh\Options as \Facade as PDFDomOptions;
// use Image;
// use Intervention\Image;


ini_set('memory_limit', -1);


class EditorController extends Controller
{
	protected $userPurchaseService;
	protected $paypalService;

	public function __construct(PayPalService $paypalService, UserPurchaseService $userPurchaseService)
	{
		$this->paypalService = $paypalService;
		$this->userPurchaseService = $userPurchaseService;
	}

	function home()
	{
		return redirect()->action(
			[CodeController::class, 'validateCode'],
			[]
		);
	}

	function demoTemplate($country, $template_key)
	{

		if ($country == 'mx') {
			$language_code = 'es';
		} else {
			$language_code = 'en';
		}

		$demo_as_id = Rand(100000, 999999);
		$user_role = 'customer';
		$purchase_code = 0;

		return view('editor', [
			'templates' => $template_key,
			'purchase_code' => $purchase_code,
			'demo_as_id' => $demo_as_id,
			'user_role' => $user_role,
			'language_code' => $language_code
		]);
	}

	function home1()
	{
		return view('home1', ['templates' => null]);
	}

	function product()
	{
		return view('product', ['templates' => null]);
	}

	function category()
	{
		return view('category', ['templates' => null]);
	}

	function getJSONTemplate($template_id, $language_code)
	{
		$template_key = 'template:' . $language_code . ':' . $template_id . ':jsondata';

		// print_r($template_key);
		// exit;

		if (App::environment() == 'local') {
			$template = str_replace('http://localhost', url('/'), Redis::get($template_key));
			$template = str_replace('http:\/\/localhost:8001', url('/'), $template);
			$template = str_replace('http:\/\/localhost', url('/'), $template);
			$template = str_replace('https:\/\/wayak.app', url('/'), $template);

			// echo "<pre>";
			// print_r( $template );
			// exit;
			// $template = str_replace('http:\\\/ \\\/wayak.app', url('/'), $template );

			// $template = json_decode($template);
			// if( isset($template[1]->background) ){
			// 	unset($template[1]->background);
			// }

			// echo "<pre>";
			// print_r( $template[1] );
			// exit;
			// $template = json_encode($template);

			return $template;
		} else {
			$template = str_replace('http://localhost', 'https:\/\/wayak-templates.s3.us-west-1.amazonaws.com', Redis::get($template_key));
			$template = str_replace('http:\/\/localhost:8001', 'https:\/\/wayak-templates.s3.us-west-1.amazonaws.com', $template);
			$template = str_replace('http:\/\/localhost', 'https:\/\/wayak-templates.s3.us-west-1.amazonaws.com', $template);

			return $template;
		}
	}

	function adminTemplateEditor($language_code, $template_key, Request $request)
	{

		$templates = $template_key;
		$demo_as_id = 0;
		$user_role = 'designer';
		$purchase_code = 9999;

		// echo $templates;
		// exit;
		// $language_code = 'es';

		return view('editor', [
			'templates' => $templates,
			'purchase_code' => $purchase_code,
			'demo_as_id' => $demo_as_id,
			'user_role' => $user_role,
			'language_code' => $language_code
		]);
	}

	function editPurchasedTemplate($country, Request $request)
	{
		echo "<pre>";
		print_r($country);
		exit;

		$purchase_code = $request['purchase_code'];
		$templates = $request['templates'];

		if ($purchase_code == '' or $templates == '') {
			return redirect()->action(
				[CodeController::class, 'validateCode'],
				[]
			);
		}

		$demo_as_id = rand(1, 999999);

		// echo "<pre>";
		// print_r($request->all());
		// print_r($templates);
		// exit;

		if (Redis::exists('code:' . $purchase_code) == true && Redis::get('code:' . $purchase_code) == $templates) {
			// echo "jiji";
			// exit;
			$demo_as_id = 0;
			$user_role = 'customer';

			return view('editor', [
				'templates' => $templates,
				'purchase_code' => $purchase_code,
				'demo_as_id' => $demo_as_id,
				'user_role' => $user_role
			]);
		}
		// if( Redis::exists('code:'.$purchase_code) == true && Redis::get('code:'.$purchase_code) == 0 ){

		// 	$demo_as_id = 0;
		// 	$user_role = 'customer';

		// 	return view('editor',[ 
		// 		'templates' => $templates, 
		// 		'purchase_code' => $purchase_code,
		// 		'demo_as_id' => $demo_as_id,
		// 		'user_role' => $user_role
		// 	]);

		// } else
		// if( $purchase_code == 'administrator' ){

		// 	$demo_as_id = 0;
		// 	$user_role = 'designer';
		// 	$purchase_code = 9999;

		// 	return view('editor',[ 
		// 		'templates' => $templates, 
		// 		'purchase_code' => $purchase_code,
		// 		'demo_as_id' => $demo_as_id,
		// 		'user_role' => $user_role
		// 	]);

		// } else {
		return redirect()->action(
			[CodeController::class, 'validateCode'],
			['templates' => $templates]
		);
		// }

		// echo Redis::get('code:'.$purchase_code);
		// exit;

	}

	function index(Request $request)
	{
		$template_urls = [];
		$templates = DB::table('d_templates')
			->select('id', 'template_id')
			->where('status', '=', 3)
			->orderBy('id', 'DESC')
			->limit(2)
			->get();

		// echo "<pre>";
		// print_r($templates);
		// exit;

		foreach ($templates as $template) {
			array_push($template_urls, 'http://localhost/open?templates=' . $template->template_id);
		}

		// echo "<pre>";
		// print_r($template_urls);
		// exit;

		return view('index', ['template_urls' => $template_urls]);
	}

	function open(Request $request)
	{
		$templates = $request['templates'];
		return view('editor', ['templates' => $templates]);
	}

	function convertPXtoIn($pixels)
	{
		return round($pixels / 96);
	}

	function randomNumber($length = 15)
	{
		// // $length = 15;
		// $result = '';

		// for($i = 0; $i < $length; $i++) {
		// 	$result .= mt_rand(0, 9);
		// }

		// return $result;

		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return substr(str_shuffle($permitted_chars), 0, $length);
	}

	function update(Request $request)
	{

		$template_obj = json_decode($request->jsonData);
		$template_dimensions = $this->convertPXtoIn($template_obj[1]->cwidth) . 'x' . $this->convertPXtoIn($template_obj[1]->cheight) . ' in';
		$template_id = $request->templateid;
		$language_code = $request->language_code;

		// Its temporal user template
		if (strpos($template_id, 'temp') === false) {

			$templateDocument = Template::where('_id', '=', $template_id)->first();
			// $templateDocument->previewImageUrls;
			// $templateDocument->save();

			// echo "<pre>";
			// print_r( $template->previewImageUrls );
			// exit;

			// Check if 'previewImageUrls' is set and is an array
			if (isset($templateDocument->previewImageUrls) && is_array($templateDocument->previewImageUrls)) {
				$existingFileNames = [
					'carousel' => $templateDocument->previewImageUrls['carousel'],
					'grid' => str_replace('carousel', 'grid', $templateDocument->previewImageUrls['carousel']),
					'large' => $templateDocument->previewImageUrls['large'],
					'product_preview' => $templateDocument->previewImageUrls['product_preview'],
					'thumbnail' => $templateDocument->previewImageUrls['thumbnail']
				];
				$thumbStatus = 1;
			} else {
				$existingFileNames = [
					'carousel' => null,
					'grid' => null,
					'large' => null,
					'product_preview' => null,
					'thumbnail' => null
				];
				$thumbStatus = 999;
			}

			$this->deleteCurrentThumbnails($template_id, $language_code);
			$thumbnail_imgs = $this->createThumbnailFiles($request->pngimageData, $template_id, $language_code, $existingFileNames);
			// exit;

			$thumbnail_info = [
				'filename' => $thumbnail_imgs['thumbnail'],
				'language_code' => $language_code,
				'template_id' => $template_id,
				'dimentions' => $template_dimensions,
				'status' => 1
			];


			$this->updateThumbnailsOnDB($thumbnail_info);

			// Redis::set('product:format_ready:'.$template_id, 1);
			// if( $language_code != 'en' ){
			// echo "aqui >> $template_id";
			// exit;

			DB::table('thumbnails')
				->where('template_id', '=', $template_id)
				->where('language_code', '=', $language_code)
				->update([
					// 'translation_ready' => true,
					// 'format_ready' => true,
					'status' => $thumbStatus,
					'thumbnail_ready' => true
				]);
			// Redis::set('product:thumbnail_ready:'.$template_id, 1);
			// }
		}

		// exit;
		// echo "<pre>";
		// print_r( $template_id );
		// print_r( $thumbnail_info );
		// exit;

		// $this->storeJSONTemplate($template_id, $language_code, json_encode($template_obj));

		$response = [
			'id' => $template_id,
			'err' => 0,
			'msg' => 'Update exitoso'
		];

		return json_encode($response);
	}

	function uploadImage(Request $request)
	{

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
			$name = Str::slug('ejemplo_' . time());
			// Define folder path
			$folder = '/design/template/ejemplo/';
			// Make a file path where image will be stored [ folder path + file name + file extension]
			$filePath = $folder . $name . '.' . $image->getClientOriginalExtension();
			// Upload image
			$this->uploadOne($image, $folder, 'public', $name);
			$response = [
				"id" => 1,
				"msg" => 'Hola Mundo',
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

		$file = $uploadedFile->storeAs($folder, $name . '.' . $uploadedFile->getClientOriginalExtension(), $disk);
		// echo $folder;
		// echo $name;
		return $file;
	}

	function getUploadedImage($image_resource_id)
	{
		return json_encode([
			'success' => true,
			'img' => asset('design/template/ejemplo/5a2fb0dbd8141396fe9b528b.svg')
		]);
	}

	function saveAs(Request $request)
	{
		$png_base64_thumb_data = $request['pngimageData'];

		$template_json = json_decode($request->jsonData);
		$template_dimensions = $this->convertPXtoIn($template_json[1]->cwidth) . 'x' . $this->convertPXtoIn($template_json[1]->cheight) . ' in';
		$template_id = $this->randomNumber(20);
		// $collection_id = $request->tmp_templates;

		// Crreate thumbnail file, from base64 encoded data
		$thumbnail_paths = $this->createThumbnailFiles($png_base64_thumb_data, $template_id, '', null);

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

		$this->registerThumbnailsOnDB($thumbnail_info);
		$this->registerNewTemplate($template_id, $template_config, $template_json);
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

	function registerNewTemplate($template_id, $template_config, $template_json)
	{
		$template_id_query = DB::table('templates')
			->select('template_id')
			->where('template_id', '=', $template_id)
			->first();

		// echo "<pre>";
		// print_r($template_id_query);
		// exit;

		// If template does not exists on db
		if (
			isset($template_id_query->template_id) == false
			&& isset($template_json)
			&& is_array($template_json)
			&& is_object($template_json[1])
		) {

			// echo "<pre>";
			// print_r("TEMPLATE ID NO EXISTE PREVIAMENTE");
			// print_r($template_config);
			// exit;

			// if(  ){
			$template_info = $this->generateTemplateMetadata($template_id, $template_config);

			$template_json = json_encode($template_json);
			$template_json = str_replace('https:\/\/dbzkr7khx0kap.cloudfront.net\/', 'http:\/\/localhost\/design\/template\/' . $template_id . '\/assets\/', $template_json);
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
				if ($object->type == 'image') {
					// echo '<br>'.$object->src;
					$this->registerImagesOnDB($object->src, $template_info['templateid']);
				} elseif ($object->type == 'path' && isset($object->src)) {
					// echo '<br>'.$object->src;
					$this->registerSVGsOnDB($object->src, $template_info['templateid']);
				} elseif ($object->type == 'textbox') {
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
			$this->storeJSONTemplate($template_id, json_encode($template_json));

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

	private function generateTemplateMetadata($template_id, $template_config)
	{
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

	private function storeJSONTemplate($template_id, $language_code, $json_data)
	{
		$template_key = 'template:' . $language_code . ':' . $template_id . ':jsondata';
		Redis::set($template_key, $json_data);
	}

	function registerDemoAsIDOnDB($username, $demo_as_id)
	{

		DB::table('tmp_demo_as_id')->insert([
			'id' => null,
			'username' => $username,
			'demo_as_id' => $demo_as_id
		]);
	}

	function registerAssetOnDB($file_name, $template_path, $template_id)
	{
		DB::table('images')->insert([
			'id' => null,
			'template_id' => $template_id,
			'tmp_path' => $template_path,
			'filename' => $file_name,
			'status' => 0 // Estado inicial, metadatos extraidos de etsy
		]);
	}

	function registerImagesOnDB($url, $template_id)
	{
		$diagonal = strripos($url, '/') + 1;
		$file_name = substr($url, $diagonal, strlen($url));

		$images_query = DB::table('images')
			->select('template_id')
			->where('template_id', '=', $template_id)
			->where('filename', '=', $file_name)
			->first();

		// If this image does not exists on db
		if (isset($images_query->template_id) == false) {
			$path = 'design/template/images/' . $template_id;
			$this->registerAssetOnDB($file_name, $path . '/' . $file_name, $template_id);
		}
	}

	function registerSVGsOnDB($url, $template_id)
	{

		$diagonal = strripos($url, '/') + 1;
		$file_name = substr($url, $diagonal, strlen($url));

		$svg_query = DB::table('images')
			->select('template_id')
			->where('template_id', '=', $template_id)
			->where('filename', '=', $file_name)
			->first();

		// If font id does not exists on db
		if (isset($svg_query->template_id) == false) {
			$path = 'design/template/images/' . $template_id;
			$this->registerAssetOnDB($file_name, $path . '/' . $file_name, $template_id);
		}
	}

	function registerFontsOnDB($font_id, $template_id)
	{

		// Check if font/template relationship already exist
		$relationship_query = DB::table('template_has_fonts')
			->select('template_id')
			->where('template_id', '=', $template_id)
			->where('font_id', '=', $font_id)
			->first();

		// Create relationship between font and template, if it does not exists
		if (isset($relationship_query->template_id) == false) {
			$this->createFontTemplateRelationship($font_id, $template_id);
		}

		$font_query = DB::table('fonts')
			->select('font_id')
			->where('font_id', '=', $font_id)
			->first();

		// If font id does not exists on db
		if (isset($font_query->font_id)) {
			// Update rest of templates to avoid double download
			DB::table('template_has_fonts')
				->where('font_id', $font_id)
				->update(['status' => 1]);
		}
	}

	function createFontTemplateRelationship($font_id, $template_id)
	{
		DB::table('template_has_fonts')->insert([
			'id' => null,
			'template_id' => $template_id,
			'font_id' => $font_id,
			'status' => 0
		]);
	}

	function saveTemplateOnDB($template_info)
	{
		$template_id_query = DB::table('templates')
			->select('template_id')
			->where('template_id', '=', $template_info['templateid'])
			->first();

		// If font id does not exists on db
		if (isset($template_id_query->template_id) == false) {
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

	function createThumbnailFiles($image_data, $template_id, $language_code, $existingFileNames)
	{
		$croppie_code = $image_data;

		if (preg_match('/^data:image\/(\w+);base64,/', $croppie_code, $type)) {

			$encoded_base64_image = substr($croppie_code, strpos($croppie_code, ',') + 1);
			$decoded_image = base64_decode($encoded_base64_image);
			$img = \Image::make($decoded_image);
			$img_path = 'design/template/' . $template_id . '/thumbnails/' . $language_code . '/';
			$path = public_path($img_path);

			@mkdir($path, 0777, true);

			// Use the existing filenames from the MongoDB document
			$full_thumbnail_path = public_path($img_path . $existingFileNames['large']);
			$img->save($full_thumbnail_path);

			// Product Preview Thumbnail
			$img->resize(null, 600, function ($constraint) {
				$constraint->aspectRatio();
			});
			$product_preview_thumbnail_path = public_path($img_path . $existingFileNames['product_preview']);
			$img->save($product_preview_thumbnail_path);

			// Create Carousel Thumbnail
			$img->resize(null, 400, function ($constraint) {
				$constraint->aspectRatio();
			});
			$carousel_thumbnail_path = public_path($img_path . $existingFileNames['carousel']);
			$img->save($carousel_thumbnail_path);

			// Create Grid Thumbnail
			$img->resize(335, null, function ($constraint) {
				$constraint->aspectRatio();
			});
			$carousel_thumbnail_path = public_path($img_path . $existingFileNames['grid']);
			$img->save($carousel_thumbnail_path);

			// Create mini thumbnail
			$img->resize(278, 360, function ($constraint) {
				$constraint->aspectRatio();
			});
			$full_minithumbnail_path = public_path($img_path . $existingFileNames['thumbnail']);
			$img->save($full_minithumbnail_path);

			return [
				'thumbnail' => $existingFileNames['thumbnail'],
				'preview' => $existingFileNames['large']
			];
		}
	}


	function updateThumbnailsOnDB($template_info)
	{
		// print_r($template_info);
		// exit;

		$thumbnail = DB::table('thumbnails')
			->select('id')
			->where('template_id', '=', $template_info['template_id'])
			->where('language_code', '=', $template_info['language_code'])
			->first();

		if (isset($thumbnail->id) != false) {
			DB::table('thumbnails')
				->where('template_id', '=', $template_info['template_id'])
				->where('language_code', '=', $template_info['language_code'])
				->update([
					'filename' => $template_info['filename'],
					'dimentions' => $template_info['dimentions'],
					'status' => 1
				]);
			return true;
		} else {
			DB::table('thumbnails')->insert([
				'id' => null,
				'template_id' => $template_info['template_id'],
				'title' => 'Invitation',
				'filename' => $template_info['filename'],
				'tmp_original_url' => null,
				'language_code' => $template_info['language_code'],
				'dimentions' => $template_info['dimentions'],
				// 'tmp_templates' => $template_info['template_id'],
				'status' => 1
			]);
		}

		return false;
	}

	function registerThumbnailsOnDB($template_info)
	{
		$thumbnail = DB::table('thumbnails')
			->select('id')
			->where('template_id', '=', $template_info['template_id'])
			->first();

		if (isset($thumbnail->id) == false) {
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

	function deleteCurrentThumbnails($template_id, $language_code)
	{
		$thumbnail = DB::table('thumbnails')
			->select('filename')
			->where('template_id', '=', $template_id)
			->where('language_code', '=', $language_code)
			->first();

		if (isset($thumbnail->filename)) {

			$img_folder = 'design/template/' . $template_id . '/thumbnails/' . $language_code . '/';
			$img_path = $img_folder . $thumbnail->filename;

			$thumbnail_path = public_path($img_path);
			$mini_thumbnail_path = str_replace('_thumbnail.jpg', '_large.jpg', $thumbnail_path);

			if (is_file($thumbnail_path)) {
				unlink($thumbnail_path);
			}

			if (is_file($mini_thumbnail_path)) {
				unlink($mini_thumbnail_path);
			}
		}

		$this->emptyFolder($img_folder);
	}

	function emptyFolder($dir)
	{
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (filetype($dir . "/" . $object) == "dir") {
						$this->emptyFolder($dir . "/" . $object); // Recurse into subdirectories
					} else {
						unlink($dir . "/" . $object); // Delete files
					}
				}
			}
			reset($objects);
		}
	}

	function getTemplateThumbnails(Request $request)
	{
		$templateKeys = str_replace('temp:', '', $request->demo_templates);
		$purchaseCode = str_replace('temp:', '', $request->demo_templates);
		$languageCode = $request->language_code;
		$customerId = $request->customerId;

		// Fetch template IDs
		$templateIds = Redis::hget('wayak:user:' . $customerId . ':purchases:' . $purchaseCode, 'template_key') ? Redis::hget('wayak:user:' . $customerId . ':purchases:' . $purchaseCode, 'template_key') : $templateKeys;

		if (!$templateIds) {
			return response()->json(['success' => false, 'message' => 'Template IDs not found.']);
		}

		// Fetch thumbnail
		$thumbnail = DB::table('thumbnails')
			->select(['template_id', 'filename', 'title', 'dimentions'])
			->where('language_code', '=', $languageCode)
			->whereIn('template_id', explode(',', $templateIds))
			->first();

		if (!$thumbnail) {
			return response()->json(['success' => false, 'message' => 'Thumbnail not found.']);
		}

		// Determine image URL
		$imgUrl = App::environment('local') ?
			url('design/template/' . $thumbnail->template_id . '/thumbnails/' . $languageCode . '/' . $thumbnail->filename) :
			Storage::disk('s3')->url('design/template/' . $thumbnail->template_id . '/thumbnails/' . $languageCode . '/' . $thumbnail->filename);

		// Construct response data
		$responseData = [
			'success' => true,
			'data' => [
				[
					'template_id' => $templateKeys,
					'order_id' => '0',
					'uid' => mt_rand(100000, 999999),
					'template_name' => $this->escapeForJson($thumbnail->title),
					// 'canvas_thumbnail' => '',
					// 'canvas_json' => '',
					// 'original_thumbnail' => '',
					// 'original_json' => '',
					'tags' => 'pampas grass',
					'format' => 'new',
					// 'preview_s3key' => 'thumbs/401481_1604309596_preview.jpeg',
					// 'original_preview_s3key' => 'thumbs/401481_1604309596_preview.jpeg',
					// 'original_thumb_s3key' => 'thumbs/401481_1604309596.png',
					// 'thumb_s3key' => 'thumbs/401481_1604309596.png',
					// 'options' => '{"width":480,"height":672,"metrics":"in","type":"single","instructionsId":"","scriptVersion":4}',
					// 'canvas_json_s3url' => 'https://templett.s3.us-west-1.amazonaws.com/templates/5378270.json',
					// 'original_json_s3url' => 'https://templett.s3.us-west-1.amazonaws.com/templates/5378270_original.json',
					'status' => 'active',
					// 'creation_date' => null,
					// 'expiration_date' => null,
					// 'granted_by_uid' => '0',
					'download_number' => '0',
					'width' => 5,
					'height' => 7,
					'metrics' => 'in',
					'temp_source' => $imgUrl
				]
			]
		];

		return response()->json($responseData);
	}


	function escapeForJson($string)
	{
		// Use json_encode to escape the string
		$escapedString = json_encode($string);
		// Strip the surrounding quotes added by json_encode
		// $escapedString = trim($escapedString, '"');
		// echo $escapedString;
		// exit;

		return $escapedString;
	}

	function loadAdditionalAssets()
	{
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

	function getBackgroundImages()
	{
		return '{"err":0,"data":[{"id":"15783","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1551377633.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1551377633.png","isownitem":"own","name":"Ombre Blush Pink Peach Background"},{"id":"11718","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1543510433.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1543510433.png","isownitem":"own","name":"Christmas Candy Cane BG"},{"id":"11634","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1543332034.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1543332034.png","isownitem":"own","name":"Gold Foil"},{"id":"7859","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1535289181.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1535289181.png","isownitem":"own","name":"Linen Background"},{"id":"7857","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1535288961.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1535288961.png","isownitem":"own","name":"Canvas Background"},{"id":"7856","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1535288921.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1535288921.png","isownitem":"own","name":"Watercolor Paper"},{"id":"7855","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1535288842.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1535288842.png","isownitem":"own","name":"Watercolor Paper"},{"id":"7854","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1535288720.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1535288720.png","isownitem":"own","name":"Watercolor Paper"},{"id":"7610","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1534723194.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1534723194.png","isownitem":"own","name":"Unicorn Background"},{"id":"7045","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1533408670.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1533408670.png","isownitem":"own","name":"Eucalyptus Background Pattern"},{"id":"6695","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532705763.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532705763.png","isownitem":"own","name":"Art Deco Gatsby Back"},{"id":"6536","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532405555.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532405555.png","isownitem":"own","name":"Baby First"},{"id":"6526","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532391374.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532391374.png","isownitem":"own","name":"Watercolor Wood Background"},{"id":"6518","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532389975.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532389975.png","isownitem":"own","name":"Watercolor Background"},{"id":"6484","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532297507.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532297507.png","isownitem":"own","name":"Black Stripes + Peonies Background"},{"id":"6483","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532297187.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532297187.png","isownitem":"own","name":"Beige watercolor ombre background"},{"id":"6482","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532295457.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532295457.png","isownitem":"own","name":"Black Stripes + Peonies"},{"id":"6481","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532294695.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532294695.png","isownitem":"own","name":"Under The Sea - Back"},{"id":"6480","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532294425.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532294425.png","isownitem":"own","name":"Under The Sea - Text Optimized"},{"id":"6478","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532294293.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532294293.png","isownitem":"own","name":"Under The Sea - No Bleed"},{"id":"6458","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532275816.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532275816.png","isownitem":"own","name":"B&W Couple"},{"id":"6457","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532275672.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532275672.png","isownitem":"own","name":"Background Couple Photo"},{"id":"6439","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/173355_1532220748.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/173355_1532220748.png","isownitem":"own","name":"White Muted Painted Background"},{"id":"2848","url":"https:\/\/dbzkr7khx0kap.cloudfront.net\/1_1518631904.jpg","thumb":"https:\/\/dbzkr7khx0kap.cloudfront.net\/thumbs\/1_1518631904.png","isownitem":"not-own","name":"Old Paper Wrinkled"}],"query":"SELECT * FROM background WHERE userid IN(1,173355)  ORDER BY userid=\'173355\' DESC, id DESC LIMIT 0, 24"}';
	}

	function loadSettings()
	{
		return '{"err":1,"msg":"Not allowed"}';
	}

	function loadTemplate(Request $request)
	{

		$purchaseCode = isset($request['id']) ? $request['id'] : null;
		$customerId = $request->customerId;
		$demoAsId = $request->demo_as_id;
		$remainingDownloads = intval(Redis::hget('wayak:user:' . $customerId . ':purchases:' . $purchaseCode, 'remaining_downloads'));

		// if($remainingDownloads > 0 || (intval($demoAsId) > 0)){
		$templateIds = Redis::hget('wayak:user:' . $customerId . ':purchases:' . $purchaseCode, 'template_key') ? Redis::hget('wayak:user:' . $customerId . ':purchases:' . $purchaseCode, 'template_key') : $request['id'];
		$language_code = isset($request['language_code']) ? $request['language_code'] : 'en';
		$array_final = $this->getJSONTemplate($templateIds, $language_code);

		return response()->json(
			array(
				'err' => 0,
				'data' => $array_final,
				'metrics' => 'in',
				'options' => "{\"width\":1728,\"height\":2304,\"metrics\":\"in\",\"type\":\"single\",\"instructionsId\":\"80\",\"scriptVersion\":4}",
				'instructions' => ""
			)
		);
		// } else {
		// 	return response()->json(
		// 		array(
		// 			'err' => 1,
		// 			// 'data' => '',
		// 			'msg' => 'This item is no longer available',
		// 			// 'metrics' => '',
		// 			// 'options' => '',
		// 			// 'instructions' => ''
		// 		)
		// 	);
		// }

	}

	function loadRemainingDownloads($purchaseCode, Request $request)
	{
		$customerId = $request->customerId;
		$remainingDownloads = Redis::hget('wayak:user:' . $customerId . ':purchases:' . $purchaseCode, 'remaining_downloads') ? Redis::hget('wayak:user:' . $customerId . ':purchases:' . $purchaseCode, 'remaining_downloads') : $request['id'];

		return response()->json([
			'success' => true,
			'msg' => 'No downloads remaining',
			'limit' => 10,
			'remaining' => intval($remainingDownloads)
		]);
	}

	function getUploadedImages($limit_image, $load_count)
	{

		// return response()->json([
		// 	'success' => true,
		// 	'msg' => 'No downloads remaining',
		// 	'limit' => 10,
		// 	'remaining' => 0
		// ]);
		echo '{"success":true,"images":[]}';
	}


	function getRelatedProducts($templateId_related, Request $request)
	{

		// return response()->json([
		// 	'success' => true,
		// 	'msg' => 'No downloads remaining',
		// 	'limit' => 10,
		// 	'remaining' => 0
		// ]);
		echo '{"success":true,"products":[],"page":"0","total":[]}';
	}

	function getBackgrounds(Request $request)
	{

		// return response()->json([
		// 	'success' => true,
		// 	'msg' => 'No downloads remaining',
		// 	'limit' => 10,
		// 	'remaining' => 0
		// ]);
		echo '{"success":true,"data":[]}';
	}

	function getWoffFontUrl(Request $request)
	{
		// {"success":true,"url":"https:\/\/templett.com\/design\/fonts_new\/KG_Second_Chances_Solid_1537862439.woff"}
		$success = false;
		$font_url = null;

		if (isset($request->font_id)) {
			$font_id = $request->font_id;

			$font_info = DB::table('fonts')
				->select('name')
				->where('font_id', '=', $font_id)
				->where('status', '=', 1)
				->first();

			// echo "<pre>";
			// print_r($font_info);
			// exit;

			if (isset($font_info->name)) {
				$success = 'true';
				$font_url = url('design/fonts_new/' . $font_info->name);
			}

			return json_encode(array(
				'success' => $success,
				'url' => $font_url,
				'msg' => '',
			));
		}
	}

	function checkAllowRevertTemplate()
	{
		return '{"access":true}';
	}

	function getCSSFonts(Request $request)
	{
		$templates = urldecode($request->templates);

		// print_r($templates);
		// // print_r(json_decode($templates));
		// exit;

		$values = array();
		$response = "";

		// $templates = explode(",", $templates);
		// $templates = "'".implode("','", $templates)."'";

		if (
			isset($request->templates) && is_array(json_decode($templates))
			|| strpos(json_decode($templates), "font") !== false
		) {

			if (is_array(json_decode($templates))) {
				$templates = "'" . implode("','", json_decode($templates)) . "'";
			}

			$font_families = DB::Table('fonts')
				->select(['font_id', 'name'])
				->whereRAW('font_id IN(' . $templates . ')')
				->get();


			// header("Content-type: text/css");
			foreach ($font_families as $font) {
				$font_url = url('design/fonts_new/' . $font->name);

				$response .= '@font-face {
					font-family:\'' . $font->font_id . '\';
					src:url(\'' . $font_url .
					'\') format(\'woff\');
				}';
			}

			return (new Response($response, 200))
				->header('Content-Type', "text/css");
		}
	}

	function generatePDF(Request $request)
	{

		// if ($_SERVER['REQUEST_METHOD']=='OPTIONS') {
		// 	header('Access-Control-Allow-Origin : *');
		// 	header('Access-Control-Allow-Methods : POST, GET, OPTIONS, PUT, DELETE');
		// 	header('Access-Control-Allow-Headers : X-Requested-With, content-type');
		// }

		// Writes SVG on disk
		$svg_content = json_decode($request['jsonData']);

		File::put(public_path('example.svg'), $svg_content);

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
		$data = ['base64' => $base64];

		// PAPER SIZES
		// dompdf/dompdf/src/Adapter/CPDF.php
		$pdf = PDF::loadView('pdf_view', $data)
			->setPaper('a4', 'landscape')
			->save(public_path('invitation.pdf'));

		// $file_to_save = public_path('invitation.pdf');
		// file_put_contents($file_to_save, $pdf->output());

		$response = [
			'data' => 'invitation.pdf',
			'success' => true
			// 'msg' => 'Ajuuua'
		];

		return json_encode($response);
	}

	function downloadPDF(Request $request)
	{
		$path = public_path('invitation.pdf');

		header("Content-Type: application/octet-stream");
		// http response headers to set composition and file to download
		header('Content-Disposition: attachment; filename="' . $request->filename . '"');
		// The length of the requested file need to download
		header("Content-Length: " . filesize($path));
		// Reads a file and writes it to the output buffer.
		readfile($path);
	}

	function registerTemplateDownload(Request $request)
	{
		$language_code = 'en';
		// echo "<pre>";
		// print_r($request->all());
		// exit;
		// DB::table('orders')->insert([
		// 	'template_id' => $request->templateId,
		// 	'filetype' => $request->filetype,
		// 	'option' => $request->option,
		// 	'purchase_code' => $request->purchase_code
		// ]);

		// $template_key = Redis::get('temp:template:relation:' . $request->templateId);

		$customerId = $request->customerId;
		$purchaseCode = $request->templateId;
		$templateKey = Redis::hget('wayak:user:' . $customerId . ':purchases:' . $purchaseCode, 'template_key');
		$expires_at = Redis::hget('wayak:user:' . $customerId . ':purchases:' . $purchaseCode, 'expires_at');
		$remaining_downloads = Redis::hget('wayak:user:' . $customerId . ':purchases:' . $purchaseCode, 'remaining_downloads') - 1;

		if (Redis::hexists('analytics:btn:download', $templateKey)) {
			Redis::hincrby('analytics:btn:download', $templateKey, 1);
		} else {
			Redis::hset('analytics:btn:download', $templateKey, 1);
		}

		// Once user downloads template, code is removed to avoid multiple usages

		Redis::hincrby('wayak:user:' . $customerId . ':purchases:' . $purchaseCode, 'remaining_downloads', -1);
		$successResponse = true;

		if ($remaining_downloads == 0) {
			// } else {
			// $successResponse = false;
			Redis::del('code:' . $purchaseCode);
			Redis::del('template:' . $language_code . ':temp:' . $purchaseCode . ':jsondata');
			Redis::srem('wayak:user:' . $customerId . ':purchases', $templateKey);
		}

		return response()->json([
			'success' => $successResponse,
			'msg' => 'No downloads remaining',
			'limit' => 3,
			'remaining' => $remaining_downloads
		]);
	}

	private function getCustomerId(Request $request)
	{
		// Cache authenticated user
		$user = auth()->user();

		if ($user) {
			return $user->customer_id;
		}

		// $customerId = $request->input('customer_id');
		// print_r($request->all());
		// exit;
		if ($request->customerId) {
			return $request->customerId;
		}

		return false;
	}

	function openTemplate($country, Request $request, $template_key)
	{
		if ($country == 'mx') {
			$language_code = 'es';
		} else {
			$language_code = 'en';
		}

		$purchase_code = rand(1111, 9999);


		$original_template_key = $template_key;
		// echo $original_template_key; exit;

		// http://localhost:8001/us/template/open/sjilZYwA1V?customerId=gq9mm31pti
		$customerId = $this->getCustomerId($request);
		echo $customerId;
		if ($this->userPurchaseService->isTemplateIdInPurchases($customerId, $template_key) == false) {
			abort(404);
		}

		$temporal_customer_key = 'temp:' . $purchase_code;

		// Register action on edit template button
		if (Redis::hexists('analytics:btn:edit', $template_key)) {
			Redis::hincrby('analytics:btn:edit', $template_key, 1);
		} else {
			Redis::hset('analytics:btn:edit', $template_key, 1);
		}

		$expiresAt = 60 * 60 * 24 * 1; // Codigo valido por 30 dias - 60*60*24*30 = 2592000

		// // Redis::set('temp:template:relation:temp:' . $purchase_code, $original_template_key);
		// // Redis::expire('temp:template:relation:temp:' . $purchase_code, $expiresAt ); 

		// Clone original template into a temporal key for user usage.
		Redis::set('template:' . $language_code . ':' . $temporal_customer_key . ':jsondata', Redis::get('template:' . $language_code . ':' . $original_template_key . ':jsondata'));
		Redis::expire('template:' . $temporal_customer_key . ':jsondata', $expiresAt); // Codigo valido por 30 dias - 60*60*24*30 = 2592000

		// Stores purchase info
		Redis::hset('wayak:user:' . $customerId . ':purchases:' . $purchase_code, 'template_key', $original_template_key);
		Redis::hset('wayak:user:' . $customerId . ':purchases:' . $purchase_code, 'expires_at', $expiresAt);
		Redis::hset('wayak:user:' . $customerId . ':purchases:' . $purchase_code, 'remaining_downloads', 3);

		// Redis::get('template:'.$language_code.':'.$original_template_key.':jsondata')

		// echo $original_template_key;
		// echo "<br>";
		// echo $temporal_customer_key;
		// exit;

		// Redis::set('code:'.$purchase_code, $temporal_customer_key);
		// Redis::expire('code:'.$purchase_code, 2592000); // Codigo valido por 30 dias - 60*60*24*30 = 2592000

		return redirect()
			->route('editor.editTemplate', [
				'country' => $country,
				'template_key' => $temporal_customer_key
			]);
	}

	function editTemplate($country, $template_key)
	{

		if ($country == 'mx') {
			$language_code = 'es';
		} else {
			$language_code = 'en';
		}

		// echo 'template:' . $language_code . ':' . $template_key . ':jsondata';
		// exit;

		if (Redis::exists('template:' . $language_code . ':' . $template_key . ':jsondata') == false) {
			abort(404);
			// return response()->json([
			// 	'success' => false,
			// 	'msg' => 'Template does not exists'
			// ]);
		}

		$templates = $template_key;
		$demo_as_id = 0;
		$user_role = 'designer';
		$purchase_code = 9999;

		return view('editor', [
			'templates' => $templates,
			'purchase_code' => $purchase_code,
			'demo_as_id' => $demo_as_id,
			'user_role' => $user_role,
			'language_code' => $language_code
		]);
	}

	function createPdfWithBackgroundImage(Request $request)
	{
		// Retrieve the data from the request
		$base64Image = $request->input('jpgImageData');
		$widthInPixels = $request->input('canvasWidth');
		$heightInPixels = $request->input('canvasHeight');
		$requestId = $request->input('requestId');
		$trimsMarks = $request->input('trimsMarks', false); // Default to false if not provided
		$savePaper = filter_var($request->input('savePaper', false), FILTER_VALIDATE_BOOLEAN);
		$pageSize = $request->input('pageSize', 'us-letter');

		// Paper dimensions in points (width x height)
		$paperDimensions = [
			'us-letter' => [612, 792],
			'a4' => [595, 842]
		];

		// Get the dimensions for the selected paper size
		list($paperWidth, $paperHeight) = $paperDimensions[$pageSize] ?? $paperDimensions['us-letter'];

		if ($savePaper) {
			$widthInPoints = $paperWidth;
			$heightInPoints = $paperHeight;

			$imageWidthInPoints = ($widthInPixels / 96) * 72;
			$imageHeightInPoints = ($heightInPixels / 96) * 72;
			// Calculate how many images fit on one page horizontally and vertically
			$imagesPerRow = floor($widthInPoints / $imageWidthInPoints);
			$imagesPerColumn = floor($heightInPoints / $imageHeightInPoints);
		} else {
			// Convert pixels to inches assuming 96 DPI, then convert inches to points for DOMPDF
			$widthInPoints = ($widthInPixels / 96) * 72;
			$heightInPoints = ($heightInPixels / 96) * 72;
		}


		// echo $imagesPerRow;
		// echo '--';
		// echo $imagesPerColumn;
		// exit;

		// Check if trim marks are requested
		$trimMarksHtml = '';
		if (filter_var($trimsMarks, FILTER_VALIDATE_BOOLEAN)) {
			// Add HTML/CSS for trim marks. Adjust the styling as needed.
			$trimMarksHtml = <<<HTML
			<div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; box-sizing: border-box;">
				<div style="position: absolute; top: -10px; left: 0; right: 0; height: 20px; background-color: transparent; border-top: 1px solid black; border-bottom: 1px solid black;"></div>
				<div style="position: absolute; top: 0; left: -10px; bottom: 0; width: 20px; background-color: transparent; border-left: 1px solid black; border-right: 1px solid black;"></div>
				<div style="position: absolute; bottom: -10px; left: 0; right: 0; height: 20px; background-color: transparent; border-top: 1px solid black; border-bottom: 1px solid black;"></div>
				<div style="position: absolute; top: 0; right: -10px; bottom: 0; width: 20px; background-color: transparent; border-left: 1px solid black; border-right: 1px solid black;"></div>
			</div>
			HTML;
		}

		// If savePaper is true and more than one image can fit on a page, adjust calculations
		if ($savePaper && ($imagesPerRow > 1 || $imagesPerColumn > 1)) {
			// HTML content for multiple images
			$htmlContent = '<!DOCTYPE html><html><head><style>';
			$htmlContent .= 'body, html { margin: 0; padding: 0; width: ' . $widthInPoints . 'px; height: ' . $heightInPoints . 'px; }';
			$htmlContent .= '.image { width: ' . $widthInPixels . 'px; height: ' . $heightInPixels . 'px; background-size: contain; background-repeat: no-repeat; background-position: center; }';
			$htmlContent .= '</style></head><body>';

			for ($row = 0; $row < $imagesPerColumn; $row++) {
				for ($col = 0; $col < $imagesPerRow; $col++) {
					$leftPosition = $col * $widthInPoints;
					$topPosition = $row * $heightInPixels;
					$htmlContent .= "<div class='image' style='position: absolute; left: ${leftPosition}px; top: ${topPosition}px; background-image: url(\"{$base64Image}\");'></div>";
				}
			}

			$htmlContent .= '</body></html>';
		} else {
			// Generate the HTML content
			$htmlContent = <<<HTML
							<!DOCTYPE html>
							<html>
							<head>
							<style>
								body, html {
									margin: 0;
									padding: 0;
									background-image: url('{$base64Image}');
									background-size: cover;
									background-repeat: no-repeat;
									position: relative;
									height: 100%;
								}
							</style>
							</head>
							<body>
								$trimMarksHtml
							</body>
							</html>
							HTML;
		}

		// Initialize dompdf
		$options = new \Dompdf\Options();
		$options->setDpi(96);
		$dompdf = new \Dompdf\Dompdf($options);
		$dompdf->loadHtml($htmlContent);

		// Set paper size in points for a 5x7 inch document
		$dompdf->setPaper(array(0, 0, $widthInPoints, $heightInPoints));

		// Render the HTML as PDF
		$dompdf->render();

		// Define the PDF file path within the "temp" folder in the public directory
		$pdfFileName = 'doc_' . uniqid() . '.pdf';
		$pdfFilePath = public_path('temp/' . $pdfFileName);

		// Ensure the "temp" directory exists
		if (!file_exists(public_path('temp'))) {
			mkdir(public_path('temp'), 0777, true);
		}

		// Save the PDF to a file
		file_put_contents($pdfFilePath, $dompdf->output());

		// Check if file was saved successfully
		if (file_exists($pdfFilePath)) {
			$success = true;
			$fileUrl = url('temp/' . $pdfFileName);
			$message = "Your PDF is Ready";
		} else {
			$success = false;
			$fileUrl = null;
			$message = "Please try again";
		}

		// Return JSON response
		return response()->json([
			'success' => $success,
			'file' => $fileUrl,
			'msg' => $message,
			'requestId' => $requestId,
		]);
	}
}
