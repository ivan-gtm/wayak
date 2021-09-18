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
    protected $signature = 'wayak:migrate-redis-dev-to-prod';

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
        
        self::migratePSDurls();
    }
    
    function migrateTemplates(){
        
        $redis_src = Redis::connection('redispro');
        $redis_dest = Redis::connection('default');

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
        $redis_uat = Redis::connection('redisuat');
        $wayak_config = Redis::keys('wayak:*');

        foreach ($wayak_config as $config_keyname) {
            $redis_uat->set($config_keyname, Redis::get($config_keyname));
            print_r("Migrated key >> \n");
            print_r($config_keyname);
            usleep(500000);
        }
    }
    
    function migrateCarousels(){
        $redis_src = Redis::connection('redispro');
        $redis_dest = Redis::connection('default');
        
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
        $redis_src = Redis::connection('redispro');
        $redis_dest = Redis::connection('default');
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
        $redis_src = Redis::connection('redispro');
        $redis_dest = Redis::connection('default');
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
