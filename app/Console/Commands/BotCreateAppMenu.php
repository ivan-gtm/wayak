<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class BotCreateAppMenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:4-createmenu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create REDIS menu cache, based only on categories that had temmplates';

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
        $categories = Redis::keys('wayak:en:categories:*');
        $country = 'us';
        
        $menu = [];
        foreach($categories as $category) {
            $cat_params = [];
            $category_slug = str_replace( 'wayak:en:categories:',null, $category);

            if( Template::whereNotNull('slug')->whereIn('categories', ['/'.$category_slug])->count() > 0 ){
                
                $categorie_levels = explode('/',$category_slug);
                $categorie_levels_size = sizeof($categorie_levels);
                $cat_params['country'] = $country;

                for ($i=1; $i <= $categorie_levels_size; $i++) { 
                    $cat_params['cat_lvl_'.$i] = $categorie_levels[$i-1];
                }

                $cat_metadata = json_decode( Redis::get( $category ) );
                $url = route( 'showCategoryLevel'.$categorie_levels_size, $cat_params );
                $menu['templates'][] = [
                    'name' => $cat_metadata->name,
                    'url' => $url
                ];
            }
        }

        foreach (['es','mx','co','ar','bo','ch','cu','do','sv','hn','ni', 'pe', 'uy', 've','py','pa','gt','pr','gq','us','ca','gb','gh','ke','lr','ng'] as $country) {
            Redis::set('wayak:'.$country.':menu', str_replace('\\/us\\/','\\/'.$country.'\\/',json_encode($menu)) );
        }

    }
}
