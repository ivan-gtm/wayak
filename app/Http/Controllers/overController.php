<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

ini_set("max_execution_time", 0);   // no time-outs!
ini_set("request_terminate_timeout", 2000);   // no time-outs!
ini_set('memory_limit', -1);
ini_set('display_errors', 1);

ignore_user_abort(true);            // Continue downloading even after user closes the browser.
error_reporting(E_ALL);

class overController extends Controller
{
    public function index(){
        $categories = $this->getCategories();
        // print_r("\n");
        // print_r($categories);
        // print_r('---\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\---');
        // exit;

        // $categories = $categories;
        // print_r($categories->quickstartList->quickstarts);
        foreach ($categories->quickstartList->quickstarts as $category) {
            $img_url = $category->icon;
            $path_info = pathinfo($img_url); // dirname, filename, extension
            $local_img_path = public_path('over/categories/'.$path_info['basename']);
            
            if( file_exists( $local_img_path )  == false ){
                self::downloadImage( $local_img_path, $img_url );
            }
            
            print_r("\n");
            print_r('---\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\---');
            print_r($category->id);
            print_r('---\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\---');
            
            // for ($offset=0; $offset < 10000; $offset +=100) { 
            //     print_r("\n");
            //     print_r($offset);

            //     if( $this->saveCategoryOnDB($category->id, $offset) == false){
            //         break;
            //     }
            // }

            // $this->generateDownloadPage(16916);
            // exit;
            
            $pages = Redis::keys('over:category:'.$category->id.':offset:*');
            $total_page_number = sizeof($pages)*100;
            // print_r($total_page_number);
            for ($offset_page=0; $offset_page < $total_page_number; $offset_page +=100) { 
                $page_data = json_decode(Redis::get('over:category:'.$category->id.':offset:'.$offset_page));
                // print_r($page_data->elementList->elements);
                // exit;
                $templates = $page_data->elementList->elements;
                foreach ($templates as $template) {
                    // print_r("\n<pre>");
                    // print_r($template);
                    if( isset($template->video->thumbnailUrl) ){
                        // print_r($template);
                        $img_url = $template->video->thumbnailUrl;
                        $path_info = pathinfo($img_url); // dirname, filename, extension
                        $local_img_path = public_path('over/templates/'.$template->id.'/'.$path_info['basename'].'.jpg');

                        // print_r("\n<pre>");
                        // print_r($img_url);
                        // print_r($path_info);
                        // print_r($local_img_path);
                        // exit;
                        
                        if( file_exists( $local_img_path )  == false ){
                            $this->downloadImage(  $local_img_path, $img_url );
                        }
                        
                        // print_r($template->video->thumbnailUrl);
                    } else {
                        // print_r($template->template->thumbnailUrl);
                        // exit;
                        $img_url = $template->template->thumbnailUrl;
                        $path_info = pathinfo($img_url); // dirname, filename, extension
                        $local_img_path = public_path('over/templates/'.$template->id.'/'.$path_info['basename'].'.jpg');

                        // print_r("\n<pre>");
                        // print_r($img_url);
                        // print_r($path_info);
                        // print_r($local_img_path);
                        // exit;
                        
                        if( file_exists( $local_img_path )  == false ){
                            $this->downloadImage(  $local_img_path, $img_url );
                        }
                    }
                    // exit;

                    print_r("\n TEMPLATE:: ".$template->id);
                    $this->generateDownloadPage($template->id);
                    // // exit;
                }
            }

        }
    }

    function getCategories(){
        // $auth_token = 'eyJjdHkiOiJKV1QiLCJlbmMiOiJBMTI4R0NNIiwiYWxnIjoiZGlyIn0..HsTjvBwUoWcG0CPH.ZL_UNTdO7M0UbCxNaqmjXtwss7RIznBfmbGM2lNbvBFUGx1I3Q27YNbbTa-QovyUMnIn56U4OFdX3FSusOmdcvCBc7bc_dQtUzC-RIqw8RSZ4_mV5VqqVIq-wkNd4GK3fYuAFgAi8qmb9WwX6_OMqjjKQmQscMc3Cr6665gfWN1vOeeYBp8cpkLjthC7V3qW8UfG13Ho9Omwwn2fs98MfbCcob6J2JllYKHsNjvY6VPeADS6KMKhHgcid4feXpCfFuUjQjVYe9-3srUDywwyKH9-jT6VHN0eQYtbLEDfQrQeI9E54ub0jMBcH322c1OG9ugcab4AcT973hrENlxBtaS3ToVPX3FwHJ-b77hw8hV8e9pIOqrZ0O8bEkfDnT3tlIGZt9RlOuLzmWcxpT0hQyRHqfvis7gKhiFFQeoq6VTlDp3OeCuGLIcmsNaUowY5Dxp5yuM3T79RGeFlvZjq-LGJ645ozh1IA8mjM4T6W1_IrDOAbzKm-hXdtADx-7xGUAsgvjFmkcpvLVgKGb8Wi9rpYGwP-xg9kqPxaXPV1wQoGM6nUtqFtp8yvDyMw7Hu0tkmWiKkJhqN83WUEmfNpNFmTg9gfxKAcJWWJg5FR69kuZSIWTYHvDPacj5C4buOgQ8ynrfOB2ov0G6NZ1Yj3ZUy1LI7FiDK5CSby0vObAd32DXMMJBKJhTVyjvB6S7XYIze3y-UYLyKDXpCu398sQ0E_AG8ixz8ZX6l.Bz23_GRoIVIeYy_jZbao-g';

        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => "https://api.overhq.com/feed/quickstart",
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => "",
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => "GET",
        //     CURLOPT_HTTPHEADER => array(
        //         "Host: api.overhq.com",
        //         "accept: application/json",
        //         "content-type: application/json",
        //         "accept-language: en-MX;q=1.0, es-MX;q=0.9",
        //         "over-lang: en",
        //         "user-agent: Over/7.1.7 (com.gopotluck.over; build:70094; iOS 14.0.0)",
        //         "over-auth: $auth_token"
        //     ),
        // ));

        // $response = curl_exec($curl); 
        // Redis::set('over:categories', $response);
        // curl_close($curl);

        $response = Redis::get('over:categories');
        $response = json_decode($response);

        
        echo "<pre>";
        print_r($response);

        return $response;

    }

    function downloadImage(  $local_img_path, $img_url ){
        
        $path_info = pathinfo($local_img_path);
        
        $path = $path_info['dirname'];

        // print_r("<pre>");
        // print_r($path_info['dirname']);
        // print_r($path);
        // print_r($path_info);
        // print_r($local_img_path);
        // exit;
    
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

    function saveCategoryOnDB($category_id, $offset = 0){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.overhq.com/feed/quickstart/$category_id?limit=100&offset=$offset&refresh=0",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Host: api.overhq.com",
            "accept: application/json",
            "content-type: application/json",
            "accept-language: en-MX;q=1.0, es-MX;q=0.9",
            "over-lang: en",
            "user-agent: Over/7.1.7 (com.gopotluck.over; build:70094; iOS 14.0.0)",
            "over-auth: eyJjdHkiOiJKV1QiLCJlbmMiOiJBMTI4R0NNIiwiYWxnIjoiZGlyIn0..HsTjvBwUoWcG0CPH.ZL_UNTdO7M0UbCxNaqmjXtwss7RIznBfmbGM2lNbvBFUGx1I3Q27YNbbTa-QovyUMnIn56U4OFdX3FSusOmdcvCBc7bc_dQtUzC-RIqw8RSZ4_mV5VqqVIq-wkNd4GK3fYuAFgAi8qmb9WwX6_OMqjjKQmQscMc3Cr6665gfWN1vOeeYBp8cpkLjthC7V3qW8UfG13Ho9Omwwn2fs98MfbCcob6J2JllYKHsNjvY6VPeADS6KMKhHgcid4feXpCfFuUjQjVYe9-3srUDywwyKH9-jT6VHN0eQYtbLEDfQrQeI9E54ub0jMBcH322c1OG9ugcab4AcT973hrENlxBtaS3ToVPX3FwHJ-b77hw8hV8e9pIOqrZ0O8bEkfDnT3tlIGZt9RlOuLzmWcxpT0hQyRHqfvis7gKhiFFQeoq6VTlDp3OeCuGLIcmsNaUowY5Dxp5yuM3T79RGeFlvZjq-LGJ645ozh1IA8mjM4T6W1_IrDOAbzKm-hXdtADx-7xGUAsgvjFmkcpvLVgKGb8Wi9rpYGwP-xg9kqPxaXPV1wQoGM6nUtqFtp8yvDyMw7Hu0tkmWiKkJhqN83WUEmfNpNFmTg9gfxKAcJWWJg5FR69kuZSIWTYHvDPacj5C4buOgQ8ynrfOB2ov0G6NZ1Yj3ZUy1LI7FiDK5CSby0vObAd32DXMMJBKJhTVyjvB6S7XYIze3y-UYLyKDXpCu398sQ0E_AG8ixz8ZX6l.Bz23_GRoIVIeYy_jZbao-g"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        // echo $response;
        $obj_response = json_decode($response);
        
        if($obj_response->elementList->count > 0){
            Redis::set('over:category:'.$category_id.':offset:'.$offset, $response);
            return true;
        }

        return false;

    }

    function generateDownloadPage($template_id){
        
        set_time_limit(0);

        $full_file_path = public_path('over/templates/'.$template_id.'.zip');
        $path_info = pathinfo($full_file_path);
        $path = $path_info['dirname'];
        
        // echo "file_path\n\n\n\n";
        // echo $full_file_path;
        // echo "info\n\n\n\n";
        // print_r($path);
        // exit;
        if( file_exists( $full_file_path )  == false ){
            
            $curl = curl_init();
            
            @mkdir($path, 0777, true);
        
            //This is the file where we save the    information
            $fp = fopen ($full_file_path, 'w+');
    
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.overhq.com/element/$template_id/asset",
                // CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                // write curl response to file
                CURLOPT_FILE => $fp,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => array(
                    "Host: api.overhq.com",
                    "accept: */*",
                    "over-lang: en",
                    "user-agent: Over/7.1.7 (com.gopotluck.over; build:70094; iOS 14.0.0)",
                    "over-auth: eyJjdHkiOiJKV1QiLCJlbmMiOiJBMTI4R0NNIiwiYWxnIjoiZGlyIn0..HsTjvBwUoWcG0CPH.ZL_UNTdO7M0UbCxNaqmjXtwss7RIznBfmbGM2lNbvBFUGx1I3Q27YNbbTa-QovyUMnIn56U4OFdX3FSusOmdcvCBc7bc_dQtUzC-RIqw8RSZ4_mV5VqqVIq-wkNd4GK3fYuAFgAi8qmb9WwX6_OMqjjKQmQscMc3Cr6665gfWN1vOeeYBp8cpkLjthC7V3qW8UfG13Ho9Omwwn2fs98MfbCcob6J2JllYKHsNjvY6VPeADS6KMKhHgcid4feXpCfFuUjQjVYe9-3srUDywwyKH9-jT6VHN0eQYtbLEDfQrQeI9E54ub0jMBcH322c1OG9ugcab4AcT973hrENlxBtaS3ToVPX3FwHJ-b77hw8hV8e9pIOqrZ0O8bEkfDnT3tlIGZt9RlOuLzmWcxpT0hQyRHqfvis7gKhiFFQeoq6VTlDp3OeCuGLIcmsNaUowY5Dxp5yuM3T79RGeFlvZjq-LGJ645ozh1IA8mjM4T6W1_IrDOAbzKm-hXdtADx-7xGUAsgvjFmkcpvLVgKGb8Wi9rpYGwP-xg9kqPxaXPV1wQoGM6nUtqFtp8yvDyMw7Hu0tkmWiKkJhqN83WUEmfNpNFmTg9gfxKAcJWWJg5FR69kuZSIWTYHvDPacj5C4buOgQ8ynrfOB2ov0G6NZ1Yj3ZUy1LI7FiDK5CSby0vObAd32DXMMJBKJhTVyjvB6S7XYIze3y-UYLyKDXpCu398sQ0E_AG8ixz8ZX6l.Bz23_GRoIVIeYy_jZbao-g",
                    "accept-language: en-MX;q=1.0, es-MX;q=0.9"
                ),
            ));
    
            curl_exec($curl);
    
            curl_close($curl);
    
            fclose($fp);
        }
        
    }

    // function downloadTemplate(  $local_img_path, $img_url ){
        
    //     $path_info = pathinfo($local_img_path);
        
    //     $path = $path_info['dirname'];

    //     // print_r("<pre>");
    //     // print_r($path_info['dirname']);
    //     // print_r($path);
    //     // print_r($path_info);
    //     // print_r($local_img_path);
    //     // exit;
    
    //     @mkdir($path, 0777, true);
    
    //     set_time_limit(0);
    
    //     //This is the file where we save the    information
    //     $fp = fopen ($local_img_path, 'w+');
    
    //     //Here is the file we are downloading, replace spaces with %20
    //     $ch = curl_init(str_replace(" ","%20",$img_url));
    //     curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        
    //     // write curl response to file
    //     curl_setopt($ch, CURLOPT_FILE, $fp); 
    //     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        
    //     // get curl response
    //     curl_exec($ch); 
    //     curl_close($ch);
    //     fclose($fp);
    // }
}
