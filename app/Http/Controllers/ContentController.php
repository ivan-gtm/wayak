<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Template;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

// ini_set("max_execution_time", 0);   // no time-outs!
// ini_set("request_terminate_timeout", 2000);   // no time-outs!
// ini_set('memory_limit', -1);
// ini_set('display_errors', 1);

// ignore_user_abort(true);            // Continue downloading even after user closes the browser.
// error_reporting(E_ALL);


class ContentController extends Controller
{
    
    public function showHome(Request $request) {
        $country = 'us';
        $language_code = 'en';

        $search_result = Template::where('title', 'like', '%baby shower%')
            ->where('width','=','5')
            ->where('height','=','7')
            ->take(40)
            ->get([
                'title',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'previewImageUrls'
            ]);

        $carousels[] = [
            'slider_id' => Str::random(5),
            'title' => 'Templates for "Baby shower"',
            'items' => $search_result
        ];

        $search_result = Template::where('title', 'like', '%unicorn%')
            ->where('width','=','5')
            ->where('height','=','7')
            ->take(40)
            ->get([
                'title',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'previewImageUrls'
            ]);

        $carousels[] = [
            'slider_id' => Str::random(5),
            'title' => 'Unicorn',
            'items' => $search_result
        ];

        $search_result = Template::where('title', 'like', '%save the date%')
            ->where('width','=','5')
            ->where('height','=','7')
            ->take(40)
            ->get([
                'title',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'previewImageUrls'
            ]);

        $carousels[] = [
            'slider_id' => Str::random(5),
            'title' => 'Templates for "Wedding Invitations"',
            'items' => $search_result
        ];

        $search_result = Template::where('title', 'like', '%floral%wedding%invitation%')
            ->where('width','=','5')
            ->where('height','=','7')
            ->take(40)
            ->get([
                'title',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'previewImageUrls'
            ]);

        $carousels[] = [
            'slider_id' => Str::random(5),
            'title' => 'Templates for "Wedding Invitations"',
            'items' => $search_result
        ];

        $search_result = Template::where('title', 'like', '%birthday%')
            ->where('width','=','5')
            ->where('height','=','7')
            ->take(40)
            ->get([
                'title',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'previewImageUrls'
            ]);

        $carousels[] = [
            'slider_id' => Str::random(5),
            'title' => 'Birthday Invitation Templates',
            'items' => $search_result
        ];

        $search_result = Template::where('title', 'like', '%glitter%')
            ->where('width','=','5')
            ->where('height','=','7')
            ->take(40)
            ->get([
                'title',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'previewImageUrls'
            ]);

        $carousels[] = [
            'slider_id' => Str::random(5),
            'title' => 'Glitter',
            'items' => $search_result
        ];
        
        $search_result = Template::where('title', 'like', '%tropical%')
            ->where('width','=','5')
            ->where('height','=','7')
            ->take(40)
            ->get([
                'title',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'previewImageUrls'
            ]);

        $carousels[] = [
            'slider_id' => Str::random(5),
            'title' => 'Tropical',
            'items' => $search_result
        ];
        
        // echo "<pre>";
        // print_r($carousels);
        // exit;
        
        return view('content.home',[
            'language_code' => $language_code,
            'country' => $country,
            'carousels' => $carousels
        ]);
    }

    public function showCategoryPage($country, $category_slug){
        return view('content.category',[]);
    }

    public function showCreatePage($country){
        return view('content.create',[]);
    }

    public function showTemplatePage($country, $template_id, $slug){
        $language_code = 'en';
        $template = Template::where('_id','=',$template_id)
            ->first([
                'title',
                'format',
                'category',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'measureUnits',
                'createdAt',
                'updatedAt'
            ]);
        
        // echo "<pre>";
        // print_r($template->previewImageUrls);
        // exit;

        // return view('content.template',[]);
        return view('content.product-detail',[
            'country' => $country,
            'language_code' => $language_code,
            'template' => $template
        ]);
    }

    public function showSearchPage($country, Request $request){
        $language_code = 'en';
        $search_query = '';
        
        $page = 1;
        $per_page = 100;
        $skip = 0;

        if( isset($request->searchQuery) ) {
            $search_query = $request->searchQuery;
            // print_r($search_query);
            // exit;
        }

        if( isset($request->page) ) {
            // print_r($page);
            // exit;
            $page = $request->page;
            $skip = $per_page*($page-1);
        }

        $search_result = Template::where('title', 'like', '%'.$search_query.'%')
            ->skip($skip)
            ->take($per_page)
            ->get([
                'title',
                'forSubscribers',
                // 'category',
                // 'categoryCaption',
                'previewImageUrls'
            ]);
        
        $total_documents = Template::where('title', 'like', '%'.$search_query.'%')->count();
        $from_document = $skip + 1;
        $to_document = $skip + $per_page;
        // echo $total_documents;
        // exit;

        return view('content.search',[
            'country' => $country,
            'language_code' => $language_code,
            'search_query' => $search_query,
            'page' => $page,
            'from_document' => $from_document,
            'to_document' => $to_document,
            'total_documents' => $total_documents,
            'templates' => $search_result
        ]);
    }

    // <section class="BDy6Jg"><div class="pit87w"><div class="y4wxNQ"><section class="_sBzQQ"><div class="T7H5hQ"><div class="_2W3o4A"><h2 class="jaapjw l864gg wp6-yg fP4ZCw _5Ob-nQ I-IZwQ"><span class="_17xc5g">Browse by category</span></h2></div></div><div class="wQhSMw"><div class="CqomjA"><span id="__a11yId18"></span><div class="FmtbLQ TfRV3Q _252raA"><p class="mJlaGw l864gg fFOiLQ fP4ZCw _2xcaIA _5Ob-nQ I-IZwQ"><a class="ovm4pQ" href="#__a11yId19" draggable="false"><span class="N00Reg">Skip to end of carousel</span></a></p></div><div class="Sn2Zbw"><button class="B2M-bQ VMaH7A JSiJJw _4aHkYA" aria-controls="__a11yId20" aria-label="Previous" type="button"><span aria-hidden="true" class="VT64Ng NA_Img dkWypw lmfTqA"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15.45 17.97L9.5 12.01a.25.25 0 0 1 0-.36l5.87-5.87a.75.75 0 0 0-1.06-1.06l-5.87 5.87c-.69.68-.69 1.8 0 2.48l5.96 5.96a.75.75 0 0 0 1.06-1.06z"></path></svg></span></button><div id="__a11yId20" class="biBQjw _Ap-nw xSP9mQ"><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/posters/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Posters</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/logos/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Logos</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/presentations/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Presentations</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/videos/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Videos</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/flyers/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Flyers</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/cards/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Cards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/zoom-virtual-backgrounds/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Zoom Virtual Backgrounds</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/infographics/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Infographics</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/business-cards/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Business Cards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/t-shirts/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">T-Shirts</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/instagram-stories/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Instagram Stories</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/resumes/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Resumes</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/brochures/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Brochures</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/invitations/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Invitations</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/desktop-wallpapers/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Desktop Wallpapers</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/book-covers/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Book Covers</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/certificates/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Certificates</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/menus/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Menus</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/letterheads/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Letterheads</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/cd-covers/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">CD Covers</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/magazine-covers/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Magazine Covers</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/id-cards/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">ID Cards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/newsletters/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Newsletters</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/calendars/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Calendars</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/social-graphics/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Social Graphics</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/photo-collages/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Photo Collages</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/postcards/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Postcards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/labels/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Labels</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/announcements/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Announcements</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/storyboards/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Storyboards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/gift-certificates/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Gift Certificates</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/tags/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Tags</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/programs/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Programs</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/tickets/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Tickets</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/bookmarks/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Bookmarks</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/class-schedules/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Class Schedules</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/coupons/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Coupons</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/reports/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Reports</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/proposals/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Proposals</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/media-kits/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Media Kits</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/worksheets/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Worksheets</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/invoice/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Invoices</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/recipe-cards/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Recipe Cards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/rack-cards/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Rack Cards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/planners/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Planners</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/report-cards/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Report Cards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/letters/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Letters</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/lesson-plans/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Lesson Plans</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/web-banners/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Web Banners</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/web-ads/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Web Ads</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/websites/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Websites</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/checklists/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Checklists</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/memos/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Memos</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/table-of-contents/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Table Of Contents</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/twitter/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Twitter</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/facebook-stories/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Facebook Stories</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/online-whiteboard/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Online Whiteboards</div></a></div><div class="Icpd8A oSwifg Q1eo8w wOTC_g"><a class="aiE6Dw" href="/memes/templates/" draggable="false"><div class="mJlaGw l864gg fFOiLQ fP4ZCw _5Ob-nQ I-IZwQ Tl-v-Q">Memes</div></a></div></div></div><div class="FmtbLQ TfRV3Q _252raA"><p class="mJlaGw l864gg fFOiLQ fP4ZCw _2xcaIA _5Ob-nQ I-IZwQ"><a class="ovm4pQ" href="#__a11yId18" draggable="false"><span class="N00Reg">Skip to start of carousel</span></a></p></div><span id="__a11yId19"></span></div></div></section></div></div></section>
}
