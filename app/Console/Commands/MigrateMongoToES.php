<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use stdClass;

class MigrateMongoToES extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:migrate:mongo-to-es';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate mongo db to elasticsearch';

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
        // $title = "save The Date Template, Navy Blue  Editable, Templett Invites DIY, C14";
        // print_r( self::getCategory($title) );
        // Array
        // (
        //     [categories] => Array
        //         (
        //             [0] => /invitations
        //             [1] => /invitations/wedding
        //             [2] => /invitations/wedding/save-the-date
        //         )

        //     [mainCategory] => /invitations/wedding/save-the-date
        // )
        // exit;

        $source_templates = DB::select(
            DB::raw(
                'SELECT
                    tmp_etsy_product.source,
                    tmp_etsy_metadata.username author, 
                    tmp_etsy_metadata.sales,
                    `tmp_etsy_metadata`.`title` AS `title`,
                    `tmp_etsy_product`.currency_value price_1,
                    `tmp_etsy_metadata`.price price_2,
                    `tmp_etsy_metadata`.templett_url demo_url,
                    tmp_etsy_metadata.product_imgs images,
                    null as template_id,
                    null as `width`,
                    null as `height`,
                    null as `metrics`,
                    `tmp_etsy_metadata`.`username`,
                    tmp_etsy_metadata.thumbnail as thumbnail,
                    parsed_url AS `slug`,
                    null as dimentions
                FROM
                    tmp_etsy_metadata,
                    tmp_etsy_product
                WHERE
                    tmp_etsy_metadata.fk_product_id = tmp_etsy_product.id
                    AND `tmp_etsy_metadata`.templett_url IS NOT NULL 
                    AND tmp_etsy_metadata.thumbnail IS NOT NULL 
                ORDER BY tmp_etsy_metadata.id DESC'
            )
        );

        echo "<pre>";
        foreach ($source_templates as $product) {

            $product_id = Str::random(10);
            
            $fproduct = new stdClass();
            // $fproduct->_id = $product_id;
            $fproduct->title = str_replace('  ', null, str_replace('corjl', ' ', str_replace('Corjl', ' ', $product->title)));
            $fproduct->slug = substr($product->slug, strrpos($product->slug, '/') + 1, strlen($product->slug)) . '-' . $product_id;

            $product_category = self::getCategory($fproduct->title);
            $fproduct->category = $product_category['mainCategory'];
            $fproduct->categoryCaption = $product_category['mainCategory'];
            $fproduct->categorySlug = $product_category['mainCategory'];
            // $fproduct->mainCategory = '/invitations';
            $fproduct->categories = $product_category['categories'];

            $fproduct->tags = [];
            // $fproduct->like = [];
            $fproduct->status = "completed";
            $fproduct->format = "Invitation";
            $fproduct->templateType = "regular";
            $fproduct->measureUnits = trim($product->metrics);
            // $fproduct->width = trim($dimentions[0];
            // $fproduct->height = trim($dimentions[1];

            // $fproduct->group = null;
            $fproduct->language = "en";
            $fproduct->forSubscribers = false;
            $fproduct->hasAnimatedPreview = false;
            $fproduct->hasAnimatedScreenPreview = false;
            $fproduct->downloadUrl = null;
            // $fproduct->name = null;
            // $fproduct->folder = null;
            $fproduct->pixelWidth = null;
            $fproduct->pixelHeight = null;
            // $fproduct->hash = null;
            $fproduct->studioName = $product->username;
            // $fproduct->createdAt = 1560162764361;
            // $fproduct->updatedAt = 1598402668055;
            // $fproduct->acceptedAt = 1571737232366;
            // $fproduct->attributedAt = 1582635551101;
            $fproduct->template = [];
            $fproduct->driveFileIds = [];
            $fproduct->previewImageUrls = [
                // 'carousel' => str_replace('_thumbnail.jpg', '_carousel.jpg', $product->filename),
                // 'large' => str_replace('_thumbnail.jpg', '_large.jpg', $product->filename),
                // 'product_preview' => str_replace('_thumbnail.jpg', '_product_preview.jpg', $product->filename),
                'thumbnail' => $product->thumbnail
            ];
            $fproduct->images = json_decode($product->images);
            
            $fproduct->keywords = [
                // "en" => [
                "invitation"
                // ]
            ];
            $fproduct->industries = [];
            $fproduct->languages = [
                "en"
            ];
            // $fproduct->localizedTitle = [
            //     "en" => $fproduct->title
            // ];
            $fproduct->userState = [
                "purchased" => false,
                "collected" => false
            ];

            // $fproduct->save();
            // }

            // print_r(json_encode($fproduct));
            print_r($fproduct->title );
            print_r("\n");
            // print_r($fproduct->categories );
            // print_r($product);
            // exit;
            self::createProduct( $product_id, json_encode($fproduct) );
        }

        return 0;
    }

    function createProduct($template_id, $template_body){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://search-ccp-prod-ut5vyvxnhpwlss6p3yft3okcrm.us-west-2.es.amazonaws.com/wy/_doc/'.$template_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => $template_body,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    function getCategory($title)
    {
        
        if (preg_match('/.*birthday.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/birthday'
                ],
                'mainCategory' => '/invitations/birthday'
            ];
        }

        if (preg_match('/.*(W|w)edding.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/wedding',
                ],
                'mainCategory' => '/invitations/wedding'
            ];
        }

        if (preg_match('/.*(B|b)achelor.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/wedding',
                    '/invitations/wedding/bachelor-party',
                ],
                'mainCategory' => '/invitations/wedding/bachelor-party'
            ];
        }

        if (preg_match('/.*(R|r)ehearsal.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/wedding',
                    '/invitations/wedding/rehearsal-dinner',
                ],
                'mainCategory' => '/invitations/wedding/rehearsal-dinner'
            ];
        }

        if (preg_match('/.*(E|e)ngagement.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/wedding',
                    '/invitations/wedding/engagement-party',
                ],
                'mainCategory' => '/invitations/wedding/engagement-party'
            ];
        }

        if (preg_match('/.*(B|b)ridal.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/wedding',
                    '/invitations/wedding/bridal-shower',
                ],
                'mainCategory' => '/invitations/wedding/bridal-shower'
            ];
        }

        if (preg_match('/.*(S|s)ave.*(D|d)ate.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/wedding',
                    '/invitations/wedding/save-the-date'
                ],
                'mainCategory' => '/invitations/wedding/save-the-date'
            ];
        }


        if (preg_match('/.*(RSVP|rsvp).*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/rsvp',
                ],
                'mainCategory' => '/invitations/wedding/rsvp'
            ];
        }

        if (preg_match('/.*(C|c)ocktail.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/cocktail-party',
                ],
                'mainCategory' => '/invitations/cocktail-party'
            ];
        }

        if (preg_match('/.*(T|t)hank.*(Y|y)ou.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/thank-you'
                ],
                'mainCategory' => '/invitations/thank-you'
            ];
        }

        if (preg_match('/.*(M|m)enu.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/wedding/menus',
                    '/menus'
                ],
                'mainCategory' => '/invitations/wedding/menus',
            ];
        }

        if (preg_match('/.*(T|t)ag.*/i', $title)) {
            return [
                'categories' => [
                    '/tags',
                    '/tags/gift',
                    '/gift-tags'
                ],
                'mainCategory' => '/tags'
            ];
        }

        if (
            preg_match('/.*(T|t)ags.*(C|c)hristmas.*/i', $title) ||
            preg_match('/.*(C|c)hristmas.*(T|t)ags.*/i', $title)
        ) {

            return [
                'categories' => [
                    '/tags',
                    '/tags/gift',
                    '/tags/christmas',
                    '/gift-tags',
                    '/christmas-tags',
                ],
                'mainCategory' => '/tags'
            ];
        }

        if (preg_match('/.*(R|r)ecipe.*/i', $title)) {
            return [
                'categories' => [
                    '/recipe-cards',
                ],
                'mainCategory' => '/recipe-cards'
            ];
        }


        if (preg_match('/.*(P|p)rogram.*/i', $title)) {
            return [
                'categories' => [
                    '/event-programs',
                ],
                'mainCategory' => '/event-programs'
            ];
        }

        if (preg_match('/.*(W|w)edding.*(P|p)rogram.*/i', $title)) {
            return [
                'categories' => [
                    '/wedding-programs',
                    '/event-programs/wedding',
                ],
                'mainCategory' => '/wedding-programs'
            ];
        }

        if (preg_match('/.*(C|c)oupon.*/i', $title)) {
            return [
                'categories' => [
                    '/coupons',
                ],
                'mainCategory' => '/coupons'
            ];
        }

        if (preg_match('/.*(L|l)abel.*/i', $title)) {
            return [
                'categories' => [
                    '/labels',
                ],
                'mainCategory' => '/labels'
            ];
        }

        if (preg_match('/.*(C|c)alendar.*/i', $title)) {
            return [
                'categories' => [
                    '/calendars',
                ],
                'mainCategory' => '/calendars'
            ];
        }

        if (preg_match('/.*(C|c)ommunion.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/communion',
                ],
                'mainCategory' => '/invitations'
            ];
        }

        if (
            preg_match('/.*bbq.*/i', $title) ||
            preg_match('/.*barbecue.*/i', $title)
        ) {

            return [
                'categories' => [
                    '/invitations',
                    '/invitations/bbq',
                ],
                'mainCategory' => '/invitations'
            ];
        }

        if (
            preg_match('/.*(R|r)etirement.*/i', $title) ||
            preg_match('/.*(F|f)arewell.*/i', $title)
        ) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/retirement-and-farewell',
                ],
                'mainCategory' => '/invitations'
            ];
        }

        if (
            preg_match('/.*(D|d)inner.*(P|p)arty.*/i', $title) ||
            preg_match('/.*(D|d)inner.*/i', $title)
        ) {

            return [
                'categories' => [
                    '/invitations',
                    '/invitations/dinner-party',
                ],
                'mainCategory' => '/invitations'
            ];
        }

        if (preg_match('/.*(P|p)otluck.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/dinner-party',
                    '/invitations/dinner-party/potluck',
                ],
                'mainCategory' => '/invitations'
            ];
        }

        if (preg_match('/.*(C|c)hristmas.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/holidays',
                    '/invitations/holidays/christmas',
                ],
                'mainCategory' => '/invitations/holidays/christmas'
            ];
        }

        if (preg_match('/.*(A|a)nniversary.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/anniversary',
                ],
                'mainCategory' => '/invitations/anniversary'
            ];
        }

        if (preg_match('/.*(P|p)pool.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/summer-and-pool-party',
                ],
                'mainCategory' => '/invitations/summer-and-pool-party'
            ];
        }

        if (preg_match('/.*(H|h)ousewarming.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/housewarming',
                    '/invitations/party/housewarming'
                ],
                'mainCategory' => '/invitations/party/housewarming'
            ];
        }

        if (preg_match('/.*(G|g)raduation.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/graduation',
                    '/invitations/party/graduation'
                ],
                'mainCategory' => '/invitations/party/graduation'
            ];
        }

        if (preg_match('/.*(E|e)aster.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/easter',
                    '/invitations/holidays/easter'
                ],
                'mainCategory' => '/invitations/holidays/easter'
            ];
        }

        if (preg_match('/.*(P|p)atrick.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/st-patricks-day',
                    '/invitations/holidays/st-patricks-day'
                ],
                'mainCategory' => '/invitations'
            ];
        }

        if (preg_match('/.*(T|t)hanksgiving.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/thanksgiving',
                    '/invitations/holidays/thanksgiving'
                ],
                'mainCategory' => '/invitations/holidays/thanksgiving'
            ];
        }

        if (preg_match('/.*(N|n)ew.*(Y|y)ear.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/new-year',
                    '/invitations/holidays/new-year'
                ],
                'mainCategory' => '/invitations/holidays/new-year'
            ];
        }

        if (preg_match('/.*(V|v)alentine.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/valentines-day',
                    '/invitations/holidays/valentines-day'
                ],
                'mainCategory' => '/invitations/holidays/valentines-day'
            ];
        }

        if (preg_match('/.*(H|h)alloween.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/halloween',
                    '/invitations/holidays/halloween'
                ],
                'mainCategory' => '/invitations/holidays/halloween'
            ];
        }

        if (preg_match('/.*(B|b)aptism.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/baptism',
                    '/invitations/holidays/baptism'
                ],
                'mainCategory' => '/invitations/holidays/baptism'
            ];
        }

        if (preg_match('/.*(B|b)aby.*(S|s)hower.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/baby-shower'
                ],
                'mainCategory' => '/invitations/baby-shower'
            ];
        }

        if (preg_match('/.*(B|b)runch.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/brunch'
                ],
                'mainCategory' => '/invitations/brunch'
            ];
        }

        if (preg_match('/.*(S|s)leepover.*/i', $title)) {
            return [
                'categories' => [
                    '/invitations',
                    '/invitations/sleepover'
                ],
                'mainCategory' => '/invitations/sleepover'
            ];
        }

        if (preg_match('/.*(I|i)nvitation.*/i', $title)) {
            return [
                'categories' => ['/invitations'],
                'mainCategory' => '/invitations'
            ];
        }
        
        if (preg_match('/.*envelope.*/i', $title)) {
            return [
                'categories' => [
                    '/printables',
                    '/printables/envelopes'
                ],
                'mainCategory' => '/printables/envelopes'
            ];
        }
        
        if (preg_match('/.*certificate.*/i', $title)) {
            return [
                'categories' => [
                    '/printables',
                    '/printables/certificates'
                ],
                'mainCategory' => '/printables/certificates'
            ];
        }

        return [
            'categories' => [
                '/editable'
            ],
            'mainCategory' => '/editable'
        ];
    }
}
