<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
use Storage;
use Illuminate\Support\Facades\App;

class CreateHomeCarousels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:X-createcarousels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create REDIS carousels based on querys from MongoDB cache';

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
        $country = 'us';
        $language_code = 'en';
        $total_items_per_carousel = 30;
        
        
        $search_result = Template::where('title', 'like', '%baby shower%')
        ->where('width','=','5')
        ->where('height','=','7')
        ->take($total_items_per_carousel)
        ->get([
            'title',
            'slug',
            'previewImageUrls',
            'width',
            'height',
            'forSubscribers',
            'previewImageUrls'
        ]);

        $templates = [];
        foreach ($search_result as $template) {
            
            if( App::environment() == 'local' ){
                $template->preview_image_url = asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls['carousel'] );
            } else {
                $template->preview_image_url = Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls['carousel'] );
            }
            $templates[] = $template;
        }

        $carousels[] = [
            'slider_id' => Str::random(5),
            'title' => 'Templates for "Baby shower"',
            'items' => $templates
        ];
            
        $search_result = Template::where('title', 'like', '%unicorn%')
            ->where('width','=','5')
            ->where('height','=','7')
            ->take($total_items_per_carousel)
            ->get([
                'title',
                'slug',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'previewImageUrls'
            ]);

        $templates = [];
        foreach ($search_result as $template) {
            
            if( App::environment() == 'local' ){
                $template->preview_image_url = asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls['carousel'] );
            } else {
                $template->preview_image_url = Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls['carousel'] );
            }
            $templates[] = $template;
        }

        $carousels[] = [
            'slider_id' => Str::random(5),
            'title' => 'Unicorn Templates',
            'items' => $templates
        ];

        $search_result = Template::where('title', 'like', '%save%date%')
            ->where('width','=','5')
            ->where('height','=','7')
            ->take($total_items_per_carousel)
            ->get([
                'title',
                'slug',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'previewImageUrls'
            ]);

        $templates = [];
        foreach ($search_result as $template) {
            
            if( App::environment() == 'local' ){
                $template->preview_image_url = asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls['carousel'] );
            } else {
                $template->preview_image_url = Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls['carousel'] );
            }
            $templates[] = $template;
        }

        $carousels[] = [
            'slider_id' => Str::random(5),
            'title' => 'Templates for "Save The Date"',
            'items' => $templates
        ];

        $search_result = Template::where('title', 'like', '%wedding%')
            ->where('width','=','5')
            ->where('height','=','7')
            ->take($total_items_per_carousel)
            ->get([
                'title',
                'slug',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'previewImageUrls'
            ]);
        
        $templates = [];
        foreach ($search_result as $template) {
            
            if( App::environment() == 'local' ){
                $template->preview_image_url = asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls['carousel'] );
            } else {
                $template->preview_image_url = Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls['carousel'] );
            }
            $templates[] = $template;
        }

        $carousels[] = [
            'slider_id' => Str::random(5),
            'title' => 'Templates for "Wedding Invitations"',
            'items' => $templates
        ];

        $search_result = Template::where('title', 'like', '%birthday%')
            ->where('width','=','5')
            ->where('height','=','7')
            ->take($total_items_per_carousel)
            ->get([
                'title',
                'slug',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'previewImageUrls'
            ]);

        $templates = [];
        foreach ($search_result as $template) {
            
            if( App::environment() == 'local' ){
                $template->preview_image_url = asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls['carousel'] );
            } else {
                $template->preview_image_url = Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls['carousel'] );
            }
            $templates[] = $template;
        }

        $carousels[] = [
            'slider_id' => Str::random(5),
            'title' => 'Birthday Invitation Templates',
            'items' => $templates
        ];

        $search_result = Template::where('title', 'like', '%glitter%')
            ->where('width','=','5')
            ->where('height','=','7')
            ->take($total_items_per_carousel)
            ->get([
                'title',
                'slug',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'previewImageUrls'
            ]);

        $templates = [];
        foreach ($search_result as $template) {
            
            if( App::environment() == 'local' ){
                $template->preview_image_url = asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls['carousel'] );
            } else {
                $template->preview_image_url = Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls['carousel'] );
            }
            $templates[] = $template;
        }

        $carousels[] = [
            'slider_id' => Str::random(5),
            'title' => 'Glitter',
            'items' => $templates
        ];
        
        $search_result = Template::where('title', 'like', '%tropical%')
            ->where('width','=','5')
            ->where('height','=','7')
            ->take($total_items_per_carousel)
            ->get([
                'title',
                'slug',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'previewImageUrls'
            ]);
        
        $templates = [];
        foreach ($search_result as $template) {
            
            if( App::environment() == 'local' ){
                $template->preview_image_url = asset( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls['carousel'] );
            } else {
                $template->preview_image_url = Storage::disk('s3')->url( 'design/template/'.$template->_id.'/thumbnails/'.$language_code.'/'.$template->previewImageUrls['carousel'] );
            }
            $templates[] = $template;
        }

        $carousels[] = [
            'slider_id' => Str::random(5),
            'title' => 'Tropical',
            'items' => $templates
        ];

        $carousels = json_encode($carousels);
        // $carousels = json_decode($carousels);
        // $carousels = json_decode($carousels);

        // echo "<pre>";p
        // print_r($carousels);
        
        Redis::set('wayak:'.$country.':home:carousels', $carousels);

        return 0;
    }
}
