<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CrelloCreateThumbnails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crello:create_thumbnails';

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
     * @return int
     */
    public function handle()
    {

        // $template_keys = Redis::keys('template:*:jsondata');
        // foreach ($template_keys as $template_key) {
        //     if(strpos($template_key,':en:') == false && strpos($template_key,':es:') == false){
        //         $new_template_key = str_replace('template:', null, $template_key);
        //         $new_template_key = str_replace(':jsondata', null, $new_template_key);
        //         print_r( "\n".$template_key.' '.$new_template_key." - \n" );
        //         Redis::rename($template_key, 'template:en:'.$new_template_key.':jsondata');
        //     }
        // }
        // exit;

        $template_keys = Redis::keys('template:*:jsondata');
        foreach ($template_keys as $template_key) {
            $template_key = str_replace('template:', null, $template_key);
            $template_key = str_replace(':jsondata', null, $template_key);

            $thumbnail_rows = DB::table('thumbnails')
                ->where('template_id','=',$template_key)
                ->count();

            if( $thumbnail_rows == 0 ){

                $path = public_path().'/design/template/' . $template_key.'/thumbnails/';
                $preview_path = public_path().'/design/template/' . $template_key.'/assets/';
                File::makeDirectory($path, $mode = 0777, true, true);
    
                if (file_exists( $preview_path . 'preview.jpg')) {
                    File::move($preview_path. 'preview.jpg', $path. 'preview.jpg');    
                }
                
                if( Redis::exists('crello:template:'.$template_key) ){
                    // echo "<pre>";
                    // print_r( json_decode( Redis::get('crello:template:'.$template_key) ) );
                    // exit;
                    $template_obj = json_decode( Redis::get('crello:template:'.$template_key) );
                    $title = isset($template_obj->title) ? $template_obj->title : $template_obj->name;
                    
                    DB::table('thumbnails')->insert([
                        'id' => null,
                        'template_id' => $template_key,
                        'title' => htmlspecialchars_decode( $title ),
                        'filename' => 'preview.jpg',
                        'tmp_original_url' => null,
                        'dimentions' => '4x7 in',
                        'tmp_templates' => $template_key,
                        'language_code' => 'en',
                        'status' => 1
                    ]);

                }
                // exit;
            } else {
                // $thumbnail_info = DB::table('thumbnails')
                //     ->where('template_id','=',$template_key)
                //     ->first();
                // echo "<pre>";
                // print_r( $thumbnail_info );
                // exit;
            }

            // print_r($path);
            // // print_r($template_key);
            // exit;
            // print_r($thumb_info);
            // exit;
        }

        echo sizeof( Redis::keys('template:*:jsondata') );

        return 0;
    }
}
