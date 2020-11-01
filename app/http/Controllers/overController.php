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

class CrelloController extends Controller
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
            
            $pages = Redis::keys('category:'.$category->id.':offset:*');
            $total_page_number = sizeof($pages)*100;
            // print_r($total_page_number);
            for ($offset_page=0; $offset_page < $total_page_number; $offset_page +=100) { 
                $page_data = json_decode(Redis::get('category:'.$category->id.':offset:'.$offset_page));
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

                    // print_r("\n TEMPLATE:: ".$template->id);
                    // $this->generateDownloadPage($template->id);
                    // // exit;
                }
            }

        }
    }

    function getCategories(){
        // $auth_token = 'eyJjdHkiOiJKV1QiLCJlbmMiOiJBMTI4R0NNIiwiYWxnIjoiZGlyIn0..MqIBDs9TDJkvdywU.EqVtUaMEMzb73DFwHPSk1I3jBp8dNK5B90Yu8eGeUfNUZsOjCI_xh-_Sb_5ns1A3MOWhfn5V4d8NGcRwilgLnwyrovWGyLYrpjRz--XpYnWDlyZVXEnr8ud2lT6o0HBnY7ABqpyvDK8Sk7E1tdEV2a1AboP0aMZM3TkHXruk94qPQgqzYR32JXK97Id4RxjpVniiyOLtlF1UrxynHJMUkusUpLTwanaSThhg7WOu5ZW7ua4lQ1k4ymgBnaTSacmZBA1Wi77NTGPmQT9aHmF5wGlNWTDGQKjqSW_R8jIoNM5ILDreStr2_yfwepqpBZgqWTE5LBDiWywKsq-TMpi7ZvdQaTSOkOucZTjQ_Jwt0Ky07FYr9DAQMjZHJ7AbTdfUpuwTOGfX8_0rm5boiC8i77BsZ-97aCrPanxCtr_OMRqwsRYyi68A91rmCKNXYHlMQsZ1U0j6M6JYv7L4jDt2iOPZyF23DKnb-8qtBZQqQm1gyG4V_t0e2fVQ3z0JCL80vfLt2uBnKJta5Ikp0u2VhKHJXkf-Y9_oTtIIkCOi2LXhploB091WvTZ55i8QTxO1RG9WjprDWfE9qBZ14DfoZ5P4Q7Npy3beMMncCpnjAL6QB8ItJFqYu39atfR7YV2fK0R4umNv-EeA1lOQPQ77l4AdZn5X5zl0avzcrWvpMZTG50WKnlCyInbW9DxMltBJYEdIa7TAlapMnfslOQzQpFe-oiM-EFjxKmVh.sBd5Y6rwAfhRzJercezTaA';

        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        // CURLOPT_URL => "https://api.overhq.com/feed/quickstart",
        // CURLOPT_RETURNTRANSFER => true,
        // CURLOPT_ENCODING => "",
        // CURLOPT_MAXREDIRS => 10,
        // CURLOPT_TIMEOUT => 0,
        // CURLOPT_FOLLOWLOCATION => true,
        // CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        // CURLOPT_CUSTOMREQUEST => "GET",
        // CURLOPT_HTTPHEADER => array(
        //     "Host: api.overhq.com",
        //     "accept: application/json",
        //     "content-type: application/json",
        //     "accept-language: en-MX;q=1.0, es-MX;q=0.9",
        //     "over-lang: en",
        //     "user-agent: Over/7.1.7 (com.gopotluck.over; build:70094; iOS 14.0.0)",
        //     "over-auth: $auth_token"
        // ),
        // ));

        // $response = curl_exec($curl);
        
        // Redis::set('categories', $response);
        
        $response = Redis::get('categories');
        $response = json_decode($response);

        // curl_close($curl);
        // echo "<pre>";
        // print_r($response);
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
            "over-auth: eyJjdHkiOiJKV1QiLCJlbmMiOiJBMTI4R0NNIiwiYWxnIjoiZGlyIn0..MqIBDs9TDJkvdywU.EqVtUaMEMzb73DFwHPSk1I3jBp8dNK5B90Yu8eGeUfNUZsOjCI_xh-_Sb_5ns1A3MOWhfn5V4d8NGcRwilgLnwyrovWGyLYrpjRz--XpYnWDlyZVXEnr8ud2lT6o0HBnY7ABqpyvDK8Sk7E1tdEV2a1AboP0aMZM3TkHXruk94qPQgqzYR32JXK97Id4RxjpVniiyOLtlF1UrxynHJMUkusUpLTwanaSThhg7WOu5ZW7ua4lQ1k4ymgBnaTSacmZBA1Wi77NTGPmQT9aHmF5wGlNWTDGQKjqSW_R8jIoNM5ILDreStr2_yfwepqpBZgqWTE5LBDiWywKsq-TMpi7ZvdQaTSOkOucZTjQ_Jwt0Ky07FYr9DAQMjZHJ7AbTdfUpuwTOGfX8_0rm5boiC8i77BsZ-97aCrPanxCtr_OMRqwsRYyi68A91rmCKNXYHlMQsZ1U0j6M6JYv7L4jDt2iOPZyF23DKnb-8qtBZQqQm1gyG4V_t0e2fVQ3z0JCL80vfLt2uBnKJta5Ikp0u2VhKHJXkf-Y9_oTtIIkCOi2LXhploB091WvTZ55i8QTxO1RG9WjprDWfE9qBZ14DfoZ5P4Q7Npy3beMMncCpnjAL6QB8ItJFqYu39atfR7YV2fK0R4umNv-EeA1lOQPQ77l4AdZn5X5zl0avzcrWvpMZTG50WKnlCyInbW9DxMltBJYEdIa7TAlapMnfslOQzQpFe-oiM-EFjxKmVh.sBd5Y6rwAfhRzJercezTaA"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        // echo $response;
        $obj_response = json_decode($response);
        
        if($obj_response->elementList->count > 0){
            Redis::set('category:'.$category_id.':offset:'.$offset, $response);
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
                    "over-auth: eyJjdHkiOiJKV1QiLCJlbmMiOiJBMTI4R0NNIiwiYWxnIjoiZGlyIn0..MqIBDs9TDJkvdywU.EqVtUaMEMzb73DFwHPSk1I3jBp8dNK5B90Yu8eGeUfNUZsOjCI_xh-_Sb_5ns1A3MOWhfn5V4d8NGcRwilgLnwyrovWGyLYrpjRz--XpYnWDlyZVXEnr8ud2lT6o0HBnY7ABqpyvDK8Sk7E1tdEV2a1AboP0aMZM3TkHXruk94qPQgqzYR32JXK97Id4RxjpVniiyOLtlF1UrxynHJMUkusUpLTwanaSThhg7WOu5ZW7ua4lQ1k4ymgBnaTSacmZBA1Wi77NTGPmQT9aHmF5wGlNWTDGQKjqSW_R8jIoNM5ILDreStr2_yfwepqpBZgqWTE5LBDiWywKsq-TMpi7ZvdQaTSOkOucZTjQ_Jwt0Ky07FYr9DAQMjZHJ7AbTdfUpuwTOGfX8_0rm5boiC8i77BsZ-97aCrPanxCtr_OMRqwsRYyi68A91rmCKNXYHlMQsZ1U0j6M6JYv7L4jDt2iOPZyF23DKnb-8qtBZQqQm1gyG4V_t0e2fVQ3z0JCL80vfLt2uBnKJta5Ikp0u2VhKHJXkf-Y9_oTtIIkCOi2LXhploB091WvTZ55i8QTxO1RG9WjprDWfE9qBZ14DfoZ5P4Q7Npy3beMMncCpnjAL6QB8ItJFqYu39atfR7YV2fK0R4umNv-EeA1lOQPQ77l4AdZn5X5zl0avzcrWvpMZTG50WKnlCyInbW9DxMltBJYEdIa7TAlapMnfslOQzQpFe-oiM-EFjxKmVh.sBd5Y6rwAfhRzJercezTaA",
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
