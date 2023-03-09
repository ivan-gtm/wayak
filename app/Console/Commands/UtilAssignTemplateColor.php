<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
// use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

ini_set("max_execution_time", 0);   // no time-outs!
ignore_user_abort(true);            // Continue downloading even after user closes the browser.

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '-1');

class UtilAssignTemplateColor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:util:assigncolor';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign human color to templates';

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
     * @return mixed
     */
    public function handle()
    {   
        $this->getTemplateColor();
    }
    
    function getTemplateColor(){
        $rgb = $this->getMainRGBColor();
        $color = $this->getHumanColor($rgb);
    }
    
    function getHumanColor($rgb){
        // https://github.com/ourcodeworld/name-that-color
        // Load the NameThatColor library
        require_once('path/to/namethatcolor/namethatcolor.php');

        // Define the RGB value that you want to get the color name for
        $rgb = array(255, 0, 0); // Red

        // Get the color name from the RGB value
        $colorName = NameThatColor\Color::name($rgb);

        // Output the color name as text
        echo 'Color name: ' . $colorName;
    }

    function getMainRGBColor(){
        // Define the path to your image file
        $imagePath = 'path/to/image.jpg';

        // Create an image resource from the image file
        $image = imagecreatefromjpeg($imagePath);

        // Resize the image to a smaller size for faster processing
        $smallImage = imagescale($image, 50);

        // Get the color index of the most frequently used color in the image
        $colorIndex = imagecolorstotal($smallImage);

        // Get the RGB values of the color index
        $rgb = imagecolorsforindex($smallImage, $colorIndex - 1);

        // Print the RGB values of the main color
        echo 'R: ' . $rgb['red'] . ', G: ' . $rgb['green'] . ', B: ' . $rgb['blue'];

        // Free up memory by destroying the image resources
        imagedestroy($image);
        imagedestroy($smallImage);

        // An alternative could be use this library https://github.com/ksubileau/color-thief-php

        return $rgb;
    }
}
