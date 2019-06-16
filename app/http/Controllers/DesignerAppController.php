<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;

use SVG\SVG;
// use Image;

use SVG\Nodes\Shapes\SVGCircle;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class DesignerAppController extends Controller
{
	function getJSONTemplate($template_id){
		$template_key = 'template:'.$template_id.':jsondata';
		//  Redis::get($template_key);
		return str_replace('http://localhost:8000/design/','http://localhost/design/', Redis::get($template_key) );
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
		
		// $png_image_data = ;
		$template_data = json_decode( $request->jsonData );
		$template_dimensions = $this->convertPXtoIn( $template_data[1]->cwidth ).'x'.$this->convertPXtoIn($template_data[1]->cheight).' in';
		// $prefix_filename = $this->randomNumber();
		$template_id = $request->templateid;
		$collection_id = $template_id;
		
		$template_info = [
			'title' => $template_dimensions,
			'filename' => $template_id,
			'template_id' => $template_id,
			'tmp_original_url' => null,
			'dimentions' => $template_dimensions,
			'tmp_templates' => $collection_id,
			'status' => 1
		];

		// echo "<pre>";
		// print_r( $request->all() );
		// exit;

		// echo "<pre>";
		// print_r( $template_info );
		// exit;

		$this->deleteCurrentThumbnails($template_info);

		$paths = $this->createThumbnailFiles( $request->pngimageData, $template_id );
		$template_info['filename'] = $paths['normal'];

		// echo "<pre>";
		// print_r( $template_info );
		// exit;

		$this->registerThumbnailOnDB( $template_info );

		$response = [
			'id' => $template_id,
			'err' => 0,
			'msg' => 'Ajuuua'
		];
		return json_encode($response);

	}
	
	function saveAs(Request $request){
		
		$png_image_data = $request['pngimageData'];

		$template_data = json_decode( $request->jsonData );

		$template_dimensions = $this->convertPXtoIn( $template_data[1]->cwidth ).'x'.$this->convertPXtoIn($template_data[1]->cheight).' in';
		// $prefix_filename = $this->randomNumber();
		$template_id = $request->template_id;
		$collection_id = $request->tmp_templates;
		
		$template_info = [
			'title' => $request->filename,
			'filename' => $template_id,
			'template_id' => $template_id,
			'tmp_original_url' => null,
			'dimentions' => $template_dimensions,
			'tmp_templates' => $collection_id,
			'status' => 1
		];

		// echo "<pre>";
		// print_r( $request->all() );
		// exit;

		$paths = $this->createThumbnailFiles( $png_image_data, $template_id );
		$template_info['filename'] = $paths['normal'];
		
		$this->registerThumbnailOnDB( $template_info );

		$response = [
			'id' => $template_id,
			'err' => 0,
			'msg' => 'Ajuuua'
		];
		return json_encode($response);

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

		// 1:: Borrar thumb pasado
		
		$image = $image_data;  // your base64 encoded
        $image = str_replace('data:image/jpeg;base64,', '', $image);
		$image = str_replace(' ', '+', $image);

		// Create image from base64 string
		$img = \Image::make(base64_decode($image));

		// echo "<pre>";
		// print_r($img);
		// exit;
		
		$img_path = 'design/template/'.$template_id.'/thumbnails/';
		$path = public_path($img_path);
		@mkdir($path, 0777, true);

		// Store mid-size thumbnail
		$unique_id = Str::random(10);
		$full_thumbnail_path = public_path($img_path.$unique_id.'.jpg');
		$img->save($full_thumbnail_path);
		
		// Create mini thumbnail
		$img->resize(150, 210, function($constraint) {
			$constraint->aspectRatio();
		});

		$mini_thumbnail_path = public_path($img_path.$unique_id.'_mini.jpg');
		$img->save($mini_thumbnail_path);

		return [
			'normal' => $unique_id.'.jpg',
			'mini' => $unique_id.'_mini.jpg',
		];
		
	}

	function registerThumbnailOnDB( $template_info ){
		$thumbnail = DB::table('d_thumbnails')
						->select('id')
						->where('template_id','=', $template_info['template_id'] )
						->first();

		if( isset( $thumbnail->id ) == false ){
			DB::table('d_thumbnails')->insert([
				'id' => null,
				'template_id' => $template_info['template_id'],
				'title' => htmlspecialchars_decode($template_info['title']),
				'filename' => $template_info['filename'],
				'tmp_original_url' => null,
				'dimentions' => $template_info['dimentions'],
				'tmp_templates' => $template_info['tmp_templates'],
				'status' => 1
			]);
		} else {
			/*
				echo "<pre>";
				print_r($thumbnail->id);
				echo "<br>";
				print_r($template_info['filename']);
				exit;
			*/

			DB::table('d_thumbnails')
			->where(['id' => $thumbnail->id ])
			->update([
				// 'template_id' => $template_info['template_id'],
				// 'title' => htmlspecialchars_decode($template_info['title']),
				'filename' => $template_info['filename']
				// 'tmp_original_url' => null,
				// 'dimentions' => $template_info['dimentions'],
				// 'tmp_templates' => $template_info['tmp_templates'],
				// 'status' => 1
			]);
		}
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

			$template_thumbnails = DB::table('d_thumbnails')
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

		

		$template = DB::table('d_templates')
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

			$font_info = DB::table('d_fonts')
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
		
		$templates = explode(",", $templates);
		$templates = "'".implode("','", $templates)."'";

		if( isset($templates) ){
			// $templates = json_decode($templates);
			// $templates = urldecode($request['d_templates']);
			// $templates = "'".implode("','", $templates)."'";
			
			// "SELECT * FROM fonts WHERE "
			$font_families = DB::Table('d_fonts')
								->select(['font_id','name'])
								->whereRAW('font_id IN('.$templates.')')
								->get();
		
		
			header("Content-type: text/css");
			foreach( $font_families as $font ){
				$font_url = url('design/fonts_new/'.$font->name);
				
				echo '@font-face {
					font-family:\''.$font->font_id.'\';
					src:url(\''.$font_url.'\') format(\'woff\');
				}';
		
			}
		
		}
	}

	function pdf(Request $request){
		if ($_SERVER['REQUEST_METHOD']=='OPTIONS') {
			header('Access-Control-Allow-Origin : *');
			header('Access-Control-Allow-Methods : POST, GET, OPTIONS, PUT, DELETE');
			header('Access-Control-Allow-Headers : X-Requested-With, content-type');
		}

		// https://www.npmjs.com/package/svg2png
		// chmod 755 /Users/ivan_gtm/Dropbox/templett/scrapper/wayak/app/Http/Controllers/DesignerAppController.php
		
		$svg = json_decode($request['jsonData']);
		// echo $svg;
		// filename

		// cropWidth
		// cropBottom
		// pages

		echo "<pre>";
		print_r($request['filename']);
		print_r("\n");
		print_r($request['cropWidth']);
		print_r("\n");
		print_r($request['cropBottom']);
		print_r("\n");
		print_r($request['pages']);
		print_r("\n");

		print_r($request['cwidth']);
		print_r("\n");
		print_r($request['cheight']);
		print_r("\n");
		print_r($svg);
		exit;
		
		// file_put_contents('xpruebaprueba.svg', $svg);
		$command = 'svg2png xpruebaprueba.svg -o -w '.$request['cwidth'].' -h '.$request['cheight'];
		// $command = 'ls -l';
		$process_running = shell_exec($command);
		$process_list = explode("\n", $process_running);

		echo "<pre>";
		print_r($process_list); //gives an array of processes
		exit;

		/* CUSTOM FONT
		$im = new Imagick();

		// Set the font for the object 
		$im->setFont("Burrito_1538902164.woff");

		// Create new caption
		$im->newPseudoImage(100, 100, "caption:Perra");

		$im->setformat('png');
		header('Content-type: image/png');
		echo $im;

		exit;
		*/

		// $usmap = '/path/to/blank/us-map.svg';
		$im = new Imagick();

		// $im->setFont("Burrito_1538902164.woff");

		// $svg = file_get_contents($usmap);

		/*loop to color each state as needed, something like*/ 
		$idColorArray = array(
			"AL" => "339966"
			,"AK" => "0099FF"
			// ...
			,"WI" => "FF4B00"
			,"WY" => "A3609B"
		);

		foreach($idColorArray as $state => $color){
			//Where $color is a RRGGBB hex value
			$svg = preg_replace(
				'/id="'.$state.'" style="fill:#([0-9a-f]{6})/'
				, 'id="'.$state.'" style="fill:#'.$color
				, $svg
			);
		}

		$im->readImageBlob($svg);

		/*png settings*/
		$im->setImageFormat("png32");
		// $im->resizeImage(720, 445, imagick::FILTER_LANCZOS, 1);  /*Optional, if you need to resize*/

		/*jpeg*/
		// $im->setImageFormat("jpeg");
		// $im->adaptiveResizeImage(720, 445); /*Optional, if you need to resize*/

		// $im->writeImage('/path/to/colored/us-map.png');/*(or .jpg)*/

		echo '<img src="data:image/jpg;base64,' . base64_encode($im) . '"  />';

		$im->clear();
		$im->destroy();


		$SVGData = json_decode($_POST['jsonData']);
		file_put_contents('testsvg.svg', $SVGData);

		exit;



		// $file_name = $_POST['filename'];

		// [cwidth] => 480
		// [cheight] => 672
		// [cropWidth] => 360
		// [cropBottom] => 0
		// [pages] => 2

		// echo "<pre>";
		// print_r($_POST);


		/**
		 * Creates an example PDF TEST document using TCPDF
		 * @package com.tecnick.tcpdf
		 * @abstract TCPDF - Example: SVG Image
		 * @author Nicola Asuni
		 * @since 2010-05-02
		 */

		// Include the main TCPDF library (search for installation path).
		require_once('tcpdf.php');

		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle('TCPDF Example 058');
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 058', PDF_HEADER_STRING);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
			require_once(dirname(__FILE__).'/lang/eng.php');
			$pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		// $pdf->SetFont('helvetica', '', 10);

		// add a page
		$pdf->AddPage();

		// NOTE: Uncomment the following line to rasterize SVG image using the ImageMagick library.
		//$pdf->setRasterizeVectorImages(true);

		$pdf->ImageSVG($file='testsvg.svg', $x=15, $y=30, $w='', $h='', $link='', $align='', $palign='', $border=1, $fitonpage=false);

		// $pdf->ImageSVG($file='images/tux.svg', $x=30, $y=100, $w='', $h=100, $link='', $align='', $palign='', $border=0, $fitonpage=false);

		$pdf->SetFont('helvetica', '', 8);
		$pdf->SetY(195);
		$txt = '© The copyright holder of the above Tux image is Larry Ewing, allows anyone to use it for any purpose, provided that the copyright holder is properly attributed. Redistribution, derivative work, commercial use, and all other use is permitted.';
		$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);

		// ---------------------------------------------------------

		//Close and output PDF document
		$pdf->Output('example_058.pdf', 'D');

		//============================================================+
		// END OF FILE
		//============================================================+

	}
}
