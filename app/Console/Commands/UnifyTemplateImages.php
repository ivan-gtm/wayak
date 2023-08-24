<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Image;

class UnifyTemplateImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:unify-template-images';

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
        $this->fixTemplateFolders();
    }


    function fixTemplateFolders(){
        $templates = DB::select( DB::raw(
            'SELECT
                thumbnails.template_id,
                thumbnails.filename
            FROM
                templates,
                thumbnails 
            WHERE
                templates.template_id = thumbnails.template_id
                AND templates.source = \'green\'
                AND templates.template_id = \'x3ftnGC5YSu01dc\'
            ORDER BY templates.id DESC
            LIMIT 10') 
            );

        foreach ($templates as $template) {
            $thumbnail_path = public_path('design/template/'.$template->template_id.'/thumbnails/en/'.$template->filename);
            
            print_r("\n\nPARSING >>".$template->template_id.' ->    '.$thumbnail_path."\n");
            
            if( !file_exists($thumbnail_path) ){
                print_r("\n\nDOES NOT EXISTS\n");
            }
            
            // $scan = scandir( $template_paths );
            // foreach($scan as $folder) {
            // }
        }
        exit;

        $template_paths = public_path('design/template/');
        $scan = scandir( $template_paths );
        
        foreach($scan as $folder) {
            print_r("\n\nPARSING >>".$folder."\n");
            exit;
            
            if( strlen($file_name) > 3 
                && $file_name != '.DS_Store' 
                && (
                    strpos($file_name, ".png") > 0 
                    OR strpos($file_name, ".jpg") > 0 
                    OR strpos($file_name, ".jpeg") > 0 
                    OR strpos($file_name, ".svg") > 0 
                ) ) {

                print_r("\t\t\n     ".$file_name);

                $path_info = pathinfo($file_name); // dirname, filename, extension
                $db_image = DB::table('images')
                                ->select('id')
                                ->where('template_id','=',$template->template_id)
                                ->where('source', '=', $template->source)
                                ->where('filename','=',$file_name)
                                ->first();
                
                if( isset( $db_image->id ) == false ){
                    
                    $canva_asset_id = self::generateRandString();
                    $new_img_path = public_path('/instagram/assets/'.$canva_asset_id.'.'.$path_info['extension']);
                    $new_thumb_path = public_path('/instagram/thumbs/'.$canva_asset_id.'.'.$path_info['extension']);
                    $template_row = [
                        'id' => null,
                        'source' => $template->source,
                        'template_id' => $template->template_id,
                        'filename' => $file_name,
                        'original_path' => $local_path.$file_name,
                        'img_path' => $new_img_path,
                        'thumb_path' => $new_thumb_path,
                        'file_type' => $path_info['extension']
                    ];

                    // self::copyImage( $local_path.$file_name , $new_img_path);
                    if( $path_info['extension'] == 'png' OR $path_info['extension'] == 'jpg' ){
                        try {
                            self::createThumb( $local_path.$file_name, $new_thumb_path);
                        } catch (\Throwable $th) {
                            // throw $th;
                            $template_row['status'] = -1;
                            // $imagePath = $local_path.$file_name;
                            // $saveToDir = public_path('/instagram/thumbs/');
                            // $imageName = $canva_asset_id.'.'.$path_info['extension'];
                            
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
                    }

                    DB::table('images')->insert($template_row);
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

    function getDirectorySize($path){
        $bytestotal = 0;
        $path = realpath($path);
        if($path!==false && $path!='' && file_exists($path)){
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS)) as $object){
                $bytestotal += $object->getSize();
            }
        }
        return $bytestotal;
    }
}
