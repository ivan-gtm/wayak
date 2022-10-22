<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class TemplettScrapAssets extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:templett:download-assets';

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
        $this->bulkTemplateAssetsDownload();
    }


    function bulkTemplateAssetsDownload(){

        // Check if font/template relationship already exist
        $assets_to_download = DB::table('images')
                    ->select('id', 'template_id','img_path', 'filename','status')
                    ->where('status', '=', '0')
                    // ->where('template_id', '=', 799782)
                    ->limit(10000)
                    ->get();

        // echo "<pre>";
        // print_r( $assets_to_download);
        // exit;

        // Create relationship between font and template, if it does not exists
        if( $assets_to_download->count() > 0 ){
            // while( $font_row = $assets_to_download->fetch_assoc() ){
            foreach( $assets_to_download as $asset ){
                
                $existing_asset = DB::table('images')
                                        ->where('filename', $asset->filename )
                                        ->where('status', 1 )
                                        ->first();
                // echo "<pre>";
                // print_r( $existing_asset);
                // exit;

                // $existing_img_row = $mysqli->query("SELECT filename,template_id, tmp_path FROM images WHERE filename = '".$asset->filename."' AND status = 1 LIMIT 1");

                // Verify if an image is already donwloaded for another template
                if( $existing_asset != null && isset($existing_asset->id) ){

                    $old_path = public_path('design/template/'.$existing_asset->template_id.'/assets/'.$existing_asset->filename);
                    $new_path = public_path('design/template/'.$asset->template_id.'/assets/'.$asset->filename);
                    
                    // print_r(sizeof($existing_asset));
                    // print_r("\n");
                    // print_r($old_path);
                    // print_r("\n");
                    // print_r($new_path);
                    // print_r("\n");
                    // exit;

                    if( file_exists( $old_path ) ) {

                        echo "Se va a copiar <br>".$old_path.' hacia '.$new_path."\n";
                        $this->copyImage( $old_path, $new_path );
                        
                    } else {

                        DB::table('images')
                            ->where('id', $existing_asset->id)
                            ->update(['status' => 0]);

                    }

                } else {
                    $url = 'https://dbzkr7khx0kap.cloudfront.net/'.$asset->filename;
                    // print_r($url);
                    // exit;
                    $this->downloadImage( $asset->template_id, $asset->filename, $url );
                }

                // $mysqli->query("UPDATE images SET status = 1 WHERE id =".$font_row['id']);
                DB::table('images')
                        ->where('id', $asset->id)
                        ->update(['status' => 1]);

            }
        }

        // Set templates as status 3: 
        DB::statement("UPDATE templates SET status = 3 WHERE template_id IN(
                            SELECT template_id FROM (
                                SELECT images.template_id, COUNT(images.id) images, SUM(images.status) downloaded_images 
                                                                    FROM images, templates
                                                                WHERE images.template_id = templates.template_id
                                                                    AND templates.status = 2
                                                                GROUP BY images.template_id
                                                                    LIMIT 1000
                            ) tmp_images 
                            WHERE images = downloaded_images
                        )");
        echo "Termine\n";
    }

    function copyImage($old_path, $new_path){
        $path = pathinfo($new_path); // dirname, filename, extension
        
        if (!file_exists($path['dirname'])) {
            @mkdir($path['dirname'], 0777, true);
        }   
        if (!copy($old_path,$new_path)) {
            echo "copy failed \n";
        }
    }

    function downloadImage($template_id, $file_name, $url){
        $path = public_path('design/template/'.$template_id.'/assets');

        @mkdir($path, 0777, true);

        set_time_limit(0);

        //This is the file where we save the    information
        $fp = fopen ($path . '/'.$file_name, 'w+');

        //Here is the file we are downloading, replace spaces with %20
        $ch = curl_init(str_replace(" ","%20",$url));
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        
        // write curl response to file
        curl_setopt($ch, CURLOPT_FILE, $fp); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        // get curl response
        curl_exec($ch); 
        curl_close($ch);
        fclose($fp);
    }
}
