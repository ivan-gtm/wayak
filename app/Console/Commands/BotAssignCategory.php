<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class BotAssignCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:3-assigncategory';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign category based on product name, title and MongoDB database';

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
        self::massiveCategoryAssigment();
        self::checkProductCategoryNotAssigned();
    }

    function checkProductCategoryNotAssigned(){
        $templates = Template::whereNotNull('slug')
        ->get([
            'title',
            'category',
            'categories',
            'mainCategory'
        ]);

        // $templates = [];
        foreach($templates as $template) {
            $category_name = $template->mainCategory;
            $category_name = substr( $template->mainCategory,1, strlen($category_name) );
            
            if( Redis::exists('wayak:en:categories:'.$category_name) == false ){
                print_r('wayak:en:categories:'.$category_name);
                print_r("\n");
                
                if($category_name == 'invitations/wedding/rsvp'){
                    $x = [
                        'name' => 'RSVP Cards',
                        'slug' => 'rsvp',
                        'section' => 'cards',
                        'children' => [],
                        'parent' => [
                            'name' => 'Wedding',
                            'slug' => 'wedding',
                            'section' => 'cards',
                            'children' => [],
                            'parent' => [
                                'name' => 'Invitations',
                                'slug' => 'invitations',
                                'children' => [],
                            ]
                        ]
                    ];
                    Redis::set('wayak:en:categories:'.$category_name, json_encode($x) );
                } elseif($category_name == 'invitations/wedding/menus'){
                    $x = [
                        'name' => 'Wedding Menus',
                        'slug' => 'menus',
                        'section' => 'cards',
                        'children' => [],
                        'parent' => [
                            'name' => 'Wedding',
                            'slug' => 'wedding',
                            'section' => 'cards',
                            'children' => [],
                            'parent' => [
                                'name' => 'Invitations',
                                'slug' => 'invitations',
                                'children' => [],
                            ]
                        ]
                    ];
                    Redis::set('wayak:en:categories:'.$category_name, json_encode($x) );
                } elseif($category_name == 'invitations/wedding/bridal-shower'){
                    $x = [
                        'name' => 'Bridal Shower',
                        'slug' => 'bridal-shower',
                        'section' => 'cards',
                        'children' => [],
                        'parent' => [
                            'name' => 'Wedding',
                            'slug' => 'wedding',
                            'section' => 'cards',
                            'children' => [],
                            'parent' => [
                                'name' => 'Invitations',
                                'slug' => 'invitations',
                                'children' => [],
                            ]
                        ]
                    ];
                    Redis::set('wayak:en:categories:'.$category_name, json_encode($x) );
                } elseif($category_name == 'invitations/wedding/bachelor-party'){
                    $x = [
                        'name' => 'Bachelor Party',
                        'slug' => 'bachelor-party',
                        'section' => 'cards',
                        'children' => [],
                        'parent' => [
                            'name' => 'Wedding',
                            'slug' => 'wedding',
                            'section' => 'cards',
                            'children' => [],
                            'parent' => [
                                'name' => 'Invitations',
                                'slug' => 'invitations',
                                'children' => [],
                            ]
                        ]
                    ];
                    Redis::set('wayak:en:categories:'.$category_name, json_encode($x) );
                } elseif($category_name == 'invitations/cocktail-party'){
                    $x = [
                        'name' => 'Cocktail Party',
                        'slug' => 'cocktail-party',
                        'section' => 'cards',
                        'children' => [],
                        'parent' => [
                            'name' => 'Invitations',
                            'slug' => 'invitations',
                            'children' => [],
                        ]
                    ];
                    Redis::set('wayak:en:categories:'.$category_name, json_encode($x) );
                } elseif($category_name == 'invitations/wedding/save-the-date'){
                    $x = [
                        'name' => 'Save the date',
                        'slug' => 'save-the-date',
                        'section' => 'cards',
                        'children' => [],
                        'parent' => [
                            'name' => 'Wedding',
                            'slug' => 'wedding',
                            'section' => 'cards',
                            'children' => [],
                            'parent' => [
                                'name' => 'Invitations',
                                'slug' => 'invitations',
                                'children' => [],
                            ]
                        ]
                    ];
                    Redis::set('wayak:en:categories:'.$category_name, json_encode($x) );
                } elseif($category_name == 'invitations/holidays/baptism'){
                    $x = [
                        'name' => 'Baptism',
                        'slug' => 'baptism',
                        'section' => 'cards',
                        'children' => [],
                        'parent' => [
                            'name' => 'Holidays',
                            'slug' => 'holidays',
                            'section' => 'cards',
                            'children' => [],
                            'parent' => [
                                'name' => 'Invitations',
                                'slug' => 'invitations',
                                'children' => [],
                            ]
                        ]
                    ];
                    Redis::set('wayak:en:categories:'.$category_name, json_encode($x) );
                } elseif($category_name == 'invitations/wedding/engagement-party'){
                    $x = [
                        'name' => 'Engagement Party',
                        'slug' => 'engagement-party',
                        'section' => 'cards',
                        'children' => [],
                        'parent' => [
                            'name' => 'Wedding',
                            'slug' => 'wedding',
                            'section' => 'cards',
                            'children' => [],
                            'parent' => [
                                'name' => 'Invitations',
                                'slug' => 'invitations',
                                'children' => [],
                            ]
                        ]
                    ];
                    Redis::set('wayak:en:categories:'.$category_name, json_encode($x) );
                } elseif($category_name == 'invitations/party/graduation'){
                    $x = [
                        'name' => 'Graduation',
                        'slug' => 'graduation',
                        'section' => 'cards',
                        'children' => [],
                        'parent' => [
                            'name' => 'Party',
                            'slug' => 'party',
                            'section' => 'cards',
                            'children' => [],
                            'parent' => [
                                'name' => 'Invitations',
                                'slug' => 'invitations',
                                'children' => [],
                            ]
                        ]
                    ];
                    Redis::set('wayak:en:categories:'.$category_name, json_encode($x) );
                } elseif($category_name == 'invitations/party/housewarming'){
                    $x = [
                        'name' => 'Housewarming',
                        'slug' => 'housewarming',
                        'section' => 'cards',
                        'children' => [],
                        'parent' => [
                            'name' => 'Party',
                            'slug' => 'party',
                            'section' => 'cards',
                            'children' => [],
                            'parent' => [
                                'name' => 'Invitations',
                                'slug' => 'invitations',
                                'children' => [],
                            ]
                        ]
                    ];
                    Redis::set('wayak:en:categories:'.$category_name, json_encode($x) );
                } elseif($category_name == 'invitations/baby-shower'){
                    $x = [
                        'name' => 'Baby Shower',
                        'slug' => 'baby-shower',
                        'section' => 'cards',
                        'children' => [],
                        'parent' => [
                            'name' => 'Invitations',
                            'slug' => 'invitations',
                            'children' => [],
                        ]
                    ];
                    Redis::set('wayak:en:categories:'.$category_name, json_encode($x) );
                } elseif($category_name == 'invitations/sleepover'){
                    $x = [
                        'name' => 'Sleepover',
                        'slug' => 'sleepover',
                        'section' => 'cards',
                        'children' => [],
                        'parent' => [
                            'name' => 'Invitations',
                            'slug' => 'invitations',
                            'children' => [],
                        ]
                    ];
                    Redis::set('wayak:en:categories:'.$category_name, json_encode($x) );
                } elseif($category_name == 'invitations/brunch'){
                    $x = [
                        'name' => 'Brunch',
                        'slug' => 'brunch',
                        'section' => 'cards',
                        'children' => [],
                        'parent' => [
                            'name' => 'Invitations',
                            'slug' => 'invitations',
                            'children' => [],
                        ]
                    ];
                    Redis::set('wayak:en:categories:'.$category_name, json_encode($x) );
                }

            }
            
            // exit;
        }
    }

    function massiveCategoryAssigment(){
        
        Template::where('title', 'regexp', '/.*(I|i)nvitation.*/i')
            ->update([
                'categories' => ['/invitations'],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'regexp', '/.*(B|b)irthday.*/i')
            ->update([
                'categories' => [
                    '/invitations',
                    '/invitations/birthday',
                    // '/cards',
                    // '/cards/birthday',
                ],
                'mainCategory' => '/invitations/birthday'
            ]);
        
        Template::where('title', 'regexp', '/.*(W|w)edding.*/i')
            ->update([
                'categories' => [
                    '/invitations',
                    '/invitations/wedding',
                    // '/cards',
                    // '/cards/wedding',
                ],
                'mainCategory' => '/invitations/wedding'
            ]);
            
        Template::where('title', 'regexp', '/.*(B|b)achelor.*/i')
            ->update([
                'categories' => [
                    '/invitations',
                    '/invitations/wedding',
                    '/invitations/wedding/bachelor-party',
                    // '/cards',
                    // '/cards/wedding',
                    // '/cards/wedding/bachelor-party'
                ],
                'mainCategory' => '/invitations/wedding/bachelor-party'
            ]);
        
        Template::where('title', 'regexp', '/.*(R|r)ehearsal.*/i')
            ->update([
                'categories' => [
                    '/invitations',
                    '/invitations/wedding',
                    '/invitations/wedding/rehearsal-dinner',
                    // '/cards',
                    // '/cards/wedding',
                    // '/cards/wedding/rehearsal-dinner'
                ],
                'mainCategory' => '/invitations/wedding/rehearsal-dinner'
            ]);
            
        Template::where('title', 'regexp', '/.*(E|e)ngagement.*/i')
            ->update([
                'categories' => [
                    '/invitations',
                    '/invitations/wedding',
                    '/invitations/wedding/engagement-party',
                    // '/cards',
                    // '/cards/wedding',
                    // '/cards/wedding/engagement-party'
                ],
                'mainCategory' => '/invitations/wedding/engagement-party'
            ]);
        
        Template::where('title', 'regexp', '/.*(B|b)ridal.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/wedding',
                    // '/cards/wedding/bridal-shower',
                    // '/cards/bridal-shower',
                    '/invitations',
                    '/invitations/wedding',
                    '/invitations/wedding/bridal-shower',
                ],
                'mainCategory' => '/invitations/wedding/bridal-shower'
            ]);
            
        Template::where('title', 'regexp', '/.*(S|s)ave.*(D|d)ate.*/i')
            ->update([
                'categories' => [
                    '/invitations',
                    '/invitations/wedding',
                    '/invitations/wedding/save-the-date'
                ],
                'mainCategory' => '/invitations/wedding/save-the-date'
                ]);
                
                
        Template::where('title', 'regexp', '/.*(RSVP|rsvp).*/i')
        ->update([
                'categories' => [
                '/invitations',
                '/invitations/rsvp',
                // '/cards',
                // '/cards/wedding',
                // '/cards/wedding/responseand-rsvp-cards',
            ],
            'mainCategory' => '/invitations/wedding/rsvp'
        ]);
                    
        Template::where('title', 'regexp', '/.*(C|c)ocktail.*/i')
                        ->update([
                            'categories' => [
                                '/invitations',
                                '/invitations/cocktail-party',
                                // '/cards',
                                // '/cards/party',
                                // '/cards/party/cocktail-party',
                            ],
                            'mainCategory' => '/invitations/cocktail-party'
                        ]);

        Template::where('title', 'regexp', '/.*(T|t)hank.*(Y|y)ou.*/i')
            ->update([
                'categories' => [
                    '/invitations',
                    '/invitations/thank-you'
                ],
                'mainCategory' => '/invitations/thank-you'
            ]);
        
        Template::where('title', 'regexp', '/.*(M|m)enu.*/i')
            ->update([
                'categories' => [
                    '/invitations',
                    '/invitations/wedding/menus',
                    '/menus'
                ],
                'mainCategory' => '/invitations/wedding/menus',
            ]);
        
        
        Template::where('title', 'regexp', '/.*(T|t)tag.*/i')
            ->update([
                'categories' => [
                    '/tags',
                    '/tags/gift',
                    '/gift-tags'
                ],
                'mainCategory' => '/tags'
            ]);
        
        Template::where('title', 'regexp', '/.*(T|t)ags.*(C|c)hristmas.*/i')
            ->orWhere('title', 'regexp', '/.*(C|c)hristmas.*(T|t)ags.*/i')
            ->update([
                'categories' => [
                    '/tags',
                    '/tags/gift',
                    '/tags/christmas',
                    '/gift-tags',
                    '/christmas-tags',
                ],
                'mainCategory' => '/tags'
            ]);
        
        Template::where('title', 'regexp', '/.*(R|r)ecipe.*/i')
            ->update([
                'categories' => [
                    '/recipe-cards',
                ],
                'mainCategory' => '/recipe-cards'
            ]);

        
        Template::where('title', 'regexp', '/.*(P|p)rogram.*/i')
            ->update([
                'categories' => [
                    '/event-programs',
                ],
                'mainCategory' => '/event-programs'
            ]);
        
        Template::where('title', 'regexp', '/.*(W|w)edding.*(P|p)rogram.*/i')
            ->update([
                'categories' => [
                    '/wedding-programs',
                    '/event-programs/wedding',
                ],
                'mainCategory' => '/wedding-programs'
            ]);
        
        Template::where('title', 'regexp', '/.*(C|c)oupon.*/i')
            ->update([
                'categories' => [
                    '/coupons',
                ],
                'mainCategory' => '/coupons'
            ]);
        
        Template::where('title', 'regexp', '/.*(L|l)abel.*/i')
            ->update([
                'categories' => [
                    '/labels',
                ],
                'mainCategory' => '/labels'
            ]);
        
        Template::where('title', 'regexp', '/.*(C|c)alendar.*/i')
            ->update([
                'categories' => [
                    '/calendars',
                ],
                'mainCategory' => '/calendars'
            ]);
        
        Template::where('title', 'regexp', '/.*(C|c)ommunion.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/communion',
                    '/invitations',
                    '/invitations/communion',
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'regexp', '/.*bbq.*/i')
            ->orWhere('title', 'regexp', '/.*barbecue.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/bbq',
                    '/invitations',
                    '/invitations/bbq',
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'regexp', '/.*(R|r)etirement.*/i')
            ->orWhere('title', 'regexp', '/.*(F|f)arewell.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/retirement-and-farewell',
                    '/invitations',
                    '/invitations/retirement-and-farewell',
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'regexp', '/.*(D|d)inner.*(P|p)arty.*/i')
            ->orWhere('title', 'regexp', '/.*(D|d)inner.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/dinner-party',
                    '/invitations',
                    '/invitations/dinner-party',
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'regexp', '/.*(P|p)otluck.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/dinner-party',
                    // '/cards/dinner-party/potluck',
                    '/invitations',
                    '/invitations/dinner-party',
                    '/invitations/dinner-party/potluck',
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'regexp', '/.*(C|c)hristmas.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/holidays',
                    // '/cards/holidays/christmas',
                    '/invitations',
                    '/invitations/holidays',
                    '/invitations/holidays/christmas',
                ],
                'mainCategory' => '/invitations/holidays/christmas'
            ]);
        
        Template::where('title', 'regexp', '/.*(A|a)nniversary.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/anniversary'
                    '/invitations',
                    '/invitations/anniversary',
                ],
                'mainCategory' => '/invitations/anniversary'
            ]);
        
        Template::where('title', 'regexp', '/.*(P|p)pool.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/summer-and-pool-party'
                    '/invitations',
                    '/invitations/summer-and-pool-party',
                ],
                'mainCategory' => '/invitations/summer-and-pool-party'
            ]);
        
        Template::where('title', 'regexp', '/.*(H|h)ousewarming.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/housewarming',
                    // '/cards/party/housewarming'
                    '/invitations',
                    '/invitations/housewarming',
                    '/invitations/party/housewarming'
                ],
                'mainCategory' => '/invitations/party/housewarming'
            ]);
        
        Template::where('title', 'regexp', '/.*(G|g)raduation.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/graduation',
                    // '/cards/party/graduation-party'
                    '/invitations',
                    '/invitations/graduation',
                    '/invitations/party/graduation'
                ],
                'mainCategory' => '/invitations/party/graduation'
            ]);
        
        Template::where('title', 'regexp', '/.*(E|e)aster.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/holidays',
                    // '/cards/holidays/easter'
                    '/invitations',
                    '/invitations/easter',
                    '/invitations/holidays/easter'
                ],
                'mainCategory' => '/invitations/holidays/easter'
            ]);
        
        Template::where('title', 'regexp', '/.*(P|p)atrick.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/holidays',
                    // '/cards/holidays/st-patricks-day'
                    '/invitations',
                    '/invitations/st-patricks-day',
                    '/invitations/holidays/st-patricks-day'
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'regexp', '/.*(T|t)hanksgiving.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/holidays',
                    // '/cards/holidays/thanksgiving'
                    '/invitations',
                    '/invitations/thanksgiving',
                    '/invitations/holidays/thanksgiving'
                ],
                'mainCategory' => '/invitations/holidays/thanksgiving'
            ]);
        
        Template::where('title', 'regexp', '/.*(N|n)ew.*(Y|y)ear.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/holidays',
                    // '/cards/holidays/new-year'
                    '/invitations',
                    '/invitations/new-year',
                    '/invitations/holidays/new-year'
                ],
                'mainCategory' => '/invitations/holidays/new-year'
            ]);
        
        Template::where('title', 'regexp', '/.*(V|v)alentine.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/holidays',
                    // '/cards/holidays/valentines-day'
                    '/invitations',
                    '/invitations/valentines-day',
                    '/invitations/holidays/valentines-day'
                ],
                'mainCategory' => '/invitations/holidays/valentines-day'
            ]);

        Template::where('title', 'regexp', '/.*(H|h)alloween.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/holidays',
                    // '/cards/holidays/halloween'
                    '/invitations',
                    '/invitations/halloween',
                    '/invitations/holidays/halloween'
                ],
                'mainCategory' => '/invitations/holidays/halloween'
            ]);
        
        Template::where('title', 'regexp', '/.*(B|b)aptism.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/baptism-and-christening'
                    '/invitations',
                    '/invitations/baptism',
                    '/invitations/holidays/baptism'
                ],
                'mainCategory' => '/invitations/holidays/baptism'
            ]);
        
        Template::where('title', 'regexp', '/.*(B|b)aby.*(S|s)hower.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/baby-shower'
                    '/invitations',
                    '/invitations/baby-shower'
                ],
                'mainCategory' => '/invitations/baby-shower'
            ]);
        
        Template::where('title', 'regexp', '/.*(B|b)runch.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/party/brunch'
                    '/invitations',
                    '/invitations/brunch'
                ],
                'mainCategory' => '/invitations/brunch'
            ]);
        
        Template::where('title', 'regexp', '/.*(S|s)leepover.*/i')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/party/sleepover'
                    '/invitations',
                    '/invitations/sleepover'
                ],
                'mainCategory' => '/invitations/sleepover'
            ]);
            
        
        echo "MASSIVE CATEGORY ASSIGMENT FINISHED !!";
    }
}
