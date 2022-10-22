<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class CorjlImageScrapper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:corjl:image-downloader';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrap Corjl template';

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
        self::generateWayakTemplate();
    }

    function generateWayakTemplate()
    {

        // $product = Redis::keys('corjl:MO2BOM');
        $product = Redis::keys('corjl:11F0OP');

        foreach ($product as $product_key) {

            $template_svg_path = public_path('/corjl/design/template/' . str_replace('corjl:', null, $product_key) . '/svg_template_0_page_1.svg');

            if (file_exists($template_svg_path) && filesize($template_svg_path) > 0) {
                $template_svg_path = public_path('/corjl/design/template/' . str_replace('corjl:', null, $product_key) . '/');
                $scan = scandir($template_svg_path);
                foreach ($scan as $file_name) {

                    $file_path_info = pathinfo($file_name);

                    if (isset($file_path_info['extension']) && $file_path_info['extension'] != '') {

                        print_r("\n<< PAGE >> " . $file_name);

                        $file_content = self::openSVGTemplate($template_svg_path.$file_name);

                        preg_match_all('/((https?):\/\/)?[-A-Za-z0-9+&@#\/\%?=~_|!:,.;]+[-A-Za-z0-9+&@#\/\\%=~_|](\.jpg|\.png|\.jpeg|\.svg)/', $file_content, $assets);

                        if (isset($assets[0]) == false) {
                            echo "\n<< FIN >>";
                            exit;
                        } elseif (isset($assets[0]) && sizeof($assets[0]) > 0) {
                            print_r("\nIMAGES >>");
                            $images_arr = $assets[0];
                            foreach ($images_arr as $img) {

                                
                                print_r("\n");
                                print_r("\n\tIMAGE >> " . $img);
                                
                                $template_id = Str::random(10);
                                $path = pathinfo($img); // dirname, filename, extension
                                $template_path = str_replace('http://localhost/', null, $img);

                                // $path[dirname] => http://localhost/design/template/nmr5IBZCfa/assets
                                // $path[basename] => 47821_1525751719.jpg
                                // $path[extension] => jpg
                                // $path[filename] => 47821_1525751719

                                print_r("\n\t\tTEMPLATE ID >> " . $template_id);
                                print_r("\n\t\tFILENAME >> " . $path['basename'] );
                                print_r("\n\t\tPATH >>" . str_replace('http://localhost/', null, $img));
                                print_r("\n\t\tIMG PATH >>" . '/application/public/design/template/'.$template_id.'/assets/'.$path['filename']);
                                // exit;

                                // $db_images = DB::table('images')
                                //     ->where('template_id', $template_id)
                                //     ->where('filename', $path['basename'])
                                //     ->count();

                                // if ($db_images == 0) {
                                //     // print_r($path);
                                //     // exit;
                                //     DB::table('images')->insert([
                                //         'id' => null,
                                //         'source' => 'corjl',
                                //         'template_id' => $template_id,
                                //         'img_path' => $template_path,
                                //         'original_path' => '/application/public/' . $template_path,
                                //         'file_type' => $path['extension'],
                                //         'filename' => $path['basename'],
                                //         'status' => 0 // Estado inicial, metadatos extraidos de etsy
                                //     ]);
                                // }
                            }
                        }
                    }
                }
            } else {
                echo "\n" . 'DOES NOT EXISTS >>' . $template_svg_path;
                // Redis::del($product_key);
            }
        }

        print_r("\n\n");
    }



    function openSVGTemplate($svg_file_path)
    {
        // echo '<br>';
        // print_r( $svg_file_path );
        // exit;

        // if ( file_exists( $svg_file_path ) ) {
        $svg_content = file_get_contents($svg_file_path);
        return $svg_content;
        // } else {
        //     return null;
        // }
    }

    function generateRandString($length = 15)
    {
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($permitted_chars), 0, $length);
    }

    function parseTemplatePages($pages, $template_id)
    {
        foreach ($pages as $page) {
            // if( isset($page->thumbnail) ){
            //     $local_img_path = public_path().'/design/template/'.$template_id.'/thumbnails/en/';
            //     $file_name = self::downloadImage( $template->thumb_url,$local_img_path, $template_id);
            //     // self::registerThumbOnDB($template_id, $template->name, $file_name, $template->dimentions);
            // }

            foreach ($page->images as $image_url) {
                // echo $image_url;
                // exit;
                $local_img_path = public_path() . '/design/template/' . $template_id . '/assets/';
                $file_name = self::downloadImage($image_url, $local_img_path, $template_id);
            }
        }
    }

    function registerTemplateOnDB($template_id, $original_template_id, $name, $fk_etsy_template_id, $parent_template_id, $width, $height, $measureUnits)
    {

        $thumbnail_rows = DB::table('templates')
            ->where('template_id', '=', $template_id)
            ->count();

        if ($thumbnail_rows == 0) {
            DB::table('templates')->insert([
                'id' => null,
                'source' => 'corjl',
                'template_id' => $template_id,
                'original_template_id' => $original_template_id,
                // 'name' => htmlspecialchars_decode( $name ),
                'fk_etsy_template_id' => $fk_etsy_template_id->id,
                'status' => 0,
                'parent_template_id' => $parent_template_id,
                'width' => $width,
                'height' => $height,
                'metrics' => $measureUnits
            ]);
        }
    }

    function registerFontOnDB($name, $url)
    {

        $thumbnail_rows = DB::table('fonts')
            ->where('name', '=', $name)
            ->count();

        if ($thumbnail_rows == 0) {
            $font_id = self::generateRandString(10);

            DB::table('fonts')->insert([
                'id' => null,
                'name' => $name,
                'url' => $url,
                'font_id' => $font_id,
                'status' => 1,
                'source' => 'corjl'
            ]);
        }
    }

    function downloadImage($img_url, $local_img_path, $template_id)
    {
        $url_info = pathinfo($img_url);
        $full_local_img_path = $local_img_path . $url_info['basename'];

        $path_info = pathinfo($full_local_img_path);
        $path = $path_info['dirname'];
        $file_name = $path_info['basename'];

        if (file_exists($full_local_img_path) == false) {


            @mkdir($path, 0777, true);

            set_time_limit(0);

            //This is the file where we save the    information
            $fp = fopen($path . '/' . $file_name, 'w+');
            //Here is the file we are downloading, replace spaces with %20
            $ch = curl_init(str_replace(" ", "%20", $img_url));
            curl_setopt($ch, CURLOPT_TIMEOUT, 50);
            // write curl response to file
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            // get curl response
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);
        }

        return $file_name;
    }

    function svgToJSON($svg_content)
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "nodejs:8080/api/svg2json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "svg_content=" . urlencode($svg_content),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}
