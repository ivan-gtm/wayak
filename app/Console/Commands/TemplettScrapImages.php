<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class TemplettScrapImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:templett:getimagelinks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get image URLs from template source';

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
        $templates = Redis::keys('template:en:*:jsondata');
        foreach($templates as $template_key) {
            $template_key_components = [];
            preg_match_all('/template:en:([a-zA-Z0-9]+):jsondata+/', $template_key, $template_key_components);
            if( isset($template_key_components[1][0]) ){

                $template_id = $template_key_components[1][0];
    
                $db_thumb_row = DB::table('templates')
                                            ->where( 'template_id', '=', $template_id )
                                            ->count();
                    
                if( $db_thumb_row > 0 ){
                    
                    // $template_id = "template:en:EDbP1tV8wf:jsondata";
                    echo "\nTEMPLATE >>";
                    echo "\n".$template_id;
                    
                    $assets = [];
                    $template_content = Redis::get($template_key);
                    echo "\nLENGTH >>".strlen($template_content);
                    
                    if( strlen($template_content) <= 104000 ){
                        preg_match_all('/((https?):\/\/)?[-A-Za-z0-9+&@#\/\%?=~_|!:,.;]+[-A-Za-z0-9+&@#\/\\%=~_|](\.jpg|\.png|\.jpeg|\.svg)/', $template_content, $assets);
                        
                        // print_r($assets);
                        if( isset($assets[0]) == false ){
                            echo "\n<< FIN >>";
                            exit;
                        }elseif( isset($assets[0]) && sizeof($assets[0]) > 0 ){
                            echo "\nIMAGES >>";
                            $images_arr = $assets[0];
                            foreach($images_arr as $img) {
                                
                                print_r("\n\tIMAGE >>".$img);

                                $path = pathinfo($img); // dirname, filename, extension
                                $template_path = str_replace('http://localhost/',null,$img);
                                // $path[dirname] => http://localhost/design/template/nmr5IBZCfa/assets
                                // $path[basename] => 47821_1525751719.jpg
                                // $path[extension] => jpg
                                // $path[filename] => 47821_1525751719
                                print_r("\n\t\tPATH >>".str_replace('http://localhost/',null,$img));
                                // exit;
                                
                                $db_images = DB::table('images')
                                                    ->where('template_id', $template_id)
                                                    ->where('filename', $path['basename'])
                                                    ->count();
                                
                                if( $db_images == 0 ){
                                    // print_r($path);
                                    // exit;
                                    DB::table('images')->insert([
                                        'id' => null,
                                        'source' => 'templett',
                                        'template_id' => $template_id,
                                        'img_path' => $template_path,
                                        'original_path' => '/application/public/'.$template_path,
                                        'file_type' => $path['extension'],
                                        'filename' => $path['basename'],
                                        'status' => 0 // Estado inicial, metadatos extraidos de etsy
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }

        // ((http|https)\:\/\/[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-zA-Z0-9](?:\.[a-zA-Z]{2,})*\/design\/template\/[a-zA-Z0-9]*\/assets\/(.)+(\.png|\.jpg|\.jpeg\.svg))
        
        // $template_content = Redis::get('template:en:H7wdX5t5Kn:jsondata');
        // $template_content = Redis::get('template:en:gmnftcCJWK:jsondata');
        
        

    }

}
