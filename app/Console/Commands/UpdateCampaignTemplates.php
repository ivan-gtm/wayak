<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Illuminate\Support\Facades\Redis;

class UpdateCampaignTemplates extends Command {
    protected $signature = 'campaign:update-templates {redisKey} {discountPercentage}';
    protected $description = 'Updates templates with new campaign details';

    public function handle() {
        $redisKey = $this->argument('redisKey');
        $discountPercentage = $this->argument('discountPercentage');

        $this->info('Starting to update templates...');
        $this->info("Redis Key: $redisKey");
        $this->info("Discount Percentage: $discountPercentage%");

        $newPriceCalculation = function ($originalPrice) use ($discountPercentage) {
            // Calculate the new price
            $newPrice = $originalPrice * (1 - $discountPercentage / 100);
            // Format the new price to 2 decimal places
            return number_format($newPrice, 2, '.', '');
        };

        Template::chunk(200, function ($templates) use ($newPriceCalculation, $discountPercentage) {
            foreach ($templates as $template) {
                $newPrice = $newPriceCalculation($template->prices['original_price']);
                $this->info("Updating template ID: {$template->id}, New Price: $newPrice");

                Template::where('_id', $template->id )
                ->update([
                    'prices.price' => $newPrice,
                    'prices.discount_percent' => $discountPercentage
                ]);
            }
        });

        Redis::hset($redisKey, 'status', 1);

        $this->info('Templates updated successfully!');
    }
}
