<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class SanitizeProductNames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:sanitize_names';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create products on final database';

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
        // $this->bulkThumbnailDownload();
        $templates = DB::table('product_translations')
                    ->select('name','id')
                    // ->limit(2000)
                    ->get();
        
        $not_allowed_words = ['instant','download','diy','printable','templett','editable','pdf','template','edit','yourself','100%','jpeg','file'];
        foreach ($templates as $template) {
            print_r($template->name);
            $template->name = strtolower($template->name);
            $template->name = str_replace($not_allowed_words, null, $template->name);
            $template->name = ucwords($template->name);
            print_r($template);

            DB::table('product_translations')
                    ->where('id', $template->id)
                    ->update(['name' => $template->name]);

            /*
            exit;
            $template_id = substr($template->templett_url, strrpos($template->templett_url,'/'), strlen($template->templett_url));
            $template_id = preg_replace("/[^0-9,]/", "", $template_id);

            $thumbnail = DB::table('thumbnails')
                    ->select('filename','template_id')
                    ->where('tmp_templates','=', $template_id)
                    ->first();
            
            if(is_object($thumbnail)){
                
                $thumbnail_url = 'design/template/'.$thumbnail->template_id.'/thumbnails/'.$thumbnail->filename;
                
                print_r($thumbnail_url."\n\n");
                print_r($thumbnail->filename."\n\n");
                
                $product_id = DB::table('products')->insertGetId(
                    [
                        'tax_class_id' => NULL,
                        'slug' => $this->createSlug($template->title),
                        'price' => $template->price,
                        'special_price' => NULL,
                        'special_price_start' => NULL,
                        'special_price_end' => NULL,
                        'selling_price' => $template->price,
                        'sku' => NULL,
                        'manage_stock' => 0,
                        'qty' => NULL,
                        'in_stock' => 1,
                        'viewed' => 4,
                        'is_active' => 1,
                        'new_from' => NULL,
                        'new_to' => NULL,
                        'fk_metadata' => $template->id,
                        'deleted_at' => NULL,
                        'created_at' => '2019-05-09 03:54:48',
                        'updated_at' => '2019-05-09 03:54:48'
                    ]
                );
                       
                DB::table('product_translations')->insert(
                    [
                        'product_id' => $product_id,
                        'locale' => 'en',
                        'name' => substr($template->title,0,180),
                        'description' => $template->description,
                        'short_description' => NULL
                    ]
                );
                
                $file_id = DB::table('files')->insertGetId(
                    [
                        'user_id' => 1,
                        'filename' => $thumbnail->filename,
                        'disk' => 'public',
                        'path' => $thumbnail_url,
                        'extension' => 'png',
                        'mime' => 'image/png',
                        'size' => '53202',
                        'created_at' => '2019-05-09 03:55:39',
                        'updated_at' => '2019-05-09 03:55:39'
                    ]
                );
    
                DB::table('entity_files')->insert(
                    [
                        // 'id' => ,
                        'file_id' => $file_id,
                        'entity_type' => 'Modules\\Product\\Entities\\Product',
                        'entity_id' => $product_id,
                        'zone' => 'base_image',
                        'created_at' => '2019-05-09 03:56:04',
                        'updated_at' => '2019-05-09 03:56:04'
                    ]
                );
    
                DB::table('search_terms')->insert(
                    [
                        // 'id' => 1,
                        'term' => substr($template->title,0,180).Str::random(10),
                        'results' => 1,
                        'hits' => 1,
                        'created_at' => '2019-05-09 03:56:18',
                        'updated_at' => '2019-05-09 03:56:18',
                    ]
                );

                DB::table('tmp_etsy_metadata')
                    ->where('id', $template->id)
                    ->update(['in_store' => 1]);
            }
            */
        }     
    }

    function createSlug($str, $delimiter = '-'){

        $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));
        $slug = substr($slug,0,180);
        $slug .= Str::random(10);
        return $slug;
    
    }
}
