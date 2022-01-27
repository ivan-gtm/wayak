<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Facades\DB;

class UtilCalculateColors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:util:getcolors';

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
        $templates = DB::select( DB::raw(
            "SELECT 
                thumbnails.template_id, thumbnails.filename 
            FROM 
                thumbnails,templates
            WHERE
                thumbnails.template_id = templates.template_id
                AND templates.source = 'templett'
                AND templates.status = 5
                AND thumbnails.language_code = 'en'
                AND thumbnails.thumbnail_ready IS NOT NULL
            LIMIT 300") 
        );

        foreach ($templates as $template) {
            $thumb_path = public_path( 'design/template/'. $template->template_id.'/thumbnails/en/'.$template->filename);
            $thumb_url = asset( 'design/template/'. $template->template_id.'/thumbnails/en/'.$template->filename);
            $path = pathinfo($thumb_path);
            
            $palette = Palette::fromFilename($thumb_path);

            // // // $palette is an iterator on colors sorted by pixel count
            // echo '<table>';
            // foreach($palette as $color => $count) {
            //     // colors are represented by integers
            //     // echo Color::fromIntToHex($color), ': ', $count, "\n";
            //     echo '<tr><td>'.Color::fromIntToHex($color).'</td><td style="background-color:'.Color::fromIntToHex($color).';">'.$count.'</td></tr>';
            // }
            // echo '</table>';

            // // it offers some helpers too
            $topFive = $palette->getMostUsedColors(10);
            // // echo "<pre>";
            // print_r($topFive);
            // echo '<table>';
            // foreach($topFive as $hexadecimal => $value ){
            //         echo '<tr><td>'.Color::fromIntToHex($hexadecimal).'</td><td style="background-color:'.Color::fromIntToHex($hexadecimal).';">RGB</td></tr>';
            // }
            // echo '<table>';

            // $colorCount = count($palette);

            // $blackCount = $palette->getColorCount(Color::fromHexToInt('#000000'));


            // an extractor is built from a palette
            $extractor = new ColorExtractor($palette);

            // it defines an extract method which return the most “representative” colors
            $colors = $extractor->extract(10);

            
            echo "<pre>";
            // print_r($colors);
            echo '<img src="'.$thumb_url.'">';
            echo '<table>';
            for ($i=0; $i < sizeof($colors); $i++) { 
                    echo '<tr><td>'.Color::fromIntToHex($colors[$i]).'</td><td style="background-color:'.Color::fromIntToHex($colors[$i]).';">RGB</td></tr>';
            }
            echo '<table>';

        }
    }
}
