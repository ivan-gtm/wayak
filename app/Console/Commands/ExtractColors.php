<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Imagick;
use ImagickException;
use App\Models\Template;
use League\ColorExtractor\Color;
use League\ColorExtractor\ColorExtractor;
use League\ColorExtractor\Palette;
use Illuminate\Support\Facades\App;
use Storage;

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
        $this->info('Fetching up to 10 completed templates...');
        // Exclude templates that have status 'failed'
        $templates = Template::whereNull('colors')->get();

        if ($templates->isEmpty()) {
            $this->info('No templates found to update.');
            return 0;
        }

        // $consecutiveFailures = 0;  // Initialize consecutive failure counter

        foreach ($templates as $index => $template) {
            $this->info('Processing template ' . ($index + 1) . ' of ' . $templates->count() . '...');
            $this->info('Template >> '.$template->_id.' >> http://localhost:8001/us/template/baby-shower-hippo-'.$template->_id);
            
            // $fileName = $template->_id . '/thumbnails/en/' . $template->previewImageUrls['large'];
            // $filePath = public_path('/design/template/'.$fileName);
            // $topColors = $this->getTopColorsFromImage2($filePath);
            $language_code = 'en'; // Temporal
            if (App::environment() == 'local') {
                $preview_image = asset('design/template/' . $template->_id . '/thumbnails/' . $language_code . '/' . $template->previewImageUrls["product_preview"]);
                // print_r($preview_image);
                // echo App::environment();
                // exit;
            } else {
                $preview_image = Storage::disk('s3')->url('design/template/' . $template->_id . '/thumbnails/' . $language_code . '/' . $template->previewImageUrls["product_preview"]);
            }
            if (App::environment() == 'local') {
                $thumb_path = public_path('design/template/' . $template->_id . '/thumbnails/' . $language_code . '/' . $template->previewImageUrls["product_preview"]);
            } else {
                $thumb_path = $preview_image;
            }

            try {
                $topColors = $this->getTopColorsFromImage2($thumb_path);
                $template->colors = $topColors;
                $template->save();
            } catch (\Throwable $th) {
                //throw $th;
            }
            
            // print_r($thumb_path);
            // print_r(array_keys($topColors));
        }
    }

    private function getTopColorsFromImage2($thumb_path){
        
        $palette = Palette::fromFilename($thumb_path);
        $extractor = new ColorExtractor($palette);
        $colors = $extractor->extract(10);
        for ($i = 0; $i < sizeof($colors); $i++) {
            $colors[$i] = Color::fromIntToHex($colors[$i]);
        }
        
        // print_r($colors);
        // exit;

        return $colors;
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
            return array_slice($colors, 0, 10, true);
        } catch (ImagickException $e) {
            $this->error("An error occurred while processing $filePath: " . $e->getMessage());
            return [];
        }
    }
}
