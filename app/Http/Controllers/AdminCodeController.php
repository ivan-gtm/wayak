<?php

namespace App\Http\Controllers;

// use App\Models\Template;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class AdminCodeController extends Controller
{
    // Define a constant for expiration time
    const EXPIRATION_TIME = 86400;  // 24 hours in seconds

    /**
     * Display the form to create a new promotional code.
     *
     * @return \Illuminate\View\View
     */
    public function showCreateForm()
    {
        return view('admin.create_code_form');
    }

    /**
     * Handle the creation of a new promotional code.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createCode($country, Request $request)
    {
        $four_digit_code = rand(1000, 9999);
        $type = $request->input('type');
        $discountType = $request->input('discount_type');
        $product_id = $request->input('product_id');
        $category_id = ($type == 'product' || $type == 'category') ? $request->input('category') : null;
        $fixed_price = $request->input('fixed_price', null);
        $percentage_discount = $request->input('percentage_discount', null);
        $number_of_redeemers = $request->input('numberOfRedeemers', null);
        $user_requirement = $request->input('userRequirement', null);
        $expires_at = $request->input('expiresAt', null);

        if($discountType == 'free'){
            $percentage_discount = 100;
            $fixed_price = 0;
        } elseif($discountType == 'percentage'){
            $percentage_discount = intval($percentage_discount);
            $fixed_price = 0;
        } elseif($discountType == 'fixed'){
            $percentage_discount = 0;
            $fixed_price = number_format($fixed_price, 2);
        }

        // Store the promotional code in Redis
        $promoKey = 'wayak:admin:template:code:' . $four_digit_code;
        Redis::hmset($promoKey, [
            'type' => $type,
            'discountType' => $discountType,
            'product_id' => $product_id,
            'category_id' => $category_id,
            'fixed_price' => $fixed_price,
            'percentage_discount' => $percentage_discount,
            'number_of_redeemers' => $number_of_redeemers,
            'user_requirement' => $user_requirement,
            'expires_at' => $expires_at
        ]);
        Redis::expire($promoKey, self::EXPIRATION_TIME);  // Set an expiration for the promo code

        // Fetch and return all created codes with their details
        $redis_codes = Redis::keys('wayak:admin:template:code:*');
        $codes = [];

        if (sizeof($redis_codes) > 0) {
            foreach ($redis_codes as $redis_key_code) {
                $details = Redis::hgetall($redis_key_code);
                $details['code'] = $this->getCode($redis_key_code);

                if ($details['type'] == 'product') {
                    $details['template_img'] = $this->getThumbnailUrl($details['product_id']);
                }
                $codes[] = $details;
            }
        }

        return redirect()->route('admin.code.manage', ['country' => $country])->with('success', 'Code created successfully!');
    }

    private function getCode($redis_key_code)
    {
        // Assuming the code is the last part of the Redis key, separated by a colon
        $parts = explode(':', $redis_key_code);
        return end($parts); // Returns the last element from the parts array
    }

    // function getCode($redis_key_code)
    // {
    //     // Use preg_match to extract digits
    //     if (preg_match('/(\d+)/', $redis_key_code, $matches)) {
    //         $digit_part = $matches[1];
    //         return $digit_part;  // Outputs: 9177
    //     }

    //     return false;
    // }

    function manageCodes($country)
    {

        $redis_codes = Redis::keys('wayak:admin:template:code:*');
        $details = [];
        $codes = [];
        
        if(sizeof($redis_codes) > 0){
            foreach ($redis_codes as $redis_key_code) {
    
                $details = Redis::hgetall($redis_key_code);
                $details['code'] = $this->getCode($redis_key_code);
    
                if ($details['type'] == 'product') {
                    $details['template_img'] = $this->getThumbnailUrl($details['product_id']);
                }
                $codes[] = $details;
            }
        }

        return view('admin.create_code_form', [
            'country' => $country,
            'codes' => $codes,
            'categories' => $this->getTotalDocumentsByCategory()
        ]);
    }

    function getThumbnailUrl($template_key)
    {
        $thumbnail_info = DB::table('thumbnails')
            ->where('template_id', $template_key)
            ->first();

        return $thumbnail_info
            ? asset('design/template/' . $template_key . '/thumbnails/en/' . $thumbnail_info->filename)
            : null;
    }

    function getTotalDocumentsByCategory()
    {
        // Group by category and count the total number of documents in each category
        $categoryCounts = Template::raw(function($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => '$mainCategory', // Group by category field
                        'total' => ['$sum' => 1] // Count the total number of documents
                    ]
                ],
                [
                    '$project' => [
                        'category' => '$_id',
                        'total' => 1,
                        '_id' => 0
                    ]
                ]
            ]);
        });
        $categories = [];
        foreach ($categoryCounts as $category) {
            // echo "<pre>";
            // print_r(json_decode(Redis::get('wayak:en:categories:' . substr($category->category, 1))));
            $category_obj = json_decode(Redis::get('wayak:en:categories:' . substr($category->category, 1)));
            
            $category{'name'} = $category_obj->name;
            $category{'total'} = $category->total;
            $category{'id'} = substr($category->category, 1);
            $categories[] = $category;

        }

        return $categories;
    }


    public function deleteCode($country, $four_digit_code)
    {
        $codeKey = 'wayak:admin:template:code:' . $four_digit_code;
        Redis::del($codeKey);
        
        return redirect()->action(
            [AdminCodeController::class,'manageCodes'], ['country' => $country]
        )->with('success', 'Code deleted successfully!');
    }
}
