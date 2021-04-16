<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

ini_set("max_execution_time", 0);   // no time-outs!
ignore_user_abort(true);            // Continue downloading even after user closes the browser.

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '-1');

class VerifyTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:verifytemplates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verify Assets';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   
        // 1:: New / Not scrapped
        // 2: Fonts have been downloaded
        // 3:: Scrapped JSON from site
        // 4:: Thumbnails downloaded
        // 5:: Template assets has been downloaded
        
        // 6:: Missing FONTS
        // 7:: Missing IMG's
        // 8:: Missing SVG's
        // 8:: JSON Does not exists
        // 9:: No se pudo descargar de la plataforma original

        $this->bulkTemplateVerification();
    }


    function bulkTemplateVerification(){

        $templates = DB::table('templates')
                            ->select('id', 'template_id')
                            // ->whereIn('status', [1,3,4,8])
                            // ->whereIn('status', [1])
                            ->where('source','=', 'templett')
                            ->where('template_id','=', '682087')
							->orderBy('id','DESC')
							// ->limit(1000)
							->get();

        foreach ($templates as $template) {
			$template_key = 'template:en:'.$template->template_id.':jsondata';
            
            print_r("\n>> PARSING TEMPLATE >>".$template_key);

            if( Redis::exists($template_key)) {

                // print_r( $template_key."- EXISTE\n" );
                $pages = Redis::get($template_key);
                $pages = json_decode($pages);
                
                // echo "HIHI";
                // print_r($pages);
                // exit;

                unset( $pages[0] ); // Remove dimentions object

                foreach ($pages as $page) {
                    $objects = $page->objects;
                    
                    print_r("\n>> PARSING PAGE");

                    $downloaded_asset = self::parseTemplateObjects($objects, $template->template_id, $template->id);

                    if( isset( $page->patternSourceCanvas ) && isset($page->patternSourceCanvas->objects) ){
                        self::parseTemplateObjects( $page->patternSourceCanvas->objects, $template->template_id, $template->id);
                    }
                    // print_r( "\n\n".$template_key."->".$downloaded_asset."->".sizeof($objects) );

                    if( $downloaded_asset >= sizeof($objects) ){
                        print_r( "\n".$template_key."- TEMPLATE ASSET's DESCARGADAS" );
                        
                        DB::table('templates')
                            ->where('id', $template->id)
                            ->update(['status' => 5]);
                    }
                }

			} else {
                print_r($template_key."- NO EXISTE\n");
                DB::table('templates')
                            ->where('id', $template->id)
                            ->update(['status' => 8]);
            }
            
		}
    }

    function parseTemplateObjects($objects, $template_key, $template_id){
        $downloaded_asset = 0;
        foreach ($objects as $index => $object) {
                        
            print_r("\n>> PARSING OBJ ".$object->type);

            if($object->type == 'image'){
                if( $this->registerImagesOnDB($object->src, $template_key) ){
                    $downloaded_asset++;
                } else {
                    print_r( "\n".$template_key."- MISSING IMG" );

                    DB::table('templates')
                    ->where('id', $template_id)
                    ->update(['status' => 7]);
                }
            } elseif($object->type == 'path' && isset($object->src) OR $object->type == 'path-group' && isset($object->src) ){
                if( $this->registerSVGsOnDB($object->src, $template_key) ){
                    $downloaded_asset++;
                } else {
                    print_r( "\n".$template_key."- MISSING SVG" );
                    
                    DB::table('templates')
                    ->where('id', $template_id)
                    ->update(['status' => 8]);

                }
            } elseif($object->type == 'textbox' 
                        OR $object->type == 'i-text'){
                
                if( isset($object->fill->src) && $this->registerImagesOnDB($object->fill->src, $template_key) == false){

                    print_r( "\n".$template_key."- MISSING IMG STATUS 7" );

                    DB::table('templates')
                        ->where('id', $template_id)
                        ->update(['status' => 7]);
                }

                if( $this->registerFontsOnDB($object->fontFamily, $template_key) ){
                    $downloaded_asset++;
                    // print_r($downloaded_asset);
                    // exit;
                } else {
                    print_r( "\n".$template_key."- MISSING FONT" );
                    
                    DB::table('templates')
                    ->where('id', $template_id)
                    ->update(['status' => 6]);

                }
            } elseif($object->type == 'rect' 
                        OR $object->type == 'path' 
                        OR $object->type == 'line'
                        OR $object->type == 'circle'
                        OR $object->type == 'polygon'
                        OR $object->type == 'ellipse'
                        OR $object->type == 'activeSelection'
                        OR ($object->type == 'path-group' && isset($object->src) == false)
                        ){
                $downloaded_asset++;
            } elseif($object->type == 'text'){
                if(isset($object->src) && $this->registerImagesOnDB($object->src, $template_key) == false){

                    print_r( "\n".$template_key."- MISSING IMG" );

                    DB::table('templates')
                    ->where('id', $template_id)
                    ->update(['status' => 7]);

                } elseif( $this->registerFontsOnDB($object->fontFamily, $template_key) == false ){
                    
                    print_r( "\n".$template_key."- MISSING FONT" );
                    
                    DB::table('templates')
                    ->where('id', $template_id)
                    ->update(['status' => 6]);

                } else {
                    $downloaded_asset++;
                }
            } elseif($object->type == 'group'){
                print_r(">>>>   PARSING A GRUOP OF OBJECTS >>".$object->type);
                self::parseTemplateObjects($object->objects, $template_key, $template_id);
            } else {
                print_r("TYPE DESCONOCIDO >>".$object->type);
                print_r($object);
                exit;
            }
        }

        return $downloaded_asset;
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
    		->select('template_id','status')
    		->where('template_id','=',$template_id)
    		->where('filename','=',$file_name)
    		->first();
		
		// If this image does not exists on db
		if( isset($images_query->template_id) == false ){
			$path = 'design/template/images/'.$template_id;
			$this->registerAssetOnDB($file_name, $path . '/'.$file_name, $template_id);
        } 
        
        if (isset($images_query->status) &&  $images_query->status == 1) {
            return true;
        }
        return false;
	}

	function registerSVGsOnDB($url, $template_id){
		
		$diagonal = strripos($url, '/')+1;
		$file_name = substr($url, $diagonal, strlen($url));
		
		$svg_query = DB::table('images')
            ->select('template_id','status')
    		->where('template_id','=',$template_id)
    		->where('filename','=',$file_name)
    		->first();
		
		// If font id does not exists on db
		if( isset($svg_query->template_id) == false ){
			$path = 'design/template/images/'.$template_id;
			$this->registerAssetOnDB($file_name, $path . '/'.$file_name, $template_id);
        } 
        
        if (isset($svg_query->status) && $svg_query->status == 1) {
            return true;
        }
        return false;
	}

	function registerFontsOnDB($font_id, $template_id){

		// Check if font/template relationship already exist
		$relationship_query = DB::table('template_has_fonts')
            ->select('template_id','status')
    		->where('template_id','=',$template_id)
    		->where('font_id','=',$font_id)
    		->first();

		// Create relationship between font and template, if it does not exists
		if( isset($relationship_query->template_id) == false ){
			$this->createFontTemplateRelationship($font_id, $template_id);
		}

		$font_query = DB::table('fonts')
    		->select('font_id','status')
    		->where('font_id','=',$font_id)
    		->first();

		// If font id does not exists on db
		if( isset($font_query->font_id) ){
			// Update rest of templates to avoid double download
			DB::table('template_has_fonts')
			    ->where('font_id', $font_id)
                ->update(['status' => 1]);
        } 
        
        if(isset($font_query->status) && $font_query->status == 1) {
            return true;
        }

        return false;

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
