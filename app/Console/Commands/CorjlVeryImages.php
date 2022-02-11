<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Image;

class CorjlVeryImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:corjl:verify-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create image thumbnails from every asset image template';

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
        $this->bulkTemplateAssetsDownload();
    }


    function bulkTemplateAssetsDownload(){

        $templates = DB::table('templates')
                    ->select('id', 'template_id','original_template_id')
                    ->where('source','=','corjl')
                    ->orderByDesc('id')
                    ->get();

        foreach ($templates as $template) {
            
            $local_path = public_path('design/template/'.$template->template_id.'/assets/');
            
            print_r("\n\nPARSING >>".$template->template_id."\n");
            
            $missing_images = false;
            // Templat assets folder exists
            if( file_exists( $local_path ) ) {
                $scan = scandir( $local_path );
                foreach($scan as $file_name) {

                    $file_path_info = pathinfo($file_name);

                    if( isset($file_path_info['extension']) && 
                        (
                            $file_path_info['extension'] == 'png'
                            || $file_path_info['extension'] == 'jpg'
                            || $file_path_info['extension'] == 'jpeg'
                            || $file_path_info['extension'] == 'svg'
                        )
                        ) {

                            if( file_exists( $local_path.$file_name ) == true && filesize( $local_path.$file_name ) == 0) {
                                
                                print_r( "\n\tImagen mal descargada >>".$local_path.$file_name );
                                $missing_images = true;
                                
                                // if( is_file( $local_path.$file_name ) ) {
                                    unlink( $local_path.$file_name );
                                // }

                            }
                    }
                }
            }

            if($missing_images){
                
                // Redis::del('corjl:'.$template->original_template_id);
                DB::table('thumbnails')
                    ->where('template_id', $template->template_id)
                    ->update(['status' => 0]);
                
                // DB::table('templates')
                //     ->where('template_id', $template->template_id)
                //     ->update(['status' => 7]);
            }
        }
    }

}
