<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
// use Illuminate\Support\Facades\DB;
use Elasticsearch\ClientBuilder;


class MigrateToES extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:db:migrate-es';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Elastic Search cache from MongoDB.';

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
        echo "Hola";
        $response = self::searchAll();
        print_r( json_decode($response) );
        exit;

        $templates = Template::all();
        foreach($templates as $mongo_template) {

            print_r( "\n" );
            print_r( "\n" );
            print_r( "\n" );
            
            print_r( $mongo_template->_id);
            
            $template_id = $mongo_template->_id;
            $template_body = json_decode( $mongo_template ) ;
            unset($template_body->_id);
            $json_body = json_encode($template_body);
            self::createProduct($template_id, $json_body);
        }
        
        return 0;
    }

    function createProduct($template_id, $template_body){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://search-ccp-prod-ut5vyvxnhpwlss6p3yft3okcrm.us-west-2.es.amazonaws.com/wy/_doc/'.$template_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => $template_body,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    function searchAll(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://search-ccp-prod-ut5vyvxnhpwlss6p3yft3okcrm.us-west-2.es.amazonaws.com/wy/_search',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS =>'{
            "query": {
                "match_all": {}
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }
}
