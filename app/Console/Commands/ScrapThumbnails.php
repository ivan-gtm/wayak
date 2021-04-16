<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ScrapThumbnails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:scrapthumbnails';

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
        $this->bulkThumbnailDownload();
    }

    function downloadThumbnails($url, $template_id){
        $path = str_replace('https://dbzkr7khx0kap.cloudfront.net/', null, $url);
        $file_name = str_replace('thumbs/', null, $path);
    
        $path = public_path('design/template/'.$template_id.'/thumbnails/');

        if (file_exists($path . '/'.$file_name)) {
            echo "The file $path / $file_name exists \n";
        } else {
            echo "The file $path / $file_name does not exist \n";

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

    function bulkThumbnailDownload(){
        // Check if font/template relationship already exist
        // $thumbs_to_download = $mysqli->query("SELECT id, template_id, filename, tmp_original_url FROM thumbnails WHERE status = 0 LIMIT 100");

        $thumbs_to_download = DB::select('
        SELECT id,template_id,filename,tmp_original_url FROM thumbnails
        WHERE 
            status = 0
        LIMIT 5000');

        // print_r($thumbs_to_download);
        // exit;

        // Create relationship between font and template, if it does not exists
        // if( $thumbs_to_download->num_rows > 0 ){
            // while( $thumb_row = $thumbs_to_download->fetch_assoc() ){
            foreach ($thumbs_to_download as $key => $thumb_row) {
                
                $url = $thumb_row->tmp_original_url;
                $this->downloadThumbnails( $url, $thumb_row->template_id );

                // $mysqli->query("UPDATE thumbnails SET status = 1 WHERE id =".$thumb_row->id);
                DB::table('thumbnails')
                    ->where('id', $thumb_row->id)
                    ->update(['status' => 1]);

                DB::table('templates')
                    ->where('template_id', $thumb_row->template_id)
                    ->update(['status' => 4]);

            }
        // }

        // Set templates as status 3: 
        // $mysqli->query("UPDATE templates SET status = 2 WHERE template_id IN(
        //              SELECT template_id FROM (SELECT template_id, COUNT(id) fonts, SUM(status) downloaded_fonts FROM template_has_fonts GROUP BY template_id) fonts 
        //              WHERE fonts = downloaded_fonts
        //              )");
        echo "Termine thumbnails<br>";
    }
}
