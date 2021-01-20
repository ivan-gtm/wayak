<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Template;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

ini_set("max_execution_time", 0);   // no time-outs!
ini_set("request_terminate_timeout", 2000);   // no time-outs!
ini_set('memory_limit', -1);
ini_set('display_errors', 1);

ignore_user_abort(true);            // Continue downloading even after user closes the browser.
error_reporting(E_ALL);


class ContentController extends Controller
{
    
    public function showHome() {
        $certain_templates = Template::whereIn('_id', [
            "3952688",
            "5502933",
            "2302240",
            "2302364"
        ])->get();

        echo "<pre>";
        print_r($certain_templates);
        exit;

        // $search_result = Template::where('title', 'like', '%tag%')
        //     ->skip(0)
        //     ->take(50)
        //     ->get([
        //         'title',
        //         'format',
        //         'width',
        //         'height',
        //         'measureUnits',
        //         'forSubscribers',
        //         'category',
        //         'categoryCaption',
        //         'previewImageUrls',
        //     ]);

        
        
        // // echo "<pre>";
        // // print_r( Redis::get('crello:search:results:page:115') );
        // // exit;

        // // {
        // //     id: "5db98076abc8ea6d1c716500",
        // //     format: "Full HD video",
        // //     group: "AN",
        // //     itemsCount: 1,
        // //     width: 1920,
        // //     height: 1080,
        // //     itemType: "templateElement",
        // //     subType: "animated",
        // //     premium: true,
        // //     previewImageUrls: [
        // //     "/common/3dff7461-1e84-4874-9de7-f4ddf63e1967.jpg"
        // //     ],
        // //     categories: [
        // //     "educationScience"
        // //     ],
        // //     title: "Education Courses Woman Holding Book",
        // //     previewVideoUrl: "/video-convert/b239a357-1b72-4157-82c4-f20da6b8c04c.mp4"
        // // }

        // foreach ($search_result as $template) {
        //     echo "ID >>".$template->_id."<br>";
        //     echo "TITLE >>".$template->title."<br>";
        //     echo "TITLE_ >>";
        //     print_r( $template->title_ );
        //     echo "<hr>";
        // }
        // // echo "<pre>";
        // // print_r($search_result);
        // exit;

        $source_templates = DB::table('templates')
            // ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('tmp_etsy_metadata', 'tmp_etsy_metadata.id', '=', 'templates.fk_etsy_template_id')
            ->join('thumbnails', 'thumbnails.template_id', '=', 'templates.template_id')
            ->where('thumbnails.language_code','=','en')
            ->where('templates.status','=',5)
            ->whereNotNull('templates.fk_etsy_template_id')
            ->select('templates.template_id', 'templates.width', 'templates.height','templates.metrics','tmp_etsy_metadata.title','tmp_etsy_metadata.username','thumbnails.filename','thumbnails.title as title_','thumbnails.dimentions')
            ->get();

        echo "<pre>";
        foreach ($source_templates as $db_template) {
            // print_r($db_template);
            $dimentions = $db_template->dimentions;
            $dimentions = trim(str_replace($db_template->metrics, null, $db_template->dimentions));
            $dimentions = explode('x', $dimentions);

            if( Template::where("_id",'=', $db_template->template_id )->count() == 0 ){
                echo $db_template->template_id.'<br>';
                
                $template = new Template;
                $template->_id = $db_template->template_id;
                $template->title = $db_template->title .'-'. $db_template->title_;
                $template->category = "Party Invitations";
                $template->categoryCaption = "partyInvitations";
                $template->status = "completed";
                $template->format = "Invitation";
                $template->templateType = "regular";
                $template->measureUnits = trim($db_template->metrics);
                $template->width = trim($dimentions[0]);
                $template->height = trim($dimentions[1]);
                $template->group = null;
                $template->language = "en";
                $template->forSubscribers = false;
                $template->hasAnimatedPreview = false;
                $template->hasAnimatedScreenPreview = false;
                $template->downloadUrl = null;
                $template->name = null;
                $template->folder = null;
                $template->pixelWidth = null;
                $template->pixelHeight = null;
                $template->hash = null;
                $template->studioName = $db_template->username;
                $template->createdAt = 1560162764361;
                $template->updatedAt = 1598402668055;
                $template->acceptedAt = 1571737232366;
                $template->attributedAt = 1582635551101;
                $template->template = [];
                $template->driveFileIds = [];
                $template->previewImageUrls = [
                    $db_template->filename
                ];
                $template->suitability = [
                    "web"
                ];
                $template->keywords = [
                    "en" => [
                        "invitation"
                    ]
                ];
                $template->industries = [
                ];
                $template->languages = [
                    "en"
                ];
                $template->localizedTitle = [
                    "en" => $template->title
                ];
                $template->userState = [
                    "purchased" => false,
                    "collected" => false
                ];
        
                $template->save();
            }

            // exit;
        }

        // echo "<pre>";
        // print_r($source_template);
        exit;
        // phpinfo();
        // exit;
        $templates = Template::all();
        
        echo "<pre>";
        print_r( Template::where("_id",'=',"5cfe31cc8cba87f943e4a6cf")->count() );
        exit;

        // print_r( Redis::get('crello:template:5cfe31cc8cba87f943e4a6cf') );
        // print_r( Redis::get('laravel_database_green:categories') );
        // print_r( Redis::get('laravel_database_green:product_metadata:17763') );
        // print_r( Redis::get('over:category:39:offset:600') );
        // print_r( Redis::get('laravel_database_green:categories:356:page:2') );
        // print_r( Templates::count() );
        
        // "crello:search:results:page:129"
        // print_r( Redis::get('crello:search:results:page:115') );
        // print_r( Redis::get('crello:search:results:url:6:page:23') );
        
        // print_r( Redis::get('crello:template:5cfe31cc8cba87f943e4a6cf') );
        print_r(json_encode($template));

        /*
        {
            id: "5cfe31cc8cba87f943e4a6cf",
            format: "Instagram",
            group: "SM",
            itemsCount: 1,
            width: 1080,
            height: 1080,
            itemType: "templateElement",
            subType: "regular",
            premium: true,
            previewImageUrls: [
            "/common/5cbfc1b7-453e-4c84-9b2f-a9f65bf429a6.jpg"
            ],
            categories: [
            "fashionStyle"
            ],
            title: "Summer Offer with Couple at the Beach"
        }
        */
        exit;

        // $flight = new Flight;
        // $flight->name = $request->name;
        // $flight->save();

        foreach (Templates::all() as $template) {
            print_r($template->glossary['title']);
        }
        exit;

        return view('content.home',[]);
    }

    public function migrateToMongo(){
        /*
        {
            
        }
        */
    }

    public function showCategoryPage($country, $category_slug){
        return view('content.category',[]);
    }

    public function showCreatePage($country, $category_slug){
        return view('content.create',[]);
    }

    public function showTemplatePage($country, $template_id, $slug){
        return view('content.template',[]);
    }

    public function showSearchPage($country){
        $language_code = 'en';

        $search_result = Template::where('title', 'like', '%wedding%')
            // ->skip(0)
            ->take(100)
            ->get([
                'title',
                'format',
                'width',
                'height',
                'measureUnits',
                'forSubscribers',
                'category',
                'categoryCaption',
                'previewImageUrls',
            ]);

        return view('content.search',[
            'language_code' => $language_code,
            'templates' => $search_result
        ]);
    }

    // <section class="BDy6Jg"><div class="pit87w"><div class="y4wxNQ"><section class="_sBzQQ"><div class="T7H5hQ"><div class="_2W3o4A"><h2 class="jaapjw l864gg wp6-yg fP4ZCw _5Ob-nQ I-IZwQ"><span class="_17xc5g">Browse by category</span></h2></div></div><div class="wQhSMw"><div class="CqomjA"><span id="__a11yId18"></span><div class="FmtbLQ TfRV3Q _252raA"><p class="mJlaGw l864gg fFOiLQ fP4ZCw _2xcaIA _5Ob-nQ I-IZwQ"><a class="ovm4pQ" href="#__a11yId19" draggable="false"><span class="N00Reg">Skip to end of carousel</span></a></p></div><div class="Sn2Zbw"><button class="B2M-bQ VMaH7A JSiJJw _4aHkYA" aria-controls="__a11yId20" aria-label="Previous" type="button"><span aria-hidden="true" class="VT64Ng NA_Img dkWypw lmfTqA"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15.45 17.97L9.5 12.01a.25.25 0 0 1 0-.36l5.87-5.87a.75.75 0 0 0-1.06-1.06l-5.87 5.87c-.69.68-.69 1.8 0 2.48l5.96 5.96a.75.75 0 0 0 1.06-1.06z"></path></svg></span></button><div id="__a11yId20" class="biBQjw _Ap-nw xSP9mQ"><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/posters/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Posters</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/logos/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Logos</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/presentations/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Presentations</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/videos/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Videos</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/flyers/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Flyers</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/cards/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Cards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/zoom-virtual-backgrounds/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Zoom Virtual Backgrounds</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/infographics/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Infographics</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/business-cards/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Business Cards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/t-shirts/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">T-Shirts</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/instagram-stories/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Instagram Stories</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/resumes/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Resumes</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/brochures/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Brochures</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/invitations/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Invitations</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/desktop-wallpapers/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Desktop Wallpapers</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/book-covers/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Book Covers</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/certificates/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Certificates</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/menus/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Menus</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/letterheads/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Letterheads</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/cd-covers/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">CD Covers</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/magazine-covers/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Magazine Covers</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/id-cards/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">ID Cards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/newsletters/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Newsletters</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/calendars/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Calendars</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/social-graphics/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Social Graphics</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/photo-collages/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Photo Collages</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/postcards/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Postcards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/labels/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Labels</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/announcements/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Announcements</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/storyboards/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Storyboards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/gift-certificates/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Gift Certificates</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/tags/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Tags</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/programs/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Programs</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/tickets/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Tickets</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/bookmarks/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Bookmarks</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/class-schedules/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Class Schedules</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/coupons/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Coupons</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/reports/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Reports</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/proposals/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Proposals</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/media-kits/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Media Kits</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/worksheets/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Worksheets</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/invoice/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Invoices</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/recipe-cards/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Recipe Cards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/rack-cards/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Rack Cards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/planners/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Planners</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/report-cards/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Report Cards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/letters/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Letters</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/lesson-plans/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Lesson Plans</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/web-banners/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Web Banners</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/web-ads/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Web Ads</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/websites/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Websites</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/checklists/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Checklists</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/memos/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Memos</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/table-of-contents/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Table Of Contents</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/twitter/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Twitter</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/facebook-stories/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Facebook Stories</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/online-whiteboard/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Online Whiteboards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/memes/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Memes</div></a></div></div></div><div class="FmtbLQ TfRV3Q _252raA"><p class="mJlaGw l864gg fFOiLQ fP4ZCw _2xcaIA _5Ob-nQ I-IZwQ"><a class="ovm4pQ" href="#__a11yId18" draggable="false"><span class="N00Reg">Skip to start of carousel</span></a></p></div><span id="__a11yId19"></span></div></div></section></div></div></section>
}
