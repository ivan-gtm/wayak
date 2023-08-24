<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Imagick;
use ImagickException;

class ExtractColors extends Command
{
    protected $signature = 'utils:extract:colors';

    protected $description = 'Extract top colors from thumbnails in design/template directories';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $basePath = public_path('design/template');
        $directories = glob($basePath . '/*', GLOB_ONLYDIR);

        foreach ($directories as $dir) {
            $thumbnailFiles = glob($dir . '/thumbnails/*thumbnail*.jpg'); // Adjust the file extension if necessary

            foreach ($thumbnailFiles as $file) {
                $this->info("Extracting colors from: " . basename($file));

                $topColors = $this->getTopColorsFromImage($file);

                foreach ($topColors as $hex => $count) {
                    $this->line("Color: $hex, Occurrence: $count");
                }
            }
        }
    }

    private function getTopColorsFromImage($filePath)
    {
        try {
            // Load the image
            $image = new Imagick($filePath);

            // Reduce the image to a palette of colors
            $image->quantizeImage(256, Imagick::COLORSPACE_RGB, 0, false, false);

            // Extract the color palette
            $histogram = $image->getImageHistogram();

            $colors = [];
            foreach ($histogram as $pixel) {
                $color = $pixel->getColor();
                $hexColor = sprintf("#%02x%02x%02x", $color['r'], $color['g'], $color['b']);
                $colors[$hexColor] = isset($colors[$hexColor]) ? $colors[$hexColor] + $pixel->getColorCount() : $pixel->getColorCount();
            }

            arsort($colors);
            return array_slice($colors, 0, 5, true);
        } catch (ImagickException $e) {
            $this->error("An error occurred while processing $filePath: " . $e->getMessage());
            return [];
        }
    }
}
