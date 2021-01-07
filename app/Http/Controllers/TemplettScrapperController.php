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
		print_r("			Inserting JSON >> ".$template_id);

		$template_key = 'template:en:'.$template_id.':jsondata';
		Redis::set($template_key, $json_data);
	}

	function getJSONTemplate($template_id){
		$template_key = 'template:en:'.$template_id.':jsondata';
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
										->where('status', '=' , 8)
										->orderBy('id','DESC')
										->limit(1000)
										->get();
		// echo sizeof($templates);
		// exit;
		foreach ($templates as $template) {
			$template_key = 'template:en:'.$template->template_id.'ss:jsondata';
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
							->whereRaw('id IN (SELECT fk_etsy_template_id FROM templates WHERE `status` = 8 AND fk_etsy_template_id IS NOT NULL GROUP BY fk_etsy_template_id)')
							// ->where('username','!=', 'asterandrose')
							// ->where('status', '<>', 3)
							// ->where('templett_url', 'not like', "%asterandrose%")
							// ->where('templett_url', 'like', "%4168392,4171985%")
							->get();
		
		// echo "<pre>";
		// print_r($templates);
		// exit;

		foreach ($templates as $template) {
			
			$template_ids = substr($template->templett_url, strrpos($template->templett_url, '/')+1, strlen($template->templett_url));
			$template_ids = explode(',',$template_ids);
			
			// echo "<pre>";
			// print_r($template_ids);
			// exit;
			
			foreach ($template_ids as $template_id) {
				
				$template_key = 'template:en:'.$template_id.':jsondata';

				// echo "<pre>";
				// print_r($template_key);
				// exit;
				
				// IF template does not exists on REDIS database
				if( Redis::exists($template_key) == false ) {

					echo "<br>$template_key does not exist >> Start scrapping";
					// $templett_url = $this->sanitizeExtraLargeURL( $template->templett_url );

					$templett_url = $template->templett_url;

					// echo "<pre>";
					// print_r($templett_url);
					// exit;
	
					// if(strlen($templett_url) > 0 && strpos($templett_url, 'templett.com/design/demo/') > 0 ){
						// echo "-------------------------\n";
						// print_r('<pre>');
						// print_r($template);
						// // print_r($template_id);
						// exit;
						
						echo "<br>	Start parsing for URL:: ".$templett_url."<br>\n";
						$this->startScrapping($templett_url, $template->id);
						echo "<br>	Parsing complete - ".$templett_url."-\n\n<br>";
						echo "<br><br><br><br><br>";

						// exit;
						
						// DB::table('templates')
						// 	->where('id', $template->id)
						// 	->update(['status' => 3]);
	
						usleep(50000);
	
					// }
	
				} else {
					// echo "<br>$template_key >> Already exists on db";
					DB::table('templates')
						->where('id', $template->id)
						->update(['status' => 3]);
				}
			}
		}
		
	}

	function migrateTemplateKeyNames(){
		$templates = Redis::keys('template:*:jsondata');
		echo "<pre>";
		// exit;
		
		foreach ($templates as $template_key) {
			$language_token_en = strpos($template_key,':en:');
			$language_token_es = strpos($template_key,':es:');
			
			// print_r($template_key);
			// print_r("\n");

			if ($language_token_es == false && $language_token_en == false) {
				// echo $template_key;
				$new_keyname = str_replace('template:','template:en:',$template_key);
				print_r( $new_keyname."\n");
				Redis::rename($template_key, $new_keyname );
				// exit;
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
            
            $template_key = 'template:en:'.$template->template_id.':jsondata';
			
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
					
					echo "<hr>";
					echo 'Start parsing for URL:: '.$templett_url."<br>\n";
						$this->startScrapping($templett_url, $template->id);
					echo '<br>Parsing complete - '.$templett_url."-\n\n<br>";
					echo "<hr>";
					
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
					echo '<br>Parsing complete - '.$templett_url."-\n\n<br>";
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

		// exit;
		
		// echo '<br>AQUI PUTO >> '.$url;
		// if( $etsy_template_id == '216803' ){
		// 	echo "<pre>";
		// 	print_r($url_info);
		// 	exit;
		// }

		// Extract username and template ids
		if(isset($url_info[0]) && isset($url_info[1])){

			$username = $url_info[0];
			$templates = explode(',', $url_info[1]);
			$parent_template_id = $templates[0];
			$templates_with_commas = $url_info[1];
			
			echo "<pre>";
			print_r("\n		Parsed Username >> $username");
			print_r("\n		Parsed Templates >>\t\t".$templates_with_commas);
			// print_r($templates);

			// print_r($parent_template_id);
			// print_r($templates_with_commas);
			// exit;
			
			foreach ( $templates as $template_id ) {
				
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
		
		// echo '<hr>';
		// print_r($templates);
		// exit;

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
				
				print_r('	>>Template IDs');
				print_r($templateIdMatches[1]);
				print_r('	>>Title');
				print_r($titleMatches[1]);
				print_r('	>>IMGs');
				print_r($imgsMatches[1]);
				print_r('	>>Dimentions');
				print_r($dimentionsMatches[1]);
				
				for ($i=0; $i < sizeof( $templateIdMatches[1] ); $i++) { 
					$template_id = $templateIdMatches[1][$i][0];

					$thumbnail = DB::table('thumbnails')
						->select('id')
						->where('template_id','=',$template_id)
						->first();

					if( isset($thumbnail->id) == false ){

						print_r("			Inserting thumbnails >> $template_id");

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
			
		} else {
			print_r("\n			>> Thumbs for $templates already exists");
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
    	// print_r($template_id);
		// exit;
		
    	// echo "<hr>";
		print_r( ( isset($demo_id_query->demo_as_id) ? "\n\n			>> DEMO AS ID >> ".$demo_id_query->demo_as_id  : 'NO TENEMOS DEMO AS ID' ) );
		// echo "<hr>";
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
				echo "\nError al obtener demo id de el template $template_id, este template no se va a parsear\n";
				
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

		// print_r( $template_config );
		// print_r( $templates );
		// exit;

		print_r("\n			>> PARSING TEMPLATE >> $template_id");
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
		
		print_r("\n			>> registerJSONTemplateOnDB FOR TEMPLATE >> ");
		if(isset($template_id_query->template_id)){
			print_r($template_id_query->template_id);
		}
		print_r(" etsy_template_id - ".$etsy_template_id);
		// exit;

		if( Redis::exists('template:en:'.$template_id.':jsondata') == false ){

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
			$template_json_url = 'https://templett.com/design/loadtemplate.php?id='.$template_id.'&design_as_id='.$design_as_id.'&demo_as_id='.$demo_as_id.'&demo_templates='.$template_id;
			// echo $template_json_url;
			// exit;

			//Open the file using the HTTP headers set above
			$template_raw_data = file_get_contents($template_json_url, false, $context);
			$array_template = json_decode($template_raw_data);
			
			// print_r($array_template);
			// exit;
			
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

				$pages = json_decode( $additional_info['jsondata'] );
				
				unset( $pages[0] ); // Remove dimentions
				
				// if( sizeof($objects) > 2 ){
				// 	echo "<pre>";
				// 	print_r( "FALTA PARSEAR PAGINAS" );
				// 	print_r( $objects );
				// 	exit;
				// }

				foreach ($pages as $page) {
					$objects = $page->objects;
					foreach ($objects as $index => $object) {
						if($object->type == 'image'){
							$this->registerImagesOnDB($object->src, $template_info['templateid']);
						} elseif($object->type == 'path' && isset($object->src)){
							$this->registerSVGsOnDB($object->src, $template_info['templateid']);
						} elseif($object->type == 'textbox'){
							$this->registerFontsOnDB($object->fontFamily, $template_info['templateid']);
						}
					}
				}

				$additional_info['jsondata'] = str_replace('https://dbzkr7khx0kap.cloudfront.net/', 'http://localhost/design/template/'.$template_id.'/assets/', $additional_info['jsondata']);
				// Saves JSON Template on REDIS
				$this->storeJSONTemplate($template_id, $additional_info['jsondata'] );

				return $this->saveTemplateOnDB($template_info);

			} else {
				print_r("\n			>> No se pudo descargar de la plataforma el template id:".$template_id);
				// DB::table('tmp_etsy_metadata')
				// 	->where('id', $etsy_template_id)
				// 		->update(['status' => 4 ]); // No se pudo descargar de la plataforma

			}

		// If template does not exists on db
		} elseif( isset($template_id_query->template_id) == false ) {
			
			echo '<hr>';
			echo $template_id.' >> Does not exists on MySQL Table';
			echo '<hr>';

		} elseif( Redis::exists('template:en:'.$template_id.':jsondata') ) {
			print_r("\n			>> $template_id - Already exists on redis database");
			
			DB::table('templates')
				->where('template_id', $template_id)
				->update(['status' => 3 ]);
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
				print_r("			Inserting template on db >> ".$template_info['templateid']);

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

		} else {
			DB::table('templates')
							->where('id', $template_info['templateid'])
							->update(['status' => 3]);
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

	function missinTranslation(){
		// $thumbs_to_download = DB::select('
		// 	SELECT id,template_id,filename,tmp_original_url FROM thumbnails
		// 	WHERE 
		// 		template_id IN(
		// 		SELECT
		// 		templates.template_id 
		// 	FROM
		// 		templates,
		// 		images 
		// 	WHERE
		// 		templates.template_id REGEXP \'^-?[0-9]+$\'
		// 		AND templates.template_id = images.template_id
		// 		AND images.`status` = 1 
		// 	GROUP BY
		// 		template_id
		// 		)
		// 	AND status = 1');
		$thumbs_to_download = DB::select('
			SELECT
				thumbnails.id,
				thumbnails.template_id,
				thumbnails.filename,
				thumbnails.tmp_original_url,
				tmp_etsy_product.title
			FROM
				thumbnails,
				templates,
				tmp_etsy_product,
				tmp_etsy_metadata
			WHERE
				thumbnails.template_id = templates.template_id
				AND templates.fk_etsy_template_id = tmp_etsy_metadata.id
				AND tmp_etsy_metadata.fk_product_id = tmp_etsy_product.id
				AND thumbnails.template_id IN (
					SELECT
						templates.template_id 
					FROM
						templates,
						images 
					WHERE
						templates.template_id REGEXP \'^-?[0-9]+$\' 
						AND templates.template_id = images.template_id 
						AND images.`status` = 1 
						AND templates.`status` = 5
				GROUP BY
					template_id 
				) 
				AND thumbnails.`status` = 1
				ORDER BY tmp_etsy_product.review DESC');

        $products = [];
        foreach ($thumbs_to_download as $key => $product) {
			// $product->Id
			$product->PreviewImage = asset('/design/template/'.$product->template_id.'/thumbnails/'.$product->filename);
			$products[] = $product;
		}

		return view('templett.missing_translation',[
            'product_result' => $products
        ]);
	}

	function bulkTranslation($origin_lang, $destination_lang, Request $request){

		$templates_per_page = 30;

		$ready_for_translation = DB::table('templates')
						->select('template_id')
						->where('status', '=' , 5)
						// ->limit($templates_per_page)
						->get();
		
		// echo "<pre>";
		// print_r( $ready_for_translation );
		// exit;
		
		// // Save translated Google data on database
        if( isset($request->templates_text) ){
			$templates_metadata = $request->templates_text;
			
			// echo "<pre>";
			// print_r( $templates_metadata );
			// exit;

            foreach ($templates_metadata as $template_info) {
                self::saveTemplateTranslation( $template_info );
            }
        }
        
        // Get formated templates
        $template_total = sizeof($ready_for_translation); // Array size of format ready templates
		$template_text = '';
		$templates_on_page = 0;
		
        foreach ($ready_for_translation as $template) {
			$template_key = $template->template_id;
			$source_template_key = 'template:'.$origin_lang.':'.$template_key.':jsondata';

            $source_template_exists = Redis::exists( $source_template_key );
			$template_translation_ready = Redis::exists('template:'.$destination_lang.':'.$template_key.':jsondata') && Redis::exists('product:translation_ready:'.$template_key);
			
			// echo '<br><br>';
			// echo $source_template_key.'<br>';
			// echo 'template:'.$destination_lang.':'.$template_key.':jsondata'.'<br>';
			// echo 'product:translation_ready:'.$template_key.'<br>';
			
			if( $source_template_exists
                && $template_translation_ready == false  ){

				$template_text .= self::getTemplateHTMLText($source_template_key);
				if(strlen( $template_text ) > 0){
					$templates_on_page++;
				}
				
                if($templates_on_page == $templates_per_page) {
                    break;
				}
				
            }
        }

        return view('templett.bulk_translate', [
            'template_key' => $template_key,
            'template_text' => $template_text,
            'from' => $origin_lang,
            'to' => $destination_lang
        ]);
	}
	
	function keyrefactor(){
		$thumbs_to_download = DB::select('
			SELECT
				thumbnails.id,
				thumbnails.template_id,
				thumbnails.filename,
				thumbnails.tmp_original_url,
				tmp_etsy_product.title
			FROM
				thumbnails,
				templates,
				tmp_etsy_product,
				tmp_etsy_metadata
			WHERE
				thumbnails.template_id = templates.template_id
				AND templates.fk_etsy_template_id = tmp_etsy_metadata.id
				AND tmp_etsy_metadata.fk_product_id = tmp_etsy_product.id
				AND thumbnails.template_id IN (
					SELECT
						templates.template_id 
					FROM
						templates,
						images 
					WHERE
						templates.template_id REGEXP \'^-?[0-9]+$\' 
						AND templates.template_id = images.template_id 
						AND images.`status` = 1 
						AND templates.`status` = 5
				GROUP BY
					template_id 
				) 
				AND thumbnails.`status` = 1
				ORDER BY tmp_etsy_product.review DESC');

        foreach ($thumbs_to_download as $key => $product) {
			print_r( $product->template_id . "\n" );
			$template_key = $product->template_id;

			if( Redis::exists('product:format_ready:'.$template_key) == false ){
				Redis::set('product:format_ready:'.$template_key, 1);
			}
		}
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
		
        if( isset($template_obj[1]->objects) && sizeof( $template_obj[1]->objects ) > 0 ){
			$template_text = '<br><br> <ul class="template-content" data-template-id="'.$template_key.'">';
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
			// If template does not have text, is not worthy list it for translation
			if( $text_i == 0){
				$template_text = '';
			}
		}

        return $template_text;
	}
	
	function saveTemplateTranslation( $template_info ){
        $language_from = 'en';
        $language_to = 'es';
        
        $template_key = str_replace('template:'.$language_from.':',null, $template_info['key']);
        $template_key = str_replace(':jsondata',null, $template_key);

        // echo $template_key;
        // exit;

        // $translations = Redis::keys('template:es:*:jsondata');
        // foreach ($translations as $template_key) {
        //     Redis::del($template_key);
        // }
        // exit;

        if( isset($template_info['key']) && isset($template_info['template_text']) ){
            // $template_key = ;
            $template_obj = json_decode( Redis::get( $template_info['key'] ) );
            $template_objects = sizeof( $template_obj[1]->objects );

            // echo "<pre>";
            // // print_r($template_info['template_text']);
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
            Redis::set('product:translation_ready:'.$template_key, 1);

            
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
}
