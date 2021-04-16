<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class AssignTemplateID extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:1-assigntemplateid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign Template ID';

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
     * @return int
     */
    public function handle()
    {
        $templates = DB::table('templates')
                            ->select('id', 'template_id', 'original_template_id')
                            ->where('status','=', '5')
                            ->whereRaw('template_id = original_template_id')
                            ->orderBy('id','DESC')
							->limit(3000)
							->get();

        foreach( $templates as $template ) {
            $template_id = $template->template_id;
            $template_key = 'template:en:'.$template_id.':jsondata'; 
            
            if( Redis::exists($template_key) ){
                $new_template_id = Str::random(10);

                print_r($template->template_id);
                print_r("\n");
                
                self::updateAssetsFolder($template_id, $new_template_id);
                self::updateREDISKeyname($template_id, $new_template_id);
                self::updateTemplateIDOnDB($template_id, $new_template_id);
            } else {
                DB::table('templates')
                    ->where('id', $template->id )
                    ->update([ 'status' => 8 ]);
            }
        }

    }

    function updateTemplateIDOnDB($template_id, $new_template_id){
        DB::table('templates')
                ->where('template_id', $template_id)
                ->update(['template_id' => $new_template_id]);
        
        DB::table('thumbnails')
                ->where('template_id', $template_id)
                ->update(['template_id' => $new_template_id]);
    }

    function updateAssetsFolder($template_id, $new_template_id){

        $source = public_path('design/template/'.$template_id);
        $destination = public_path('design/template/'.$new_template_id);
        $production = public_path('design/production/template/'.$new_template_id);
        $backup = public_path('design/backup/template/'.$template_id);
        
        print_r("\n");
        print_r($source);
        print_r("\n");
        print_r($destination);
        print_r("\n");
        print_r($backup);
        print_r("\n");
        print_r($production);
        print_r("\n");

        // Backup
        self::recurseCopy($source, $backup);
        // Assets rename folder
        self::recurseCopy($source, $destination);
        
        // Production
        self::recurseCopy($destination, $production);

        self::deleteFiles($source);
                    
    }

    function recurseCopy($src,$dst, $childFolder='') { 

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
    
    function deleteFiles($dirname) { 
        
        if (is_dir($dirname))
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

    function updateREDISKeyname($template_id, $new_template_id){
        
        $template_key = 'template:en:'.$template_id.':jsondata';
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
}
