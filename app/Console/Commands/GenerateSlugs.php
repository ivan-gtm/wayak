<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Facades\DB;

class GenerateSlugs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:2-generate-name-and-slugs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Product Name and URL Slug from MySQL DB.';

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
        $ready_for_sale_products = DB::select( DB::raw(
            'SELECT
                thumbnails.id,
                thumbnails.template_id,
                thumbnails.title as thumb_title,
                tmp_etsy_metadata.title, 
                tmp_etsy_product.title product_title, 
                tmp_etsy_product.product_link_href 
            FROM 
                thumbnails,
                templates,
                tmp_etsy_metadata,
                tmp_etsy_product
            WHERE 
                thumbnails.template_id = templates.template_id
                AND thumbnails.language_code = \'en\'
                AND thumbnails.product_name IS NULL
                AND templates.source = \'templett\'
                AND templates.fk_etsy_template_id = tmp_etsy_metadata.id
                AND tmp_etsy_metadata.fk_product_id = tmp_etsy_product.id
                AND templates.status = 5
            ') 
        );
        
        echo "<pre>";
        foreach($ready_for_sale_products as $row){
            // print_r($row);
            // exit;
            
            $parsed_slug = str_replace('-',' ',substr($row->product_link_href, strripos($row->product_link_href, '/')+1, strlen($row->product_link_href)));
            $original_title = $row->thumb_title.' '.$row->title.' '.$row->product_title.' '.$parsed_slug;
            
            $tmp_title = [];
            preg_match_all('/([a-zA-Z])+/', $original_title, $final_title);
            
            if( isset($final_title[0]) ){
                $words = $final_title[0];
                
                // print_r($original_title);
                // print_r("<br>");
                // print_r($words);
                // print_r("<br");
                // exit;
                
                $ready_for_title = DB::select( DB::raw(
                    'SELECT
                        word 
                    FROM
                        `wayak`.`keywords` 
                    WHERE
                        word IN ('."'".implode( '\',\'',$words)."'".') 
                        AND language_code = \'en\' 
                        AND (
                            ( is_reviewed = 1 AND is_valid_for_title = 1 ) 
                            OR is_reviewed = 0 
                        )') 
                );

                foreach ($ready_for_title as $word) {
                    $tmp_title[] = ucwords($word->word);
                }
                
                
                $unique_keywords_title = array_unique($tmp_title);
                $final_title = implode(' ',$unique_keywords_title);
                
                // print_r($tmp_title);
                // exit;
                
                $ready_for_slug = DB::select( DB::raw(
                    'SELECT * FROM `wayak`.`keywords` 
                    WHERE 
                    word IN('."'".implode( '\',\'',$words)."'".')
                    AND language_code = \'en\'
                    AND (
                        ( is_reviewed = 1 AND is_tag = 1 ) OR is_reviewed = 0)
                        LIMIT 20') 
                    );
                    
                $tmp_slug = [];
                $slug_length = 0;
                foreach ($ready_for_slug as $word) {
                    $slug_length = $slug_length + strlen($word->word) + 1;
                    $tmp_slug[] = strtolower($word->word);
                    
                    if( $slug_length > 80 ){
                        break;
                    }
                }

                $tmp_slug[] = $row->template_id;
                
                $unique_keywords_slug = array_unique($tmp_slug);
                $final_slug = implode('-',$unique_keywords_slug);
                
                // print_r( "<hr>original_title >>" );
                // print_r( $original_title );
                // print_r( "<br>" );
                // print_r( $row->id.'-'.substr($row->product_link_href, strripos($row->product_link_href, '/')+1, strlen($row->product_link_href)));
                // print_r( "<br>" );
                print_r( strlen($final_title).'>> TITLE >> ' );
                print_r( $final_title );
                print_r( "\n" );
                print_r( strlen($final_slug).'>> SLUG >> ' );
                print_r( $final_slug );
                
                print_r( "\n\n" );

                DB::table('thumbnails')
                ->where('id','=',$row->id)
                ->update([
                    'product_name' => $final_title,
                    'product_slug' => $final_slug
                ]);

                // exit;
            }
        }

        // $read
    }
}
