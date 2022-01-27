<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;

use SVG\SVG;
// use Image;
// use Intervention\Image\ImageManagerStatic as Image;

use SVG\Nodes\Shapes\SVGCircle;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Barryvdh\DomPDF\Facade as PDF;
use Image;

// use Intervention\Image;
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


// use App\Exports\MercadoLibreExport;
// use Maatwebsite\Excel\Facades\Excel;

// ini_set('memory_limit', -1);
// ini_set("max_execution_time", 0);   // no time-outs!
// ignore_user_abort(true);            // Continue downloading even after user closes the browser.

// error_reporting(E_ALL);
// ini_set('display_errors', 1);


class CategoryController extends Controller
{
    function manage_wayak_cats(){
        $categories = '
            https://wayak.app/us/templates/instagram-stories/
            https://wayak.app/us/templates/instagram-posts/
            https://wayak.app/us/templates/facebook-posts/
            https://wayak.app/us/templates/facebook-covers/
            https://wayak.app/us/templates/youtube-channel-art/
            https://wayak.app/us/templates/linkedin-banners/
            https://wayak.app/us/templates/invitations/
            https://wayak.app/us/templates/cards/
            https://wayak.app/us/templates/resumes/
            https://wayak.app/us/templates/postcards/
            https://wayak.app/us/templates/planners/weekly-schedule/
            https://wayak.app/us/templates/t-shirts/
            https://wayak.app/us/templates/presentations/
            https://wayak.app/us/templates/websites/
            https://wayak.app/us/templates/logos/
            https://wayak.app/us/templates/business-cards/
            https://wayak.app/us/templates/invoice/
            https://wayak.app/us/templates/business/letterheads
            https://wayak.app/us/templates/posters/
            https://wayak.app/us/templates/flyers/
            https://wayak.app/us/templates/infographics/
            https://wayak.app/us/templates/brochures/
            https://wayak.app/us/templates/newsletters/
            https://wayak.app/us/templates/proposals/
            https://wayak.app/us/templates/lesson-plans/
            https://wayak.app/us/templates/worksheets/
            https://wayak.app/us/templates/certificates/
            https://wayak.app/us/templates/storyboards/
            https://wayak.app/us/templates/bookmarks/
            https://wayak.app/us/templates/class-schedules/
            https://wayak.app/us/templates/gift/tags
            https://wayak.app/us/templates/christmas/gift-certificates
            https://wayak.app/us/templates/youtube-intros/
            https://wayak.app/us/templates/photo-books/
            https://wayak.app/us/templates/mugs/
            https://wayak.app/us/templates/christmas-cards/
            https://wayak.app/us/templates/baby-shower-invitations/
            https://wayak.app/us/templates/brochures/
            https://wayak.app/us/templates/business-cards/
            https://wayak.app/us/templates/calendars/
            https://wayak.app/us/templates/christmas-cards/
            https://wayak.app/us/templates/facebook/
            https://wayak.app/us/templates/flyers/
            https://wayak.app/us/templates/instagram/
            https://wayak.app/us/templates/invitations/
            https://wayak.app/us/templates/labels/
            https://wayak.app/us/templates/letterheads/
            https://wayak.app/us/templates/logos/
            https://wayak.app/us/templates/menus/
            https://wayak.app/us/templates/photo-collages/
            https://wayak.app/us/templates/planners/
            https://wayak.app/us/templates/posters/
            https://wayak.app/us/templates/presentations/
            https://wayak.app/us/templates/resumes/
            https://wayak.app/us/templates/thank-you-cards/
            https://wayak.app/us/templates/twitter/
            https://wayak.app/us/templates/wedding-invitations/
            https://wayak.app/us/templates/youtube/
            https://wayak.app/us/templates/logos/">Logos</a></span></li>
            https://wayak.app/us/templates/posters/">Posters</a></span></li>
            https://wayak.app/us/templates/business-cards/">Business Cards</a></span></li>
            https://wayak.app/us/templates/flyers/">Flyers</a></span></li>
            https://wayak.app/us/templates/resumes/">Resumes</a></span></li>
            https://wayak.app/us/templates/presentations/">Presentations</a></span></li>
            https://wayak.app/us/templates/create/">Design Types</a></span></li>
            https://wayak.app/us/templates/templates/">Templates</a></span></li>
            https://wayak.app/us/templates/graphs/">Graphs &amp; Charts</a></span></li>
            https://wayak.app/us/templates/features/">Photo Editing</a></span></li>
            
            https://wayak.app/us/templates/bingo-cards/">Bingo Cards</a></li>
            https://wayak.app/us/templates/facebook-ads/">Facebook Ads</a></li>
            https://wayak.app/us/templates/facebook-covers/">Facebook Cover</a></li>
            https://wayak.app/us/templates/facebook-event-covers/">Facebook Events</a></li>
            https://wayak.app/us/templates/facebook-stories/">Facebook Stories</a></li>
            https://wayak.app/us/templates/instagram-stories/">Instagram Stories</a></li>
            https://wayak.app/us/templates/memes/">Meme Generator</a></li>
            https://wayak.app/us/templates/snapchat-geofilters/">Snapchat Geofilters</a></li>
            https://wayak.app/us/templates/tumblr-graphics/">Tumblr Graphics</a></li>
            https://wayak.app/us/templates/twitter-headers/">Twitter Header</a></li>
            https://wayak.app/us/templates/video-intros/">Video intros</a></li>
            https://wayak.app/us/templates/video-outros/">Video outros</a></li>
            https://wayak.app/us/templates/videos/">Videos</a></li>
            https://wayak.app/us/templates/whatsapp-status/">Whatsapp Status</a></li>
            https://wayak.app/us/templates/youtube-thumbnails/">YouTube Thumbnail</a></li>
            https://wayak.app/us/templates/announcements/">Announcements</a></li>
            https://wayak.app/us/templates/calendars/">Calendars</a></li>
            https://wayak.app/us/templates/cards/">Cards</a></li>
            https://wayak.app/us/templates/checklists/">Checklists</a></li>
            https://wayak.app/us/templates/daily-planners/">Daily Planners</a></li>
            https://wayak.app/us/templates/ecards/">e-Cards</a></li>
            https://wayak.app/us/templates/eid-al-fitr-cards/">Eid al-Fitr Cards</a></li>
            https://wayak.app/us/templates/id-cards/">ID Cards</a></li>
            https://wayak.app/us/templates/mood-boards/">Mood Boards</a></li>
            https://wayak.app/us/templates/online-thank-card/">Online Thank You Card</a></li>
            https://wayak.app/us/templates/personal-planners/">Personal Planners</a></li>
            https://wayak.app/us/templates/place-cards/">Place Cards</a></li>
            https://wayak.app/us/templates/same-sex-wedding-invitations/">Same Sex Wedding Invitations</a></li>
            https://wayak.app/us/templates/wedding-invitation-kits/">Wedding Invitation Kits</a></li>
            https://wayak.app/us/templates/wedding-programs/">Wedding Programs</a></li>
            https://wayak.app/us/templates/wedding-seating-charts/">Wedding Seating Charts</a></li>
            https://wayak.app/us/templates/business-cards/">Business cards</a></li>
            https://wayak.app/us/templates/invoices/">Invoices</a></li>
            https://wayak.app/us/templates/letterheads/">Letterheads</a></li>
            https://wayak.app/us/templates/logos/">Logos</a></li>
            https://wayak.app/us/templates/magazine-covers/">Magazine Covers</a></li>
            https://wayak.app/us/templates/media-kits/">Media Kits</a></li>
            https://wayak.app/us/templates/memos/">Memos</a></li>
            https://wayak.app/us/templates/powerpoint-alternative/">Powerpoint Alternative</a></li>
            https://wayak.app/us/templates/presentations/">Presentations</a></li>
            https://wayak.app/us/templates/proposals/">Proposals</a></li>
            https://wayak.app/us/templates/reports/">Reports</a></li>
            https://wayak.app/us/templates/resumes/">Resumes</a></li>
            https://wayak.app/us/templates/zoom-virtual-background/">Zoom virtual background</a></li>
            https://wayak.app/us/templates/banners/">Banners</a></li>
            https://wayak.app/us/templates/brochures/">Brochures</a></li>
            https://wayak.app/us/templates/coupons/">Coupons</a></li>
            https://wayak.app/us/templates/email-headers/">Email Header</a></li>
            https://wayak.app/us/templates/event-programs/">Event Programs</a></li>
            https://wayak.app/us/templates/flyers/">Flyers</a></li>
            https://wayak.app/us/templates/labels/">Labels</a></li>
            https://wayak.app/us/templates/newsletters/">Newsletters</a></li>
            https://wayak.app/us/templates/pamphlets/">Pamphlets</a></li>
            https://wayak.app/us/templates/posters/">Posters</a></li>
            https://wayak.app/us/templates/rack-cards/">Rack Cards</a></li>
            https://wayak.app/us/templates/restaurant-menus/">Restaurant Menu</a></li>
            https://wayak.app/us/templates/table-of-contents/">Table of Contents</a></li>
            https://wayak.app/us/templates/art-lesson-plans/">Art Lesson Plans</a></li>
            https://wayak.app/us/templates/bookmarks/">Bookmarks</a></li>
            https://wayak.app/us/templates/certificates/">Certificates</a></li>
            https://wayak.app/us/templates/class-schedules/">Class Schedules</a></li>
            https://wayak.app/us/templates/flashcards/">Flashcards</a></li>
            https://wayak.app/us/templates/infographics/">Infographics</a></li>
            https://wayak.app/us/templates/lesson-plans/">Lesson Plans</a></li>
            https://wayak.app/us/templates/math-lesson-plans/">Math Lesson Plans</a></li>
            https://wayak.app/us/templates/name-tags/">Name Tags</a></li>
            https://wayak.app/us/templates/report-cards/">Report Cards</a></li>
            https://wayak.app/us/templates/science-lesson-plans/">Science Lesson Plans</a></li>
            https://wayak.app/us/templates/social-studies-lesson-plans/">Social Studies Lesson Plans</a></li>
            https://wayak.app/us/templates/toddler-lesson-plans/">Toddler Lesson Plans</a></li>
            https://wayak.app/us/templates/weekly-lesson-plans/">Weekly Lesson Plans</a></li>
            https://wayak.app/us/templates/weekly-schedules/">Weekly Schedules</a></li>
            https://wayak.app/us/templates/worksheets/">Worksheets</a></li>
            https://wayak.app/us/templates/yearbooks/">Yearbooks</a></li>
            https://wayak.app/us/templates/album-covers/">Album Covers</a></li>
            https://wayak.app/us/templates/book-covers/">Book Covers</a></li>
            https://wayak.app/us/templates/campaign-posters/">Campaign Posters</a></li>
            https://wayak.app/us/templates/christmas-tags/">Christmas Tags</a></li>
            https://wayak.app/us/templates/comic-strips/">Comic Strips</a></li>
            https://wayak.app/us/templates/email-invitations/">E-mail Invitations</a></li>
            https://wayak.app/us/templates/ebook-covers/">eBook Covers</a></li>
            https://wayak.app/us/templates/ebooks/">eBooks</a></li>
            https://wayak.app/us/templates/fashion-photo-collage/">Fashion Photo Collage</a></li>
            https://wayak.app/us/templates/gender-equality-posters/">Gender Equality Posters</a></li>
            https://wayak.app/us/templates/gift-certificates/">Gift Certificates</a></li>
            https://wayak.app/us/templates/gift-tags/">Gift Tags</a></li>
            https://wayak.app/us/templates/international-day-of-yoga-posters/">International Day of Yoga Posters</a></li>
            https://wayak.app/us/templates/love-photo-collage/">Love Photo Collage</a></li>
            https://wayak.app/us/templates/photo-books/">Photo Books</a></li>
            https://wayak.app/us/templates/photo-collages/">Photo collages</a></li>
            https://wayak.app/us/templates/postcards/">Postcards</a></li>
            https://wayak.app/us/templates/quote-graphics/">Quote Graphics Maker</a></li>
            https://wayak.app/us/templates/quote-posters/">Quote Posters</a></li>
            https://wayak.app/us/templates/recipe-cards/">Recipe Cards</a></li>
            https://wayak.app/us/templates/scrapbooks/">Scrapbooks</a></li>
            https://wayak.app/us/templates/seating-charts/">Seating Charts</a></li>
            https://wayak.app/us/templates/slideshows/">Slideshows</a></li>
            https://wayak.app/us/templates/social-media-graphics/">Social Media Graphic</a></li>
            https://wayak.app/us/templates/storyboards/">Storyboards</a></li>
            https://wayak.app/us/templates/take-your-dog-to-work-day-graphics/">Take Your Dog to Work Day Social Media Graphics</a></li>
            https://wayak.app/us/templates/tickets/">Tickets</a></li>
            https://wayak.app/us/templates/tiktok-videos/">TikTok Videos</a></li>
            https://wayak.app/us/templates/wallpapers/">Wallpapers</a></li>
            https://wayak.app/us/templates/wattpad-covers/">Wattpad Covers</a></li>
            https://wayak.app/us/templates/
            https://wayak.app/us/templates/logos/
            https://wayak.app/us/templates/bingo-cards/
            https://wayak.app/us/templates/facebook-ads/
            https://wayak.app/us/templates/facebook-covers/
            https://wayak.app/us/templates/facebook-event-covers/
            https://wayak.app/us/templates/facebook-stories/
            https://wayak.app/us/templates/instagram-stories/
            https://wayak.app/us/templates/memes/
            https://wayak.app/us/templates/snapchat-geofilters/
            https://wayak.app/us/templates/tumblr-graphics/
            https://wayak.app/us/templates/twitter-headers/
            https://wayak.app/us/templates/video-intros/
            https://wayak.app/us/templates/video-outros/
            https://wayak.app/us/templates/videos/
            https://wayak.app/us/templates/whatsapp-status/
            https://wayak.app/us/templates/youtube-thumbnails/
            https://wayak.app/us/templates/announcements/
            https://wayak.app/us/templates/calendars/
            https://wayak.app/us/templates/cards/
            https://wayak.app/us/templates/checklists/
            https://wayak.app/us/templates/daily-planners/
            https://wayak.app/us/templates/ecards/
            https://wayak.app/us/templates/eid-al-fitr-cards/
            https://wayak.app/us/templates/id-cards/
            https://wayak.app/us/templates/mood-boards/
            https://wayak.app/us/templates/online-thank-card/
            https://wayak.app/us/templates/personal-planners/
            https://wayak.app/us/templates/place-cards/
            https://wayak.app/us/templates/same-sex-wedding-invitations/
            https://wayak.app/us/templates/wedding-invitation-kits/
            https://wayak.app/us/templates/wedding-programs/
            https://wayak.app/us/templates/wedding-seating-charts/
            https://wayak.app/us/templates/business-cards/
            https://wayak.app/us/templates/invoices/
            https://wayak.app/us/templates/letterheads/
            https://wayak.app/us/templates/logos/
            https://wayak.app/us/templates/magazine-covers/
            https://wayak.app/us/templates/media-kits/
            https://wayak.app/us/templates/memos/
            https://wayak.app/us/templates/powerpoint-alternative/
            https://wayak.app/us/templates/presentations/
            https://wayak.app/us/templates/proposals/
            https://wayak.app/us/templates/reports/
            https://wayak.app/us/templates/resumes/
            https://wayak.app/us/templates/zoom-virtual-background/
            https://wayak.app/us/templates/banners/
            https://wayak.app/us/templates/brochures/
            https://wayak.app/us/templates/coupons/
            https://wayak.app/us/templates/email-headers/
            https://wayak.app/us/templates/event-programs/
            https://wayak.app/us/templates/flyers/
            https://wayak.app/us/templates/labels/
            https://wayak.app/us/templates/newsletters/
            https://wayak.app/us/templates/pamphlets/
            https://wayak.app/us/templates/posters/
            https://wayak.app/us/templates/rack-cards/
            https://wayak.app/us/templates/restaurant-menus/
            https://wayak.app/us/templates/table-of-contents/
            https://wayak.app/us/templates/art-lesson-plans/
            https://wayak.app/us/templates/bookmarks/
            https://wayak.app/us/templates/certificates/
            https://wayak.app/us/templates/class-schedules/
            https://wayak.app/us/templates/flashcards/
            https://wayak.app/us/templates/infographics/
            https://wayak.app/us/templates/lesson-plans/
            https://wayak.app/us/templates/math-lesson-plans/
            https://wayak.app/us/templates/name-tags/
            https://wayak.app/us/templates/report-cards/
            https://wayak.app/us/templates/science-lesson-plans/
            https://wayak.app/us/templates/social-studies-lesson-plans/
            https://wayak.app/us/templates/toddler-lesson-plans/
            https://wayak.app/us/templates/weekly-lesson-plans/
            https://wayak.app/us/templates/weekly-schedules/
            https://wayak.app/us/templates/worksheets/
            https://wayak.app/us/templates/yearbooks/
            https://wayak.app/us/templates/album-covers/
            https://wayak.app/us/templates/book-covers/
            https://wayak.app/us/templates/campaign-posters/
            https://wayak.app/us/templates/christmas-tags/
            https://wayak.app/us/templates/comic-strips/
            https://wayak.app/us/templates/email-invitations/
            https://wayak.app/us/templates/ebook-covers/
            https://wayak.app/us/templates/ebooks/
            https://wayak.app/us/templates/fashion-photo-collage/
            https://wayak.app/us/templates/gender-equality-posters/
            https://wayak.app/us/templates/gift-certificates/
            https://wayak.app/us/templates/gift-tags/
            https://wayak.app/us/templates/international-day-of-yoga-posters
            https://wayak.app/us/templates/love-photo-collage/
            https://wayak.app/us/templates/photo-books/
            https://wayak.app/us/templates/photo-collages/
            https://wayak.app/us/templates/postcards/
            https://wayak.app/us/templates/quote-graphics/
            https://wayak.app/us/templates/quote-posters/
            https://wayak.app/us/templates/recipe-cards/
            https://wayak.app/us/templates/scrapbooks/
            https://wayak.app/us/templates/seating-charts/
            https://wayak.app/us/templates/slideshows/
            https://wayak.app/us/templates/social-media-graphics/
            https://wayak.app/us/templates/storyboards/
            https://wayak.app/us/templates/take-your-dog-to-work
            https://wayak.app/us/templates/tickets/
            https://wayak.app/us/templates/tiktok-videos/
            https://wayak.app/us/templates/wallpapers/
            https://wayak.app/us/templates/wattpad-covers/
            https://wayak.app/us/templates/instagram-stories/
            https://wayak.app/us/templates/instagram-posts/
            https://wayak.app/us/templates/facebook-posts/
            https://wayak.app/us/templates/facebook-covers/
            https://wayak.app/us/templates/youtube-channel-art/
            https://wayak.app/us/templates/linkedin-banners/
            https://wayak.app/us/templates/invitations/
            https://wayak.app/us/templates/cards/
            https://wayak.app/us/templates/resumes/
            https://wayak.app/us/templates/postcards/
            https://wayak.app/us/templates/planners/weekly-schedule/
            https://wayak.app/us/templates/t-shirts/
            https://wayak.app/us/templates/presentations/
            https://wayak.app/us/templates/websites/
            https://wayak.app/us/templates/logos/
            https://wayak.app/us/templates/business-cards/
            https://wayak.app/us/templates/invoice/
            https://wayak.app/us/templates/business/letterheads
            https://wayak.app/us/templates/posters/
            https://wayak.app/us/templates/flyers/
            https://wayak.app/us/templates/infographics/
            https://wayak.app/us/templates/brochures/
            https://wayak.app/us/templates/newsletters/
            https://wayak.app/us/templates/proposals/
            https://wayak.app/us/templates/lesson-plans/
            https://wayak.app/us/templates/worksheets/
            https://wayak.app/us/templates/certificates/
            https://wayak.app/us/templates/storyboards/
            https://wayak.app/us/templates/bookmarks/
            https://wayak.app/us/templates/class-schedules/
            https://wayak.app/us/templates/gift/tags/
            https://wayak.app/us/templates/christmas/gift-certificates/
            https://wayak.app/us/templates/youtube-intros/
            https://wayak.app/us/templates/photo-books/
            https://wayak.app/us/templates/mugs/
            https://wayak.app/us/templates/christmas-cards/
            
            https://wayak.app/us/templates/instagram-stories/
            https://wayak.app/us/templates/instagram-posts/
            https://wayak.app/us/templates/facebook-posts/
            https://wayak.app/us/templates/facebook-covers/
            https://wayak.app/us/templates/youtube-channel-art/
            https://wayak.app/us/templates/linkedin-banners/
            https://wayak.app/us/templates/invitations/
            https://wayak.app/us/templates/cards/
            https://wayak.app/us/templates/resumes/
            https://wayak.app/us/templates/postcards/
            https://wayak.app/us/templates/planners/weekly-schedule/
            https://wayak.app/us/templates/t-shirts/
            https://wayak.app/us/templates/presentations/
            https://wayak.app/us/templates/websites/
            https://wayak.app/us/templates/logos/
            https://wayak.app/us/templates/business-cards/
            https://wayak.app/us/templates/invoice/
            https://wayak.app/us/templates/letterheads/business/
            https://wayak.app/us/templates/posters/
            https://wayak.app/us/templates/flyers/
            https://wayak.app/us/templates/infographics/
            https://wayak.app/us/templates/brochures/
            https://wayak.app/us/templates/newsletters/
            https://wayak.app/us/templates/proposals/
            https://wayak.app/us/templates/lesson-plans/
            https://wayak.app/us/templates/worksheets/
            https://wayak.app/us/templates/certificates/
            https://wayak.app/us/templates/storyboards/
            https://wayak.app/us/templates/bookmarks/
            https://wayak.app/us/templates/class-schedules/
            https://wayak.app/us/templates/tags/gift/
            https://wayak.app/us/templates/gift-certificates/christmas/
            https://wayak.app/us/templates/youtube-intros/
            https://wayak.app/us/templates/photo-books/
            https://wayak.app/us/templates/mugs/
            https://wayak.app/us/templates/cards/valentines-day/';

        preg_match_all( '#((https?|ftp)://(\S*?\.\S*?))([\s)\[\]{},;"\':<]|\.\s|$)#i', $categories, $matches);
        // echo "<pre>";
        // print_r($matches[1]);
        // exit;

        print_r("<pre>");
        $nav_menu = [];
        $slugs_index = [];

        foreach ($matches[1] as $url) {
            $slugs = str_replace('https://wayak.app/us/templates/', null, $url);
            $slugs = explode('/',$slugs);
            array_pop($slugs);
            // unset( $url[ count($url) ] );
            // print_r("\n<br>");
            // print_r($slugs);
            
            if( isset($slugs[0]) ){
                $children = [];
                
                if( isset($slugs[1]) ){
                    $children = [
                        'name' => ucwords(str_replace('-',' ', $slugs[1] )),
                        'slug' => $slugs[1],
                        'children' => []
                    ];
                }

                $category = [
                    'name' => ucwords(str_replace('-',' ', $slugs[0] )),
                    'slug' => $slugs[0]
                ];
                $category['children'][] = $children;

                $key = array_search( trim($category['slug']), $slugs_index );
                
                if($key === false && $category['slug'] != 'cards' && $category['slug'] != 'invitations'){
                    $slugs_index[] = $category['slug'];
                    $nav_menu[] = $category;
                    // print_r( $slugs_index );
                }
                

            }
        }

        // print_r( $slugs_index );
        // print_r( $nav_menu );
        // Redis::set('wayak:en:categories',json_encode($nav_menu));
        return $nav_menu;
    
    }

    function manage(){
        
        $categories = json_decode(Redis::get('laravel_database_green:categories'));
        $clean_category_obj = self::createCategoryTree($categories->CategoryTree);
        $top_level_categories = [
            [
                'name' => 'Invitations',
                'slug' => 'invitations',
                // 'link' => url('template/invitations'),
                'children' => []
            ],
            [
                'name' => 'Cards',
                'slug' => 'cards',
                // 'link' => url('template/cards'),
                'children' => []
            ]
            // 'link' => url('template/'.self::strToSlug($category->SectionName).'/'.self::strToSlug($category->CategoryName))
        ];

        echo "<pre>";
        print_r($clean_category_obj);
        exit;
        
        foreach($clean_category_obj as $category) {
            if($category['section'] == 'cards'){
                $top_level_categories[0]['children'][] = $category;
            } elseif($category['section'] == 'invitations'){
                $top_level_categories[1]['children'][] = $category;
            }
        }

        // $top_level_categories = self::cleanJSON($top_level_categories);
        $final_array = array_merge($top_level_categories, self::manage_wayak_cats() );

        Redis::set('wayak:en:categories', json_encode($final_array));

        // echo "<pre>";
        // print_r($final_array);

        foreach ($final_array as $cat_level_1) {
            // Redis::set('wayak:en:categories:')
            if( isset( $cat_level_1['slug'] )){
                // $cat_level_1['children'] = [];
                $key_name = $cat_level_1['slug'];
                print_r('>> wayak:en:categories:'.$key_name);
                // print_r($cat_level_1);
                Redis::set('wayak:en:categories:'.$key_name, json_encode($cat_level_1));
            }

            if( isset( $cat_level_1['children'] ) ){
                foreach ($cat_level_1['children'] as $cat_level_2) {
                    
                    if( isset($cat_level_2['slug'])){
                        $key_name = $cat_level_1['slug'].'/'.$cat_level_2['slug'];
                        $cat_level_2['parent'] = $cat_level_1;
                        $cat_level_2['parent']['children'] = [];

                        print_r('>> wayak:en:categories:'.$key_name);
                        print_r($cat_level_2);
                        Redis::set('wayak:en:categories:'.$key_name, json_encode($cat_level_2));
                    }

                    if( isset( $cat_level_2['children'] ) ){
                        foreach ($cat_level_2['children'] as $cat_level_3) {

                            if(isset($cat_level_3['slug'])){
                                $key_name = $cat_level_1['slug'].'/'.$cat_level_2['slug'].'/'.$cat_level_3['slug'];
                                $cat_level_3['parent'] = $cat_level_2;
                                $cat_level_3['parent']['children'] = [];
                                $cat_level_3['parent']['parent'] = $cat_level_1;
                                $cat_level_3['parent']['parent']['children'] = [];

                                print_r('>> wayak:en:categories:'.$key_name);
                                print_r($cat_level_3);
                                Redis::set('wayak:en:categories:'.$key_name, json_encode($cat_level_3));
                            }

                            if( isset( $cat_level_3['children'] ) ){
                                foreach ($cat_level_3['children'] as $cat_level_4) {

                                    if(isset($cat_level_4['slug'])){
                                        $key_name = $cat_level_1['slug'].'/'.$cat_level_2['slug'].'/'.$cat_level_3['slug'].'/'.$cat_level_4['slug'];
                                        $cat_level_4['parent'] = $cat_level_3;
                                        $cat_level_4['parent']['children'] = [];
                                        $cat_level_4['parent']['parent'] = $cat_level_2;
                                        $cat_level_4['parent']['parent']['children'] = [];

                                        print_r('>> wayak:en:categories:'.$key_name);
                                        print_r($cat_level_4);
                                        Redis::set('wayak:en:categories:'.$key_name, json_encode($cat_level_4));
                                    }
        
                                    if( isset( $cat_level_4['children'] ) ){
                                        foreach ($cat_level_4['children'] as $cat_level_5) {

                                            if(isset($cat_level_5['slug'])){
                                                $key_name = $cat_level_1['slug'].'/'.$cat_level_2['slug'].'/'.$cat_level_3['slug'].'/'.$cat_level_4['slug'].'/'.$cat_level_5['slug'];
                                                $cat_level_5['parent'] = $cat_level_4;
                                                $cat_level_5['parent']['children'] = [];
                                                $cat_level_5['parent']['parent'] = $cat_level_3;
                                                $cat_level_5['parent']['parent']['children'] = [];

                                                print_r('>> wayak:en:categories:'.$key_name);
                                                print_r($cat_level_5);
                                                Redis::set('wayak:en:categories:'.$key_name, json_encode($cat_level_5));
                                            }
                
                                            if( isset( $cat_level_5['children'] ) ){
                                                
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
        print_r($final_array);
        echo "<pre>";
        print_r($top_level_categories);
        exit;
        // self::createURLs('',$final_array);

        // exit;

        $final_array = Redis::get('wayak:en:categories');
        
        return view('admin.categories.manage', [
            'data' => json_encode($final_array)
        ]);
    }

    function createURLs($base_text, $category_array) {
        foreach ($category_array as $category) {
            $url_str = $base_text;
            
            if( isset( $category['slug'] ) ){
                //     print_r("MISSING >>");
                    // print_r($category);
                //     // exit;
                $url_str .= '/'.$category['slug'];
                echo $url_str.'<br>';
            }

            if( isset( $category['children'] ) ){
                // print_r($category['children']);
                self::createURLs($url_str, $category['children']);
            }
        }
    }

    function cleanJSON($top_level_categories){
        $new_category_obj = [];
        foreach($top_level_categories as $category) {
            $tmp_category = $category;
            unset($tmp_category['section']);
            // exit;

            if( isset( $category['children'] ) ){
                $tmp_category['children'] = self::cleanJSON( $category['children'] );
            }

            $new_category_obj[] = $tmp_category;
            // $new_category_obj = ;
        }
        
        return $new_category_obj;

    }
    
    function createCategoryTree($categories){
        $new_category_obj = [];
        foreach($categories as $category) {
            $tmp_category = [
                'name' => $category->CategoryName,
                'slug' => self::strToSlug($category->CategoryName),
                'section' => self::strToSlug($category->SectionName),
                // 'link' => url('template/'.self::strToSlug($category->SectionName).'/'.self::strToSlug($category->CategoryName))
            ];

            if( isset( $category->Children ) ){
                $tmp_category['children'] = self::createCategoryTree( $category->Children );
            }

            $new_category_obj[] = $tmp_category;
            // $new_category_obj = ;
        }
        
        return $new_category_obj;

    }
    
    function strToSlug($string){
        return str_replace('\'',null, str_replace('--',null, str_replace( '&','and',str_replace(' ','-',strtolower($string)))));
    }

    public $html = '';

    function translateCategory($origin_lang, $destination_lang, Request $request){
        // $redis_src = Redis::connection('redispro');
        // $redis_dest = Redis::connection('default');
        
        // echo "<pre>";
        $wayak_categories = Redis::keys('wayak:categories:*');

        foreach ($wayak_categories as $category_keyname) {
            // print_r($wayak_config);
            $category_key = str_replace('wayak:categories:',null, $category_keyname);
            
            $category_content = json_decode(Redis::get($category_keyname));
            // print_r($category_content);

            $this->html = '';
            echo '<h1>** '.$category_key.'</h1>';
            self::getCatHTML( $category_content );
            echo $this->html;
            echo '<hr>';
            // exit;
        }
        
        exit;
        // Redis::rename( $template_key, $new_template_key);
        // echo "Hello";
        // exit;
    }

    function getCatHTML( $category_content ){
        
        $this->html .= '<ul class="template-content" data-type="$category_key">';
            // $html .= '<li lang="en" data-type="key"><strong>'.$category_key.'</strong></li>';
            if(isset($category_content->name)){
                $this->html .= '<li lang="en" data-type="name">'.$category_content->name.'</li>';
            }
            
            if(isset($category_content->slug)){
                $this->html .= '<li lang="en" data-type="slug">'.$category_content->slug.'</li>';
            }
            
            if(isset($category_content->section)){
                $this->html .= '<li lang="en" data-type="section">'.$category_content->section.'</li>';
            }
        
            if( isset($category_content->parent) ){
                
                // foreach ($category_content->parent as $key => $xxx) {
                    
                    // print_r( "parent" );
                    // print_r( $category_content->parent );
                    // exit;
                    $this->html .= '<li lang="en" data-type="parent">';
                    self::getCatHTML( $category_content->parent );
                    $this->html .= '</li>';
                // }
            }
        
        $this->html .= '</ul>';

    }
}
