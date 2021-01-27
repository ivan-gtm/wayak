<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

ini_set("max_execution_time", 0);   // no time-outs!
ini_set("request_terminate_timeout", 2000);   // no time-outs!
ini_set('memory_limit', -1);
ini_set('display_errors', 1);

ignore_user_abort(true);            // Continue downloading even after user closes the browser.
error_reporting(E_ALL);


class PlaceitController extends Controller
{
    private $category_ids = [];

    /**
     * Show the application dashboard.
     */
    public function index(Request $request)
    {
        // echo "<pre>";
        // $products = Redis::keys('placeit*');
        // foreach ($products as $product_key_name) {
        //     Redis::rename($product_key_name, $product_key_name.':metadata');
        //     // print_r( $product_key_name );
        // }
        // exit;
        // echo "<pre>";
        // $placeit_categories = [];
        // $placeit_categories['urls'] = [
        //     [
        //         'title' => "Instagram Post Templates",
        //         'url' => "instagram-post-templates"
        //     ],
        //     [
        //         'title' => "Instagram Story Maker",
        //         'url' => "instagram-story-templates"
        //     ],
        //     [
        //         'title' => "Instagram Story Video Maker",
        //         'url' => "instagram-story-video-template"
        //     ],
        //     [
        //         'title' => "Facebook Cover Maker",
        //         'url' => "facebook-cover-photo-maker"
        //     ],
        //     [
        //         'title' => "Facebook Post Maker",
        //         'url' => "facebook-post-template"
        //     ],
        //     [
        //         'title' => "Facebook Cover Video Maker",
        //         'url' => "facebook-cover-video-maker"
        //     ],
        //     [
        //         'title' => "YouTube Thumbnails",
        //         'url' => "gaming-templates?f_devices=YouTube%20Thumbnail%20Maker"
        //     ],
        //     [
        //         'title' => "YouTube Banners",
        //         'url' => "gaming-templates?f_devices=YouTube%20Banner%20Maker"
        //     ],
        //     [
        //         'title' => "YouTube End Cards",
        //         'url' => "gaming-templates?f_devices=YouTube%20End%20Card"
        //     ],
        //     [
        //         'title' => "YouTube Video Templates",
        //         'url' => "youtube-video-templates"
        //     ],
        //     [
        //         'title' => "YouTube Channel Art Templates",
        //         'url' => "youtube-templates"
        //     ],
        //     [
        //         'title' => "Free Mockups",
        //         'url' => "free-templates"
        //     ],
        //     [
        //         'title' => "Android Mockups",
        //         'url' => "android-mockup-generator"
        //     ],
        //     [
        //         'title' => "App Store Screenshots",
        //         'url' => "app-store-screenshot-generator"
        //     ],
        //     [
        //         'title' => "Book Mockups",
        //         'url' => "book-mockup-generator"
        //     ],
        //     // [
        //     //     'title' => "Free Image Cropper",
        //     //     'url' => "image-cropper"
        //     // ],
        //     [
        //         'title' => "Hat Mockups",
        //         'url' => "hat-mockup-generator"
        //     ],
        //     [
        //         'title' => "Hoodie Mockups",
        //         'url' => "hoodie-mockup-templates"
        //     ],
        //     [
        //         'title' => "iMac Mockups",
        //         'url' => "imac-mockup-generator"
        //     ],
        //     [
        //         'title' => "iPad Mockups",
        //         'url' => "ipad-mockup-generator"
        //     ],
        //     [
        //         'title' => "iPhone Mockups",
        //         'url' => "iphone-mockup-generator"
        //     ],
        //     [
        //         'title' => "Long Sleeve Shirts",
        //         'url' => "long-sleeve-shirt-mockup"
        //     ],
        //     [
        //         'title' => "MacBook Mockups",
        //         'url' => "macbook-mockup-generator"
        //     ],
        //     [
        //         'title' => "Mug Mockups",
        //         'url' => "coffee-mug-mockup-generator"
        //     ],
        //     [
        //         'title' => "Musician Mockups",
        //         'url' => "musician-templates"
        //     ],
        //     [
        //         'title' => "Onesie Mockups",
        //         'url' => "baby-onesie-mockup"
        //     ],
        //     [
        //         'title' => "Responsive Mockups",
        //         'url' => "responsive-mockup-generator"
        //     ],
        //     [
        //         'title' => "T-Shirt Mockups ",
        //         'url' => "tshirt-mockup-generator"
        //     ],
        //     [
        //         'title' => "Tank Top Mockups",
        //         'url' => "tank-top-mockup-generator"
        //     ],
        //     [
        //         'title' => "Tote Bag Mockups",
        //         'url' => "tote-bag-mockup-generator"
        //     ],
        //     [
        //         'title' => "Transparent Mockups",
        //         'url' => "transparent-mockup-generator"
        //     ],
        //     [
        //         'title' => "Free Design Templates",
        //         'url' => "free-templates"
        //     ],
        //     [
        //         'title' => "Album Cover Maker",
        //         'url' => "album-cover-templates"
        //     ],
        //     [
        //         'title' => "Banner Ad Maker",
        //         'url' => "online-banner-maker"
        //     ],
        //     [
        //         'title' => "Beauty Design Templates",
        //         'url' => "beauty-templates"
        //     ],
        //     [
        //         'title' => "Birthday Design Templates",
        //         'url' => "birthday-templates"
        //     ],
        //     [
        //         'title' => "Book Cover Maker",
        //         'url' => "book-cover-designs"
        //     ],
        //     [
        //         'title' => "Business Card Maker",
        //         'url' => "online-business-card-maker"
        //     ],
        //     [
        //         'title' => "Cannabis Design Templates",
        //         'url' => "cannabis-templates"
        //     ],
        //     [
        //         'title' => "Flyer Maker",
        //         'url' => "flyer-templates"
        //     ],
        //     // [
        //     //     'title' => "Free Image Resizer",
        //     //     'url' => "image-cropper"
        //     // ],
        //     [
        //         'title' => "Musician Designs",
        //         'url' => "musician-templates"
        //     ],
        //     [
        //         'title' => "Pinterest Templates",
        //         'url' => "pinterest-pin-maker"
        //     ],
        //     [
        //         'title' => "Podcast Cover Maker",
        //         'url' => "podcast-cover-templates"
        //     ],
        //     [
        //         'title' => "Poster Templates",
        //         'url' => "poster-templates?sortby=newest"
        //     ],
        //     [
        //         'title' => "T-Shirt Design Maker",
        //         'url' => "t-shirt-design-templates"
        //     ],
        //     [
        //         'title' => "T-Shirt Label Maker",
        //         'url' => "t-shirt-label-design"
        //     ],
        //     [
        //         'title' => "Twitch Templates",
        //         'url' => "twitch-templates"
        //     ],
        //     [
        //         'title' => "Twitch Banners",
        //         'url' => "gaming-templates?f_devices=Twitch%20Banner%20Maker"
        //     ],
        //     [
        //         'title' => "Twitch Overlays",
        //         'url' => "gaming-templates?f_devices=Twitch%20Overlay%20Maker"
        //     ],
        //     [
        //         'title' => "Twitch Panels",
        //         'url' => "gaming-templates?f_devices=Twitch%20Panel%20Maker"
        //     ],
        //     [
        //         'title' => "Twitter Header Maker",
        //         'url' => "twitter-header-template"
        //     ],
        //     [
        //         'title' => "Twitter Post Templates",
        //         'url' => "twitter-post-template"
        //     ],
        //     [
        //         'title' => "Wellness Design Templates",
        //         'url' => "wellness-templates"
        //     ],
        //     [
        //         'title' => "Free Logos",
        //         'url' => "free-templates?f_devices=Logo%20Maker"
        //     ],
        //     [
        //         'title' => "Animated Logos",
        //         'url' => "animated-logos"
        //     ],
        //     // [
        //     //     'title' => "Free Image Cropper",
        //     //     'url' => "image-cropper"
        //     // ],
        //     [
        //         'title' => "Music Logo Maker",
        //         'url' => "hip-hop-templates?f_devices=Logo%20Maker"
        //     ],
        //     [
        //         'title' => "Musican Logos",
        //         'url' => "musician-templates?f_devices=Logo%20Maker"
        //     ],
        //     [
        //         'title' => "Video Maker",
        //         'url' => "video-maker"
        //     ],
        //     [
        //         'title' => "Animated Logos",
        //         'url' => "animated-logos"
        //     ],
        //     [
        //         'title' => "Animated Logos",
        //         'url' => "gaming-templates?f_devices=Animated%20Logo"
        //     ],
        //     [
        //         'title' => "Video Cropper",
        //         'url' => "video-cropper"
        //     ],
        //     [
        //         'title' => "Intro Maker",
        //         'url' => "video-intro-maker"
        //     ],
        //     [
        //         'title' => "Promo Video Maker",
        //         'url' => "promo-video-templates"
        //     ],
        //     [
        //         'title' => "Slideshow Video Maker",
        //         'url' => "video-slideshow-maker"
        //     ],
        //     [
        //         'title' => "Stream Starting Soon Template",
        //         'url' => "stream-starting-soon-templates"
        //     ],
        //     [
        //         'title' => "Video to Gif Converter",
        //         'url' => "video-to-gif-converter"
        //     ],
        //     [
        //         'title' => "Gaming",
        //         'url' => "gaming-templates"
        //     ],
        //     [
        //         'title' => "Free Gaming Templates",
        //         'url' => "gaming-templates?sortby=free"
        //     ],
        //     // [
        //     //     'title' => "Free Image Cropper",
        //     //     'url' => "image-cropper"
        //     // ],
        //     [
        //         'title' => "Free Online Video Cropper",
        //         'url' => "video-cropper"
        //     ],
        //     [
        //         'title' => "Gaming Video Intros",
        //         'url' => "gaming-templates?f_devices=Intro%20Maker"
        //     ],
        //     [
        //         'title' => "Mockup Generator",
        //         'url' => "c/mockups"
        //     ],
        //     [
        //         'title' => "Online Design Maker",
        //         'url' => "c/design-templates"
        //     ],
        //     [
        //         'title' => "Video to Gif Converter",
        //         'url' => "video-to-gif-converter"
        //     ],
        //     [
        //         'title' => "Facebook Ad Templates",
        //         'url' => "facebook-ad-mockups"
        //     ],
        //     [
        //         'title' => "Sportswear Mockups",
        //         'url' => "sportswear-mockups"
        //     ],
        //     [
        //         'title' => "App Video Mockups",
        //         'url' => "app-video-mockups"
        //     ],
        //     [
        //         'title' => "Apparel Mockups",
        //         'url' => "apparel-mockups"
        //     ],
        //     [
        //         'title' => "T-Shirt Video Mockups",
        //         'url' => "t-shirt-video-mockups"
        //     ],
        //     [
        //         'title' => "Banner Mockups",
        //         'url' => "banner-mockups"
        //     ],
        //     [
        //         'title' => "Beanie Mockups",
        //         'url' => "beanie-mockups"
        //     ],
        //     [
        //         'title' => "Business Card Mockups",
        //         'url' => "business-card-mockups"
        //     ],
        //     [
        //         'title' => "Garment Only Mockups",
        //         'url' => "garment-only-mockups"
        //     ],
        //     [
        //         'title' => "Heather Mockups",
        //         'url' => "heather-mockups"
        //     ],
        //     [
        //         'title' => "Home Decor Mockups",
        //         'url' => "home-decor-mockups"
        //     ],
        //     [
        //         'title' => "Packaging Mockups",
        //         'url' => "packaging-mockups"
        //     ],
        //     [
        //         'title' => "Phone Case Mockups",
        //         'url' => "iphone-case-mockups"
        //     ],
        //     [
        //         'title' => "Phone Grip Mockups",
        //         'url' => "phone-grip-mockups"
        //     ],
        //     [
        //         'title' => "Polo Shirt Mockups",
        //         'url' => "polo-shirt-mockups"
        //     ],
        //     [
        //         'title' => "Stationery Mockups",
        //         'url' => "stationery-mockups"
        //     ],
        //     [
        //         'title' => "Sublimated Mockups",
        //         'url' => "sublimated-mockups"
        //     ],
        //     [
        //         'title' => "Sweatshirt Mockups",
        //         'url' => "sweatshirt-mockups"
        //     ],
        //     [
        //         'title' => "Travel Mug Mockups",
        //         'url' => "travel-mug-mockups"
        //     ],
        //     [
        //         'title' => "T-Shirt Video Mockups",
        //         'url' => "t-shirt-video-mockups"
        //     ],
        //     [
        //         'title' => "YouTube Profile Picture Maker",
        //         'url' => "logo-maker?industry=all&amp;industryId=YouTube"
        //     ],
        //     [
        //         'title' => "Logo Maker",
        //         'url' => "logo-maker"
        //     ],
        //     [
        //         'title' => "Abstract Logo Maker",
        //         'url' => "logo-maker?industry=Abstract&amp;industryId=Abstract"
        //     ],
        //     [
        //         'title' => "Architect Logo Maker",
        //         'url' => "logo-maker?industry=Architect&amp;industryId=Architect"
        //     ],
        //     [
        //         'title' => "Avatar Maker",
        //         'url' => "logo-maker?industry=Avatar Maker&amp;industryId=Avatar"
        //     ],
        //     [
        //         'title' => "Bakery Logo Maker",
        //         'url' => "logo-maker?industry=Bakery&amp;industryId=Bakery"
        //     ],
        //     [
        //         'title' => "Bar Logo Maker",
        //         'url' => "logo-maker?industry=Bar&amp;industryId=Bar"
        //     ],
        //     [
        //         'title' => "Beauty Logo Maker",
        //         'url' => "logo-maker?industry=Beauty&amp;industryId=Beauty"
        //     ],
        //     [
        //         'title' => "Catering Logo Maker",
        //         'url' => "logo-maker?industry=Catering&amp;industryId=Catering"
        //     ],
        //     [
        //         'title' => "Consulting Logo Maker",
        //         'url' => "logo-maker?industry=Consulting&amp;industryId=Consulting"
        //     ],
        //     [
        //         'title' => "Daycare Logo Maker",
        //         'url' => "logo-maker?industry=Daycare&amp;industryId=Daycare"
        //     ],
        //     [
        //         'title' => "Dental Logo Maker",
        //         'url' => "logo-maker?industry=Dental&amp;industryId=Dental"
        //     ],
        //     [
        //         'title' => "Designer Logo Maker",
        //         'url' => "logo-maker?industry=Design&amp;industryId=Design"
        //     ],
        //     [
        //         'title' => "Medical Logo Maker",
        //         'url' => "logo-maker?industry=Medical&amp;industryId=Medical"
        //     ],
        //     [
        //         'title' => "Financial Logo Maker",
        //         'url' => "logo-maker?industry=Finance&amp;industryId=Finance"
        //     ],
        //     [
        //         'title' => "Fitness Logo Maker",
        //         'url' => "logo-maker?industry=Fitness&amp;industryId=Fitness"
        //     ],
        //     [
        //         'title' => "Gaming Logo Maker",
        //         'url' => "logo-maker?industry=Gaming&amp;industryId=Gaming"
        //     ],
        //     [
        //         'title' => "Law Firm Logo Maker",
        //         'url' => "logo-maker?industry=Law&amp;industryId=Law"
        //     ],
        //     [
        //         'title' => "HVAC Logo Maker",
        //         'url' => "logo-maker?industry=HV_AC&amp;industryId=HV_AC"
        //     ],
        //     [
        //         'title' => "Automotive Logo Maker",
        //         'url' => "logo-maker?industry=Automotive&amp;industryId=Automotive"
        //     ],
        //     [
        //         'title' => "Painter Logo Maker",
        //         'url' => "logo-maker?industry=Painter&amp;industryId=Painter"
        //     ],
        //     [
        //         'title' => "Pet Store Logo Maker",
        //         'url' => "logo-maker?industry=Pets&amp;industryId=Pets"
        //     ],
        //     [
        //         'title' => "Sports Logo Maker",
        //         'url' => "logo-maker?industry=Sports Logos&amp;industryId=Sports"
        //     ],
        //     [
        //         'title' => "Education Logo Maker",
        //         'url' => "logo-maker?industry=Education&amp;industryId=Education"
        //     ],
        //     [
        //         'title' => "Travel Agency Logo Maker",
        //         'url' => "logo-maker?industry=Travel&amp;industryId=Travel"
        //     ],
        //     [
        //         'title' => "Wellness Logo Maker",
        //         'url' => "logo-maker?industry=Wellness&amp;industryId=Wellness"
        //     ],
        //     [
        //         'title' => "Publishing Logo Maker",
        //         'url' => "logo-maker?industry=Writer&amp;industryId=Writer"
        //     ],
        //     [
        //         'title' => "Gaming Logos",
        //         'url' => "logo-maker?industry=Gaming&amp;industryId=Gaming"
        //     ],
        //     [
        //         'title' => "Coffee Shop Logo Maker",
        //         'url' => "logo-maker?industry=Coffee Shop&amp;industryId=Coffee Shop"
        //     ],
        //     [
        //         'title' => "Electrician Logo Maker",
        //         'url' => "logo-maker?industry=Electrician&amp;industryId=Electrician"
        //     ],
        //     [
        //         'title' => "Landscaping Logo Maker",
        //         'url' => "logo-maker?industry=Landscaping&amp;industryId=Landscaping"
        //     ],
        //     [
        //         'title' => "Real Estate Logo Maker",
        //         'url' => "logo-maker?industry=Real Estate&amp;industryId=Real Estate"
        //     ],
        //     [
        //         'title' => "Restaurant Logo Maker",
        //         'url' => "logo-maker?industry=Restaurant&amp;industryId=Restaurant"
        //     ],
        //     [
        //         'title' => "Arts and Crafts Logo Maker",
        //         'url' => "logo-maker?industry=Arts and Crafts&amp;industryId=Arts and Crafts"
        //     ],
        //     [
        //         'title' => "Event Planner Logo Maker",
        //         'url' => "logo-maker?industry=Event Planner&amp;industryId=Event Planner"
        //     ],
        //     [
        //         'title' => "Cleaning Services Logo Maker",
        //         'url' => "logo-maker?industry=Cleaning Services&amp;industryId=Cleaning Services"
        //     ],
        //     [
        //         'title' => "T-Shirt Sellers",
        //         'url' => "logo-maker?industry=Clothing Brand&amp;industryId=Clothing Brand"
        //     ],
        //     [
        //         'title' => "Maintenance Company Logos",
        //         'url' => "logo-maker?industry=Service Provider&amp;industryId=Services"
        //     ],
        //     [
        //         'title' => "Moving Company Logo Maker",
        //         'url' => "logo-maker?industry=Moving Company&amp;industryId=Moving Companies"
        //     ],
        //     [
        //         'title' => "Farmers Market Logo Maker",
        //         'url' => "logo-maker?industry=Organic Products&amp;industryId=Organic Products"
        //     ],
        //     [
        //         'title' => "Tech Company Logo Maker",
        //         'url' => "logo-maker?industry=Technology&amp;industryId=Technology"
        //     ]
        // ];

        // echo "<pre>";
        // print_r($placeit_categories);
        // $templates = Redis::set('placeit:categories', json_encode($placeit_categories) );
        // exit;

        echo "<pre>";
        $templates = Redis::keys('placeit:*:metadata');
        
        // print_r("\n");
        // // print_r( "--");
        // print_r( Redis::get('placeit:template:db5a5518549a508ccfdfbadb67730f6c:jsondata') );
        // exit;


        // Place it - envato
        // 1) Loads https://placeit.net/instagram-post-templates
        //     Loads a ul>li of templates #item2wPro0 > li:nth-child(3)
        //     Every li element has an data-preset-id="c994c4859d6009bda3ebca0fa43fa8bd" attribute
        // 2) Load json from https://nice-assets-3.s3-accelerate.amazonaws.com/presets/ae83d787e0349f056583735d6ee03738/ui.json
        //     Parse graphic property from json 
        //         IMAGES
        //             https://nice-assets-2.s3-accelerate.amazonaws.com/image_library/08533dbb608c7c86a0b48df17a799406/image.png
        //         FONTS
        //             https://nice-assets-2.s3-accelerate.amazonaws.com/fonts/e57deb519599baa7c80a41939506f8d4.ttf
        
        foreach ($templates as $template) {
            $template_id = str_replace('placeit:template:',null,$template);
            $template_id = str_replace(':metadata',null,$template_id);
            // print_r("\n");
            // print_r($template_id);
            // exit;

            // $local_img_path = public_path('placeit/design/template/'.$template_id.'/assets/json/'.$template_id.'.json');
            $json_url = 'https://nice-assets-3.s3-accelerate.amazonaws.com/presets/'.$template_id.'/ui.json';

            self::downloadTemplateJSON( $template_id,  $json_url );
            // print_r("\n");
            // print_r($json_url);
            // print_r("\n");
            // print_r($template_id);
            // exit;
                        
        }
    }

    function downloadTemplateJSON( $template_id, $img_url ){

        if( Redis::exists('placeit:template:'.$template_id.':jsondata') == false ){

            $curl = curl_init();
        
            curl_setopt_array($curl, array(
                CURLOPT_URL => $img_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));
        
            $response = curl_exec($curl);
    
            Redis::set('placeit:template:'.$template_id.':jsondata', $response);
    
            // print_r("\n");
            // print_r($response);
            // exit;
        
            curl_close($curl);
        }
        
    }

    // Transfer current template
    function translateTemplate(){
        // echo $template_id;

        $base_json = '["{\"width\": 1728.00, \"height\": 2304.00, \"rows\": 1, \"cols\": 1}",{"version":"2.7.0","objects":[{"type":"image","version":"2.7.0","originX":"center","originY":"center","left":903.969858637,"top":1291.4128696969,"width":4878,"height":6757,"fill":"rgb(0,0,0)","stroke":null,"strokeWidth":0,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeMiterLimit":4,"scaleX":0.4035511785,"scaleY":0.4035511785,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","transformMatrix":null,"skewX":0,"skewY":0,"crossOrigin":"Anonymous","cropX":0,"cropY":0,"src":"https://dbzkr7khx0kap.cloudfront.net/11984_1548096343.png","locked":false,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"filters":[]},{"type":"textbox","version":"2.7.0","originX":"center","originY":"top","left":864,"top":1022.793,"width":521.6418220016,"height":257.414,"fill":"#666666","stroke":null,"strokeWidth":1,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeMiterLimit":4,"scaleX":1,"scaleY":1,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","transformMatrix":null,"skewX":0,"skewY":0,"text":"\nWelcome\n","fontSize":"67","fontWeight":"normal","fontFamily":"font30218","fontStyle":"normal","lineHeight":1.2,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"minWidth":20,"splitByGrapheme":false,"selectable":true,"editable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"styles":{}}],"overlay":{"type":"pattern","source":"function(){return patternSourceCanvas.setDimensions({width:80*scale,height:80*scale}),patternSourceCanvas.renderAll(),patternSourceCanvas.getElement()}","repeat":"repeat","crossOrigin":"","offsetX":0,"offsetY":0,"patternTransform":null,"id":32},"cwidth":1728,"cheight":2304}]';
        $base_json = json_decode($base_json);

        $base_json[0] = str_replace(1728, 480 , $base_json[0]);
        $base_json[0] = str_replace(2304, 672 , $base_json[0]);
        $base_json[1]->cwidth = 480;
        $base_json[1]->cheight = 672;
        
        // echo "<pre>";
        // print_r( $base_json );
        // exit;

        // Example image structure required for new json schema
        $base_img_obj = $base_json[1]->objects[0];
        
        // Example text structure required for new json schema
        $base_txt_obj = $base_json[1]->objects[1];

        // echo "<pre>";
        // print_r($base_txt_obj);
        // exit;

        echo "<pre>";
        // // print_r( Redis::keys('laravel_database_green:product:*') );
        $products = Redis::keys('laravel_database_green:product:*');
        
        // Parse green island product by product
        foreach ($products as $product_key_name) {
            // print_r("\n$product_key_name");
            
            $original_template_id = str_replace('laravel_database_green:product:', null, $product_key_name);
            
            if( Redis::exists('green:template:'.$original_template_id) ){
                $new_template_id = Redis::get('green:template:'.$original_template_id);
                // echo $new_template_id;
                // exit;
            } else {
                $new_template_id = self::randomNumber(15);
            }
            
            $original_template = json_decode( Redis::get('laravel_database_green:product_metadata:'.$original_template_id ) );
            
            // Transform object to known json format for wayak
            $page_objects = [];

            $thumb_url = str_replace('w=220', 'w=660', $original_template->config->thumbnail);
            $thumb_path = public_path('design/template/'.$new_template_id.'/thumbnails/'.$new_template_id.'_thumbnail.png');
            
            // $path_info = pathinfo($thumb_path);
            // print_r($original_template->config->title);
            // exit;

            // Download template thumbnail
            self::downloadTemplateJSON(  $thumb_path, $thumb_url );
            // exit;

            foreach ($original_template->config->pages as $page) {

                $new_img_obj = self::transformToImgObj($new_template_id, $base_img_obj, 'http://localhost:8001'.$page->name);
                $page_objects[] = $new_img_obj;

                foreach ($page->fields as $tmp_obj) {
                    $new_txt_obj = self::transformToTxtObj($base_txt_obj, $tmp_obj);
                    $page_objects[] = $new_txt_obj;
                }

                // print_r($page_objects);
                // exit;

            }

            // $page_objects[] = $new_img_obj;
            // print_r($page_objects);
            // exit;

            $base_json[1]->objects = $page_objects;
            
            // if( $original_template_id == 19815){
            //     print_r( $original_template );
            //     print_r( $base_json );
            //     exit;
            // }

            $final_json_template = json_encode($base_json);
            $final_json_template = str_replace('~',"\\n",$final_json_template);
            
            // print_r( $base_json );
            // exit;

            // Saves template on wayak format
            Redis::set('template:'.$new_template_id.':jsondata', $final_json_template);
            Redis::set('green:template:'.$original_template_id, $new_template_id);

            $template_info['template_id'] = $new_template_id;
            $template_info['title'] = isset($original_template->config->title) ? $original_template->config->title : ' x ';
            $template_info['filename'] = $new_template_id.'_thumbnail.png';
            $template_info['dimentions'] = '4x7 in';
            
            self::registerThumbnailsOnDB($template_info);
            
            // print_r($template_info);
            // exit;
            
        }
        
    }

    function registerThumbnailsOnDB($template_info){
		$thumbnail = DB::table('thumbnails')
						->select('id')
						->where('template_id','=', $template_info['template_id'] )
						->first();

		if( isset( $thumbnail->id ) == false ){
			DB::table('thumbnails')->insert([
				'id' => null,
				'template_id' => $template_info['template_id'],
				'title' => htmlspecialchars_decode($template_info['title']),
				'filename' => $template_info['filename'],
				'tmp_original_url' => null,
				'dimentions' => $template_info['dimentions'],
				'tmp_templates' => $template_info['template_id'],
				'status' => 1
			]);
			return true;
		}
		return false;
	}
    
    function transformToImgObj($new_template_id, $base_img_obj, $background_img_url ){
        
        $tmp_obj = new \StdClass;;
        $tmp_obj = clone($base_img_obj);
        
        $img_path = public_path( str_replace('http://localhost:8001/', null, $background_img_url) );
        $img_path = str_replace('’', null, $img_path);
        $img_path = str_replace('ñ', 'n', $img_path);
        $img_path = str_replace('‘', null, $img_path);
        $img_path = str_replace('é', 'e', $img_path);

        $tmp_obj->src = $background_img_url;
        $tmp_obj->top = 0;
        $tmp_obj->left = 0;

        if( file_exists( $img_path ) ){

            if( filesize($img_path) == 0 ){
                echo $img_path;
                exit;
            }

            list($img_width, $img_height, $img_type, $img_attr) = getimagesize( $img_path );
            $tmp_obj->width = $img_width;
            $tmp_obj->height = $img_height;
            
            
            $original_path_info = pathinfo($img_path);
            // $template_id = self::randomNumber(10);
            $media_id = self::randomNumber(10);
            
            $full_file_path = public_path('design/template/'.$new_template_id.'/assets/'.$media_id.'.'.$original_path_info['extension']);
            $path_info = pathinfo($full_file_path);
            $path = $path_info['dirname'];
            
            @mkdir( $path_info['dirname'] , 0777, true);
            
            // echo "<pre>";
            // print_r($path_info);
            // print_r(  );
            // exit;
            
            if (!copy($img_path, $full_file_path)) {
                echo "failed to copy $file...\n";
                exit;
            }
            
            $tmp_obj->src = asset('design/template/'.$new_template_id.'/assets/'.$media_id.'.'.$original_path_info['extension']);

        }
        
        // echo "<pre>";
        // print_r($tmp_obj);
        // exit;

        return $tmp_obj;
    }

    function randomNumber($length = 15) {
		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return substr(str_shuffle($permitted_chars), 0, $length);
	}

    function transformToTxtObj($base_txt_obj, $old_obj){
        $tmp_obj = new \StdClass;;
        $tmp_obj = clone($base_txt_obj);

        $tmp_obj->text = trim($old_obj->text);
        $tmp_obj->textAlign = $old_obj->align;
        // $tmp_obj->fontFamily = $old_obj->font;
        $tmp_obj->fill = '#'.$old_obj->color;
        // falta mapear $old_obj->rotation
        $tmp_obj->fill = $old_obj->color;
        $tmp_obj->fontSize = $old_obj->size;
        $tmp_obj->fontFamily = 'font7';
        // $tmp_obj->left = $old_obj->x;
        $tmp_obj->top = $old_obj->y;
        $tmp_obj->left = 240;
        
        
        $tmp_obj->originY = 'center';

        // print_r($tmp_obj);
        // echo "<pre>";
        // print_r($tmp_obj->text);
        // print_r($old_obj->text);
        // print_r($tmp_obj);
        // exit;

        return $tmp_obj;
    }

    function parseCategoryAndProducts(){
        // $user = Redis::set('user:profile', "daniel");
        // $user = Redis::get('user:profile');

        // echo $user;
        // exit;

        // echo "<pre>";
        // echo "<style>body{ background-color:black;color:white;font-size:16px; }</style>";

        // $categories = self::getCategories();
        // Redis::set('laravel_database_green:categories', $categories);

        $cats_arr = [];
        $categories = json_decode(Redis::get('laravel_database_green:categories'));

        // print_r($categories);
        // exit;

        foreach($categories->CategoryTree as $category){
            self::parseCategoryIds($category);
        }

        // print_r("\n");
        // print_r( self::getCategoryIds() );
        // exit;

        $categoryIds = self::getCategoryIds();

        foreach ($categoryIds as $category_id) {
            // print_r("\n");
            // print_r( $category_id );
            $total_page_number = 100;
            $itemsPerPage = 14;
            
            for ($current_page=0; $current_page < $total_page_number; $current_page++) { 
                
                $product_result = self::getProducts($current_page, $itemsPerPage, $category_id);
                $total_page_number = ceil($product_result->ResultsCount / $itemsPerPage);

                // Store product´s resulset per page
                Redis::set('laravel_database_green:categories:'.$category_id.':page:'.$current_page, json_encode($product_result) );
                
                // print_r("\n");
                // print_r( "\n PARSING:: ". $current_page );
                // print_r( "\n TOTAL PAGES:: ". $total_page_number );
                // print_r("\n");
                // print_r( $product_result );
                foreach ($product_result->Results as $product) {
                    // echo '<img src="'.$product->PreviewImage.'">';
                    
                    Redis::set('laravel_database_green:category:'.$category_id.':product:'.$product->Id, json_encode($product) );
                    Redis::set('laravel_database_green:product:'.$product->Id, json_encode($product) );

                    // print_r("\n");
                    // print_r( $product );
                    // exit;
                    
                    // // $path_info = pathinfo($new_path); // dirname, filename, extension
                    // $template_id = $product->Id;
                    
                    // $path = 'design/template/'.$template_id.'/assets';
                    // $download_url = $product->PreviewImage;

                    // if( file_exists($path . '/preview.jpg')  == false ) {
                    //     // echo "existe";
                    //     // exit;
                    //     self::downloadTemplateJSON( $template_id, 'preview.jpg', $download_url );
                    // }

                }
                // exit;
                
            }

            // exit;
        }

        // getProducts(1, 14, 592);
        // self::getTemplate(21389);

        // self::downloadTemplateJSON( 23123, 'ejemplo.jpg', 'https://images.greetingsisland.com/images/invitations/wedding/garden%20wreath%20&%20rings1.jpg');
    }

    function getCategories(){
        
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.greetingsisland.com/mobile/GetMobileAppData?samVer=dev",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Host: www.greetingsisland.com",
            "accept: application/json, text/plain, */*",
            "origin: ionic://localhost",
            "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148",
            "accept-language: en-us",
            "Pragma: no-cache",
            "Cache-Control: no-cache",
            "Cookie: __cfduid=dcea7e29d5a091be256d9fd4fffc21dc51600427362; lang=en"
        ),
        ));
    
        $response = curl_exec($curl);
    
        curl_close($curl);
        
        // echo "<pre>";
        // echo "<style>body{ background-color:black;color:white;font-size:16px; }</style>";
        // print_r( json_decode($response) );
        // return json_decode($response);
        return $response;
    }
    
    function getProducts($pageNum = 0, $itemsPerPage=14, $categoryId = 592){
    
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.greetingsisland.com/mobile/search?&pageNum=$pageNum&itemsPerPage=$itemsPerPage&categoryId=$categoryId&samVer=dev",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Host: www.greetingsisland.com",
            "accept: application/json, text/plain, */*",
            "origin: ionic://localhost",
            "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148",
            "accept-language: en-us",
            "Pragma: no-cache",
            "Cache-Control: no-cache",
            "Cookie: __cfduid=dcea7e29d5a091be256d9fd4fffc21dc51600427362; lang=en"
        ),
        ));
    
        $response = curl_exec($curl);
    
        curl_close($curl);
    
        // echo "<pre>";
        // echo "<style>body{ background-color:black;color:white;font-size:16px; }</style>";
        return json_decode($response);
    }
    
    function getTemplate($cardId){
        $curl = curl_init();
    
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.greetingsisland.com/mobile/getCardConfig?cardId=$cardId&samVer=dev",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Host: www.greetingsisland.com",
            "accept: application/json, text/plain, */*",
            "origin: ionic://localhost",
            "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148",
            "accept-language: en-us",
            "Pragma: no-cache",
            "Cache-Control: no-cache",
            "Cookie: __cfduid=dcea7e29d5a091be256d9fd4fffc21dc51600427362; lang=en"
        ),
        ));
    
        $response = curl_exec($curl);
    
        curl_close($curl);
        
        echo "<pre>";
        echo "<style>body{ background-color:black;color:white;font-size:16px; }</style>";
        print_r( json_decode($response) );
    
    }
    
    

    function parseCategoryIds($category, Request $request){
        
        // if( isset($category->Children) && sizeof($category->Children) > 0 ){
            foreach ($category->Children as $child) {
                self::parseCategoryIds($child);
            }
        // }

        // print_r($category);
        // print_r("\n\nCategoryId -- ");
        // print_r($category->CategoryId);
        // print_r("\n\n");

        // if( $category->CategoryId == 203 || $category->ParentCategoryId == 203 ){
            $this->category_ids[] = $category->CategoryId;
        // }
    }

    function getCategoryIds(){
        // echo "hi";
        return $this->category_ids;
    }

    function getProduct($product_id){
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.greetingsisland.com/mobile/getCardConfig?cardId=$product_id&samVer=dev",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "Host: www.greetingsisland.com",
            "accept: application/json, text/plain, */*",
            "origin: ionic://localhost",
            "user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148",
            "accept-language: en-us",
            "Pragma: no-cache",
            "Cache-Control: no-cache",
            "Cookie: __cfduid=dcea7e29d5a091be256d9fd4fffc21dc51600427362"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }

    /// MIGRATION
    /// MIGRATION
    /// MIGRATION
    /// MIGRATION
    /// MIGRATION
    /// MIGRATION
    /// MIGRATION

    

}
