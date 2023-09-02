<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\App;

class CodeController extends Controller
{
    // Define a constant for expiration time
    const EXPIRATION_TIME = 86400;  // 24 hours in seconds

    /**
     * Validates the code based on the given country and request parameters.
     *
     * @param string $country
     * @param Request $request
     * @return \Illuminate\View\View
     */
    function validateCode($country, Request $request)
    {
        // Determine the locale based on the country
        $locales = [
            'en' => ['us', 'ca'],
            'es' => ['es', 'mx', 'co', 'ar', 'bo', 'ch', 'cu', 'do', 'sv', 'hn', 'ni', 'pe', 'uy', 've', 'py', 'pa', 'gt', 'pr', 'gq']
        ];

        $locale = 'en';  // default locale
        foreach ($locales as $key => $countries) {
            if (in_array($country, $countries)) {
                $locale = $key;
                break;
            }
        }

        // Set the application's locale
        App::setLocale($locale);

        // Extract data from the request or set default values
        $templates = $request->input('templates', 0);
        $search_query = $request->input('searchQuery', '');
        $product_id = $request->input('product_id', '');

        // Retrieve menu and sale details from Redis
        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        // Return the validation view with the extracted and retrieved data
        return view('redeem_code', compact('country', 'menu', 'sale', 'search_query', 'product_id', 'templates'));
    }

    public function redeemCode($country, Request $request)
    {
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');
        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $four_digit_code = $request->digit1 . $request->digit2 . $request->digit3 . $request->digit4;
        $search_query = $request->input('searchQuery', '');
        $user_id = $request->input('user_id', 123);;  // hardcoded for now

        $product_id = $request->input('product_id', null);
        // echo $four_digit_code;
        // exit;

        if (!Redis::exists('wayak:admin:template:code:' . $four_digit_code)) {
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code does not exist', $product_id);
        }

        if (Redis::exists('wayak:user:' . $user_id . ':code:' . $four_digit_code)) {
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code already redeemed', $product_id);
        }

        $code_details = Redis::hgetall('wayak:admin:template:code:' . $four_digit_code);

        // if (!$user_id) {
        //     return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'User does not exist', $product_id);
        // }

        if ($code_details['user_requirement'] == 'logged_id' && !Redis::exists('wayak:user:' . $user_id)) {
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'User does not exist', $product_id);
        }

        if ($code_details['number_of_redeemers'] != '' && $code_details['number_of_redeemers'] == 0) {
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code expired.', $product_id);
        }

        if ($code_details['expires_at'] != '' && \Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $code_details['expires_at']))) {
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code expired.', $product_id);
        }

        if ($code_details['type'] == 'product' && $product_id != null && $code_details['product_id'] != $product_id) {
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code for this product does not exists.', $product_id);
        }

        if ($code_details['type'] == 'category' && !Redis::exists('wayak:en:categories:' . $code_details['category_id'])) {
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code for this product does not exists.', $product_id);
        }

        if ($code_details['type'] == 'product') {
            $product_id = $code_details['product_id'];
        }

        // echo $product_id;
        // exit;

        if ($product_id != '' && $this->processTemplate($code_details['type'], $product_id, $user_id, $four_digit_code, $country)) {
            return view('editor', [
                'templates' => $product_id,
                'purchase_code' => $four_digit_code,
                'language_code' => 'en',
                'demo_as_id' => 0,
                'user_role' => 'customer'
            ]);
        }

        return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code is not valid', $product_id);
    }

    private function renderValidationCodeView($country, $sale, $menu, $search_query, $error, $product_id)
    {
        return view('redeem_code', [
            'country' => $country,
            'sale' => $sale,
            'menu' => $menu,
            'search_query' => $search_query,
            'error' => $error,
            'code_validation' => 0,
            'product_id' => $product_id
        ]);
    }

    private function processTemplate($type, $product_id, $user_id, $four_digit_code, $country)
    {
        $templateTypes = ['product', 'category', 'any_product'];

        if (in_array($type, $templateTypes) && Template::where('_id', '=', $product_id)->exists()) {
            $temporal_template_key = $this->createTemporalUserCode($user_id, $four_digit_code);

            $this->createTemporalTemplate($product_id, $temporal_template_key);

            $template = Template::where('_id', '=', $product_id)->first();
            $template->downloads++;
            $template->save();

            return true;
        }

        return false;
    }

    private function createTemporalTemplate($original_template_key, $temporal_template_key)
    {
        $destination_template_key = "template:en:" . $temporal_template_key . ":jsondata";
        Redis::set($destination_template_key, Redis::get($original_template_key));
        Redis::expire($destination_template_key, self::EXPIRATION_TIME);
    }

    private function createTemporalUserCode($user_id, $four_digit_code)
    {
        $digits = 10;
        $template_digits = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $destinationKey = 'wayak:user:' . $user_id . ':code:' . $four_digit_code;

        $this->copyKey('wayak:admin:template:code:' . $four_digit_code, $destinationKey);
        Redis::hset($destinationKey, 'template_id', "template:en:temp" . $template_digits . ":jsondata");
        Redis::expire($destinationKey, self::EXPIRATION_TIME);

        return "template:en:temp" . $template_digits . ":jsondata";
    }

    private function copyKey($sourceKey, $destinationKey)
    {
        $sourceHashData = Redis::hgetall($sourceKey);
        foreach ($sourceHashData as $field => $value) {
            Redis::hset($destinationKey, $field, $value);
        }
    }
}
