<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Facades\DB;

class MigrateToMongo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mongo:migratedb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $source_templates = DB::table('templates')
            // ->join('contacts', 'users.id', '=', 'contacts.user_id')
            ->join('tmp_etsy_metadata', 'tmp_etsy_metadata.id', '=', 'templates.fk_etsy_template_id')
            ->join('thumbnails', 'thumbnails.template_id', '=', 'templates.template_id')
            ->where('thumbnails.language_code','=','en')
            ->where('templates.status','=',5)
            ->where('thumbnails.thumbnail_ready','=',1)
            ->where('templates.source','=','templett')
            ->whereNotNull('templates.fk_etsy_template_id')
            ->select(
                    'templates.template_id', 
                    'templates.width', 
                    'templates.height',
                    'templates.metrics',
                    // 'tmp_etsy_metadata.title',
                    'tmp_etsy_metadata.username',
                    'thumbnails.filename',
                    'thumbnails.product_name as title',
                    'thumbnails.product_slug as slug',
                    // 'thumbnails.title as title_',
                    'thumbnails.dimentions'
            )
            ->get();

        echo "<pre>";
        foreach ($source_templates as $db_template) {
            // print_r($db_template);
            $dimentions = $db_template->dimentions;
            $dimentions = trim(str_replace($db_template->metrics, null, $db_template->dimentions));
            $dimentions = explode('x', $dimentions);

            if( Template::where("_id",'=', $db_template->template_id )->count() == 0 ){
                print_r("\n".$db_template->template_id);
                
                $template = new Template;
                $template->_id = $db_template->template_id;
                $template->title = $db_template->title;
                $template->slug = $db_template->slug;
                $template->category = "partyInvitations";
                // $template->categoryCaption = "Party Invitations";
                // $template->categorySlug = "kids-invitation";
                // $template->tags = [];
                // $template->like = [];
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
                // $template->createdAt = 1560162764361;
                // $template->updatedAt = 1598402668055;
                // $template->acceptedAt = 1571737232366;
                // $template->attributedAt = 1582635551101;
                $template->template = [];
                $template->driveFileIds = [];
                $template->previewImageUrls = [
                    'carousel' => str_replace('_thumbnail.jpg', '_carousel.jpg', $db_template->filename),
                    'large' => str_replace('_thumbnail.jpg', '_large.jpg', $db_template->filename),
                    'product_preview' => str_replace('_thumbnail.jpg', '_product_preview.jpg', $db_template->filename),
                    'thumbnail' => str_replace('_thumbnail.jpg', '_thumbnail.jpg', $db_template->filename)
                ];
                $template->mainCategory = '/invitations';
                $template->categories = [];
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
        return 0;
    }
}
