<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;

// use SVG\SVG;
// use Image;
// use Intervention\Image\ImageManagerStatic as Image;

// use SVG\Nodes\Shapes\SVGCircle;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
// use Illuminate\Http\UploadedFile;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\App;

// use Barryvdh\DomPDF\Facade as PDF;
// use Image;
// use Intervention\Image;


// ini_set('memory_limit', -1);


class PacktController extends Controller
{
	function index(){
        // keys

        $redis_packt = Redis::connection('redisuat');
        $token = $redis_packt->get('packt:token');
        $token = json_decode($token);

        $playlists = self::getPlaylist( $token->data->access );
        
        // echo "<pre>";
        // print_r($playlists);
        // exit;

        if( isset($playlists->errorCode) && $playlists->errorCode == 1000100){ // jwt expired
            
            $refresh_token_response = self::refreshToken( $token->data->refresh, $token->data->access );
            $token = json_decode($refresh_token_response);

            if( $token->httpStatus == 200 ){
                // echo "BBB";
                $playlists = self::getPlaylist( $token->data->access );
                
                if( isset($playlists->data) ){
                    foreach($playlists->data as $playlist){
                        
                        // echo "<pre>";
                        // print_r($playlist);
                        // exit;
                        

                        foreach($playlist->products as $product){
                            // // // // // // // // // // // // // // ////
                            // $product->productId = "9781783554317";
                            // print_r($product->productId);
                            // exit;
                            self::downloadCourseContent( $product->productId, $token );
                            self::deleteFromPlaylist( $playlists->productId, $product->productId, $token );
                        }
                    }
                }
            }
        
        // User 63529605-6c13-4822-a1d3-084d468ebe42 is not entitled to access the content 9781789610253
        } elseif( isset($playlists->errorCode) && $playlists->errorCode == 1001061){
            
            echo "ERROR >>> Abrir https://subscription.packtpub.com/book/web_development/9781801071055";
            exit;

        } elseif( isset($playlists->data) ) {
            $playlists = self::getPlaylist( $token->data->access );
            if( isset($playlists->data) ){
                foreach($playlists->data as $playlist){
                    foreach($playlist->products as $product){
                        self::downloadCourseContent( $product->productId, $token );
                    }
                }
            }
        }

    }

    // $local_img_path, $img_url
    function deleteFromPlaylist( $playlist_id, $product_id, $token ){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://services.packtpub.com/lists-v1/users/me/playlists/$playlist_id/products/$product_id",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "DELETE",
        CURLOPT_POSTFIELDS =>"{}",
        CURLOPT_HTTPHEADER => array(
            "authority: services.packtpub.com",
            "pragma: no-cache",
            "cache-control: no-cache",
            "sec-ch-ua: \"Chromium\";v=\"88\", \"Google Chrome\";v=\"88\", \";Not A Brand\";v=\"99\"",
            "accept: application/json, text/plain, */*",
            "authorization: Bearer $token",
            "sec-ch-ua-mobile: ?0",
            "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36",
            "content-type: application/json",
            "origin: https://subscription.packtpub.com",
            "sec-fetch-site: same-site",
            "sec-fetch-mode: cors",
            "sec-fetch-dest: empty",
            "referer: https://subscription.packtpub.com/",
            "accept-language: es,en;q=0.9"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
    }

    function downloadCourseContent( $product_id, $token ){

        // echo "<pre>";
        // print_r($response);
        // exit;

        // $product_id = 9781800206847; // Video
        // $product_id = 9781789610253; // BOOK
        // $product_id = "9781801071055";
    
        $content_type = json_decode(self::getContentType($product_id));
        $redis_packt = Redis::connection('redisuat');
        $response = self::getBookIndex( $token->data->access, $product_id );
        $response = json_decode($response);

        // echo "<pre>";
        // print_r($content_type);
        // exit;
        
        if( isset($response->errorCode) && $response->errorCode == 1000100){ // jwt expired
            
            $refresh_token_response = self::refreshToken( $token->data->refresh, $token->data->access );
            $token = json_decode($refresh_token_response);

            if( $token->httpStatus == 200 ){
                // echo "BBB";
                $response = self::getBookIndex( $token->data->access, $product_id );
                $response = json_decode($response);

                if( isset($response->data) ) {
                    $redis_packt->set('packt:product:'.$product_id, json_encode($response) );
                }
            }
        
        // User 63529605-6c13-4822-a1d3-084d468ebe42 is not entitled to access the content 9781789610253
        } elseif( isset($response->errorCode) && $response->errorCode == 1001061){
            
            echo "ERROR >>> Abrir https://subscription.packtpub.com/book/web_development/".$product_id;
            exit;

        } elseif( isset($response->data) ) {
            $redis_packt->set('packt:product:'.$product_id, json_encode($response) );
        }

        // Video content
        if( array_search('video', $content_type->data[0]->fileTypes ) ){
            
            $chapters = $response->data->chapters;
            // echo "<pre>";
            // print_r($chapters);
            // exit;

            foreach($chapters as $index => $chapter){
                foreach($chapter->sections as $section){
                    self::getSectionContent( $product_id, $section->location );
                    
                    $donwload_urls = self::getDownloadURLs($token->data->access, $product_id, $index+1, $section->id );
                    if( isset($donwload_urls->captions) ){
                        foreach($donwload_urls->captions as $caption){
                            self::getSectionContent( $product_id, $caption->location );
                        }
                    }
                }
            }
        } elseif( array_search('epub', $content_type->data[0]->fileTypes )
            || array_search('mobi', $content_type->data[0]->fileTypes )
            || array_search('pdf', $content_type->data[0]->fileTypes ) ) {

            $graphics = $response->data->graphics;
            foreach($graphics as $resource){
                // print_r( $resource );
                // exit;
                // https://static.packt-cdn.com/products/9781789610253/graphics/a128786a-95e3-41a7-9a68-3be37a271221.png

                $img_url_info = pathinfo( $resource );
                $full_file_path = public_path( "packtpub/products/$product_id/graphics/$product_id/graphics/".$img_url_info['basename'] );
                $path_info = pathinfo( $full_file_path );
                $local_img_path = $path_info['dirname'];

                if( file_exists( $full_file_path )  == false ){
                    // echo $full_file_path;
                    // exit;
                    $img_url = 'https://static.packt-cdn.com/products/$product_id/graphics/'.$img_url_info['basename'];
                    self::downloadImage($full_file_path, $img_url);
                    // exit;
                }
            }

            $chapters = $response->data->chapters;

            foreach($chapters as $chapter){
                
                foreach($chapter->sections as $section){
                    if( $section->contentType == 'text' ){
                        self::getSectionContent($product_id, $section->location );
                    }
                }
            }

            $appendices = $response->data->appendices;
            foreach($appendices as $appendix){
                foreach($appendix->sections as $section){
                    if( $section->contentType == 'text' ){
                        self::getSectionContent($product_id, $section->location );
                    }
                }
            }

            $prefaces = $response->data->prefaces;
            foreach($prefaces as $preface){
                foreach($preface->sections as $section){
                    if( $section->contentType == 'text' ){
                        self::getSectionContent($product_id, $section->location );
                    }
                }
            }
        }
    }

    function getSectionContent( $product_id, $url ){
        
        $chapter_url = pathinfo( $url );
        $filename = strpos($chapter_url['basename'], '?') > 0 ? substr($chapter_url['basename'], 0, strpos($chapter_url['basename'], '?') ) : $chapter_url['basename'];
        $full_file_path = public_path( "packtpub/products/$product_id/".$filename );
        
        if( file_exists( $full_file_path )  == false ){
            
            $path_info = pathinfo($full_file_path);
            $path = $path_info['dirname'];
        
            // echo "<pre>";
            // print_r($full_file_path);
            // exit;
    
            @mkdir($path, 0777, true);
        
            set_time_limit(0);
        
            //This is the file where we save the    information
            $fp = fopen ($full_file_path, 'w+');
        
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

            // $redis_packt->set( 'packt:product:'.$product_id.':section:'.$section_id , $response);
            
            print_r("   CHAPTER DOWNLOADED >> ".$url."<br>\n");

        }

        // echo "<pre>";
        // print_r($full_file_path);
        // exit;
    }
    
    function downloadImage(  $local_img_path, $img_url ){
        
        $path_info = pathinfo($local_img_path);
        $path = $path_info['dirname'];

        @mkdir($path, 0777, true);
    
        set_time_limit(0);
    
        //This is the file where we save the    information
        $fp = fopen ($local_img_path, 'w+');
    
        //Here is the file we are downloading, replace spaces with %20
        $ch = curl_init(str_replace(" ","%20",$img_url));
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        
        // write curl response to file
        curl_setopt($ch, CURLOPT_FILE, $fp); 
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
        // get curl response
        curl_exec($ch); 
        curl_close($ch);
        fclose($fp);
    }

	function getIndex(){
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://static.packt-cdn.com/products/9781838647773/summary",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Host: static.packt-cdn.com",
            "accept: application/json, text/plain, */*",
            "origin: http://localhost:8080",
            "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148",
            "accept-language: en-us",
            "referer: http://localhost:8080/private/var/containers/Bundle/Application/4529EA96-6FD7-427B-A9C3-ECF6D4BAE317/Packt.app/www/index.html",
            "Pragma: no-cache",
            "Cache-Control: no-cache"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
        
    }
    
	function login(){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://services.packtpub.com/auth-v1/users/tokens",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{\"password\":\"Gundam7972\",\"username\":\"dagtok@gmail.com\"}",
        CURLOPT_HTTPHEADER => array(
            "authority: services.packtpub.com",
            "pragma: no-cache",
            "cache-control: no-cache",
            "sec-ch-ua: \"Chromium\";v=\"88\", \"Google Chrome\";v=\"88\", \";Not A Brand\";v=\"99\"",
            "accept: application/json, text/plain, */*",
            "sec-ch-ua-mobile: ?0",
            "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36",
            "content-type: application/json",
            "origin: https://subscription.packtpub.com",
            "sec-fetch-site: same-site",
            "sec-fetch-mode: cors",
            "sec-fetch-dest: empty",
            "referer: https://subscription.packtpub.com/",
            "accept-language: es,en;q=0.9"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        // echo "<pre>";
        // print_r( json_decode($response) );

        $redis_packt = Redis::connection('redisuat');
        $redis_packt->set('packt:token',$response);
        // return $response;
    }

    function getBookIndex( $access_token, $product_id ){

        $redis_packt = Redis::connection('redisuat');
        
        // echo 'packt:product_content:'.$product_id;

        if( $redis_packt->exists('packt:product_content:'.$product_id) == false ){

            $curl = curl_init();
            
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://services.packtpub.com/products-v1/products/$product_id/signed-content",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Host: services.packtpub.com",
                "accept: application/json, text/plain, */*",
                "origin: http://localhost:8080",
                "referer: http://localhost:8080/private/var/containers/Bundle/Application/4529EA96-6FD7-427B-A9C3-ECF6D4BAE317/Packt.app/www/index.html",
                "accept-language: en-us",
                "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148",
                "authorization: Bearer ".$access_token,
                "Pragma: no-cache",
                "Cache-Control: no-cache"
            ),
            ));
    
            $response = curl_exec($curl);
    
            curl_close($curl);
            
            // $redis_packt->set('packt:product_content:'.$product_id, $response);

        } else {
            $response = $redis_packt->get('packt:product:'.$product_id);
        }

        // echo $response;
        return $response;
    }

    function getAsset( $product_id, $asset_id ){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://static.packt-cdn.com/products/9781838647773/graphics/assets/9588f0ee-ebbe-4629-bb46-71680dbf0780.png",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }

    function getDownloadURLs($access_token, $product_id,$chapter, $id ){
        print_r( "https://services.packtpub.com/products-v1/products/$product_id/p$chapter/$id <br>" );
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://services.packtpub.com/products-v1/products/$product_id/p$chapter/$id",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "authority: services.packtpub.com",
            "pragma: no-cache",
            "cache-control: no-cache",
            "sec-ch-ua: \"Chromium\";v=\"88\", \"Google Chrome\";v=\"88\", \";Not A Brand\";v=\"99\"",
            "accept: application/json, text/plain, */*",
            "authorization: Bearer ".$access_token,
            "sec-ch-ua-mobile: ?0",
            "user-agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.192 Safari/537.36",
            "origin: https://subscription.packtpub.com",
            "sec-fetch-site: same-site",
            "sec-fetch-mode: cors",
            "sec-fetch-dest: empty",
            "referer: https://subscription.packtpub.com/",
            "accept-language: es,en;q=0.9"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        // echo "<pre>";
        // print_r(  );
        // exit;
        return json_decode($response);
    }
    function getContentType( $product_id ){
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://services.packtpub.com/products-v1/products/$product_id/types",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Host: services.packtpub.com",
            "accept: application/json, text/plain, */*",
            "origin: http://localhost:8080",
            "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148",
            "accept-language: en-us",
            "referer: http://localhost:8080/private/var/containers/Bundle/Application/4529EA96-6FD7-427B-A9C3-ECF6D4BAE317/Packt.app/www/index.html",
            "Pragma: no-cache",
            "Cache-Control: no-cache"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        // echo "<pre>";
        // print_r($response);
        return $response;

    }

    function getPlaylist( $access_token ){
        
        // $refresh_token = $token->data->access;
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://services.packtpub.com/lists-v1/users/me/playlists",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Host: services.packtpub.com",
            "accept: application/json, text/plain, */*",
            "origin: http://localhost:8080",
            "referer: http://localhost:8080/private/var/containers/Bundle/Application/4529EA96-6FD7-427B-A9C3-ECF6D4BAE317/Packt.app/www/index.html",
            "accept-language: en-us",
            "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148",
            "authorization: Bearer $access_token",
            "Pragma: no-cache",
            "Cache-Control: no-cache"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $response = json_decode($response);

        return $response;
        // echo "<pre>";
        // print_r( $response );

    }

	function refreshToken( $refresh_token, $access_token ){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://services.packtpub.com/auth-v1/users/me/tokens",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS =>"{\"refresh\":\"$refresh_token\"}",
        CURLOPT_HTTPHEADER => array(
            "Host: services.packtpub.com",
            "accept: application/json, text/plain, */*",
            "origin: http://localhost:8080",
            "content-type: application/json",
            "authorization: Bearer $access_token",
            "referer: http://localhost:8080/private/var/containers/Bundle/Application/4529EA96-6FD7-427B-A9C3-ECF6D4BAE317/Packt.app/www/index.html",
            "accept-language: en-us",
            "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148",
            "Pragma: no-cache",
            "Cache-Control: no-cache"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        $redis_packt = Redis::connection('redisuat');
        $redis_packt->set('packt:token', $response);

        // $token = $redis_packt->get('packt:token');

        // echo "<pre>asdasdas";
        // print_r( json_decode($response) );
        // exit;

        return $response;

    }
}
