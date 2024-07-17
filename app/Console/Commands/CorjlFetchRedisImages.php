<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;

class CorjlFetchRedisImages extends Command
{
    protected $signature = 'fetch:redis-images {product_key}';
    protected $description = 'Fetch images from Redis and save them locally';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // template_id
        // original_template_id
        // language_code
        // filename
        // title
        // dimentions
        // status
        // source

        // product_name
        // product_slug

        
        
        $original_product_key = $this->argument('product_key');
        $redis_key = 'corjl:' . $original_product_key;
        
        $db_template = DB::table('templates')
                                        ->select('template_id','status')
                                        ->where( 'original_template_id', '=', $original_product_key )
                                        // ->where( 'status', '=', '0' )
                                        ->first();
                
        if( isset( $db_template->template_id ) == false ){
            $template_id = Str::random(10);
        } else {
            $template_id = $db_template->template_id;
        }
        
        $this->info("Fetching data for Redis key: $redis_key");

        // Get the JSON data from Redis
        $jsonData = Redis::get($redis_key);

        if (!$jsonData) {
            $this->error("No data found for key $redis_key");
            return 1;
        }

        $this->info("Data fetched successfully for key: $redis_key");
        
        $data = json_decode($jsonData, true);
        
        // $this->info("<< DATA >>");
        // print_r($data['templates']);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Invalid JSON data');
            return 1;
        }

        $this->info('JSON data decoded successfully.');

        $this->processImages($data, $template_id, $original_product_key);
        $this->info('Images fetched and saved successfully.');
        return 0;
    }

    function registerThumbOnDB($template_id, $title, $filename, $dimentions, $product_key) {
        // Prepare the data
        $data = [
            'template_id' => $template_id,
            'title' => htmlspecialchars_decode($title),
            'filename' => $filename,
            'dimentions' => $dimentions,
            'tmp_templates' => $template_id,
            'language_code' => 'en',
            'status' => 1,
            'original_template_id' => $product_key
        ];
    
        // Use updateOrInsert to update existing or insert new row
        DB::table('thumbnails')->updateOrInsert(
            ['template_id' => $template_id], // Condition to check existing row
            $data // Data to insert or update
        );
    }
    
    function registerImageOnDB($template_id, $filename, $img_path, $thumb_path, $file_type, $url) {
        // Prepare the data
        $data = [
            'template_id' => $template_id,
            'filename' => $filename,
            'img_path' => $img_path,
            'status' => 1,
            'thumb_path' => $thumb_path,
            'file_type' => $file_type,
            'original_path' => $url,
            'source' => 'corjl',
            'title' => null
        ];
    
        // Use updateOrInsert to update existing or insert new row
        DB::table('images')->updateOrInsert(
            [
                'template_id' => $template_id,
                'filename' => $filename
            ], // Condition to check existing row
            $data // Data to insert or update
        );
    }
        
    function registerTemplateOnDB($template_id, $original_template_id, $name, $fk_etsy_template_id, $parent_template_id, $width, $height, $measureUnits) {
        // Check if the row exists
        $existingRow = DB::table('templates')
                         ->where('template_id', $template_id)
                         ->first();
    
        // Prepare the data
        $data = [
            'source' => 'corjl',
            'template_id' => $template_id,
            'original_template_id' => $original_template_id,
            'fk_etsy_template_id' => 0,
            'status' => 0,
            'parent_template_id' => $parent_template_id,
            'width' => $width,
            'height' => $height,
            'metrics' => $measureUnits
        ];
    
        if ($existingRow) {
            // Update the existing row
            DB::table('templates')
              ->where('template_id', $template_id)
              ->update($data);
        } else {
            // Insert a new row
            DB::table('templates')->insert($data);
        }
    }
    
    function extractDimensions($data) {
        // // Decode the JSON string
        // $data = json_decode($jsonString, true);
    
        // Initialize variables
        $width = 0;
        $height = 0;
        $measureUnits = '';
    
        // Check if the templates array and dimensions exist
        if (isset($data['dimentions'])) {
            // Extract the dimensions string
            $dimensions = $data['dimentions'];
    
            // Split the dimensions string
            $parts = explode(' ', $dimensions);
    
            // Ensure we have the correct number of parts
            if (count($parts) == 4) {
                $width = floatval($parts[0]);
                $height = floatval($parts[2]);
                $measureUnits = $parts[3];
            }
        }
    
        // Return the extracted values
        return [
            'width' => $width,
            'height' => $height,
            'measureUnits' => $measureUnits
        ];
    }
    
    
    private function processImages($data, $product_key, $original_product_key)
    {
        $client = new Client();
        
        foreach ($data['templates'] as $template) {
            // $this->info("Processing template: " . $template['id']);
            
            $dimensions = $this->extractDimensions($template);
            // print_r($dimensions);
            // $template

            // Process thumbnail images
            $this->info("Processing thumbnail for template: " . $template['thumb_url']);
            $this->saveImage($product_key, $client, $template['thumb_url'], public_path("corjl_imgs/design/template/$product_key/thumbnails/en/"));

            
            $filename = $this->extractFilename( $template['thumb_url'] );

            $dimensions['measureUnits'] = isset($dimensions['measureUnits']) ? $dimensions['measureUnits'] : null;
            
            $this->registerTemplateOnDB($product_key, $original_product_key, $template['name'], 0,0, $dimensions['width'], $dimensions['height'], $dimensions['measureUnits']);
            $this->registerThumbOnDB($product_key, $template['name'], $filename, $template['dimentions'], $product_key);

            if(isset($template['pages']) && is_array($template['pages'])){
                foreach ($template['pages'] as $page) {
                    // $this->info("Processing page: " . $page['id']);
                    // $title = $page['name'];
                    
                    // Process page thumbnails if any
                    if (!empty($page['thumbnail'])) {
                        $this->info("Processing page thumbnail: " . $page['thumbnail']);
                        $this->saveImage($product_key, $client, $page['thumbnail'], public_path("corjl_imgs/design/template/$product_key/thumbnails/en/"));
                    }
    
                    // Process other images
                    foreach ($page['images'] as $image_url) {
                        $this->info("Processing image: " . $image_url);
                        $this->saveImage($product_key, $client, $image_url, public_path("corjl_imgs/design/template/$product_key/assets/"));
                    }
                }
            }
        }
    }

    private function extractFilename($url) {
        // Parse the URL to get the path
        $path = parse_url($url, PHP_URL_PATH);
        
        // Get the basename from the path
        $filename = basename($path);
        
        return $filename;
    }
    
    private function extractFileExtension($url) {
        // Parse the URL to get the path
        $path = parse_url($url, PHP_URL_PATH);
        
        // Get the file extension from the path
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        
        return $extension;
    }

    private function saveImage($template_id, $client, $url, $path)
    {
        $imageName = basename($url);
        $filePath = $path . $imageName;

        $this->info("Saving image: $url to path: $filePath");

        if (!is_dir($path)) {
            $this->info("Creating directory: $path");
            mkdir($path, 0755, true);
        }

        $file_type = $this->extractFileExtension($imageName);

        $this->registerImageOnDB($template_id, $imageName, $filePath, $filePath, $file_type, $url);

        // Check if the image already exists and its size is greater than 0
        if (file_exists($filePath) && filesize($filePath) > 0) {
            $this->info("Image already exists and is non-empty: $filePath");
            return;
        }

        $this->info("Downloading image: $url");
        $response = $client->get($url);
        $imageContent = $response->getBody();

        if ($imageContent->getSize() > 0) {
            $this->info("Image downloaded successfully, saving to: $filePath");
            file_put_contents($filePath, $imageContent);
        } else {
            $this->error("Failed to save image or image size is 0: $url");
        }
    }
}
