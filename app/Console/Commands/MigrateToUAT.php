<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class MigrateToUAT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:db:redis-dev-to-uat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate REDIS keys from DEV to UAT';

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
        self::migrateRedisKeys();

        return 0;
    }

    function migrateRedisKeys(){
        // self::migrateTemplates();
        // self::migrateCarousels();
        // self::migrateMenu();
        // self::migrateCategories();
        // self::migrateWayakConfig();
        
        // self::migrateTemplatesFromProdToDev();
        // self::migratePSDurls();
        
        // self::migrateLegacyKeys();
        self::migrateCorjl();
        // self::corjlKeys();
    }

    function corjlKeys(){
        // $redis_src = Redis::connection('redispro');
        $redis_dest = Redis::connection('default');

        $carousels = $redis_dest->keys('corjl*');

        foreach ($carousels as $carousel_key) {
            print_r("Migrated key >> ");
            print_r($carousel_key);
            print_r("\n");
            // usleep(250000);
            
            $thumbnail_rows = DB::table('corjl_template')
                            ->where('template_id', '=', $carousel_key)
                            ->count();
    
            if( $thumbnail_rows == 0 ){
                DB::table('corjl_template')->insert([
                    'id' => null,
                    'template_id' => $carousel_key,
                    'status' => 1
                ]);
            }

        }
    }

    function migrateCorjl(){
        $redis_src = Redis::connection('redispro');
        $redis_dest = Redis::connection('default');

        $carousels = $redis_src->keys('green:template*');

        foreach ($carousels as $carousel_key) {
            // if( $redis_dest->exists($carousel_key) == false ){
                $template_id = $redis_src->get($carousel_key);
                if( $redis_dest->exists('template:en:'.$template_id.':jsondata') == false ){
                    $redis_dest->set('template:en:'.$template_id.':jsondata', $redis_src->get('template:en:'.$template_id.':jsondata'));

                    self::registerThumbOnDB($template_id, 'Green Title', 'preview.jpg','xxx', $carousel_key);
                    self::registerTemplateOnDB($template_id, $carousel_key, 'Green Title', null,null, 0, 0, 'in');
    
                    print_r("Migrated key >> ");
                    print_r($carousel_key);
                    print_r("TEMPLATE >> ");
                    print_r('template:en:'.$template_id.':jsondata');
                    // $redis_src->del($carousel_key);
                    print_r("\n");
                    usleep(250000);
                }
            // }
            
            // $redis_src->del($carousel_key);
            
        }
    }

    function registerThumbOnDB($template_id, $title, $filename,$dimentions, $product_key){
        
        $thumbnail_rows = DB::table('thumbnails')
                            ->where('template_id','=',$template_id)
                            ->count();
    
        if( $thumbnail_rows == 0 ){
            DB::table('thumbnails')->insert([
                'id' => null,
                'template_id' => $template_id,
                'source' => 'green',
                'title' => htmlspecialchars_decode( $title ),
                'filename' => $filename,
                'dimentions' => $dimentions,
                'tmp_templates' => $template_id,
                'language_code' => 'en',
                'status' => 1,
                'original_template_id' => $product_key
            ]);
        }
    }

    function registerTemplateOnDB($template_id, $original_template_id, $name, $fk_etsy_template_id,$parent_template_id, $width, $height, $measureUnits){
        
        $thumbnail_rows = DB::table('templates')
                            ->where('template_id','=',$template_id)
                            ->count();
    
        if( $thumbnail_rows == 0 ){
            DB::table('templates')->insert([
                'id' => null,
                'source' => 'green',
                'template_id' => $template_id,
                'original_template_id' => $original_template_id,
                // 'name' => htmlspecialchars_decode( $name ),
                'fk_etsy_template_id' => 0,
                'status' => 0,
                'parent_template_id' => $parent_template_id,
                'width' => $width,
                'height' => $height,
                'metrics' => $measureUnits
            ]);
        }
    }
    
    function migrateTemplates(){
        
        $redis_src = Redis::connection('default');
        $redis_dest = Redis::connection('redisuat');

        $templates = DB::select( DB::raw(
            'SELECT
                thumbnails.template_id
            FROM
                templates,
                thumbnails 
            WHERE
                templates.template_id = thumbnails.template_id 
                AND templates.`status` = 5 
                AND thumbnails.language_code = \'en\' 
                AND thumbnails.thumbnail_ready IS TRUE') 
            );

        foreach ($templates as $template) {
            $template_keyname = 'template:en:'.$template->template_id.':jsondata';
            
            if( $redis_dest->exists($template_keyname) == false ){
                $redis_dest->set($template_keyname, $redis_src->get($template_keyname));
                print_r("Migrated key >> \n");
                print_r($template_keyname);
                usleep(500000);
                // exit;
            }
        }

    }

    function migratePSDurls(){
        
        $redis_src = Redis::connection('default');
        $redis_dest = Redis::connection('redisuat');

        // $templates = $redis_src->keys('psdkeys:*');
        $templates = $redis_src->keys('instagram:*');
        // $templates = $redis_src->keys('gfxcosy:*');

        foreach($templates as $template_key) {

            if( $redis_dest->exists($template_key) == false ){
                $redis_dest->set($template_key, $redis_src->get($template_key) );
                $redis_src->del($template_key);
                print_r("Migrated key >> \n");
                print_r($template_key);
                usleep(500000);
                // exit;
            }
        }

    }
    
    function migrateLegacyKeys(){
        
        $redis_src = Redis::connection('default');
        $redis_dest = Redis::connection('redisuat');

        $templates = $redis_src->keys('canva:*');
        // $templates = $redis_src->keys('placeit:*');
        // $templates = $redis_src->keys('over:*');
        // $templates = $redis_src->keys('*green:*');
        // $templates = $redis_src->keys('desygner:*');
        // $templates = $redis_src->keys('crello:*');
        
        foreach($templates as $template_key) {

            if( $redis_dest->exists($template_key) == false ){
                $redis_dest->set($template_key, $redis_src->get($template_key) );
                $redis_src->del($template_key);
                print_r("Migrated key >> \n");
                print_r($template_key);
                usleep(500000);
                // exit;
            }
        }

    }
    
    function migrateTemplatesFromProdToDev(){
        
        $redis_src = Redis::connection('redispro');
        $redis_dest = Redis::connection('default');

        $templates = $redis_src->keys('template:en:*:jsondata');

        foreach ($templates as $template_key) {
            // print_r( $template );
            // print_r( $template_key );
            // exit;
            if( $redis_dest->exists($template_key) == false ){
                
                // print_r( $template_key );
                // print_r( $redis_src->get($template_key) );
                // exit;
                $redis_dest->set($template_key, $redis_src->get($template_key) );
                print_r("Migrated key >> \n");
                print_r($template_key);
                usleep(500000);
                // exit;
            }
        }

    }
    
    function migrateWayakConfig(){
        $redis_src = Redis::connection('default');
        $redis_dest = Redis::connection('redisuat');

        $wayak_config = $redis_src->keys('wayak:*');
        foreach ($wayak_config as $config_keyname) {
            $redis_dest->set($config_keyname, $redis_src->get($config_keyname));
            print_r("Migrated key >> \n");
            print_r($config_keyname);
            usleep(500000);
        }
    }
    
    function migrateCarousels(){
        $redis_src = Redis::connection('default');
        $redis_dest = Redis::connection('redisuat');
        
        $carousels = $redis_src->keys('wayak:*:home:carousels');

        foreach ($carousels as $carousel_key) {
            if( $redis_dest->exists($carousel_key) == false ){
                $redis_dest->set($carousel_key, $redis_src->get($carousel_key));
                print_r("Migrated key >> ");
                print_r($carousel_key);
                print_r("\n");
                usleep(500000);
            }
        }

    }
    
    function migrateMenu(){
        $redis_src = Redis::connection('default');
        $redis_dest = Redis::connection('redisuat');
        // $keys = $redis_uat->keys('*');

        $carousels = $redis_src->keys('wayak:*:menu');

        foreach ($carousels as $carousel_key) {
            if( $redis_dest->exists($carousel_key) == false ){
                $redis_dest->set($carousel_key, $redis_src->get($carousel_key));
                print_r("Migrated key >> ");
                print_r($carousel_key);
                print_r("\n");
                usleep(500000);
            }
        }

    }
    
    function migrateCategories(){
        $redis_src = Redis::connection('default');
        $redis_dest = Redis::connection('redisuat');

        $carousels = $redis_src->keys('wayak:en:categories:*');

        foreach ($carousels as $carousel_key) {
            if( $redis_dest->exists($carousel_key) == false ){
                $redis_dest->set($carousel_key, $redis_src->get($carousel_key));
                print_r("Migrated key >> ");
                print_r($carousel_key);
                print_r("\n");
                usleep(500000);
            }
        }
        
        $carousels = $redis_src->keys('laravel_database_green:categories');

        foreach ($carousels as $carousel_key) {
            if( $redis_dest->exists($carousel_key) == false ){
                $redis_dest->set($carousel_key, $redis_src->get($carousel_key));
                print_r("Migrated key >> ");
                print_r($carousel_key);
                print_r("\n");
                usleep(500000);
            }
        }
    }

}
