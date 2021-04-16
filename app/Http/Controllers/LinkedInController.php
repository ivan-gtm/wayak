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


class LinkedInController extends Controller
{
	function index(){
        $redis_packt = Redis::connection('redisuat');
        
        $pages = $redis_packt->keys('linked:search:technology:*');
        echo "<pre>";
        foreach ($pages as $page_keyname) {
            $elements = json_decode( $redis_packt->get($page_keyname) );
            $elements = $elements->elements;
            // print_r( $elements );
            foreach ($elements as $course) {
                // print_r( $course->urn."\n" );
                $course_id = str_replace('urn:li:lyndaCourse:',null, $course->urn);
                // print_r( $urn."\n" );
                $course_metadata = self::getCourseContent($course_id);
                
                // print_r( $course->headline->title->text );
                // exit;
                $course_title = $course->headline->title->text;
                foreach ($course_metadata->chapters as $key => $chapter) {
                    $course_chapter_title = ($key == 0) ? $key.". ".$chapter->title : $chapter->title;
                    
                    foreach ($chapter->videos as $video_index => $video) {
                        $urn = str_replace('urn:li:lyndaVideo:(urn:li:lyndaCourse:', null, $video->urn);
                        $urn = str_replace(')', null, $urn);
                        // print_r( explode(',',$urn) );
                        // exit;
                        $url_arguments = explode(',',$urn);
                        $course_id = $url_arguments[0];
                        $video_id = $url_arguments[1];
                        $video_info = self::getVideoContent($course_id, $video_id);
                        
                        // print_r( $video_info->url );
                        // print_r( $video_info->title );
                        // print_r( $video_info->audio );

                        // print_r($video_info);
                        $course_title = str_replace(':',' -',$course_title);
                        
                        $course_chapter_title = str_replace(':',' -',$course_chapter_title);

                        $video_info_title = str_replace('/',' -',$video_info->title);
                        $video_info_title = str_replace(':',' -',$video_info->title);

                        $local_img_path = public_path( "linkedin/$course_title/$course_chapter_title/".($video_index+1).". ".$video_info_title.".mp4" );
                        
                        print_r( $local_img_path );
                        print_r( "\n" );

                        self::downloadFile($local_img_path, $video_info->url->progressiveUrl );
                        // exit;
                    }
                }
                // exit;
            }
            // exit;
        }
        // print_r($redis_packt->keys('linked:search:technology:*'));
        exit;
        $topics = [
            "technology",
            "leadership-and-management",
            "business-strategy",
            "coaching-and-mentoring",
            "communication",
            "crisis-management",
            "decision-making",
            "diversity-and-inclusion",
            "executive-leadership",
            "leadership-skills",
            "management-skills",
            "meeting-skills",
            "nonprofit-management",
            "organizational-leadership",
            "talent-management",
            "teams-and-collaboration",
            "marketing-2",
            "advertising-and-promotion",
            "b2b-marketing",
            "b2c-marketing",
            "brand-management",
            "content-marketing",
            "conversion-marketing",
            "crisis-management",
            "email-marketing",
            "enterprise-marketing",
            "event-planning",
            "lead-generation",
            "marketing-automation",
            "marketing-strategy",
            "mobile-marketing",
            "pay-per-click-marketing",
            "personal-branding",
            "public-relations",
            "search-engine-marketing-sem",
            "search-engine-optimization-seo",
            "small-business-marketing",
            "cloud-computing-5",
            "data-science",
            "database-management",
            "devops",
            "it-help-desk-5",
            "mobile-development",
            "network-and-system-administration",
            "security-3",
            "software-development",
            "web-development",
            "back-end-web-development",
            "content-management-systems-cms",
            "e-commerce-development",
            "front-end-web-development",
            "full-stack-web-development",
            "javascript-frameworks",
            "web-development-tools",
            "web-development",
            "software-development",
            "apis",
            "database-development",
            "design-patterns-3",
            "enterprise-architecture",
            "game-development",
            "internet-of-things",
            "microsoft-development",
            "object-oriented-programming",
            "programming-foundations-3",
            "programming-languages",
            "software-architecture",
            "software-design-patterns",
            "software-development-tools",
            "software-quality-assurance",
            "software-testing",
            "version-control",
            "ios-development",
            "design-thinking",
            "database-management",
            "graphic-design",
            "professional-development",
            "allyship",
            "anti-racism",
            "communication",
            "creativity-3",
            "decision-making",
            "diversity-and-inclusion",
            "meeting-skills",
            "personal-effectiveness",
            "public-speaking",
            "remote-work",
            "teams-and-collaboration",
            "time-management-3",
            "writing-7",
            "cloud-computing-5"
        ];
        foreach ($topics as $topic) {
            $total_pages = 10;
            for ($i=0; $i < $total_pages; $i++) { 
                $start = $i * 30;
                $total_pages = ceil( self::getPaginationSearchResults($topic, $i, $start ) / 30 );
                echo "PARSING PAGE >>".$i."\n";
                echo "START >>".$start."\n";
                echo $total_pages."\n";
                // exit;
            }
        }
    }

    function downloadFile( $local_img_path, $img_url ){
        
        if( file_exists( $local_img_path ) == false ){
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
        
    }

    function getPaginationSearchResults( $topic, $page, $start ){

        $redis_packt = Redis::connection('redisuat');

        if( $redis_packt->exists('linked:search:'.$topic.':page:'.$page) == false){

            $curl = curl_init();
    
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.linkedin.com/learning-api/searchV2?categorySlugs=List(technology)&count=30&facets=List(entityType%3DCOURSE)&q=categorySlugs&searchRequestId=79AA16B3-3C1D-413F-8604-ED0AE97C2815&sortBy=RELEVANCE&start=$start",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Host: www.linkedin.com",
                "Cookie: lidc=\"b=OB86:s=O:r=O:a=O:p=O:g=2207:u=116:i=1616600140:t=1616642566:v=2:sig=AQG27Ek6NFXfpUnS36hqVb29K6dO0AMi\"; liap=true; JSESSIONID=\"ajax:6499628040475905733\"; li_at=AQEDATHLMsIBXEAgAAABdSCQLSgAAAF4gPGKp04ArkXxNCNdP_X5U8hqIqzxYPkg1Qgnd6snabSWfyymkFOdL7IYmzu7rcGVO_r6xM8qQfxlyyDRUI8V7oQlWkZRGe38qahJMdsGTEf6WTh4Ac2Cd5wu; _ga=GA1.2.1918500438.1585652850; bcookie=\"v=2&57a73298-0e9e-4672-89bb-c60d09f9edc4\"; lissc=1; bscookie=\"v=1&20200331110722cdbdfd5e-7b0a-4fbb-82f8-be00421a8a65AQEeyk8jA-H7CZlN4vDiIk1UOBw3sgi5\"; lang=v=2&lang=en-US; bcookie=\"v=2&b6d07127-7214-46f4-8b27-a6a3171f60b1\"; lidc=\"b=VGST02:s=V:r=V:a=V:p=V:g=2299:u=1:i=1616602118:t=1616688518:v=2:sig=AQFFQu-__KnG4tDwFuTv9IynR0RPkTnL\"",
                "accept: */*",
                "csrf-token: ajax:6499628040475905733",
                "x-li-lang: en-US",
                "accept-language: en-us",
                "x-restli-protocol-version: 2.0.0",
                "preferredwidth: 100",
                "x-lil-intl-library: en_US",
                "user-agent: Learning/1.26.0 CFNetwork/1220.1 Darwin/20.3.0",
                "x-li-track: {\"osName\":\"iOS\",\"clientVersion\":\"1.26.0\",\"timezoneOffset\":-6,\"osVersion\":\"14.4.1\",\"displayHeight\":1792,\"deviceType\":\"iphone\",\"appId\":\"com.linkedin.Learning\",\"locale\":\"en_MX\",\"displayWidth\":828,\"clientMinorVersion\":\"1.26\",\"displayDensity\":2,\"language\":\"en-MX\",\"deviceId\":\"CA253871-BB27-4549-AE48-3B54D92FFD89\",\"model\":\"iphone12_1\",\"mpName\":\"learning-ios\",\"mpVersion\":\"1.26.0\"}"
            ),
            ));
    
            $response = curl_exec($curl);
    
            curl_close($curl);
            
            // print_r("https://www.linkedin.com/learning-api/searchV2?categorySlugs=List(technology)&count=30&facets=List(entityType%3DCOURSE)&q=categorySlugs&searchRequestId=79AA16B3-3C1D-413F-8604-ED0AE97C2815&sortBy=RELEVANCE&start=$start");
            // echo "<pre>";
            // print_r( json_decode($response) ) ;
            $object = json_decode($response);
            
            if( isset( $object->paging->total ) ){
                $redis_packt->set('linked:search:'.$topic.':page:'.$page, $response);
                return $object->paging->total;
            }

        } else {
            $object = json_decode( $redis_packt->get('linked:search:'.$topic.':page:'.$page) );
            return $object->paging->total;
        }

        return 0;
    }

    function getCourseContent($course_id){
        $redis_packt = Redis::connection('redisuat');

        if( $redis_packt->exists('linked:course:'.$course_id) == false){

            $curl = curl_init();
    
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.linkedin.com/learning-api/detailedCourses/$course_id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Host: www.linkedin.com",
                "Cookie: lidc=\"b=OB86:s=O:r=O:a=O:p=O:g=2207:u=116:i=1616600140:t=1616642566:v=2:sig=AQG27Ek6NFXfpUnS36hqVb29K6dO0AMi\"; liap=true; JSESSIONID=\"ajax:6499628040475905733\"; li_at=AQEDATHLMsIBXEAgAAABdSCQLSgAAAF4gPGKp04ArkXxNCNdP_X5U8hqIqzxYPkg1Qgnd6snabSWfyymkFOdL7IYmzu7rcGVO_r6xM8qQfxlyyDRUI8V7oQlWkZRGe38qahJMdsGTEf6WTh4Ac2Cd5wu; _ga=GA1.2.1918500438.1585652850; bcookie=\"v=2&57a73298-0e9e-4672-89bb-c60d09f9edc4\"; lissc=1; bscookie=\"v=1&20200331110722cdbdfd5e-7b0a-4fbb-82f8-be00421a8a65AQEeyk8jA-H7CZlN4vDiIk1UOBw3sgi5\"; lang=v=2&lang=en-US; bcookie=\"v=2&b6d07127-7214-46f4-8b27-a6a3171f60b1\"; lidc=\"b=OB86:s=O:r=O:a=O:p=O:g=2207:u=116:i=1616602852:t=1616642566:v=2:sig=AQFOqabAD9mj0rQPNpjicrvDlKY_lEq0\"",
                "accept: */*",
                "csrf-token: ajax:6499628040475905733",
                "x-li-lang: en-US",
                "accept-language: en-us",
                "x-restli-protocol-version: 2.0.0",
                "preferredwidth: 100",
                "x-lil-intl-library: en_US",
                "user-agent: Learning/1.26.0 CFNetwork/1220.1 Darwin/20.3.0",
                "x-li-track: {\"osName\":\"iOS\",\"clientVersion\":\"1.26.0\",\"timezoneOffset\":-6,\"osVersion\":\"14.4.1\",\"displayHeight\":1792,\"deviceType\":\"iphone\",\"appId\":\"com.linkedin.Learning\",\"locale\":\"en_MX\",\"displayWidth\":828,\"clientMinorVersion\":\"1.26\",\"displayDensity\":2,\"language\":\"en-MX\",\"deviceId\":\"CA253871-BB27-4549-AE48-3B54D92FFD89\",\"model\":\"iphone12_1\",\"mpName\":\"learning-ios\",\"mpVersion\":\"1.26.0\"}"
            ),
            ));
    
            $response = curl_exec($curl);
    
            curl_close($curl);
            
            $object = json_decode($response);
            
            // print_r($object);
            // exit;

            if( isset( $object->durationInSeconds ) ){
                $redis_packt->set('linked:course:'.$course_id, $response);
                return $object;
            }
            

        } else {
            $object = json_decode( $redis_packt->get('linked:course:'.$course_id) );
            // exit;
            return $object;
            // return $object->paging->total;
        }
    }

    function getVideoContent($course_id, $video_id){
        $redis_packt = Redis::connection('redisuat');

        if( $redis_packt->exists('linked:video:'.$course_id.':'.$video_id) == false){

            $curl = curl_init();
    
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.linkedin.com/learning-api/detailedCourses/$course_id/detailedVideos/$video_id",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Host: www.linkedin.com",
                "Cookie: lidc=\"b=OB86:s=O:r=O:a=O:p=O:g=2207:u=116:i=1616600140:t=1616642566:v=2:sig=AQG27Ek6NFXfpUnS36hqVb29K6dO0AMi\"; liap=true; JSESSIONID=\"ajax:6499628040475905733\"; li_at=AQEDATHLMsIBXEAgAAABdSCQLSgAAAF4gPGKp04ArkXxNCNdP_X5U8hqIqzxYPkg1Qgnd6snabSWfyymkFOdL7IYmzu7rcGVO_r6xM8qQfxlyyDRUI8V7oQlWkZRGe38qahJMdsGTEf6WTh4Ac2Cd5wu; _ga=GA1.2.1918500438.1585652850; bcookie=\"v=2&57a73298-0e9e-4672-89bb-c60d09f9edc4\"; lissc=1; bscookie=\"v=1&20200331110722cdbdfd5e-7b0a-4fbb-82f8-be00421a8a65AQEeyk8jA-H7CZlN4vDiIk1UOBw3sgi5\"; lang=v=2&lang=en-US; bcookie=\"v=2&b6d07127-7214-46f4-8b27-a6a3171f60b1\"; lidc=\"b=OB86:s=O:r=O:a=O:p=O:g=2207:u=116:i=1616602852:t=1616642566:v=2:sig=AQFOqabAD9mj0rQPNpjicrvDlKY_lEq0\"",
                "accept: */*",
                "csrf-token: ajax:6499628040475905733",
                "x-li-lang: en-US",
                "accept-language: en-us",
                "x-restli-protocol-version: 2.0.0",
                "preferredwidth: 100",
                "x-lil-intl-library: en_US",
                "user-agent: Learning/1.26.0 CFNetwork/1220.1 Darwin/20.3.0",
                "x-li-track: {\"osName\":\"iOS\",\"clientVersion\":\"1.26.0\",\"timezoneOffset\":-6,\"osVersion\":\"14.4.1\",\"displayHeight\":1792,\"deviceType\":\"iphone\",\"appId\":\"com.linkedin.Learning\",\"locale\":\"en_MX\",\"displayWidth\":828,\"clientMinorVersion\":\"1.26\",\"displayDensity\":2,\"language\":\"en-MX\",\"deviceId\":\"CA253871-BB27-4549-AE48-3B54D92FFD89\",\"model\":\"iphone12_1\",\"mpName\":\"learning-ios\",\"mpVersion\":\"1.26.0\"}"
            ),
            ));
    
            $response = curl_exec($curl);
    
            curl_close($curl);

            $object = json_decode($response);
            
            if( isset( $object->formats ) ){
                $redis_packt->set( 'linked:video:'.$course_id.':'.$video_id, $response);
                return $object;
            }
            
            // ('linked:video:'.$course_id.':'.$video_id)
            // print_r(json_decode($response));
        } else {
            $object = json_decode($redis_packt->get( 'linked:video:'.$course_id.':'.$video_id));
            return $object;
        }
    }
}
