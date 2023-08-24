<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
use Image;

class UnifyTemplateFolders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:unifyfolders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $this->fixTemplateFolders();
    }


    function fixTemplateFolders()
    {
        $local_path = public_path('assets-gallery');
        $templates = Redis::keys('template:*:jsondata');
        // $language = ;
        
        $menu = [];
        foreach($templates as $template_key) {
            $template_key_components = [];
            preg_match_all('/template:([0-9]+):jsondata+/', $template_key, $template_key_components);
            if( isset($template_key_components[1][0]) ){
                $original_product_key = $template_key_components[0][0];
                $template_id = $template_key_components[1][0];
                
                $new_template_id = Str::random(10);

                echo "\n";
                echo "\n";
                echo "\n";
                print_r("original_product_key");
                echo "\n";
                print_r($original_product_key);
                echo "\n";
                echo "\n";
                print_r("template_id");
                echo "\n";
                print_r($template_id);
                
                
                $db_thumb_row = DB::table('thumbnails')
                                        ->select('template_id','status')
                                        ->where( 'original_template_id', '=', $template_id )
                                        ->count();
                
                if( $db_thumb_row > 0 ){
                    // $db_thumb = DB::table('thumbnails')
                    //                     ->select('template_id','status')
                    //                     ->where( 'original_template_id', '=', $template_id )
                    //                     ->first();

                    // $new_template_id = $db_thumb->template_id;
                    // echo "\nSE VA QUEDAR";
                    // echo "\n";
                    // echo $new_template_id;
                    
                    self::updateTemplateIDOnDB($template_id, $new_template_id);

                } else {
                    echo "\nSE VA INSERTAR NUEVO ROW";
                    
                    $parent_template_id = null;
                    $template_info['template_id'] = $new_template_id;
                    $template_info['title'] = 'Template '.$new_template_id;
                    $template_info['filename'] = $new_template_id.'_thumbnail.png';
                    $template_info['dimentions'] = null;
                    $file_name = null;
                    $dimentions = null;
                    $templates_name = null;
                    $fk_etsy_template_id = null;

                    $width = null;
                    $height = null;
                    $measureUnits = null;
                    $fk_etsy_template = DB::table('tmp_etsy_metadata')
                                                    ->select('id','templett_url')
                                                    ->where('templett_url', 'like', '%'.$template_id.'%')
                                                    ->first();
                    if( isset($fk_etsy_template->id) ){
                        $fk_etsy_template_id = $fk_etsy_template->id;
                    } 
                    $parent_template_id = ( $parent_template_id == null ) ? $new_template_id : $parent_template_id;

                    self::registerThumbOnDB($new_template_id, $templates_name, $file_name, $dimentions, $template_id);
                    self::registerTemplateOnDB($new_template_id, $template_id, $templates_name, $fk_etsy_template_id, $parent_template_id, $width, $height, $measureUnits);
                }

                self::updateREDISKeyname($template_id, $new_template_id);
                // self::updateAssetsFolder($template_id, $new_template_id);

            }
            
        }
        
    }
    

    function updateTemplateIDOnDB($template_id, $new_template_id){
        // $db_templates = DB::table('thumbnails')
        //                                 ->select('template_id','status')
        //                                 ->where( 'template_id', '=', $new_template_id )
        //                                 ->first();
        // $db_thumbnails = DB::table('thumbnails')
        //                                 ->select('template_id','status')
        //                                 ->where( 'template_id', '=', $new_template_id )
        //                                 ->first();
                                        
        // if( !isset($db_templates->template_id) ){
            DB::table('templates')
                    ->where('template_id', $template_id)
                    ->update(['template_id' => $new_template_id]);
        // }
        
        // if( !isset($db_thumbnails->template_id) ){
            DB::table('thumbnails')
                    ->where('template_id', $template_id)
                    ->update(['template_id' => $new_template_id]);
        // }
    }

    function updateAssetsFolder($template_id, $new_template_id){

        $source = public_path('design/template/'.$template_id);
        $destination = public_path('design/template/'.$new_template_id);
        // $production = public_path('design/production/template/'.$new_template_id);
        // $backup = public_path('design/backup/template/'.$template_id);
        
        print_r("\n");
        print_r($source);
        print_r("\n");
        print_r($destination);
        print_r("\n");
        

        // Backup
        // self::recurseCopy($source, $backup);
        // // Production
        // self::recurseCopy($destination, $production);

        // Assets rename folder
        self::recurseCopy($source, $destination);
        

        self::deleteFiles($source);
                    
    }

    function recurseCopy($src,$dst, $childFolder='') {

        if(@opendir($src)){

            $dir = opendir($src); 
            @mkdir($dst);
            if ($childFolder!='') {
                @mkdir($dst.'/'.$childFolder);
        
                while(false !== ( $file = readdir($dir)) ) { 
                    if (( $file != '.' ) && ( $file != '..' )) { 
                        if ( is_dir($src . '/' . $file) ) { 
                            $this->recurseCopy($src . '/' . $file,$dst.'/'.$childFolder . '/' . $file); 
                        } 
                        else { 
                            copy($src . '/' . $file, $dst.'/'.$childFolder . '/' . $file); 
                        }  
                    } 
                }
            }else{
                    // return $cc; 
                while(false !== ( $file = readdir($dir)) ) { 
                    if (( $file != '.' ) && ( $file != '..' )) { 
                        if ( is_dir($src . '/' . $file) ) { 
                            $this->recurseCopy($src . '/' . $file,$dst . '/' . $file); 
                        } 
                        else { 
                            copy($src . '/' . $file, $dst . '/' . $file); 
                        }  
                    } 
                } 
            }
            
            closedir($dir); 
        }
    }
    
    function deleteFiles($dirname) { 
        
        if (is_dir($dirname)){
            $dir_handle = opendir($dirname);
            if (!$dir_handle)
                return false;
            while($file = readdir($dir_handle)) {
                if ($file != "." && $file != "..") {
                        if (!is_dir($dirname."/".$file))
                            unlink($dirname."/".$file);
                        else
                            self::deleteFiles($dirname.'/'.$file);
                }
            }
            closedir($dir_handle);
            rmdir($dirname);
            return true;
        }
        return false;

    }

    function updateREDISKeyname($template_id, $new_template_id){
        
        $template_key = 'template:'.$template_id.':jsondata';
        $new_template_key = 'template:en:'.$new_template_id.':jsondata';

        if( Redis::exists($template_key)) {
            // print_r('RENAMING REDIS KEY...');
            // print_r("\n");
            // print_r('OLD KEY >>'. $template_key);
            // print_r("\n");
            // print_r('NEW KEY >>'. $new_template_key);
            // print_r("\n");
            
            Redis::rename( $template_key, $new_template_key);
            Redis::set( $new_template_key, str_replace($template_id, $new_template_id, Redis::get( $new_template_key ) ) );
            
        }

    }
    
    function registerTemplateOnDB($template_id, $original_template_id, $name, $fk_etsy_template_id,$parent_template_id, $width, $height, $measureUnits){
        
        $thumbnail_rows = DB::table('templates')
                            ->where('original_template_id','=',$template_id)
                            ->count();
    
        if( $thumbnail_rows == 0 ){
            // echo "template_id";
            // echo $template_id;
            // exit;
            // echo "\n\n\n\noriginal_template_id";
            // exit;
            DB::table('templates')->insert([
                'id' => null,
                'source' => 'templett',
                'template_id' => $template_id,
                'original_template_id' => $original_template_id,
                // 'name' => htmlspecialchars_decode( $name ),
                'fk_etsy_template_id' => $fk_etsy_template_id,
                'status' => 0,
                'parent_template_id' => $parent_template_id,
                'width' => $width,
                'height' => $height,
                'metrics' => $measureUnits
            ]);
        }
    }

    function registerThumbOnDB($template_id, $title, $filename,$dimentions, $product_key){
        
        $thumbnail_rows = DB::table('thumbnails')
                            ->where('original_template_id','=',$template_id)
                            ->count();
    
        if( $thumbnail_rows == 0 ){
            DB::table('thumbnails')->insert([
                'id' => null,
                'template_id' => $template_id,
                'title' => htmlspecialchars_decode( $title ),
                'filename' => $filename,
                'dimentions' => $dimentions,
                'tmp_templates' => $template_id,
                'language_code' => 'en',
                'status' => 1,
                'original_template_id' => $product_key
            ]);
        }
    }
}
