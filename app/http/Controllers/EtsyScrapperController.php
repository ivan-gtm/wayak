<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

// use Sunra\PhpSimple\HtmlDomParser;
use Illuminate\Support\Facades\DB;
use KubAT\PhpSimple\HtmlDomParser;


ini_set("max_execution_time", 0);   // no time-outs!
ignore_user_abort(true);            // Continue downloading even after user closes the browser.

error_reporting(E_ALL);
ini_set('display_errors', 1);

class EtsyScrapperController extends Controller
{
  // STATUSES FOR tmp_etsy_product TABLE
  // 1:: Templett link found on description, row inserted on tmp_template
  // 0:: URL parsed but no templett url found on description
  // null:: URL not parsed yet

  // STATUSES FOR tmp_etsy_metadata TABLE
  // 0:: URL parsed, templett has not been downloaded

    // function startScrapping(){
    function extractMetaData(){
      // $this->parseMetaData('https://www.etsy.com/listing/666353075/templett-template-revision-fee-please');
      // exit;

      $urls = DB::table('tmp_etsy_product')
                ->select('id','product_link_href')
                ->whereNull('status')
                ->limit(1000)
                ->get();

      foreach ($urls as $key => $url) {
        
        $url_parts = parse_url($url->product_link_href);
        $final_url = $url_parts['scheme'].'://'.$url_parts['host'].$url_parts['path'];
        // echo $final_url."<br>";
        // exit;
        // https://www.etsy.com/listing/643207673/llama-party-thank-you-card-self-editable
        // echo $url->product_link_href;
        // preg_match_all('/(http|https):\/\/www\.etsy\.com\/listing\/[0-9]+\/[a-z-]+/', $url->product_link_href, $etsy_links);
        // echo "<pre>";
        // print_r($etsy_links);
        // exit;

        $this->parseMetaData($final_url, $url->id);
        exit;
        usleep(500000);
    	}

    	// echo "<pre>";
    	// print_r($urls);
    	// exit;
    }

    function parseMetaData($etsy_url, $product_id){

  		// $html = <<<EOF
  		// EOF;
  		// $dom = HtmlDomParser::str_get_html($html);
  		// print_r($dom->find('span[class="text-body text-gray-lighter ml-xs-1"]',0)->plaintext);
  		// exit;

    	// $etsy_url = 'https://www.etsy.com/listing/673966794/confetti-gold-glitter-birthday';
            
        $opts = array(
          'http'=>array(
            'method'=>"GET",
            'header'=> "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/72.0.3626.121 Safari/537.36\r\n"
                        // "Cookie: foo=bar\r\n"
          )
        );
        
        // print_r("Hola");
        // print_r($etsy_url);
        // print_r($html);
        // exit;

        // try {
        
        if(!empty($etsy_url)) {

          $context = stream_context_create($opts);
          $file = file_get_contents($etsy_url, false, $context);

          $html = HtmlDomParser::str_get_html($file);

          if (!empty($html)) {
            echo "Parseando HTML descargado de la web $etsy_url<br>";
            $title = null;
            $username = null;
            $price = null;
            $thumbnail_url = null;
            $stars = null;
            $description = null;
            $templett_link = null;
            $templett_ids = null;
            $parse_status = 0;

            if( isset($html->find('h1.override-listing-title',0)->innertext) ){
              $title = $html->find('h1.override-listing-title',0)->innertext;
            }

            if(isset($html->find('a.text-link-no-underline',0)->innertext)){
              $username = $html->find('a.text-link-no-underline',0)->innertext;
            }

            if(isset($html->find('span.text-largest',0)->innertext)){
              $price = $html->find('span.text-largest',0)->innertext;
            }

            if(isset($html->find('ul#image-carousel>li.height-full',0)->{'data-full-image-href'})){
              $thumbnail_url = $html->find('ul#image-carousel>li.height-full',0)->{'data-full-image-href'};
            }

            if(isset($html->find('span[class="text-body text-gray-lighter ml-xs-1"]',0)->plaintext)){
              $stars = $html->find('span[class="text-body text-gray-lighter ml-xs-1"]',0)->plaintext;
            }

            if(isset($html->find('div[class="content-toggle-body"]',0)->innertext)){
              $description = $html->find('div[class="content-toggle-body"]',0)->innertext;

              preg_match_all('/(http|ftp|https):\/\/templett\.com\/design\/demo\/(.*)\/([0-9]+)(,[0-9]+)*/', $description, $templett_links);
              if(is_array($templett_links) && sizeof($templett_links) > 0){
                $templett_url = isset($templett_links[0][0]) ? $templett_links[0][0] : '';
              }
              
              preg_match_all('/\[id:([0-9]+(,[0-9]+)*?)\]/', $description, $templett_ids);
              if(is_array($templett_ids) && sizeof($templett_ids) > 0){
                $templett_ids = isset($templett_ids[0][0]) ? $templett_ids[0][0] : '';
              }
            }

            echo "<pre>";
            print_r([
              'id' => null, 
              'fk_product_id' => $product_id,
              'title' => $title,
              'description' => $description,
              'username' => trim($username),
              'price' => trim(str_replace('$', null, $price)),
              'thumbnail' => $thumbnail_url,
              'stars' => trim(str_replace('(', null, str_replace(')', null, $stars))),
              // 'templett_url' => $templett_url,
              'templett_ids' => $templett_ids,
              'status' => 0
            ]);
            exit;

            if($templett_ids != '' || $templett_link != ''){
              
              echo "Se encontro vinculo Templett, insertando metadata del producto....<br>";

              DB::table('tmp_etsy_metadata')->insert([
                      'id' => null, 
                      'fk_product_id' => $product_id,
                      'title' => $title,
                      'description' => $description,
                      'username' => trim($username),
                      'price' => trim(str_replace('$', null, $price)),
                      'thumbnail' => $thumbnail_url,
                      'stars' => trim(str_replace('(', null, str_replace(')', null, $stars))),
                      'templett_url' => $templett_url,
                      'templett_ids' => $templett_ids,
                      'status' => 0
              ]);
              $parse_status = 1; // Templett link found on description
            }

            DB::table('tmp_etsy_product')
                ->where('id', $product_id)
                ->update([
                  'status' => $parse_status,
                  'parsed_url' => $etsy_url
                ]);

          } else {
            echo "HTML no se pudo extraer<br>";
          }
        }

        // } catch (Exception $e) {

          // Log::error("NO SE PUEDE PARSEAR ESTA URL");
          // Log::error($etsy_url);
        // }       	

    }
}
