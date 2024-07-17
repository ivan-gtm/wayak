<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Image;

class UtilCreateAssetsThumbs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:util:create-assets-thumbs';

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
        $scrapFormat = 1;

        switch ($scrapFormat) {
            case 1:
                $this->byTemplate();
                break;

            default:
                $this->byImage();
                break;
        }
    }

    function byImage(){

        // Check if font/template relationship already exist
        $templates = DB::table('templates')
                    ->select('id', 'template_id','source')
                    // ->where('source','=','corjl')
                    ->where('status', '=', 1)
                    // ->whereNull('thumb_path')
                    ->where('source','=','corjl')
                    // ->where('template_id','=','lDwkOPQsXimhd5U')
                    // ->offset(18000)
                    ->limit(18000)
                    ->orderByDesc('id')
                    ->get();

        foreach ($templates as $template) {
            
            $local_path = public_path('corjl/design/template/'.$template->template_id.'/assets/');
            
            print_r("\n\nPARSING >>".$template->template_id."\n");
            
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

                            print_r("\t\t\n     EXTENSION >>".$file_path_info['extension']);
                            print_r("\t\t\n     PARSING FILE >>".$file_name);

                            // $path_info = pathinfo($file_name); // dirname, filename, extension
                            $canva_asset_id = self::generateRandString();
                            $new_img_path = public_path('/template-assets/assets/'.$canva_asset_id.'.'.$file_path_info['extension']);
                            $new_thumb_path = public_path('/template-assets/thumbs/'.$canva_asset_id.'.'.$file_path_info['extension']);
                            $template_row = [
                                'id' => null,
                                'source' => $template->source,
                                'template_id' => $template->template_id,
                                'filename' => $file_name,
                                'original_path' => $local_path.$file_name,
                                'img_path' => $new_img_path,
                                'thumb_path' => $new_thumb_path,
                                'file_type' => $file_path_info['extension']
                            ];

                            // self::copyImage( $local_path.$file_name , $new_img_path);
                            if( $file_path_info['extension'] == 'png' OR $file_path_info['extension'] == 'jpg' ){
                                try {
                                    self::createThumb( $local_path.$file_name, $new_thumb_path);
                                } catch (\Throwable $th) {
                                    // throw $th;
                                    $template_row['status'] = -1;
                                    // $imagePath = $local_path.$file_name;
                                    // $saveToDir = public_path('/instagram/thumbs/');
                                    // $imageName = $canva_asset_id.'.'.$file_path_info['extension'];
                                    
                                    // list($width_orig, $height_orig) = getimagesize( $imagePath );
                                    // $max_w = 500;
                                    // $max_h = (round((100*500)/$width_orig)/100)*$height_orig;
                                    
                                    // echo "\n";
                                    // echo "\n";
                                    // print_r( $saveToDir );
                                    // echo "\n";
                                    // print_r( $max_h );
                                    // echo "\n";
                                    // print_r($width_orig);
                                    // echo "\n";
                                    // print_r($height_orig);
                                    // echo "\n";
                                    // echo "\n";

                                    // try {
                                    //     self::saveThumbnail( $saveToDir, $imagePath, $imageName, $max_w, $max_h);
                                    // } catch (\Throwable $th) {
                                    //     print_r($th);
                                    //     exit;
                                    // }
                                    // exit;
                                }
                            } elseif( $file_path_info['extension'] == 'svg' ){
                                // $old_path = $template_row['original_path'];
                                // $new_img_path = $template_row['img_path'];
                                // $thumb_path = $template_row['thumb_path'];
                                
                                // self::copyImage($old_path, $new_img_path);
                                // self::copyImage($old_path, $thumb_path);
                            }

                            $db_image = DB::table('images')
                            ->select('id')
                            ->where('template_id','=',$template->template_id)
                            ->where('source', '=', $template->source)
                            ->where('filename','=',$file_name)
                            ->first();
            
                            if( isset( $db_image->id ) == false ){
                                DB::table('images')->insert($template_row);
                            } else {
                                DB::statement("UPDATE images SET thumb_path = '$new_thumb_path' WHERE id = ".$db_image->id);
                            }
                    } else {
                        if( isset($file_path_info['extension']) ){
                            // print_r( "\n");
                            // print_r( 'FILE >>'.$file_name ."\n");
                            // print_r( 'NOT SUPPORTED >>'.$file_path_info['extension'] ."\n\n");
                        }
                    }
                }
            }
        }
    }

    function byTemplate(){

        // Check if font/template relationship already exist
        $templates = DB::table('templates')
                    ->select('id', 'template_id','source')
                    // ->where('status', '=', 1)
                    // ->whereNull('thumb_path')
                    // ->where('source','=','corjl')
                    ->where('source','=','templett')
                    // ->where('template_id','=','lDwkOPQsXimhd5U')
                    // ->offset(18000)
                    // ->limit(18000)
                    ->orderByDesc('id')
                    ->get();

        foreach ($templates as $template) {
            
            $local_path = public_path('design/template/'.$template->template_id.'/assets/');
            
            print_r("\n\nPARSING >>".$template->template_id."\n");
            
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

                            print_r("\t\t\n     EXTENSION >>".$file_path_info['extension']);
                            print_r("\t\t\n     PARSING FILE >>".$file_name);

                            // $path_info = pathinfo($file_name); // dirname, filename, extension
                            $canva_asset_id = self::generateRandString();
                            $new_img_path = public_path('/template-assets/assets/'.$canva_asset_id.'.'.$file_path_info['extension']);
                            $new_thumb_path = public_path('/template-assets/thumbs/'.$canva_asset_id.'.'.$file_path_info['extension']);
                            $template_row = [
                                'id' => null,
                                'source' => $template->source,
                                'template_id' => $template->template_id,
                                'filename' => $file_name,
                                'original_path' => $local_path.$file_name,
                                'img_path' => $new_img_path,
                                'thumb_path' => $new_thumb_path,
                                'file_type' => $file_path_info['extension']
                            ];

                            // self::copyImage( $local_path.$file_name , $new_img_path);
                            if( $file_path_info['extension'] == 'png' OR $file_path_info['extension'] == 'jpg' ){
                                try {
                                    self::createThumb( $local_path.$file_name, $new_thumb_path);
                                } catch (\Throwable $th) {
                                    // throw $th;
                                    $template_row['status'] = -1;
                                    // $imagePath = $local_path.$file_name;
                                    // $saveToDir = public_path('/instagram/thumbs/');
                                    // $imageName = $canva_asset_id.'.'.$file_path_info['extension'];
                                    
                                    // list($width_orig, $height_orig) = getimagesize( $imagePath );
                                    // $max_w = 500;
                                    // $max_h = (round((100*500)/$width_orig)/100)*$height_orig;
                                    
                                    // echo "\n";
                                    // echo "\n";
                                    // print_r( $saveToDir );
                                    // echo "\n";
                                    // print_r( $max_h );
                                    // echo "\n";
                                    // print_r($width_orig);
                                    // echo "\n";
                                    // print_r($height_orig);
                                    // echo "\n";
                                    // echo "\n";

                                    // try {
                                    //     self::saveThumbnail( $saveToDir, $imagePath, $imageName, $max_w, $max_h);
                                    // } catch (\Throwable $th) {
                                    //     print_r($th);
                                    //     exit;
                                    // }
                                    // exit;
                                }
                            } elseif( $file_path_info['extension'] == 'svg' ){
                                // $old_path = $template_row['original_path'];
                                // $new_img_path = $template_row['img_path'];
                                // $thumb_path = $template_row['thumb_path'];
                                
                                // self::copyImage($old_path, $new_img_path);
                                // self::copyImage($old_path, $thumb_path);
                            }

                            $db_image = DB::table('images')
                            ->select('id')
                            ->where('template_id','=',$template->template_id)
                            ->where('source', '=', $template->source)
                            ->where('filename','=',$file_name)
                            ->first();
            
                            if( isset( $db_image->id ) == false ){
                                DB::table('images')->insert($template_row);
                            } else {
                                DB::statement("UPDATE images SET thumb_path = '$new_thumb_path' WHERE id = ".$db_image->id);
                            }
                    } else {
                        if( isset($file_path_info['extension']) ){
                            // print_r( "\n");
                            // print_r( 'FILE >>'.$file_name ."\n");
                            // print_r( 'NOT SUPPORTED >>'.$file_path_info['extension'] ."\n\n");
                        }
                    }
                }
            }
        }
    }
    
    function saveThumbnail($saveToDir, $imagePath, $imageName, $max_x, $max_y) {
        preg_match("'^(.*)\.(gif|jpe?g|png)$'i", $imageName, $ext);
        switch (strtolower($ext[2])) {
            case 'jpg' :
            case 'jpeg': $im   = imagecreatefromjpeg ($imagePath);
                         break;
            case 'gif' : $im   = imagecreatefromgif  ($imagePath);
                         break;
            case 'png' : $im   = imagecreatefrompng  ($imagePath);
                         break;
            default    : $stop = true;
                         break;
        }
       
        if (!isset($stop)) {
            $x = imagesx($im);
            $y = imagesy($im);
       
            if (($max_x/$max_y) < ($x/$y)) {
                $save = imagecreatetruecolor($x/($x/$max_x), $y/($x/$max_x));
            }
            else {
                $save = imagecreatetruecolor($x/($y/$max_y), $y/($y/$max_y));
            }
            imagecopyresized($save, $im, 0, 0, 0, 0, imagesx($save), imagesy($save), $x, $y);
           
            imagegif($save, "{$saveToDir}{$ext[1]}.gif");
            imagedestroy($im);
            imagedestroy($save);
        }
    }

    function generateRandString( $length = 15 ) {
		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return substr(str_shuffle($permitted_chars), 0, $length);
	}

    function createThumb($old_path, $new_path){
        // print_r();

        $path = pathinfo($new_path); // dirname, filename, extension
        
        if (!file_exists($path['dirname'])) {
            @mkdir($path['dirname'], 0777, true);
        }

        $mockup_img_path = $old_path;
        
        // create new Intervention Image
        $mockup_img = Image::make($mockup_img_path);
        $mockup_img->resize(500, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $mockup_img->save( $new_path );

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
