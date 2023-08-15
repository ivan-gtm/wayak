<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class CorjlScrapFonts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:corjl:scrapfonts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Extract font assets for template catalog';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    function bulkFontsDownload(){
        
        // Collect all fonts are pending to download
        $fonts_to_download = DB::select("SELECT*FROM fonts WHERE source='corjl' AND `status`=0 ORDER BY id DESC", [0]);
        
        // print_r(sizeof($fonts_to_download));
        // exit;

        // Create relationship between font and template, if it does not exists
        if( sizeof($fonts_to_download) > 0 ){
            foreach( $fonts_to_download as $font ){
                // print_r($font->font_id);
                $this->downloadFont($font);
            }
        }

        echo "\nTermine Fonts\n";
    }

    function downloadFont( $font ){

        // $font_info = json_decode($response);
        $url  = $font->url;
        $font_name = $font->filename;

        // print_r("\n");
        // print_r($font_info);
        // print_r($url);
        // print_r("\n");
        // exit;

        // Download font to server
        $path = public_path('design/fonts_new/corjl');
        
        @mkdir($path, 0777, true);

        set_time_limit(0);
        //This is the file where we save the    information
        $fp = fopen ($path . '/'.$font_name, 'w+');
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

        DB::table('fonts')
            ->where('id', $font->id)
            ->update(['status' => 1]);

    }

    

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->bulkFontsDownload();
        // $this->customBulkFontDownload();
    }
}
