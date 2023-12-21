<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

use App\Traits\LocaleTrait;

class CodeController extends Controller
{
    // Define a constant for expiration time
    const EXPIRATION_TIME = 86400;  // 24 hours in seconds
    use LocaleTrait;
    /**
     * Validates the code based on the given country and request parameters.
     *
     * @param string $country
     * @param Request $request
     * @return \Illuminate\View\View
     */
    function validateCode($country, Request $request)
    {
        $locale = $this->getLocaleByCountry($country);

        // Set the application's locale
        App::setLocale($locale);

        // Extract data from the request or set default values
        $templates = $request->input('templates', 0);
        $search_query = $request->input('searchQuery', '');
        $product_id = $request->input('product_id', '');
        $customerId = null;

        if (Auth::check()) {
            // User is logged in
            // $logged_id = Auth::id();
            $user = Auth::user();
            $customerId = isset($user->customer_id) ? $user->customer_id : null;
        }

        // Retrieve menu and sale details from Redis
        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        // Return the validation view with the extracted and retrieved data
        return view('redeem_code', compact('country', 'menu', 'sale', 'search_query', 'customer_id', 'product_id', 'templates'));
    }

    /**
     * Handles the redemption of a code by a user.
     *
     * @param string $country The country code to specify the regional configuration.
     * @param Request $request The request object containing user input.
     * @return \Illuminate\Http\Response
     */
    public function redeemCode($country, Request $request)
    {
        // Retrieve sale configurations from Redis using the country code.
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        // Fetch the menu from Redis and decode the JSON data.
        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));

        // Concatenate the individual digits from the request to form a four-digit code.
        $four_digit_code = $request->digit1 . $request->digit2 . $request->digit3 . $request->digit4;

        // Get the search query from the request, defaulting to an empty string if not provided.
        $search_query = $request->input('searchQuery', '');

        // Attempt to get the customer ID from the request.
        $customerId = $request->input('user_id', null);

        // Attempt to get the product ID from the request.
        $product_id = $request->input('product_id', null);

        // Check if a user is logged in.
        if (Auth::check()) {
            $user = Auth::user();
            // If the logged-in user has a customer ID, use it.
            if (isset($user->customer_id)) {
                $customerId = $user->customer_id;
            }
        }

        // Check if the four-digit code exists in Redis.
        if (!Redis::exists('wayak:admin:template:code:' . $four_digit_code)) {
            // If not, render a view with an error message indicating the code does not exist.
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code does not exist', $product_id, $customerId);
        }

        // Check if the code has already been redeemed by the user.
        if (Redis::exists('wayak:user:' . $customerId . ':code:' . $four_digit_code)) {
            // If so, render a view with an error message indicating the code has been redeemed.
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code already redeemed', $product_id, $customerId);
        }

        // Retrieve the details of the code from Redis.
        $code_details = Redis::hgetall('wayak:admin:template:code:' . $four_digit_code);

        // if (!$customerId) {
        //     return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'User does not exist', $product_id);
        // }

        // Check if the code requires the user to be logged in and verify if the user exists in Redis.
        if ($code_details['user_requirement'] == 'logged_id' && !Redis::exists('wayak:user:' . $customerId)) {
            // If the user requirement is 'logged_id' and the user does not exist in Redis, render a view with an error message.
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'User does not exist', $product_id, $customerId);
        }

        // Check if the number of redeemers for the code is set and equals zero.
        if ($code_details['number_of_redeemers'] != '' && $code_details['number_of_redeemers'] == 0) {
            // If the number of redeemers is zero, it implies the code is expired. Render a view indicating the code has expired.
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code expired.', $product_id, $customerId);
        }

        // Check if the expiration date of the code is set and has passed.
        if ($code_details['expires_at'] != '' && \Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $code_details['expires_at']))) {
            // If the current time is greater than the expiration time of the code, render a view indicating the code has expired.
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code expired.', $product_id, $customerId);
        }

        // Check if the code is tied to a specific product and if the provided product ID does not match.
        if ($code_details['type'] == 'product' && $product_id != null && $code_details['product_id'] != $product_id) {
            // If the code type is 'product' and the product ID does not match the one specified in the code details, render a view with an error message.
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code for this product does not exists.', $product_id, $customerId);
        }

        // Check if the code is tied to a specific category and if that category exists.
        if ($code_details['type'] == 'category' && !Redis::exists('wayak:en:categories:' . $code_details['category_id'])) {
            // If the code type is 'category' and the category does not exist in Redis, render a view with an error message.
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code for this product does not exists.', $product_id, $customerId);
        }

        // If the code type is 'product', set the product_id to the one specified in the code details.
        if ($code_details['type'] == 'product') {
            $product_id = $code_details['product_id'];
        }

        // echo $product_id;
        // exit;

        // If all conditions pass and the product ID is valid, show editor template.
        if ($product_id != '' && $this->processTemplate($code_details['type'], $product_id, $customerId, $four_digit_code, $country)) {
            return view('editor', [
                'templates' => $product_id,
                'purchase_code' => $four_digit_code,
                'language_code' => 'en',
                'demo_as_id' => 0,
                'user_role' => 'customer'
            ]);
        }

        return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code is not valid', $product_id, $customerId);
    }

    private function renderValidationCodeView($country, $sale, $menu, $search_query, $error, $product_id, $customerId)
    {
        return view('redeem_code', [
            'country' => $country,
            'sale' => $sale,
            'menu' => $menu,
            'customer_id' => $customerId,
            'search_query' => $search_query,
            'error' => $error,
            'code_validation' => 0,
            'product_id' => $product_id
        ]);
    }

    private function processTemplate($type, $product_id, $customerId, $four_digit_code, $country)
    {
        $templateTypes = ['product', 'category', 'any_product'];

        if (in_array($type, $templateTypes) && Template::where('_id', '=', $product_id)->exists()) {
            $temporal_template_key = $this->createTemporalUserCode($customerId, $four_digit_code);

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

    private function createTemporalUserCode($customerId, $four_digit_code)
    {
        $digits = 10;
        $template_digits = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $destinationKey = 'wayak:user:' . $customerId . ':code:' . $four_digit_code;

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
