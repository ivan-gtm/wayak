<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Facades\DB;

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

        // Template::where('_id', '=', '1699299')
        //     ->update([
        //         'mainCategory' => '/invitations/wedding'
        //     ]);
        // echo "hihii";
        // exit;

        Template::where('title', 'like', '%invitation%')
            ->update([
                'categories' => ['/invitations'],
                'mainCategory' => '/invitations'
            ]);
        
        // print_r( Template::where('title', 'like', '%invitation%')->count());
        // print_r("\n");
        // exit;
        
        Template::where('title', 'like', '%birthday%')
            ->update([
                'categories' => [
                    '/invitations',
                    '/invitations/birthday',
                    // '/cards',
                    // '/cards/birthday',
                ],
                'mainCategory' => '/invitations/birthday'
            ]);
        
        Template::where('title', 'like', '%wedding%invitation%')
            ->orWhere('title', 'like', '%invitation%wedding%')
            ->orWhere('title', 'like', '%invite%wedding%')
            ->orWhere('title', 'like', '%wedding%invite%')
            ->update([
                'categories' => [
                    '/invitations',
                    '/invitations/wedding',
                    // '/cards',
                    // '/cards/wedding',
                ],
                'mainCategory' => '/invitations/wedding'
            ]);
            
        Template::where('title', 'like', '%bachelor%')
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
        
        Template::where('title', 'like', '%rehearsal%')
            ->update([
                'categories' => [
                    '/invitations',
                    '/invitations/wedding',
                    '/invitations/wedding/rehearsal-dinner',
                    // '/cards',
                    // '/cards/wedding',
                    // '/cards/wedding/rehearsal-dinner'
                ],
                'mainCategory' => '/invitations/wedding'
            ]);
            
        Template::where('title', 'like', '%engagement%')
            ->update([
                'categories' => [
                    '/invitations',
                    '/invitations/wedding',
                    '/invitations/wedding/engagement-party',
                    // '/cards',
                    // '/cards/wedding',
                    // '/cards/wedding/engagement-party'
                ],
                'mainCategory' => '/invitations/wedding'
            ]);
        
        Template::where('title', 'like', '%bridal%')
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
            
        Template::where('title', 'like', '%save%date%')
            ->update([
                'categories' => [
                    '/invitations',
                    '/invitations/wedding',
                    '/invitations/wedding/save-the-date'
                ],
                'mainCategory' => '/invitations/wedding'
                ]);
                
                
        Template::where('title', 'like', '%rsvp%')
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
                    
        Template::where('title', 'like', '%cocktail%')
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

        Template::where('title', 'like', '%card%thank%')
            ->update([
                'categories' => [
                    '/invitations',
                    '/invitations/thank-you'
                ],
                'mainCategory' => '/invitations/thank-you'
            ]);
        
        Template::where('title', 'like', '%menu%')
            ->update([
                'categories' => [
                    '/invitations',
                    '/invitations/wedding/menus',
                    '/menus'
                ],
                'mainCategory' => '/invitations/wedding/menus',
            ]);
        
        
        Template::where('title', 'like', '%tags%')
            ->orWhere('title', 'like', '%tags%gift%')
            ->orWhere('title', 'like', '%gift%tags%')
            ->update([
                'categories' => [
                    '/tags',
                    '/tags/gift',
                    '/gift-tags'
                ],
                'mainCategory' => '/tags'
            ]);
        
        Template::where('title', 'like', '%tags%christmas%')
            ->orWhere('title', 'like', '%christmas%tags%')
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
        
        Template::where('title', 'like', '%recipe%')
            ->update([
                'categories' => [
                    '/recipe-cards',
                ],
                'mainCategory' => '/recipe-cards'
            ]);

        
        Template::where('title', 'like', '%program%')
            ->update([
                'categories' => [
                    '/event-programs',
                ],
                'mainCategory' => '/event-programs'
            ]);
        
        Template::where('title', 'like', '%wedding%program%')
            ->update([
                'categories' => [
                    '/wedding-programs',
                    '/event-programs/wedding',
                ],
                'mainCategory' => '/wedding-programs'
            ]);
        
        Template::where('title', 'like', '%coupon%')
            ->update([
                'categories' => [
                    '/coupons',
                ],
                'mainCategory' => '/coupons'
            ]);
        
        Template::where('title', 'like', '%label%')
            ->update([
                'categories' => [
                    '/labels',
                ],
                'mainCategory' => '/labels'
            ]);
        
        Template::where('title', 'like', '%calendar%')
            ->update([
                'categories' => [
                    '/calendars',
                ],
                'mainCategory' => '/calendars'
            ]);
        
        Template::where('title', 'like', '%communion%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/communion',
                    '/invitations',
                    '/invitations/communion',
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'like', '%bbq%')
            ->orWhere('title', 'like', '%barbecue%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/bbq',
                    '/invitations',
                    '/invitations/bbq',
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'like', '%retirement%')
            ->orWhere('title', 'like', '%farewell%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/retirement-and-farewell',
                    '/invitations',
                    '/invitations/retirement-and-farewell',
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'like', '%party%dinner%')
            ->orWhere('title', 'not like', '%wedding%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/dinner-party',
                    '/invitations',
                    '/invitations/dinner-party',
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'like', '%potluck%')
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
        
        Template::where('title', 'like', '%christmas%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/holidays',
                    // '/cards/holidays/christmas',
                    '/invitations',
                    '/invitations/holidays',
                    '/invitations/holidays/christmas',
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'like', '%anniversary%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/anniversary'
                    '/invitations',
                    '/invitations/anniversary',
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'like', '%pool%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/summer-and-pool-party'
                    '/invitations',
                    '/invitations/summer-and-pool-party',
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'like', '%housewarming%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/housewarming',
                    // '/cards/party/housewarming'
                    '/invitations',
                    '/invitations/housewarming',
                    '/invitations/party/housewarming'
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'like', '%graduation%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/graduation',
                    // '/cards/party/graduation-party'
                    '/invitations',
                    '/invitations/graduation',
                    '/invitations/party/graduation'
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'like', '%easter%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/holidays',
                    // '/cards/holidays/easter'
                    '/invitations',
                    '/invitations/easter',
                    '/invitations/holidays/easter'
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'like', '%patrick%')
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
        
        Template::where('title', 'like', '%thanksgiving%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/holidays',
                    // '/cards/holidays/thanksgiving'
                    '/invitations',
                    '/invitations/thanksgiving',
                    '/invitations/holidays/thanksgiving'
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'like', '%new%year%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/holidays',
                    // '/cards/holidays/new-year'
                    '/invitations',
                    '/invitations/new-year',
                    '/invitations/holidays/new-year'
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'like', '%valentine%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/holidays',
                    // '/cards/holidays/valentines-day'
                    '/invitations',
                    '/invitations/valentines-day',
                    '/invitations/holidays/valentines-day'
                ],
                'mainCategory' => '/invitations'
            ]);

        Template::where('title', 'like', '%halloween%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/holidays',
                    // '/cards/holidays/halloween'
                    '/invitations',
                    '/invitations/halloween',
                    '/invitations/holidays/halloween'
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'like', '%baptism%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/baptism-and-christening'
                    '/invitations',
                    '/invitations/baptism',
                    '/invitations/holidays/baptism'
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'like', '%baby%shower%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/baby-shower'
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'like', '%brunch%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/party/brunch'
                    '/invitations/brunch'
                ],
                'mainCategory' => '/invitations'
            ]);
        
        Template::where('title', 'like', '%sleepover%')
            ->update([
                'categories' => [
                    // '/cards',
                    // '/cards/party/sleepover'
                    '/invitations/sleepover'
                ],
                'mainCategory' => '/invitations'
            ]);
            
        echo "TERMINE !!";
    }
}
