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

class DesygnerController extends Controller
{
    public function index() {

        // SCRAPP SEARCH RESULTS
        // $limit = 20;
        // for ($page_offset=20; $page_offset <= 3760; $page_offset+=20) { 
        //     // echo $page_offset;
        //     // echo "<br>";
        //     self::getTemplateResults($page_offset, $limit);
        // }

        // SCRAPP TEMPLATES
        // $desygner_keys = Redis::keys('desygner:search:results:*');
        // $tota_pages = sizeof($desygner_keys);

        // for ($page=0; $page < $tota_pages; $page++) { 
        //     $search_results = json_decode(Redis::get($desygner_keys[$page]));
        //     // echo "<pre>";
        //     // print_r($search_results);
        //     // exit;
        //     foreach ($search_results as $template) {
        //         echo "<pre>";
        //         // print_r($template);
        //         self::downloadTemplateThumbnail($template->encoded_id, $template->cover);
        //         self::getTemplate($template->encoded_id);
        //         // exit;
        //     }
        // }

        // DOWNLOAD ASSETS
        $template_keys = Redis::keys('desygner:template:*');

        foreach ($template_keys as $template_key) {
            $template_id = str_replace('desygner:template:','',$template_key);
            echo 'PARSING >>'.$template_id.'<br>';
            
            $template_assets = json_decode(Redis::get('desygner:template:'.$template_id));

            if(isset( $template_assets->pageContent )){

                $pattern = "/https:\/\/static.webrand.com\/virginia\/(original|web|tab|mobile|thumb)(\/\d+)*\/[A-Za-z0-9_-]*.jpg/";
                
                preg_match_all($pattern, $template_assets->pageContent, $matcher_content );
                preg_match_all($pattern, str_replace('\/','/',json_encode($template_assets->images)), $matcher_images );
                
                if( isset($matcher_content[0]) 
                    && sizeof($matcher_content[0]) > 0 ){
                    foreach ($matcher_content[0] as $img_url) {
                        self::downloadImageAsset($template_id, $img_url);
                    }
                }
        
                if( isset($matcher_images[0]) 
                    && sizeof($matcher_images[0]) > 0 ){
                    foreach ($matcher_images[0] as $img_url) {
                        self::downloadImageAsset($template_id, $img_url);
                    }
                }
        
                // echo "<pre>";
                // print_r( $matcher_content );
                // print_r( $matcher_images );
                // exit;
            } else {
                echo "<pre>";
                echo "SIN CONTENIDO <br>";
                print_r( $template_key );
                // next;
            }

        }

    }

    function downloadImageAsset($template_id, $img_url){
        
        set_time_limit(0);
        
        $img_url_info = pathinfo($img_url);
        
        // echo "<pre>";
        // print_r($img_url_info);
        // exit;
        
        $full_file_path = public_path( 'design/template/'.$template_id.'/assets/'.$img_url_info['basename'] );
        $path_info = pathinfo($full_file_path);
        $path = $path_info['dirname'];
        
        // print_r($path);
        print_r($full_file_path);
        print_r("\n");
        // exit;

        if( file_exists( $full_file_path )  == false ){

            $curl = curl_init();

            @mkdir($path, 0777, true);

            //This is the file where we save the    information
            $fp = fopen ($full_file_path, 'w+');

            curl_setopt_array($curl, array(
                CURLOPT_URL => $img_url,
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
                    "Referer: https://desygner.com/",
					"User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36"
                ),
            ));
            curl_exec($curl);
            curl_close($curl);
            fclose($fp);
        }
    }

    function downloadTemplateThumbnail($template_id, $thumb_url){

        set_time_limit(0);

        $full_file_path = public_path('design/template/'.$template_id.'/assets/preview.jpg');
        echo $full_file_path;
        $path_info = pathinfo($full_file_path);
        $path = $path_info['dirname'];

        if( file_exists( $full_file_path )  == false ){

            $curl = curl_init();

            @mkdir($path, 0777, true);

            //This is the file where we save the    information
            $fp = fopen ($full_file_path, 'w+');

            curl_setopt_array($curl, array(
                CURLOPT_URL => $thumb_url,
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
                    "Referer: https://desygner.com/",
					"User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/85.0.4183.121 Safari/537.36"
                ),
            ));
            curl_exec($curl);
            curl_close($curl);
            fclose($fp);
        }
	}

    function getFormats(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://static.inkive.com/api/brand/companies/desygner/formats_consume?8",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Accept: application/json, text/javascript, */*; q=0.01",
            "Referer: https://desygner.com/",
            "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.67 Safari/537.36"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }
    
    function getStickersGallery(){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://desygner.com/api/search/stickers?from=130&limit=10&where%255Bcategory%255D=&where%255Bactive%255D=1",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Connection: keep-alive",
            "Accept: */*",
            "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.67 Safari/537.36",
            "X-Requested-With: XMLHttpRequest",
            "Sec-Fetch-Site: same-origin",
            "Sec-Fetch-Mode: cors",
            "Sec-Fetch-Dest: empty",
            "Referer: https://desygner.com/editor/?id=Y4bprOJntG1",
            "Accept-Language: es",
            "Cookie: ci_session=7n33lmsvbm65i142q2oku4nufhfl9i5a; G_ENABLED_IDPS=google; wordpress_geo_redirect_once=1; _ga=GA1.2.397906811.1606433375; _gid=GA1.2.1780324602.1606433375; _fbp=fb.1.1606433375702.211882517; _omappvp=GXCk9SSuzKNBsghRIs6OKkjslfOvNS82J3RiDblMy5rhyV5hVK4bFHKNzjbeNEeegzykF2MSAZQeLMcYL5MfQGa60Jm1gpFF; gclid=undefined; device_view=full; _lo_uid=211961-1606433450601-dd35ce10fc7a38ad; __lotl=https%3A%2F%2Fdesygner.com%2Fpricing%2F; __stripe_mid=5e4de21e-c2e8-401b-9f87-049f8a96da6eb123e6; _lo_v=4; AWSELB=4905FD431AF6323D21C9A546BB83770FF80B5D4E76384285831435805119CC7A57EF9E45EE6885407E6F4AD288B93D00906A1FDC009E0619CAF693FE568924AC9C95A43ED4; AWSELBCORS=4905FD431AF6323D21C9A546BB83770FF80B5D4E76384285831435805119CC7A57EF9E45EE6885407E6F4AD288B93D00906A1FDC009E0619CAF693FE568924AC9C95A43ED4; referer=https%3A%2F%2Fdesygner.com%2Fcreate%2F; user_hash=a87443fba6bbb71dcd051d77e2f45fdc; user_token=4d3898304be3ff6dc280209ed6ee174fa4f88fbe3e65d709128d237bf7bc5924; locale=en; PHPSESSID=rbst4n1f5foosfa88k7o3qsbl8; __stripe_sid=38c3b927-f099-4d05-b113-1a19832ac5a72aabe3; ci_session=9hcdc7ake2mk95mfkbhah3mf5skdf0bf; locale=en_us; AWSELB=4905FD431AF6323D21C9A546BB83770FF80B5D4E76210C517AADE111F1BF5AB0614D13D5B86885407E6F4AD288B93D00906A1FDC009E0619CAF693FE568924AC9C95A43ED4; AWSELBCORS=4905FD431AF6323D21C9A546BB83770FF80B5D4E76210C517AADE111F1BF5AB0614D13D5B86885407E6F4AD288B93D00906A1FDC009E0619CAF693FE568924AC9C95A43ED4"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }

    function getStickerSVG(){
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://desygner.com/api/search/sticker?id=2832",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Connection: keep-alive",
            "Accept: */*",
            "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.67 Safari/537.36",
            "X-Requested-With: XMLHttpRequest",
            "Sec-Fetch-Site: same-origin",
            "Sec-Fetch-Mode: cors",
            "Sec-Fetch-Dest: empty",
            "Referer: https://desygner.com/editor/?id=Y4bprOJntG1",
            "Accept-Language: es",
            "Cookie: ci_session=7n33lmsvbm65i142q2oku4nufhfl9i5a; G_ENABLED_IDPS=google; wordpress_geo_redirect_once=1; _ga=GA1.2.397906811.1606433375; _gid=GA1.2.1780324602.1606433375; _fbp=fb.1.1606433375702.211882517; _omappvp=GXCk9SSuzKNBsghRIs6OKkjslfOvNS82J3RiDblMy5rhyV5hVK4bFHKNzjbeNEeegzykF2MSAZQeLMcYL5MfQGa60Jm1gpFF; gclid=undefined; device_view=full; _lo_uid=211961-1606433450601-dd35ce10fc7a38ad; __lotl=https%3A%2F%2Fdesygner.com%2Fpricing%2F; __stripe_mid=5e4de21e-c2e8-401b-9f87-049f8a96da6eb123e6; _lo_v=4; AWSELB=4905FD431AF6323D21C9A546BB83770FF80B5D4E76384285831435805119CC7A57EF9E45EE6885407E6F4AD288B93D00906A1FDC009E0619CAF693FE568924AC9C95A43ED4; AWSELBCORS=4905FD431AF6323D21C9A546BB83770FF80B5D4E76384285831435805119CC7A57EF9E45EE6885407E6F4AD288B93D00906A1FDC009E0619CAF693FE568924AC9C95A43ED4; referer=https%3A%2F%2Fdesygner.com%2Fcreate%2F; user_hash=a87443fba6bbb71dcd051d77e2f45fdc; user_token=4d3898304be3ff6dc280209ed6ee174fa4f88fbe3e65d709128d237bf7bc5924; locale=en; PHPSESSID=rbst4n1f5foosfa88k7o3qsbl8; __stripe_sid=38c3b927-f099-4d05-b113-1a19832ac5a72aabe3; locale=en_us; AWSELB=4905FD431AF6323D21C9A546BB83770FF80B5D4E76210C517AADE111F1BF5AB0614D13D5B86885407E6F4AD288B93D00906A1FDC009E0619CAF693FE568924AC9C95A43ED4; AWSELBCORS=4905FD431AF6323D21C9A546BB83770FF80B5D4E76210C517AADE111F1BF5AB0614D13D5B86885407E6F4AD288B93D00906A1FDC009E0619CAF693FE568924AC9C95A43ED4; ci_session=7n33lmsvbm65i142q2oku4nufhfl9i5a"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }

    function getStockBackgroundIMGs(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://desygner.com/api/search/backgrounds?from=80&limit=10&where%255Bcategory%255D=",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Connection: keep-alive",
            "Accept: */*",
            "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.67 Safari/537.36",
            "X-Requested-With: XMLHttpRequest",
            "Sec-Fetch-Site: same-origin",
            "Sec-Fetch-Mode: cors",
            "Sec-Fetch-Dest: empty",
            "Referer: https://desygner.com/editor/?id=Y4bprOJntG1",
            "Accept-Language: es",
            "Cookie: ci_session=7n33lmsvbm65i142q2oku4nufhfl9i5a; G_ENABLED_IDPS=google; wordpress_geo_redirect_once=1; _ga=GA1.2.397906811.1606433375; _gid=GA1.2.1780324602.1606433375; _fbp=fb.1.1606433375702.211882517; _omappvp=GXCk9SSuzKNBsghRIs6OKkjslfOvNS82J3RiDblMy5rhyV5hVK4bFHKNzjbeNEeegzykF2MSAZQeLMcYL5MfQGa60Jm1gpFF; gclid=undefined; device_view=full; _lo_uid=211961-1606433450601-dd35ce10fc7a38ad; __lotl=https%3A%2F%2Fdesygner.com%2Fpricing%2F; __stripe_mid=5e4de21e-c2e8-401b-9f87-049f8a96da6eb123e6; _lo_v=4; AWSELB=4905FD431AF6323D21C9A546BB83770FF80B5D4E76384285831435805119CC7A57EF9E45EE6885407E6F4AD288B93D00906A1FDC009E0619CAF693FE568924AC9C95A43ED4; AWSELBCORS=4905FD431AF6323D21C9A546BB83770FF80B5D4E76384285831435805119CC7A57EF9E45EE6885407E6F4AD288B93D00906A1FDC009E0619CAF693FE568924AC9C95A43ED4; referer=https%3A%2F%2Fdesygner.com%2Fcreate%2F; user_hash=a87443fba6bbb71dcd051d77e2f45fdc; user_token=4d3898304be3ff6dc280209ed6ee174fa4f88fbe3e65d709128d237bf7bc5924; locale=en; PHPSESSID=rbst4n1f5foosfa88k7o3qsbl8; _BEAMER_USER_ID_ffOZPJWv22943=fc56aec9-1d50-4a6d-8e9b-7d3378b75b91; _BEAMER_FIRST_VISIT_ffOZPJWv22943=2020-11-27T04:09:06.168Z; _BEAMER_BOOSTED_ANNOUNCEMENT_DATE_ffOZPJWv22943=2020-11-27T04:09:07.905Z; _BEAMER_LAST_PUSH_PROMPT_INTERACTION_ffOZPJWv22943=1606450151262; cookie_notice_accepted=true; locale=en_us; AWSELB=4905FD431AF6323D21C9A546BB83770FF80B5D4E76210C517AADE111F1BF5AB0614D13D5B86885407E6F4AD288B93D00906A1FDC009E0619CAF693FE568924AC9C95A43ED4; AWSELBCORS=4905FD431AF6323D21C9A546BB83770FF80B5D4E76210C517AADE111F1BF5AB0614D13D5B86885407E6F4AD288B93D00906A1FDC009E0619CAF693FE568924AC9C95A43ED4; ci_session=7n33lmsvbm65i142q2oku4nufhfl9i5a"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }

    function getTemplateResults($first, $limit){
        // MAX first=3760
        // jYB8RHAUBha
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://webrand.com/api/brand/companies/desygner/templates?public&first=$first&limit=$limit",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Connection: keep-alive",
                "Accept: application/json, text/javascript, */*; q=0.01",
                "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.67 Safari/537.36",
                "Origin: https://desygner.com",
                "Sec-Fetch-Site: cross-site",
                "Sec-Fetch-Mode: cors",
                "Sec-Fetch-Dest: empty",
                "Referer: https://desygner.com/",
                "Accept-Language: es",
                "Cookie: PHPSESSID=prpl8d4s7pvp2uqlcki18hf8uk; device_view=full; AWSELB=B94BED5A292C85256A27FF379D37287055424A758AF54F8DD2944117A8299BC69F5FF59FCC2E1C330773FD827CFDF51ACC1D61168AED001314982AB3B17217B03849FFA6; AWSELBCORS=B94BED5A292C85256A27FF379D37287055424A758AF54F8DD2944117A8299BC69F5FF59FCC2E1C330773FD827CFDF51ACC1D61168AED001314982AB3B17217B03849FFA6"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;

        Redis::set('desygner:search:results:'.$first, $response);

    }

    function getTemplate($template_id){
        if( Redis::exists('desygner:template:'.$template_id) == false ){
            $curl = curl_init();
            
            curl_setopt_array($curl, array(
              CURLOPT_URL => "https://desygner.com/api/page/by_pagenumber?isMobile=0&page=1&scrapbook_id=$template_id",
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => "",
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => "GET",
              CURLOPT_HTTPHEADER => array(
                "Connection: keep-alive",
                "Accept: */*",
                "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.67 Safari/537.36",
                "X-Requested-With: XMLHttpRequest",
                "Sec-Fetch-Site: same-origin",
                "Sec-Fetch-Mode: cors",
                "Sec-Fetch-Dest: empty",
                "Referer: https://desygner.com/editor/?id=$template_id",
                "Accept-Language: es",
                "Cookie: locale=en_us; AWSELB=4905FD431AF6323D21C9A546BB83770FF80B5D4E76210C517AADE111F1BF5AB0614D13D5B86885407E6F4AD288B93D00906A1FDC009E0619CAF693FE568924AC9C95A43ED4; AWSELBCORS=4905FD431AF6323D21C9A546BB83770FF80B5D4E76210C517AADE111F1BF5AB0614D13D5B86885407E6F4AD288B93D00906A1FDC009E0619CAF693FE568924AC9C95A43ED4; ci_session=7n33lmsvbm65i142q2oku4nufhfl9i5a"
              ),
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
            // echo $response;        
            Redis::set('desygner:template:'.$template_id, $response);
        }
    }
}
