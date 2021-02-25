<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class MigrateToUAT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:migrateuat';

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
        self::redisTemplates();
        self::redisWayakConfig();
    }
    
    function redisTemplates(){
        $redis_uat = Redis::connection('redisuat');
        // $keys = $redis_uat->keys('*');

        $templates = Redis::keys('template:en:*:jsondata');

        foreach ($templates as $template_keyname) {
            $redis_uat->set($template_keyname, Redis::get($template_keyname));
            print_r("Migrated key >> \n");
            print_r($template_keyname);
            usleep(500000);
        }

        // print_r("JIJI\n");
        // print_r( $keys );
        // print_r("DEV\n");
        // print_r( Redis::keys('wayak*') );

        // print_r( Redis::keys('template:*:jsondata') );
        
        
        // $redis2 = new Predis\Client([
        //     'host'     => 'localhost',
        //     'port'     => 6379,
        //     'database' => 3,
        // ]);
    }
    
    function redisWayakConfig(){
        $redis_uat = Redis::connection('redisuat');
        // $keys = $redis_uat->keys('*');

        $wayak_config = Redis::keys('wayak:*');

        foreach ($wayak_config as $config_keyname) {
            $redis_uat->set($config_keyname, Redis::get($config_keyname));
            print_r("Migrated key >> \n");
            print_r($config_keyname);
            usleep(500000);
        }
    }

}
