<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

// ini_set("max_execution_time", 0);   // no time-outs!
// ini_set("request_terminate_timeout", 2000);   // no time-outs!
// ini_set('memory_limit', -1);
// ini_set('display_errors', 1);

// // ignore_user_abort(true);            // Continue downloading even after user closes the browser.
// error_reporting(E_ALL);


class PlaceitController extends Controller
{
    private $category_ids = [];

    /**
     * Show the application dashboard.
     */
    public function index(Request $request)
    {

        // self::builtCategoriesJSON();
        // self::associateOriginalTemplateID();
        // self::createWayakTemplate();
        exit;

        
        

        echo "<pre>";
        $templates = Redis::keys('placeit:*:metadata');
        
        // print_r("\n");
        // // print_r( "--");
        // print_r( Redis::get('placeit:template:db5a5518549a508ccfdfbadb67730f6c:jsondata') );
        // exit;
                
        foreach ($templates as $template) {
            $template_id = str_replace('placeit:template:',null,$template);
            $template_id = str_replace(':metadata',null,$template_id);
            // print_r("\n");
            // print_r($template_id);
            // exit;

            // $local_img_path = public_path('placeit/design/template/'.$template_id.'/assets/json/'.$template_id.'.json');
            $json_url = 'https://nice-assets-3.s3-accelerate.amazonaws.com/presets/'.$template_id.'/ui.json';
            // https://nice-assets-2.s3-accelerate.amazonaws.com/smart_templates/7f096a014ead9cc35e191e4167e73bf1/structure.json

            self::downloadTemplateJSON( $template_id,  $json_url );
            // print_r("\n");
            // print_r($json_url);
            // print_r("\n");
            // print_r($template_id);
            // exit;
                        
        }
    }

    function builtCategoriesJSON(){
        echo "<pre>";
        $placeit_categories = [];
        $placeit_categories['urls'] = [
            [
                'title' => "Instagram Post Templates",
                'url' => "instagram-post-templates"
            ],
            [
                'title' => "Instagram Story Maker",
                'url' => "instagram-story-templates"
            ],
            [
                'title' => "Instagram Story Video Maker",
                'url' => "instagram-story-video-template"
            ],
            [
                'title' => "Facebook Cover Maker",
                'url' => "facebook-cover-photo-maker"
            ],
            [
                'title' => "Facebook Post Maker",
                'url' => "facebook-post-template"
            ],
            [
                'title' => "Facebook Cover Video Maker",
                'url' => "facebook-cover-video-maker"
            ],
            [
                'title' => "YouTube Thumbnails",
                'url' => "gaming-templates?f_devices=YouTube%20Thumbnail%20Maker"
            ],
            [
                'title' => "YouTube Banners",
                'url' => "gaming-templates?f_devices=YouTube%20Banner%20Maker"
            ],
            [
                'title' => "YouTube End Cards",
                'url' => "gaming-templates?f_devices=YouTube%20End%20Card"
            ],
            [
                'title' => "YouTube Video Templates",
                'url' => "youtube-video-templates"
            ],
            [
                'title' => "YouTube Channel Art Templates",
                'url' => "youtube-templates"
            ],
            [
                'title' => "Free Mockups",
                'url' => "free-templates"
            ],
            [
                'title' => "Android Mockups",
                'url' => "android-mockup-generator"
            ],
            [
                'title' => "App Store Screenshots",
                'url' => "app-store-screenshot-generator"
            ],
            [
                'title' => "Book Mockups",
                'url' => "book-mockup-generator"
            ],
            // [
            //     'title' => "Free Image Cropper",
            //     'url' => "image-cropper"
            // ],
            [
                'title' => "Hat Mockups",
                'url' => "hat-mockup-generator"
            ],
            [
                'title' => "Hoodie Mockups",
                'url' => "hoodie-mockup-templates"
            ],
            [
                'title' => "iMac Mockups",
                'url' => "imac-mockup-generator"
            ],
            [
                'title' => "iPad Mockups",
                'url' => "ipad-mockup-generator"
            ],
            [
                'title' => "iPhone Mockups",
                'url' => "iphone-mockup-generator"
            ],
            [
                'title' => "Long Sleeve Shirts",
                'url' => "long-sleeve-shirt-mockup"
            ],
            [
                'title' => "MacBook Mockups",
                'url' => "macbook-mockup-generator"
            ],
            [
                'title' => "Mug Mockups",
                'url' => "coffee-mug-mockup-generator"
            ],
            [
                'title' => "Musician Mockups",
                'url' => "musician-templates"
            ],
            [
                'title' => "Onesie Mockups",
                'url' => "baby-onesie-mockup"
            ],
            [
                'title' => "Responsive Mockups",
                'url' => "responsive-mockup-generator"
            ],
            [
                'title' => "T-Shirt Mockups ",
                'url' => "tshirt-mockup-generator"
            ],
            [
                'title' => "Tank Top Mockups",
                'url' => "tank-top-mockup-generator"
            ],
            [
                'title' => "Tote Bag Mockups",
                'url' => "tote-bag-mockup-generator"
            ],
            [
                'title' => "Transparent Mockups",
                'url' => "transparent-mockup-generator"
            ],
            [
                'title' => "Free Design Templates",
                'url' => "free-templates"
            ],
            [
                'title' => "Album Cover Maker",
                'url' => "album-cover-templates"
            ],
            [
                'title' => "Banner Ad Maker",
                'url' => "online-banner-maker"
            ],
            [
                'title' => "Beauty Design Templates",
                'url' => "beauty-templates"
            ],
            [
                'title' => "Birthday Design Templates",
                'url' => "birthday-templates"
            ],
            [
                'title' => "Book Cover Maker",
                'url' => "book-cover-designs"
            ],
            [
                'title' => "Business Card Maker",
                'url' => "online-business-card-maker"
            ],
            [
                'title' => "Cannabis Design Templates",
                'url' => "cannabis-templates"
            ],
            [
                'title' => "Flyer Maker",
                'url' => "flyer-templates"
            ],
            // [
            //     'title' => "Free Image Resizer",
            //     'url' => "image-cropper"
            // ],
            [
                'title' => "Musician Designs",
                'url' => "musician-templates"
            ],
            [
                'title' => "Pinterest Templates",
                'url' => "pinterest-pin-maker"
            ],
            [
                'title' => "Podcast Cover Maker",
                'url' => "podcast-cover-templates"
            ],
            [
                'title' => "Poster Templates",
                'url' => "poster-templates?sortby=newest"
            ],
            [
                'title' => "T-Shirt Design Maker",
                'url' => "t-shirt-design-templates"
            ],
            [
                'title' => "T-Shirt Label Maker",
                'url' => "t-shirt-label-design"
            ],
            [
                'title' => "Twitch Templates",
                'url' => "twitch-templates"
            ],
            [
                'title' => "Twitch Banners",
                'url' => "gaming-templates?f_devices=Twitch%20Banner%20Maker"
            ],
            [
                'title' => "Twitch Overlays",
                'url' => "gaming-templates?f_devices=Twitch%20Overlay%20Maker"
            ],
            [
                'title' => "Twitch Panels",
                'url' => "gaming-templates?f_devices=Twitch%20Panel%20Maker"
            ],
            [
                'title' => "Twitter Header Maker",
                'url' => "twitter-header-template"
            ],
            [
                'title' => "Twitter Post Templates",
                'url' => "twitter-post-template"
            ],
            [
                'title' => "Wellness Design Templates",
                'url' => "wellness-templates"
            ],
            [
                'title' => "Free Logos",
                'url' => "free-templates?f_devices=Logo%20Maker"
            ],
            [
                'title' => "Animated Logos",
                'url' => "animated-logos"
            ],
            // [
            //     'title' => "Free Image Cropper",
            //     'url' => "image-cropper"
            // ],
            [
                'title' => "Music Logo Maker",
                'url' => "hip-hop-templates?f_devices=Logo%20Maker"
            ],
            [
                'title' => "Musican Logos",
                'url' => "musician-templates?f_devices=Logo%20Maker"
            ],
            [
                'title' => "Video Maker",
                'url' => "video-maker"
            ],
            [
                'title' => "Animated Logos",
                'url' => "animated-logos"
            ],
            [
                'title' => "Animated Logos",
                'url' => "gaming-templates?f_devices=Animated%20Logo"
            ],
            [
                'title' => "Video Cropper",
                'url' => "video-cropper"
            ],
            [
                'title' => "Intro Maker",
                'url' => "video-intro-maker"
            ],
            [
                'title' => "Promo Video Maker",
                'url' => "promo-video-templates"
            ],
            [
                'title' => "Slideshow Video Maker",
                'url' => "video-slideshow-maker"
            ],
            [
                'title' => "Stream Starting Soon Template",
                'url' => "stream-starting-soon-templates"
            ],
            [
                'title' => "Video to Gif Converter",
                'url' => "video-to-gif-converter"
            ],
            [
                'title' => "Gaming",
                'url' => "gaming-templates"
            ],
            [
                'title' => "Free Gaming Templates",
                'url' => "gaming-templates?sortby=free"
            ],
            // [
            //     'title' => "Free Image Cropper",
            //     'url' => "image-cropper"
            // ],
            [
                'title' => "Free Online Video Cropper",
                'url' => "video-cropper"
            ],
            [
                'title' => "Gaming Video Intros",
                'url' => "gaming-templates?f_devices=Intro%20Maker"
            ],
            [
                'title' => "Mockup Generator",
                'url' => "c/mockups"
            ],
            [
                'title' => "Online Design Maker",
                'url' => "c/design-templates"
            ],
            [
                'title' => "Video to Gif Converter",
                'url' => "video-to-gif-converter"
            ],
            [
                'title' => "Facebook Ad Templates",
                'url' => "facebook-ad-mockups"
            ],
            [
                'title' => "Sportswear Mockups",
                'url' => "sportswear-mockups"
            ],
            [
                'title' => "App Video Mockups",
                'url' => "app-video-mockups"
            ],
            [
                'title' => "Apparel Mockups",
                'url' => "apparel-mockups"
            ],
            [
                'title' => "T-Shirt Video Mockups",
                'url' => "t-shirt-video-mockups"
            ],
            [
                'title' => "Banner Mockups",
                'url' => "banner-mockups"
            ],
            [
                'title' => "Beanie Mockups",
                'url' => "beanie-mockups"
            ],
            [
                'title' => "Business Card Mockups",
                'url' => "business-card-mockups"
            ],
            [
                'title' => "Garment Only Mockups",
                'url' => "garment-only-mockups"
            ],
            [
                'title' => "Heather Mockups",
                'url' => "heather-mockups"
            ],
            [
                'title' => "Home Decor Mockups",
                'url' => "home-decor-mockups"
            ],
            [
                'title' => "Packaging Mockups",
                'url' => "packaging-mockups"
            ],
            [
                'title' => "Phone Case Mockups",
                'url' => "iphone-case-mockups"
            ],
            [
                'title' => "Phone Grip Mockups",
                'url' => "phone-grip-mockups"
            ],
            [
                'title' => "Polo Shirt Mockups",
                'url' => "polo-shirt-mockups"
            ],
            [
                'title' => "Stationery Mockups",
                'url' => "stationery-mockups"
            ],
            [
                'title' => "Sublimated Mockups",
                'url' => "sublimated-mockups"
            ],
            [
                'title' => "Sweatshirt Mockups",
                'url' => "sweatshirt-mockups"
            ],
            [
                'title' => "Travel Mug Mockups",
                'url' => "travel-mug-mockups"
            ],
            [
                'title' => "T-Shirt Video Mockups",
                'url' => "t-shirt-video-mockups"
            ],
            [
                'title' => "YouTube Profile Picture Maker",
                'url' => "logo-maker?industry=all&amp;industryId=YouTube"
            ],
            [
                'title' => "Logo Maker",
                'url' => "logo-maker"
            ],
            [
                'title' => "Abstract Logo Maker",
                'url' => "logo-maker?industry=Abstract&amp;industryId=Abstract"
            ],
            [
                'title' => "Architect Logo Maker",
                'url' => "logo-maker?industry=Architect&amp;industryId=Architect"
            ],
            [
                'title' => "Avatar Maker",
                'url' => "logo-maker?industry=Avatar Maker&amp;industryId=Avatar"
            ],
            [
                'title' => "Bakery Logo Maker",
                'url' => "logo-maker?industry=Bakery&amp;industryId=Bakery"
            ],
            [
                'title' => "Bar Logo Maker",
                'url' => "logo-maker?industry=Bar&amp;industryId=Bar"
            ],
            [
                'title' => "Beauty Logo Maker",
                'url' => "logo-maker?industry=Beauty&amp;industryId=Beauty"
            ],
            [
                'title' => "Catering Logo Maker",
                'url' => "logo-maker?industry=Catering&amp;industryId=Catering"
            ],
            [
                'title' => "Consulting Logo Maker",
                'url' => "logo-maker?industry=Consulting&amp;industryId=Consulting"
            ],
            [
                'title' => "Daycare Logo Maker",
                'url' => "logo-maker?industry=Daycare&amp;industryId=Daycare"
            ],
            [
                'title' => "Dental Logo Maker",
                'url' => "logo-maker?industry=Dental&amp;industryId=Dental"
            ],
            [
                'title' => "Designer Logo Maker",
                'url' => "logo-maker?industry=Design&amp;industryId=Design"
            ],
            [
                'title' => "Medical Logo Maker",
                'url' => "logo-maker?industry=Medical&amp;industryId=Medical"
            ],
            [
                'title' => "Financial Logo Maker",
                'url' => "logo-maker?industry=Finance&amp;industryId=Finance"
            ],
            [
                'title' => "Fitness Logo Maker",
                'url' => "logo-maker?industry=Fitness&amp;industryId=Fitness"
            ],
            [
                'title' => "Gaming Logo Maker",
                'url' => "logo-maker?industry=Gaming&amp;industryId=Gaming"
            ],
            [
                'title' => "Law Firm Logo Maker",
                'url' => "logo-maker?industry=Law&amp;industryId=Law"
            ],
            [
                'title' => "HVAC Logo Maker",
                'url' => "logo-maker?industry=HV_AC&amp;industryId=HV_AC"
            ],
            [
                'title' => "Automotive Logo Maker",
                'url' => "logo-maker?industry=Automotive&amp;industryId=Automotive"
            ],
            [
                'title' => "Painter Logo Maker",
                'url' => "logo-maker?industry=Painter&amp;industryId=Painter"
            ],
            [
                'title' => "Pet Store Logo Maker",
                'url' => "logo-maker?industry=Pets&amp;industryId=Pets"
            ],
            [
                'title' => "Sports Logo Maker",
                'url' => "logo-maker?industry=Sports Logos&amp;industryId=Sports"
            ],
            [
                'title' => "Education Logo Maker",
                'url' => "logo-maker?industry=Education&amp;industryId=Education"
            ],
            [
                'title' => "Travel Agency Logo Maker",
                'url' => "logo-maker?industry=Travel&amp;industryId=Travel"
            ],
            [
                'title' => "Wellness Logo Maker",
                'url' => "logo-maker?industry=Wellness&amp;industryId=Wellness"
            ],
            [
                'title' => "Publishing Logo Maker",
                'url' => "logo-maker?industry=Writer&amp;industryId=Writer"
            ],
            [
                'title' => "Gaming Logos",
                'url' => "logo-maker?industry=Gaming&amp;industryId=Gaming"
            ],
            [
                'title' => "Coffee Shop Logo Maker",
                'url' => "logo-maker?industry=Coffee Shop&amp;industryId=Coffee Shop"
            ],
            [
                'title' => "Electrician Logo Maker",
                'url' => "logo-maker?industry=Electrician&amp;industryId=Electrician"
            ],
            [
                'title' => "Landscaping Logo Maker",
                'url' => "logo-maker?industry=Landscaping&amp;industryId=Landscaping"
            ],
            [
                'title' => "Real Estate Logo Maker",
                'url' => "logo-maker?industry=Real Estate&amp;industryId=Real Estate"
            ],
            [
                'title' => "Restaurant Logo Maker",
                'url' => "logo-maker?industry=Restaurant&amp;industryId=Restaurant"
            ],
            [
                'title' => "Arts and Crafts Logo Maker",
                'url' => "logo-maker?industry=Arts and Crafts&amp;industryId=Arts and Crafts"
            ],
            [
                'title' => "Event Planner Logo Maker",
                'url' => "logo-maker?industry=Event Planner&amp;industryId=Event Planner"
            ],
            [
                'title' => "Cleaning Services Logo Maker",
                'url' => "logo-maker?industry=Cleaning Services&amp;industryId=Cleaning Services"
            ],
            [
                'title' => "T-Shirt Sellers",
                'url' => "logo-maker?industry=Clothing Brand&amp;industryId=Clothing Brand"
            ],
            [
                'title' => "Maintenance Company Logos",
                'url' => "logo-maker?industry=Service Provider&amp;industryId=Services"
            ],
            [
                'title' => "Moving Company Logo Maker",
                'url' => "logo-maker?industry=Moving Company&amp;industryId=Moving Companies"
            ],
            [
                'title' => "Farmers Market Logo Maker",
                'url' => "logo-maker?industry=Organic Products&amp;industryId=Organic Products"
            ],
            [
                'title' => "Tech Company Logo Maker",
                'url' => "logo-maker?industry=Technology&amp;industryId=Technology"
            ]
        ];

        echo "<pre>";
        print_r($placeit_categories);
        Redis::set('placeit:categories', json_encode($placeit_categories) );
        // exit;
    }
    
    function associateOriginalTemplateID(){
        $placeit_templates = Redis::keys('placeit:template:*:metadata');
        
        foreach ($placeit_templates as $template_key) {
            
            $template_metadata = Redis::get($template_key);
            $template_metadata = json_decode($template_metadata);

            print_r( "<hr>" );
            echo '<h1>ANALYSIS >>'.$template_key.'</h1>';
            print_r( "<br>" );
            echo '<img src="'.$template_metadata->thumb_img_url.'">';

            if(Redis::exists( 'placeit:template:'.$template_metadata->template_id.':jsondata' )){
                
                print_r( "<br>TEMPLATE EXISTS" );
                print_r( "<br>" );

                $meta = self::extractTemplateMetadata( $template_metadata );
                if( isset($meta['images']) ){
                    foreach($meta['images'] as $image){
                        $path_info = pathinfo( $image->path );
                        // $path_info['filename'];
                    
                        $db_template = DB::table('images')
                            ->select('template_id')
                            ->where('original_path', 'like', '%'.$path_info['filename'].'%')
                            ->first();
                        
                        if( isset($db_template->template_id) ){
    
                            DB::table('templates')
                                ->where('template_id', $db_template->template_id )
                                ->update([ 'original_template_id' => $template_metadata->template_id ]);
                            
                            DB::table('thumbnails')
                                ->where('template_id', $db_template->template_id )
                                ->update([ 'original_template_id' => $template_metadata->template_id ]);
                            
                            echo "<pre>";
                            print_r( "<br>" );
                            print_r( $template_metadata->template_id );
                            print_r( "<br>" );
                            print_r( $db_template->template_id );
                            // exit;
                            break;
                        }
                    }
                }
                // $meta = json_decode($meta);
                
                // echo "<pre>";
                // print_r( $template_metadata );
                // print_r( $template_metadata->template_id );
                // // print_r( $meta['images'] );
                // print_r( $meta );
                // exit;

            }

        }
    }

    function createWayakTemplate(){

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

        $placeit_templates = Redis::keys('placeit:template:*:metadata');
        $template_index = 0;
        echo "<pre>";

        foreach ($placeit_templates as $key_template) {
            
            // $key_template = 'placeit:template:36573c84b9efc0f36a0d7544f8b0ab16:metadata';
            $original_metadata = json_decode(Redis::get($key_template));
            // print_r( $original_metadata->template_id );
            // print_r( $original_metadata );
            // exit;

            $db_template = DB::table('thumbnails')
                                    ->select('template_id')
                                    ->where('original_template_id', '=', $original_metadata->template_id )
                                    ->first();

            print_r( 'TEMPLATE>> '.$original_metadata->template_id.'<br>');
            // print_r( $db_template->template_id );
            // exit;

            // if( isset( $db_template->template_id ) == false ){
                
                $parent_template_id = null;
                $metadata = self::extractTemplateMetadata($original_metadata);
                
                if( isset( $db_template->template_id ) ){
                    $new_template_id = $db_template->template_id;
                } else {
                    $new_template_id = self::generateRandString();
                }

                // print_r( $key_template );
                // print_r( $original_metadata->template_id );
                // print_r( $metadata );
                // exit;

                // echo "<pre>";
                $original_width = ceil($metadata['width'] / 3.125);
                $original_height = ceil($metadata['height'] / 3.125);
                $width = $original_width;
                $height = $original_height;
                $measureUnits = 'px';

                $dimentions = $width.'x'.$height.' px';
                // print_r( $dimentions );
                // exit;
                
                $templates_name = $original_metadata->title;
                $parent_template_id = ( $parent_template_id == null ) ? $new_template_id : $parent_template_id;

                // print_r( $dimentions_arr  );
                // print_r( $original_width );
                // print_r( $original_height );
                // exit;

                $base_json = '["{\"width\": 1728.00, \"height\": 2304.00, \"rows\": 1, \"cols\": 1}",{"version":"2.7.0","objects":[{"type":"image","version":"2.7.0","originX":"center","originY":"center","left":903.969858637,"top":1291.4128696969,"width":4878,"height":6757,"fill":"rgb(0,0,0)","stroke":null,"strokeWidth":0,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeMiterLimit":4,"scaleX":0.4035511785,"scaleY":0.4035511785,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","transformMatrix":null,"skewX":0,"skewY":0,"crossOrigin":"Anonymous","cropX":0,"cropY":0,"src":"https://dbzkr7khx0kap.cloudfront.net/11984_1548096343.png","locked":false,"selectable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"filters":[]},{"type":"textbox","version":"2.7.0","originX":"center","originY":"top","left":864,"top":1022.793,"width":521.6418220016,"height":257.414,"fill":"#666666","stroke":null,"strokeWidth":1,"strokeDashArray":null,"strokeLineCap":"butt","strokeDashOffset":0,"strokeLineJoin":"miter","strokeMiterLimit":4,"scaleX":1,"scaleY":1,"angle":0,"flipX":false,"flipY":false,"opacity":1,"shadow":null,"visible":true,"clipTo":null,"backgroundColor":"","fillRule":"nonzero","paintFirst":"fill","globalCompositeOperation":"source-over","transformMatrix":null,"skewX":0,"skewY":0,"text":"\nWelcome\n","fontSize":"67","fontWeight":"normal","fontFamily":"font30218","fontStyle":"normal","lineHeight":1.2,"underline":false,"overline":false,"linethrough":false,"textAlign":"center","textBackgroundColor":"","charSpacing":0,"minWidth":20,"splitByGrapheme":false,"selectable":true,"editable":true,"evented":true,"lockMovementX":false,"lockMovementY":false,"styles":{}}],"overlay":{"type":"pattern","source":"function(){return patternSourceCanvas.setDimensions({width:80*scale,height:80*scale}),patternSourceCanvas.renderAll(),patternSourceCanvas.getElement()}","repeat":"repeat","crossOrigin":"","offsetX":0,"offsetY":0,"patternTransform":null,"id":32},"cwidth":1728,"cheight":2304}]';
                $base_json = json_decode($base_json);
                
                $base_json[0] = str_replace(1728, ceil($original_width) , $base_json[0]);
                $base_json[0] = str_replace(2304, ceil($original_height) , $base_json[0]);
                
                $base_page = $base_json[1];
                unset($base_json[1]);
                $base_json = array_values($base_json);

                $page_objects = [];
                $new_page_obj = clone($base_page);
                
                $new_page_obj->cwidth = $width;
                $new_page_obj->cheight = $height;
                
                // Example image structure required for new json schema
                $base_img_obj = $new_page_obj->objects[0];
                
                // Example text structure required for new json schema
                $base_txt_obj = $new_page_obj->objects[1];
                
                if( isset($metadata['images']) ){
                    foreach( $metadata['images'] as $img_obj) {
                        // print_r( $metadata['images'] );
                        // exit;

                        if( isset($img_obj->url) ){
                            $img_url = $img_obj->url;
                        } elseif( isset( $img_obj->path ) ){
                            $img_url = 'https://nice-assets-2.s3-accelerate.amazonaws.com/'.$img_obj->path;
                        } elseif( isset( $img_obj->image ) ){
                            $img_url = 'https://nice-assets-2.s3-accelerate.amazonaws.com/'.$img_obj->image;
                            // print_r($img_obj);
                            // exit;
                        } else {
                            // echo "DEBUG: 707 ";
                            // print_r($img_obj);
                            // exit;
                        }
                        
                        // echo '<img src="'.$img_url.'"><br>';
                        // exit;

                        $path_info = pathinfo( $img_url );
                        $local_img_path = public_path('/design/template/'.$new_template_id.'/assets/');
                        self::downloadImage( $img_url, $local_img_path,  $new_template_id);

                        $new_img_obj = self::transformToImgObj($new_template_id, $base_img_obj, $path_info['basename'] );
                        $page_objects[] = $new_img_obj;
                    }
                }

                if( isset($metadata['text']) ){
                    $template_text = self::extractTemplateText($metadata['text']);
                    foreach ($template_text as $txt_obj) {
                        $new_txt_obj = self::transformToTxtObj($base_txt_obj, $txt_obj, $measureUnits);
                        $page_objects[] = $new_txt_obj;
                    }
                } else {
                    // echo "dEBUG: 730: NO TEXT";
                    // print_r($metadata);
                    // exit;
                }
                

                $new_page_obj->objects = $page_objects;
                $new_page_obj->cwidth = $width;
                $new_page_obj->cheight = $height;

                $base_json[] = $new_page_obj;

                // print_r( $base_json );
                // print_r( $template_text );
                // print_r( $page_objects );
                // print_r( $page_objects );
                // exit;

                // print_r( $original_metadata );
                // print_r( $metadata );
                // exit;
                
                $final_json_template = json_encode($base_json);
                
                // print_r($base_json);
                // print_r($final_json_template);
                
                // Saves template on wayak format
                Redis::set('template:en:'.$new_template_id.':jsondata', $final_json_template);

                print_r("\n".'  template:en:'.$new_template_id.':jsondata');

                $template_info['template_id'] = $new_template_id;
                $template_info['title'] = isset($original_template->config->title) ? $original_template->config->title : ' x ';
                $template_info['filename'] = $new_template_id.'_thumbnail.png';
                $template_info['dimentions'] = $dimentions;
                
                $local_img_path = public_path('/design/template/'.$new_template_id.'/thumbnails/en/');
                $file_name = self::downloadImage( $original_metadata->thumb_img_url, $local_img_path, $new_template_id);
                
                // echo "PRO";
                // exit;
                self::registerThumbOnDB($new_template_id, $original_metadata->title, $file_name, $dimentions, $original_metadata->template_id);
                self::registerTemplateOnDB($new_template_id, $original_metadata->template_id, $templates_name, $parent_template_id, $width, $height, $measureUnits);
                $template_index++;

                // if($template_index == 800){
                //     echo "\n<br>TERMINE";
                //     exit;
                // }
            // }
            // exit;
        }

    }

    function downloadImage( $img_url, $local_img_path, $template_id ){
        $url_info = pathinfo($img_url);
        $full_local_img_path = $local_img_path.$url_info['basename'];
       
        $path_info = pathinfo($full_local_img_path);
        $path = $path_info['dirname'];
        $file_name = $path_info['basename'];

        if (file_exists($full_local_img_path) == false || file_exists($full_local_img_path) && filesize($full_local_img_path) == 0) {

            @mkdir($path, 0777, true);
        
            set_time_limit(0);
        
            //This is the file where we save the    information
            $fp = fopen ($path . '/'.$file_name, 'w+');
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

        return $file_name;
    }

    function registerThumbOnDB($template_id, $title, $filename,$dimentions, $product_key){
        
        $thumbnail_rows = DB::table('thumbnails')
                            ->where('template_id','=',$template_id)
                            ->count();
    
        if( $thumbnail_rows == 0 ){
            DB::table('thumbnails')->insert([
                'id' => null,
                'template_id' => $template_id,
                'title' => htmlspecialchars_decode( $title ),
                'filename' => $filename,
                'dimentions' => $dimentions,
                'tmp_templates' => $template_id,
                'language_code' => 'en',
                'status' => 1,
                'original_template_id' => $product_key
            ]);
        }
    }

    function registerTemplateOnDB($template_id, $original_template_id, $name, $parent_template_id, $width, $height, $measureUnits){
        
        $thumbnail_rows = DB::table('templates')
                            ->where('template_id','=',$template_id)
                            ->count();
    
        if( $thumbnail_rows == 0 ){
            DB::table('templates')->insert([
                'id' => null,
                'source' => 'placeit',
                'template_id' => $template_id,
                'original_template_id' => $template_id,
                // 'name' => htmlspecialchars_decode( $name ),
                'status' => 0,
                'parent_template_id' => $parent_template_id,
                'width' => $width,
                'height' => $height,
                'metrics' => $measureUnits
            ]);
        }
    }

    function transformToTxtObj($base_txt_obj, $old_obj, $measureUnits){
        $tmp_obj = new \StdClass;;
        $tmp_obj = clone($base_txt_obj);

        // print_r($old_obj->{'font-size'});
        // print_r($old_obj);
        // exit;

        $tmp_obj->text = trim($old_obj['text']);
        $tmp_obj->textAlign = 'center';
        $tmp_obj->originX = 'left';
        $tmp_obj->originY = 'top';
        $tmp_obj->fontFamily = $old_obj['font_id'];
        $tmp_obj->fill = $old_obj['color'];
        $tmp_obj->fontSize = $old_obj['fontSize'];
        $tmp_obj->top = $old_obj['y'];
        $tmp_obj->left = $old_obj['x'];
        
        $tmp_obj->width = $old_obj['width'];
        $tmp_obj->height = $old_obj['height'];
        
        return $tmp_obj;
    }

    function extractTemplateText($metadata_fonts){
        // print_r( $metadata_fonts );
        // exit;
        $text = [];
        foreach($metadata_fonts as $font) {
            if(isset($font['allowedFonts'])){
                // print_r($font);
                // exit;
                foreach($font['allowedFonts'] as $font_assets) {
                    // print_r("font_assets");
                    // https://nice-assets-2.s3-accelerate.amazonaws.com/fonts/e57deb519599baa7c80a41939506f8d4.ttf
                    $font_url = 'https://nice-assets-2.s3-accelerate.amazonaws.com/'.$font_assets->file;
                    $local_font_path = public_path('design/fonts_new/');
                    $font_name = isset($font_assets->name) ? $font_assets->name : 'No Name';
                    $insert_result = self::registerFontOnDB( $font_assets->displayName, $font_name, $font_url);
                    if( $insert_result == 0 ){
                        self::downloadFont( $font_url, $local_font_path);
                    }

                    $font_db_info = DB::table('fonts')
                                    ->select('font_id')
                                    ->where('name', '=', $font_assets->displayName)
                                    ->first();
                    $font['font_id'] = $font_db_info->font_id;

                }

                $text[] = $font;
            }
            // print_r($font);
            // exit;
        }
        
        return $text;
    }

    function registerFontOnDB($displayName, $filename, $url){

        
        $thumbnail_rows = DB::table('fonts')
                            // ->select('font_id')
                            ->where('name','=',$displayName)
                            ->count();
        
        // print_r('<br><br>'.$displayName.' - '.$thumbnail_rows.'<br>');

        if( $thumbnail_rows == 0 ){

            $font_id = self::generateRandString(10);

            DB::table('fonts')->insert([
                'id' => null,
                'name' => $displayName,
                'filename' => $filename,
                'url' => $url,
                'font_id' => $font_id,
                'status' => 1,
                'source' => 'placeit'
            ]);
            
            return 0;

        } else {
            return 1;
        }
    }

    function generateRandString($length = 15) {
		$permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		return substr(str_shuffle($permitted_chars), 0, $length);
	}

    function downloadFont( $font_url, $local_font_path){

        $url_info = pathinfo($font_url);
        $full_local_font_path = $local_font_path.$url_info['basename'];

        $path_info = pathinfo($full_local_font_path);
        $path = $path_info['dirname'];
        $file_name = $path_info['basename'];

        if (file_exists($full_local_font_path) == false 
            OR (
                file_exists($full_local_font_path)
                && filesize($full_local_font_path) == 0
            )) {

            // print_r("\n\n".$font_url.'-');
            // print_r("\n\n".$full_local_font_path.'-');
            // exit;
            
            
            @mkdir($path, 0777, true);
        
            set_time_limit(0);
        
            //This is the file where we save the    information
            $fp = fopen ($path . '/'.$file_name, 'w+');
            //Here is the file we are downloading, replace spaces with %20
            $ch = curl_init(str_replace(" ","%20",$font_url));
            curl_setopt($ch, CURLOPT_TIMEOUT, 50);
            // write curl response to file
            curl_setopt($ch, CURLOPT_FILE, $fp); 
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            // get curl response
            curl_exec($ch); 
            curl_close($ch);
            fclose($fp);
        }

        return filesize($full_local_font_path);
    }

    function extractTemplateMetadata( $template_metadata ){
        
        $template = json_decode( Redis::get( 'placeit:template:'.$template_metadata->template_id.':jsondata' ) );
        // print_r($template->graphic);
        // exit;

        // if(isset($template->original) == false || isset($template->previewImage) == false ){
        //     print_r( $template );
        //     exit;
        // }

        $template_content = [];

        $template_content['width'] = isset($template->original) ? $template->original->size->high->width : null;
        $template_content['height'] = isset($template->original) ? $template->original->size->high->height : null;
        $template_content['previewImage'] = $template->previewImage->value;
        $template_content['backgroundColor'] = isset($template->backgroundColor->color) ? $template->backgroundColor->color : null;
        $template_content['category'] = isset($template->category) ? $template->category : null;

        foreach ($template->text as $text_node) {
            // print_r( $text_node );
            // exit;

            $node = [
                'text' => $text_node->contents,
                'x' => ceil($text_node->x / 3.125),
                'y' => ceil($text_node->y / 3.125),
                'color' => $text_node->color,
                'width' => ceil($text_node->width / 3.125),
                'height' => ceil($text_node->height / 3.125),
                'font' => $text_node->font,
                'fontFamily' => $text_node->fontFamily,
                'fontSize' => ceil($text_node->fontSize / 3.125),
                'opacity' => $text_node->opacity,
                'allowedFonts' => $text_node->allowedFonts,
                // 'x' => $text_node->x,
                // 'y' => $text_node->y,
            ];

            $template_content['text'][] = $node;

        }
        
        foreach ($template->graphic as $node) {
            
            // if( isset( $node->type ) && $node->type == 'Folder' ){
                $tmp_node = [
                    'opacity' => $node->opacity,
                    // 'x' => $text_node->x,
                    // 'y' => $text_node->y,
                    'width' => $node->width,
                    'height' => $node->height,
                    'color' => $node->color            
                ];

                // print_r($node);
                // exit;
                if( isset($node->layers) 
                    && is_array($node->layers) 
                    && sizeof($node->layers) > 0 ){
                        
                    foreach ($node->layers as $layer) {
                        
                        // if(isset($layer->assetType) && $layer->assetType == 'image'){
                            
                            if(isset($layer->path) && strpos($layer->path, 'imagedocument') > 0 ){
                                $layer->path = str_replace('small', 'medium', $layer->image);
                                $json_structure = self::downloadStructureJSON( $layer->id );
                                
                                self::parseStructure( $layer->id, $json_structure);
                                $structure_images = json_decode(Redis::get('placeit:tmp:structure'));
                                Redis::del('placeit:tmp:structure');
                                
                                if( isset( $structure_images->images ) ){
                                    foreach ($structure_images->images as $image) {
                                        $template_content['images'][] = $image;
                                    }
                                }
                            }

                            $tmp_obj = new \stdClass();
                            $tmp_obj->name = isset($layer->name) ? $layer->name : null;
                            $tmp_obj->image = $layer->image;
                            $tmp_obj->path = isset($layer->path) ? $layer->path : null;
                            $tmp_obj->originalFile = isset($layer->originalFile) ? $layer->originalFile : 'no name';
                            $tmp_obj->id = $layer->id;
                            // $tmp_obj->/'src' = $layer->src
                            $template_content['images'][] = $tmp_obj;
                        // }
                    }
                }
                // $template_content['images'][] = $node;
            // }
            // print_r($template_content);
            // exit;

        }
        
        foreach ($template->background as $node) {
            // print_r( $text_node );
            // exit;
            // if( isset( $node->type ) && $node->type == 'Folder' ){
                $tmp_node = [
                    'color' => $node->color,
                    'contents' => $node->contents
                ];

                // print_r($node);
                // exit;
                if( isset($node->layers) 
                    && is_array($node->layers) 
                    && sizeof($node->layers) > 0 ){
                        
                    foreach ($node->layers as $layer) {
                        if(isset($layer->assetType) && $layer->assetType == 'image'){
                            $tmp_obj = new \stdClass();
                            
                            $tmp_obj->name = $layer->name;
                            $tmp_obj->image = $layer->image;
                            $tmp_obj->path = $layer->path;
                            $tmp_obj->originalFile = isset($layer->originalFile) ? $layer->originalFile : '';
                            // $tmp_obj->/'src' = $layer->sr;
                            $template_content['images'][] = $tmp_obj;
                            
                        }
                    }
                }
                // $template_content['images'][] = $node;
            // }

        }

        // print_r($template);

        return $template_content;
    }

    function parseStructure( $parent_id, $parent_layer ){
        
        $tmp = json_decode(Redis::get('placeit:tmp:structure'));
        
        if( isset($tmp->parent_id) == false ){
            $tmp = new \stdClass();
            $tmp->parent_id = $parent_id;
            
            // print_r($tmp->parent_id);
            // exit; 

            Redis::set('placeit:tmp:structure', json_encode($tmp) );
        }

        if( isset( $parent_layer->image ) && strlen($parent_layer->image) > 0 ){
            $img_obj = new \stdClass();
            $img_obj->name = $parent_layer->name;
            $img_obj->image = $parent_layer->image;
            $img_obj->path = $parent_layer->image;
            $img_obj->url = 'https://nice-assets-2.s3-accelerate.amazonaws.com/image_library/'.$tmp->parent_id.'/'.$parent_layer->image;
            $img_obj->originalFile = 'https://nice-assets-2.s3-accelerate.amazonaws.com/image_library/'.$tmp->parent_id.'/'.$parent_layer->image;
            $img_obj->id = $parent_layer->id;

            $tmp->images[] = $img_obj;
            
            Redis::set('placeit:tmp:structure', json_encode($tmp) );
        }

        // print_r($tmp);
        // exit;


        if( isset($parent_layer->layers) && is_array($parent_layer->layers) && sizeof($parent_layer->layers) > 0 ){
            foreach ($parent_layer->layers as $layer) {
                self::parseStructure( $tmp->parent_id,  $layer );
            }
        }

        
    }

    function downloadStructureJSON( $structure_id ){

        if( Redis::exists('placeit:template:'.$structure_id.':structure') == false ){

            $structure_url = 'https://nice-assets-2.s3-accelerate.amazonaws.com/image_library/'.$structure_id.'/structure.json';

            $curl = curl_init();
        
            curl_setopt_array($curl, array(
                CURLOPT_URL => $structure_url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
            ));
        
            $response = curl_exec($curl);
    
            Redis::set('placeit:template:'.$structure_id.':structure', $response);
    
            curl_close($curl);

            // print_r("\n");
            // print_r($response);
            // exit;
        
        }

        return json_decode(Redis::get('placeit:template:'.$structure_id.':structure'));
        
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

    function transformToImgObj($new_template_id, $base_img_obj, $file_name){
        
        $tmp_obj = new \StdClass;;
        $tmp_obj = clone($base_img_obj);
        
        // $img_path = public_path( str_replace('http://localhost:8001/', null, $file_name) );
        // print_r($tmp_obj );
        // print_r($img_obj );
        // exit;

        $tmp_obj->originX = 'left';
        $tmp_obj->originY = 'top';
        // $tmp_obj->top = ceil( $img_obj->y / 3.125 );
        // $tmp_obj->left = ceil( $img_obj->x / 3.125 );
        $tmp_obj->top = 0;
        $tmp_obj->left = 0;
        
        $tmp_obj->scaleX = 0.1528156055;
        $tmp_obj->scaleY = 0.1528156055;

        // $path_info = pathinfo($img_obj->url);
        $img_path = public_path('/design/template/'.$new_template_id.'/assets/'.$file_name);

        if( file_exists($img_path) && filesize($img_path) > 0) {
            $path = $img_path;
            $extension = pathinfo($path, PATHINFO_EXTENSION);
            
            if($extension == 'svg' OR $extension == 'png' OR $extension == 'jpg' OR $extension == 'jpeg' OR $extension == 'gif'){
                list($width, $height, $type, $attr) = getimagesize($img_path);
                
                // print_r(getimagesize($img_path));
                // exit;

                if( $extension != 'svg' ){
                    $tmp_obj->width = $width;
                    $tmp_obj->height = $height;
                    $tmp_obj->src = asset('design/template/'.$new_template_id.'/assets/'.$file_name);
                } else {
                    $tmp_obj->width = 50;
                    $tmp_obj->height = 50;
                    $tmp_obj->src = asset('design/template/'.$new_template_id.'/assets/'.$file_name);
                }
                    
                // print_r($type);
                // print_r($img_path);
                // return $tmp_obj;
                // exit;

            } else {
                // print_r('UNKWNON EXTENSION >>'.$extension);
                // exit;
                return null;
            }
        } else {
            return null;
        }

    }
   
}
