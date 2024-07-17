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
    protected $signature = 'wayak:corjl:img-downloader';

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

        $templates = DB::table('corjl_template')
                            ->select('id', 'template_id')
                            ->where('status','=', '1')
                            ->orderBy('id','ASC')
							->limit(10000)
							->get();

        foreach( $templates as $current_template ) {
            print_r("TEMPLATE >> ");
            echo $current_template->template_id;
            print_r("\n");
            
            $corjl_template_key = str_replace('corjl:', null, $current_template->template_id);

            $tmp_etsy_metadata = DB::table('tmp_etsy_metadata')
                                    ->select('id','templett_url')
                                    ->where('templett_url', 'like', '%'.$corjl_template_key)
                                    ->first();
 
            $template_metadata_id = (isset( $tmp_etsy_metadata->id ) ? $tmp_etsy_metadata->id : 99999);
            
            $content = Redis::get($current_template->template_id);
            $content_obj = json_decode($content);
            // print_r($content_obj);
            // exit;
            if( isset($content_obj->templates) ){
                foreach ($content_obj->templates as $template) {
                    
                    $template_id = Str::random(10);
                    
                    print_r("\n\n<< TEMPLATE >> " . $template_id);
                    
                    print_r("\n\t TEMPLATE ID >> $template_id");
                    print_r("\n\t ORIGINAL TEMPLATE ID >> $corjl_template_key");
                    print_r("\n\t NAME >>".$template->name);
                    print_r("\n\t FK_ETSY_TEMPLATE_ID >>".$template_metadata_id);
                    
                    $dimentions = explode('x',str_replace('in',null, $template->dimentions));
                    print_r("\n\t DIMENTIONS WIDTH >>".$dimentions[0] );
                    print_r("\n\t DIMENTIONS HEIGHT >>".$dimentions[1] );
    
                    self::registerTemplateOnDB($template_id, $corjl_template_key, $template->name, $template_metadata_id, null, $dimentions[0], $dimentions[1], 'in');
                    
                    if(isset($template->pages) && is_array($template->pages) && sizeof($template->pages) > 0 ){
                        foreach ($template->pages as $template_page) {
                            print_r("\n\t\t>> PAGE >>" );
        
                            foreach ($template_page->images as $image_url) {
                                
                                $path = pathinfo($image_url); // dirname, filename, extension
                                // print_r($path);
                                $template_path = '/application/public/design/template/'.$template_id.'/assets/'.$path['filename'];
        
                                print_r("\n");
                                print_r("\n\t\t\tIMAGE >> " . $image_url );
                                print_r("\n\t\t\tTEMPLATE ID >> " . $template_id);
                                print_r("\n\t\t\tFILENAME >> " . $path['basename'] );
                                print_r("\n\t\t\tPATH >>" . str_replace('http://localhost/', null, $image_url));
                                print_r("\n\t\t\tIMG PATH >>" . $template_path);
                                
                                // $local_img_path = public_path( '/design/template/' . $template_id . '/assets/');
                                // $file_name = self::downloadImage($image_url, $local_img_path, $template_id);
        
                                $db_images = DB::table('images')
                                    // ->where('template_id', $template_id)
                                    ->where('filename', $path['basename'])
                                    ->count();
        
                                if ($db_images == 0) {
                                    // print_r($path);
                                    // exit;
                                    DB::table('images')->insert([
                                        'id' => null,
                                        'source' => 'corjl',
                                        'template_id' => $template_id,
                                        'img_path' => $template_path,
                                        'original_path' => str_replace('http://localhost/', null, $image_url),
                                        'file_type' => (isset($path['extension'])) ? $path['extension'] : 'none',
                                        'filename' => $path['basename'],
                                        'status' => 0 // Estado inicial, metadatos extraidos de etsy
                                    ]);
                                }
                            }
                        }
                    }
                    
                }

                DB::table('corjl_template')
                    ->where('id', $current_template->id )
                    ->update([ 'status' => 2 ]);

            } else {
                
                DB::table('corjl_template')
                ->where('id', $current_template->id )
                ->update([ 'status' => -1 ]);

                // Redis::del($current_template->template_id);
            }


            // }            
        }

        print_r("\n\nTERMINE");
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

    function registerTemplateOnDB($template_id, $original_template_id, $name, $fk_etsy_template_id, $parent_template_id, $width, $height, $measureUnits)
    {

        $thumbnail_rows = DB::table('templates')
            ->where('source', '=', 'corjl')
            ->where('original_template_id', '=', $original_template_id)
            ->first();

        if (!isset($thumbnail_rows->id)) {
            DB::table('templates')->insert([
                'id' => null,
                'source' => 'corjl',
                'template_id' => $template_id,
                'original_template_id' => $original_template_id,
                'fk_etsy_template_id' => $fk_etsy_template_id,
                'status' => 0,
                'parent_template_id' => $parent_template_id,
                'width' => $width,
                'height' => $height,
                'metrics' => $measureUnits
            ]);

            return $template_id;
        } else {
            DB::table('templates')
                // ->where('template_id', $template_id )
                ->where('original_template_id', $original_template_id )
                ->update([ 
                    'source' => 'corjl',
                    // 'template_id' => $template_id,
                    // 'original_template_id' => $original_template_id,
                    'fk_etsy_template_id' => $fk_etsy_template_id,
                    'status' => 0,
                    'parent_template_id' => $parent_template_id,
                    'width' => $width,
                    'height' => $height,
                    'metrics' => $measureUnits
                ]);
            return $thumbnail_rows->template_id;
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

        // if (file_exists($full_local_img_path) == false) {


        //     @mkdir($path, 0777, true);

        //     set_time_limit(0);

        //     //This is the file where we save the    information
        //     $fp = fopen($path . '/' . $file_name, 'w+');
        //     //Here is the file we are downloading, replace spaces with %20
        //     $ch = curl_init(str_replace(" ", "%20", $img_url));
        //     curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        //     // write curl response to file
        //     curl_setopt($ch, CURLOPT_FILE, $fp);
        //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        //     // get curl response
        //     curl_exec($ch);
        //     curl_close($ch);
        //     fclose($fp);
        // }

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

    function registerTemplate($template_id, $name, $fk_metadata,$parent_template_id){
        $id = 0;
        $thumbnail_rows = DB::table('templates')
                            ->where('template_id','=',$template_id)
                            ->count();
    
        if( $thumbnail_rows == 0 ){
            $id = DB::table('templates')->insertGetId([
                'id' => null,
                'template_id' => $template_id,
                'name' => htmlspecialchars_decode( $name ),
                'slug' => null,
                'fk_etsy_template_id' => $fk_metadata,
                'parent_template_id' => $parent_template_id,
                'status' => 1
            ]);
        }
        
        return $id;
    }
}
