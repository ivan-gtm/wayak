<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ScrapFonts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:scrapfonts';

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
        $fonts_to_download = DB::select('SELECT font_id FROM template_has_fonts WHERE  status = ? LIMIT 1600', [0]);
        
        // print_r(sizeof($fonts_to_download));
        // exit;

        // Create relationship between font and template, if it does not exists
        if( sizeof($fonts_to_download) > 0 ){
            foreach( $fonts_to_download as $font ){
                // print_r($font->font_id);
                $this->downloadFont($font->font_id);
            }
        }

        // Set templates as status 2: Fonts have been downloaded
        /*
        DB::statement("UPDATE templates SET status = 2 WHERE template_id IN(
                            SELECT template_id FROM (
                                SELECT template_has_fonts.template_id, COUNT(template_has_fonts.id) fonts, SUM(template_has_fonts.status) downloaded_fonts 
                                FROM template_has_fonts, templates
                                WHERE template_has_fonts.template_id = templates.template_id
                                AND templates.status = 1
                                GROUP BY template_has_fonts.template_id
                                LIMIT 1000
                            ) fonts 
                            WHERE fonts = downloaded_fonts
                        )");
        */
        
        echo "\nTermine Fonts\n";
    }

    function customBulkFontDownload(){
        $fonts = [];

        // echo sizeof($fonts);
        // exit;

        foreach ($fonts as $font_id) {
            $this->downloadFont($font_id);
            echo "Se ha descargado fuente $font_id\n";
            usleep(500000);
        }

    }

    function downloadFont( $font_id ){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://templett.com//design/app/get-glyphs-by-font/$font_id",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "authority: templett.com",
            "sec-ch-ua: \"Google Chrome\";v=\"87\", \" Not;A Brand\";v=\"99\", \"Chromium\";v=\"87\"",
            "accept: application/json, text/javascript, */*; q=0.01",
            "x-requested-with: XMLHttpRequest",
            "sec-ch-ua-mobile: ?0",
            "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36",
            "x-demo-templett-jwt: eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImtpZCI6InRlbXBsZXR0In0.IntcImlkXCI6XCJjZDJkYzU3MjNiYjQxN2U4YzU4ZWQyNmYwNzAxYmNmZlwiLFwidWlkXCI6XCJjZDJkYzU3MjNiYjQxN2U4YzU4ZWQyNmYwNzAxYmNmZlwiLFwiZGVtb0FzXCI6dHJ1ZSxcInRlbXBsYXRlSWRzXCI6W1wiMjA5ODU0MFwiLFwiMjA5ODUyN1wiLFwiMjA5ODU1M1wiLFwiMjEwMDIzNlwiLFwiMjEwMDIyNVwiLFwiMjA5ODU1NlwiXSxcImF2YXRhclwiOlwiaHR0cHM6XFxcL1xcXC90ZW1wbGV0dC5jb21cXFwvYWRtaW5cXFwvYXNzZXRzXFxcL2ltZ1xcXC9sb2dvLXJldGluYS5wbmdcIixcInJvbGVcIjpcImRlbW9cIixcImVtYWlsXCI6XCJkZW1vQHRlbXBsZXR0LmNvbVwiLFwidXNlcm5hbWVcIjpcImRlbW9cIixcImxhbmd1YWdlXCI6XCJlbmdsaXNoXCIsXCJ1bmlxdWVfaWRcIjpcInNpZF81ZmY3OTU5MjZhOTgyXCIsXCJsb2NhdGlvblwiOntcImNvdW50cnlfY29kZVwiOlwiTVhcIixcImNvdW50cnlfbmFtZVwiOlwiTWV4aWNvXCIsXCJjaXR5X25hbWVcIjpcIkNpdWRhZCBOZXphaHVhbGNveW90bFwiLFwidGltZV96b25lXCI6XCItMDU6MDBcIn0sXCJjcmVhdGVkXCI6MTYxMDA2MTIwMixcImV4cFwiOjE2MTAxNDc2MDJ9Ig.OifiAgMeR6Dj_c_7CeP3lcMilSMNMIQM2hS8CLQMFtXehc-m5pxyWmGffLwREEHqjwf8jXI_Y7gKIi9kL65NoyMo2UHtOcNnl0leeK-4Ty-25_wGmkV4jMQmEE17bElU4ATL4R5zCsTY5N7csrcfiHXNUhSsdciJT5X7g-29cEIm_v5RSNhDjYejrhZgBZ9-9_WpRxBYTdmXq9bKesi5Oams0P9WCt5bGoq_g-o4RA885V-OmO8fq7hdqD9iIHjVCbX2vpBhFQeHnPXmNrg0RunZcT3arb0-9jaaOyp2lb2o-RL-ll-aWaFSJuthZ9jtbex89q4sKNQCgOoqhgtfYw",
            "sec-fetch-site: same-origin",
            "sec-fetch-mode: cors",
            "sec-fetch-dest: empty",
            "referer: https://templett.com/design/demo/charmingendeavours/2098540,2098527,2098553,2100236,2100225,2098556",
            "accept-language: es",
            "cookie: _ga=GA1.2.587096415.1606941442; PHPSESSID=7f6d47a47d599e44286ea45a9c516045; demo_visit_id=%5B1802071%2C1804537%2C1804626%2C1804635%2C1804636%2C1830732%2C1831780%2C1837028%2C1848692%2C1850740%2C1850743%5D; _gid=GA1.2.1431269747.1610061208; _gat_gtag_UA_11626417_21=1"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        // echo $response;
        // exit;
        
        $font_info = json_decode($response);
        $url  = $font_info->url;
        $font_name = substr($font_info->url, strrpos($font_info->url, "/")+1, strlen($font_info->url));

        // print_r("\n");
        // print_r($font_info);
        // print_r($url);
        // print_r("\n");
        // exit;

        // Download font to server
        $path = public_path('design/fonts_new');
        
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

        // Once we have font name we register this info on database
        $this->registerFontOnDB($font_id, $font_name);

    }

    function registerFontOnDB($font_id, $file_name){
        $font_exists = DB::table('fonts')
            ->select('font_id')
            ->where('font_id','=',$font_id)
            ->first();

        if( isset($font_exists->font_id) == false ){
            DB::table('fonts')->insert([
                    'font_id' => $font_id,
                    'name' => $file_name,
                    'status' => 1
                ]);
        }

        // Update all font db
        DB::table('template_has_fonts')
            ->where('font_id', $font_id)
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
