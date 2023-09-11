<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class UtilUpdateTemplateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:util:template:update-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the template collection with random data';

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
        // Fetch all documents in the templates collection
        $templates = Template::all();
        // $templates = Template::get();
        // $templates = Template::whereNotNull('category')->get();

        // Define an array of human-friendly author names
        $authorNames = [
            'ArtisticWave', 'DesignHub', 'PixelCraft', 'FontMasters', 'DreamThemes', 'StyleBridges',
            'ColorMind', 'PalettePioneers', 'VectorVogue', 'CreativeCore', 'IdeaInventors', 'TextCrafters',
            'GraphiGrove', 'FrameFusion', 'PixelPioneers', 'CanvasKings', 'VividVisuals', 'QuirkQueens',
            'InspireInk', 'BlendBuddies', 'MuseMasters', 'ChicCanvas', 'DetailDreams', 'VisualVortex',
            'ImageryInk', 'EthosElements', 'FantasyFrames', 'DesignDazzle', 'VisionVenture', 'MosaicMinds',
            'DataDesigners', 'InventIdea', 'GeniusGraphs', 'FormFables', 'UnityUniverse', 'PicturePerfect',
            'WonderWeavers', 'IconicIdeas', 'StriveStudios', 'SymmetrySouls', 'RealityRender', 'MajesticMuse',
            'SketchSaga', 'RoyalRender', 'AestheticArt', 'QuestQuills', 'RadiantRealm', 'ElegantEnigma',
            'CraftedCoders', 'MotionMasters', 'HarmonyHaven', 'ElementEdge', 'InnoInkers', 'WovenWorlds',
            'PlushPixels', 'FancyFusion', 'CosmicCrafters', 'ZenithZone', 'OpticOasis', 'DoodleDynasty',
            'CharmCraft', 'PrestigePixels', 'WhimsyWorks', 'ScribeSquad', 'CodeCraftsmen', 'EpicElement',
            'ExquisiteEtch', 'InfernoInks', 'StellarStrokes', 'StudioSymphony', 'EcoEasel', 'GeoGraphs',
            'LushLines', 'PrimalPalette', 'QuintEssence', 'LuxeLayers', 'NeonNest', 'OrbitOrigins',
            'PolishProse', 'ZenZones', 'BareBanners', 'BloomBrush', 'CosmosCraft', 'DawnDesigns',
            'EliteEasel', 'FusionFrames', 'InfiniteInks', 'JewelJunction', 'KaleidoKraft', 'LunarLyric',
            'MysticMarks', 'NobleNibs', 'OrnateOrigins', 'PurePalette', 'RegalRenders', 'SilkenScripts',
            'StellarScribes', 'TimelessTextures', 'UnityUnveil', 'VividVessels'
        ];


        // Initialize the progress bar
        $bar = $this->output->createProgressBar(count($templates));

        foreach ($templates as $template) {

            $randomPrice = mt_rand(500, 1500) / 100;
            $randomAuthor = $authorNames[array_rand($authorNames)];
            $randomSales = mt_rand(800, 40000);
            $randomStars = mt_rand(30, 50) / 10;

            Template::where('_id', $template->id )
            ->update([
                'price' => $randomPrice,
                'prices.original_price' => $randomPrice,
                'prices.price' => $randomPrice,
                'prices.discount_percent' => 0,
                'author' => $randomAuthor,
                'sales' => $randomSales,
                'stars' => $randomStars
            ]);

            // unset the category field
            Template::where('_id', $template->id)->pull('category');

            // $this->info("Template:".$template->id);
            // $this->info("Title:".$template->title);
            // $this->info("Author:".$randomAuthor);
            
            // Advance the progress bar by one step
            $bar->advance();
            // return 0;
        }

        // Finish the progress bar
        $bar->finish();

        $this->info("\nTemplates updated successfully!");

        return 0;
    }
}
