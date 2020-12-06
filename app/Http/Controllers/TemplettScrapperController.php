<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;


ini_set("max_execution_time", 0);   // no time-outs!
ignore_user_abort(true);            // Continue downloading even after user closes the browser.

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '-1');

class TemplettScrapperController extends Controller
{

	private function storeJSONTemplate($template_id, $json_data){
		$template_key = 'template:'.$template_id.':jsondata';
		Redis::set($template_key, $json_data);
	}

	function getJSONTemplate($template_id){
		$template_key = 'template:'.$template_id.':jsondata';
		return Redis::get($template_key);
	}

	function registerMissingAssets(){
		echo '<style type="text/css">
			body{
					background-color: #0f1419;
					color: #5de5ed
			}
			</style>'."\n\n\n\n";

		echo "HIHIHI";

		$templates = DB::table('templates')
										->select('id', 'template_id')
										// ->where('status', '=' , 3)
										->orderBy('id','DESC')
										->limit(3000)
										->get();
		// echo sizeof($templates);
		// exit;
		foreach ($templates as $template) {
			$template_key = 'template:'.$template->template_id.'ss:jsondata';
			if( Redis::exists($template_key) == 0 ) {
				echo $template_key."- NO EXISTE";
			} else {
				echo $template_key."- NO EXISTE";
			}
		}
	}

	function downloadOriginalTemplate(){
		echo '<style type="text/css">
			body{
					background-color: #0f1419;
					color: #5de5ed
			}
			</style>'."\n\n\n\n";

		$templates = DB::table('tmp_etsy_metadata')
                            ->select('id', 'templett_url')
							->whereNotNull('templett_url')
							// ->where('username','!=', 'asterandrose')
							->where('id', '>=', 5940)
							->where('templett_url', 'not like', "%asterandrose%")
							->limit(12000)
							->get();
		
		echo "<pre>";
		foreach ($templates as $template) {
			
			$template_ids = substr($template->templett_url, strrpos($template->templett_url, '/')+1, strlen($template->templett_url));
			// $template_ids = "s";
			$template_ids = explode(',',$template_ids);
			
			foreach ($template_ids as $template_id) {
				
				print_r($template_id);
				
				$template_key = 'template:'.$template_id.':jsondata';
				
				// IF template does not exists on REDIS database
				if(Redis::exists($template_key) == 0) {
					
					// Verify if metadata already exist on database
					// $template_md = DB::table('tmp_etsy_metadata')
					// 	->select('id','templett_url')
					// 	->whereRaw('LENGTH(templett_url) > ?', [0])
					// 	->where('templett_url', 'like', '%'.$template_id.'%')
					// 	// ->where('templett_ids', 'like', '%'.$template->template_id.'%')
					// 	->first();
					
					$templett_url = $this->sanitizeExtraLargeURL( $template->templett_url );
	
					// echo "NO EXISTE::>";
					// echo "<pre>";
					// print_r($templett_url);
					// exit;
	
					if(strlen($templett_url) > 0 && strpos($templett_url, 'templett.com/design/demo/') > 0 ){
						// echo "-------------------------\n";
						// print_r('<pre>');
						// print_r($template);
						// // print_r($template_id);
						// exit;
						
						echo 'Start parsing for URL:: '.$templett_url."<br>\n";
						$this->startScrapping($templett_url, $template->id);
						echo '<br>Parsing complete - '.$templett_url."-\n\n<br><br>";
						
						DB::table('templates')
							->where('id', $template->id)
							->update(['status' => 3]);
	
						usleep(50000);
	
					}
	
				} else {
					echo 'EL TEMPLATE already exists on database::'.$template_key.'<br>';
					DB::table('templates')
						->where('id', $template->id)
						->update(['status' => 3]);
				}
			}
		}
		
	}

	function downloadMissingREDISTemplates(){
		
		echo '<style type="text/css">
			body{
					background-color: #0f1419;
					color: #5de5ed
			}
			</style>'."\n\n\n\n";

		$templates = DB::table('templates')
                            ->select('id', 'template_id')
							->where('status','=',0)
							->orderBy('id','DESC')
							// ->offset(10000)
							// ->limit(5000)
							->get();
		// echo "<pre>";
		// print_r($templates);
		// exit;
		/*
			echo "<pre>";
			print_r($templates);
			exit;
		*/

        foreach ($templates as $template) {
            
            $template_key = 'template:'.$template->template_id.':jsondata';
			
			// IF template does not exists on REDIS database
            if(Redis::exists($template_key) == 0) {
				
				// Verify if metadata already exist on database
				$template_md = DB::table('tmp_etsy_metadata')
					->select('id','templett_url')
					->whereRaw('LENGTH(templett_url) > ?', [0])
					->where('templett_url', 'like', '%'.$template->template_id.'%')
					// ->where('templett_ids', 'like', '%'.$template->template_id.'%')
					->first();
				
				$templett_url = $this->sanitizeExtraLargeURL($template_md->templett_url);

				// echo "NO EXISTE::>";
				// echo "<pre>";
				// print_r($templett_url);
				// exit;

				if(strlen($templett_url) > 0 && strpos($templett_url, 'templett.com/design/demo/') > 0 ){
					// echo "-------------------------\n";
					// print_r('<pre>');
					// print_r($template);
					// // print_r($template_id);
					// exit;
					
					echo 'Start parsing for URL:: '.$templett_url."<br>\n";
					$this->startScrapping($templett_url, $template->id);
					echo '<br>Parsing complete - '.$templett_url."-\n\n<br><br>";
					
					DB::table('templates')
						->where('id', $template->id)
						->update(['status' => 3]);

					usleep(50000);

				}

			} else {
				echo 'EL TEMPLATE EXISTE::'.$template_key.'<br>';
				DB::table('templates')
					->where('id', $template->id)
					->update(['status' => 3]);
			}
		}
	}

	function scrapURL(){
		// $this->startScrapping('https://templett.com/design/demo/DesignMyPartyStudio/799782');
		// exit;

		// bulkThumbnailDownload();
		echo '<style type="text/css">
				body{
					background-color: #0f1419;
					color: #5de5ed
				}
			</style>'."\n\n\n\n";

		$urls = DB::table('tmp_etsy_metadata')
						->select('id','templett_url')
						// ->where('templett_url','=','https://templett.com/design/demo/ForeverYourPrints/1385372')
						->where('status','=','0')
						->whereRaw('LENGTH(templett_url) > ?', [0])
						// ->whereRaw('LENGTH(templett_url) < ?', [180])
						->limit(1600)
						->get();

    	foreach ($urls as $key => $template) {
				$templett_url = $this->sanitizeExtraLargeURL($template->templett_url);

				// echo "<pre>";
				// print_r($templett_url);
				// exit;

				if(strlen($templett_url) > 0 && strpos($templett_url, 'templett.com/design/demo/') > 0 ){

					// echo "-------------------------\n";
					// print_r('<pre>');
					// print_r($template);
					// // print_r($template_id);
					// exit;

					// echo 'Parsing '.$templett_url."<br>\n";
					// exit;
					$this->startScrapping($templett_url, $template->id);
					echo '<br>Parsing complete - '.$templett_url."-\n\n<br><br>";
					usleep(500000);
				}
    	}

  }

	function sanitizeExtraLargeURL($templett_url) {
		// return sizeof($templett_url);

		if(strlen($templett_url) > 200){
			// echo "asdasds";
			// exit;
			// $templett_url = $template->templett_url;

			// echo $templett_url;
			// echo "\n---------------\n";

			$templett_url = trim(str_replace('#', null, substr($templett_url, 0, strpos($templett_url, '<br>'))));
			preg_match_all('/(http|ftp|https):\/\/templett\.com\/design\/demo\/(.*)\/([0-9]+)(,[0-9]+)*/', $templett_url, $templett_final_url);
			
			// echo $templett_url;
			// // print_r($templett_final_url);
			// echo "\n---------------\n";

			if (isset($templett_final_url[0][0]) && strpos($templett_final_url[0][0], '//templett.com/design/demo/') !== false) {
				// echo "\n";
				// echo $templett_final_url[0][0]."<br>\n";
			 	// 	echo 'true';
				// echo "\n\n";

				return str_replace('<br>', null, $templett_final_url[0][0]);

		    	// DB::table('tmp_etsy_metadata')
		     //            ->where('id', $template->id)
		     //            ->update(['templett_url' => $templett_url ] );
			} else {
				// DB::table('tmp_etsy_metadata')
				//               ->where('id', $template->id)
				//               ->update(['status' => 0 ] );
			}

		}

		return str_replace('<br>', null, $templett_url);

	}

	function startScrapping($url, $etsy_template_id) {
		
		$url_info = trim(str_replace('*', null, str_replace('https://templett.com/design/demo/', null, str_replace('http://templett.com/design/demo/', null, $url))));
		$url_info = explode('/', $url_info);
		// echo "<pre>";
		// print_r($url_info);
		// exit;

		// Extract username and template ids
		if(isset($url_info[0]) && isset($url_info[1])){

			$username = $url_info[0];
			$templates = explode(',', $url_info[1]);
			$parent_template_id = $templates[0];
			$templates_with_commas = $url_info[1];
			
			// echo "<pre>";
			// print_r($username);
			// print_r($templates);
			// print_r($parent_template_id);
			// print_r($templates_with_commas);
			// exit;
			
			foreach ($templates as $template_id) {
				
				$result = $this->createTemplate($username, $template_id, $parent_template_id, $templates_with_commas, $etsy_template_id);
				
				if($result){
					DB::table('tmp_etsy_metadata')
						->where('id', $etsy_template_id)
						->update(['status' => 2]);
				}
			}

		} else {
			DB::table('tmp_etsy_metadata')
						->where('id', $etsy_template_id)
						->update(['status' => 4]); // URL malformada
		}


	}

	function registerThumbnailsOnDB($templates, $demo_as_id){
		$template_metadata = DB::table('thumbnails')
    		->select('id')
    		->where('tmp_templates','=',$templates)
    		->first();

		// We dont have any thumbnail registered on db
    	if( isset($template_metadata->id) == false ){

			$opts = array(
			  'http'=>array(
			    'method'=>"GET",
			    'header'=>"Accept-language: en\r\n"
			    // "Cookie: foo=bar\r\n"
			  )
			);

			$context = stream_context_create($opts);
			$thumbnails_url = 'https://templett.com/design/get_templates.php?offset=0&limit=100&tags=&design_as_id=0&demo_as_id='.$demo_as_id.'&demo_templates='.$templates;

			// // // Open the file using the HTTP headers set above
			$file = file_get_contents($thumbnails_url, false, $context);
			$file = json_decode($file);

			if(isset($file->data)){

				$file = $file->data;

				preg_match_all('/data-target="([0-9]+)">/', $file, $templateIdMatches, PREG_OFFSET_CAPTURE);
				preg_match_all('/<h3>(.*?)<\/h3>/', $file, $titleMatches, PREG_OFFSET_CAPTURE);
				preg_match_all('/src=\"(.*?)\"/', $file, $imgsMatches, PREG_OFFSET_CAPTURE);
				preg_match_all('/<span class=\"badge dims\">(.*?)<\/span>/', $file, $dimentionsMatches, PREG_OFFSET_CAPTURE);

				
				// echo "<pre>";
				// print_r($thumbnails_url);
				// print_r($file);
				// exit;
				
				// print_r($templateIdMatches[1]);
				// print_r($titleMatches[1]);
				// print_r($imgsMatches[1]);
				// print_r($dimentionsMatches[1]);
				
				for ($i=0; $i < sizeof( $templateIdMatches[1] ); $i++) { 
					$template_id = $templateIdMatches[1][$i][0];

					$thumbnail = DB::table('thumbnails')
						->select('id')
						->where('template_id','=',$template_id)
						->first();

					if( isset($thumbnail->id) == false ){
						DB::table('thumbnails')->insert([
							'id' => null,
							'template_id' => $template_id,
							'language_code' => 'en',
							'title' => htmlspecialchars_decode(str_replace('\'', null, $titleMatches[1][$i][0])),
							'filename' => str_replace('https://dbzkr7khx0kap.cloudfront.net/thumbs/', null, $imgsMatches[1][$i][0]),
							'tmp_original_url' => $imgsMatches[1][$i][0],
							'dimentions' => $dimentionsMatches[1][$i][0],
							'tmp_templates' => $templates,
							'status' => 0
						]);
					}
				}
			}
		}
	}

	// Get a demo as id, and initial information for template
	function createTemplate($username, $template_id, $parent_template_id, $templates, $etsy_template_id) {

		// $demo_as_id_query = $mysqli->query("SELECT demo_as_id FROM tmp_demo_as_id WHERE username = '$username' LIMIT 1");

		$demo_id_query = DB::table('tmp_demo_as_id')
    		->select('demo_as_id')
    		->where('username','=',$username)
    		->first();

    	// echo "<pre>";
    	// print_r($username);
    	// echo "<hr>";
    	// // exit;
    	// print_r( ( isset($demo_id_query->demo_as_id) ? 'TENEMOS DEMO AS ID':'NO TENEMOS DEMO AS ID' ) );
    	// exit;

		// If this user has not been previously parsed and we already have demo as id
		if( isset($demo_id_query->demo_as_id) == false ){
			
			$opts = array(
			  'http'=>array(
			    'method'=>"GET",
			    'header'=>"Accept-language: en\r\n"
			              // "Cookie: foo=bar\r\n"
			  )
			);

			$context = stream_context_create($opts);

			// // Open the file using the HTTP headers set above
			$file = file_get_contents('http://templett.com/design/demo/'.$username.'/'.$templates.'?demo='.$username.'&templates='.$templates, false, $context);

			preg_match('/var demo_as_id = ([0-9]+);/', $file, $demoAsIdMatches, PREG_OFFSET_CAPTURE);
			preg_match('/var fillColor = \'([A-Za-z0-9-]+)\';/', $file, $fillColorMatches, PREG_OFFSET_CAPTURE);
			preg_match('/var selectedFont = \'([A-Za-z0-9-]+)\';/', $file, $selectedFontMatches, PREG_OFFSET_CAPTURE);
			preg_match('/var geofilterBackgrounds = \[(.+)\];/', $file, $geoFilterMatches, PREG_OFFSET_CAPTURE);
			

			$demo_as_id = 0;
			if(isset($demoAsIdMatches[1][0])){
				$demo_as_id = $demoAsIdMatches[1][0];
			}

			$fillColor = 0;
			if(isset($fillColorMatches[1][0])){
				$fillColor = $fillColorMatches[1][0];
			}

			$selectedFont = 0;
			if(isset($selectedFontMatches[1][0])){
				$selectedFont = $selectedFontMatches[1][0];
			}

			$geofilterBackgrounds = 0;
			if(isset($geoFilterMatches[1][0])){
				$geofilterBackgrounds = $geoFilterMatches[1][0];
			}

			if(intval($demo_as_id) > 0){
				$template_config['demo_as_id'] = $demo_as_id;
				$template_config['design_as_id'] = 0;
				$template_config['demo_templates'] = $templates;
				$template_config['selectedFont'] = $selectedFont;
				$template_config['fillColor'] = $fillColor;
				$template_config['geofilterBackgrounds'] = $geofilterBackgrounds;
				$template_config['currentUserRole'] = '';
				$template_config['hideVideoModal'] = 'false';
				$template_config['parentTemplateId'] = $parent_template_id;

				// echo "<pre>";
				// print_r($username);
				// print_r($demo_as_id);
				// exit;

				$this->registerDemoAsIDOnDB( $username, $demo_as_id );
			} else {
				echo "\n<br>Error al obtener demo id de el template $template_id, este template no se va a parsear\n<br>";
				
				DB::table('tmp_etsy_metadata')
				    ->where('id', $etsy_template_id)
				    ->update(['status' => 3]);

				return 0;
			}

		} else {

			$template_config['demo_as_id'] = $demo_id_query->demo_as_id;
			$template_config['design_as_id'] = 0;
			$template_config['demo_templates'] = $templates;
			$template_config['selectedFont'] = 'font42';
			$template_config['fillColor'] = 'Black';
			$template_config['geofilterBackgrounds'] = '{"id":0,"filename":"none"},{"id":"1","filename":"geo-wedding.jpg"},{"id":"2","filename":"geo-party.jpg"},{"id":"3","filename":"geo-cheers.jpg"},{"id":"4","filename":"geo-babygirl.jpg"}';
			$template_config['currentUserRole'] = '';
			$template_config['hideVideoModal'] = 'false';
			$template_config['parentTemplateId'] = $parent_template_id;
		}
		
		// Register thumbnails on database, based on templett html code
		$this->registerThumbnailsOnDB($templates, $template_config['demo_as_id']);

		$this->registerJSONTemplateOnDB($template_id, $template_config['demo_as_id'], $template_config, $etsy_template_id);

		return 1;
		// echo "<pre>";
		// print_r("BUSCAME FINS");
		// exit;
	}

	function registerJSONTemplateOnDB($template_id, $demo_as_id, $template_config, $etsy_template_id){
		// 1: Template has been downloaded
		// 2: Fonts have been downloaded
		// 3: Assets have been downloaded
		// 4: Thumbnails have been downloaded

		$template_id_query = DB::table('templates')
    		->select('template_id')
    		->where('template_id','=',$template_id)
			->first();
		// echo "<pre>";
		// print_r($template_id_query);
		// exit;

		// If template does not exists on db
		if( isset($template_id_query->template_id) == false ){

			// echo "<pre>";
			// print_r("BUSCAME TON");
			// exit;

			$design_as_id = 0;

			// Create a stream
			$opts = array(
				'http'=>array(
					'method'=>"GET",
					'header'=>"Accept-language: en\r\n" .
								"Cookie: foo=bar\r\n"
				)
			);
			
			$context = stream_context_create($opts);

			//Open the file using the HTTP headers set above
			$template_raw_data = file_get_contents('https://templett.com/design/loadtemplate.php?id='.$template_id.'&design_as_id='.$design_as_id.'&demo_as_id='.$demo_as_id.'&demo_templates='.$template_id.'', false, $context);

			$array_template = json_decode($template_raw_data);
			
			if(isset($array_template->data)){

				$additional_info = array();
				$additional_info['jsondata'] = $array_template->data;
				$additional_info['metrics'] = $array_template->metrics;
				$additional_info['options'] = json_decode( $array_template->options );

				$template_info['templateid'] = $template_id;
				$template_info['etsy_template_id'] = $etsy_template_id;
				$template_info['pngimageData'] = 'null';
				
				$template_info['jsonData'] = 'null';

				$template_info['metrics'] = $additional_info['metrics'];
				$template_info['crc'] = '582839465';
				$template_info['design_as_id'] = $design_as_id;
				$template_info['type'] = $additional_info['options']->type;
				$template_info['geofilterBackground'] = 0;
				$template_info['instructionsId'] = 0;
				$template_info['updateOriginal'] = isset($additional_info['options']->dateSaved) ? $additional_info['options']->dateSaved : null;
				$template_info['width'] = $additional_info['options']->width;
				$template_info['height'] = $additional_info['options']->height;
				
				$template_info['demo_as_id'] = $demo_as_id;
				$template_info['demo_templates'] = $template_config['demo_templates'];
				$template_info['status'] = 1; // Status:: Template has beeen downloaded
				$template_info['selectedFont'] = $template_config['selectedFont'];
				$template_info['fillColor'] = $template_config['fillColor'];
				$template_info['geofilterBackgrounds'] = $template_config['geofilterBackgrounds'];
				$template_info['currentUserRole'] = $template_config['currentUserRole'];
				$template_info['hideVideoModal'] = $template_config['hideVideoModal'];
				$template_info['parentTemplateId'] = $template_config['parentTemplateId'];

				$objects = json_decode( $additional_info['jsondata'] );
				$objects = $objects[1]->objects;
				
				foreach ($objects as $index => $object) {
					if($object->type == 'image'){
						$this->registerImagesOnDB($object->src, $template_info['templateid']);
					} elseif($object->type == 'path' && isset($object->src)){
						$this->registerSVGsOnDB($object->src, $template_info['templateid']);
					} elseif($object->type == 'textbox'){
						$this->registerFontsOnDB($object->fontFamily, $template_info['templateid']);
					}
				}

				$additional_info['jsondata'] = str_replace('https://dbzkr7khx0kap.cloudfront.net/', 'http://localhost/design/template/'.$template_id.'/assets/', $additional_info['jsondata']);
				// Saves JSON Template on REDIS
				$this->storeJSONTemplate($template_id, $additional_info['jsondata'] );

				return $this->saveTemplateOnDB($template_info);

			} else {

				DB::table('tmp_etsy_metadata')
					->where('id', $etsy_template_id)
						->update(['status' => 4 ]); // No se pudo descargar de la plataforma

			}
		}

		return 0;
	}

	function saveTemplateOnDB($template_info){
		
		$template_id_query = DB::table('templates')
    		->select('template_id')
    		->where('template_id','=',$template_info['templateid'])
    		->first();

		// If font id does not exists on db
		if( isset($template_id_query->template_id) == false ){

			try {
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
			} catch (Exception $e) {
				
				return 0;

				DB::table('tmp_etsy_metadata')
							->where('id', $etsy_template_id)
							->update(['status' => 5 ]); // Error al insertar el template ( archivo muy grande )
			}

		}
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
}
