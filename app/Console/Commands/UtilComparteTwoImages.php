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

class UtilComparteTwoImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:util:compare-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Compare images similarity';

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
        $rgb = $this->compareTwoImages();
        
    }
    
    function compareTwoImages($rgb){
        //create image resources from the two images
        $image1 = imagecreatefromjpeg('image1.jpg');
        $image2 = imagecreatefromjpeg('image2.jpg');

        //get the width and height of the images
        $width = imagesx($image1);
        $height = imagesy($image1);

        //counter for the number of different pixels
        $diff_pixels = 0;

        //compare each pixel of the two images
        for ($x=0; $x<$width; $x++) {
            for ($y=0; $y<$height; $y++) {
                //get the color of the current pixel in each image
                $rgb1 = imagecolorat($image1, $x, $y);
                $rgb2 = imagecolorat($image2, $x, $y);
                //compare the color values
                if ($rgb1 != $rgb2) {
                    $diff_pixels++;
                }
            }
        }

        //calculate the percentage of different pixels
        $total_pixels = $width * $height;
        $diff_percent = ($diff_pixels / $total_pixels) * 100;

        //print out the result
        echo "The two images are $diff_percent% different.";

        //free up memory
        imagedestroy($image1);
        imagedestroy($image2);

    }
}
