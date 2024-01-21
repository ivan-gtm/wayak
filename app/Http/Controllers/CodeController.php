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
        $customer_id = null;

        // User is logged in
        if (Auth::check()) {
            // $logged_id = Auth::id();
            $user = Auth::user();
            $customer_id = isset($user->customer_id) ? $user->customer_id : null;
        }

        // Retrieve menu and sale details from Redis
        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        // Return the validation view with the extracted and retrieved data
        return view('redeem_code', compact('country', 'menu', 'sale', 'search_query', 'customer_id', 'product_id', 'templates'));
    }

    private function getCustomerIdFromUrl($referrerURL){
        // Parse the URL to get the query string
        $queryString = parse_url($referrerURL, PHP_URL_QUERY);
        
        // Parse the query string to get an associative array of parameters
        parse_str($queryString, $params);
        
        // Access the customerId from the parsed parameters
        $customerId = $params['customerId'] ?? null; // Using null coalescing operator in case customerId doesn't exist
        
        // echo $customerId; // Outputs: g4lpuq8u2w
        return $customerId;
    }

    private function getProductIdFromUrl($referrerURL){
        
        // Split the URL by '/'
        $parts = explode('/', $referrerURL);

        // The productId is the last part of the path, before the query string
        $lastPathSegment = end($parts);

        // If the URL contains a query string, remove it
        $productIdParts = explode('?', $lastPathSegment)[0];
        
        $parts = explode('-', $productIdParts);

        // The productId is the last part of the array
        $productId = end($parts);
        
        return $productId;

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
        $productMetadata = null;

        // Retrieve sale configurations from Redis using the country code.
        $sale = Redis::hgetall('wayak:' . $country . ':config:sales');

        // Fetch the menu from Redis and decode the JSON data.
        $menu = json_decode(Redis::get('wayak:' . $country . ':menu'));

        // Concatenate the individual digits from the request to form a four-digit code.
        $couponCode = $request->digit1 . $request->digit2 . $request->digit3 . $request->digit4;

        // Get the search query from the request, defaulting to an empty string if not provided.
        $search_query = $request->input('searchQuery', '');

        // Attempt to get user session
        $isLoggedIn = Auth::check();

        // Attempt to get the customer ID from the request.
        $customerId = $request->input('customer_id', null);

        // Attempt to get the product ID from the request.
        $productId = $request->input('product_id', null);
        
        
        // Attempt to get ref URL
        $refURL = $request->input('ref', null);
        
        if( isset($refURL) ) {
            $productId = self::getProductIdFromUrl($refURL);
            $customerId = self::getCustomerIdFromUrl($refURL);
            if( isset($productId) ) {
                $productMetadata = Template::where('_id', '=', $productId)->first();
            }
        }

        // Check if the four-digit code exists in Redis.
        if (!Redis::exists('wayak:admin:template:code:' . $couponCode)) {
            // If not, render a view with an error message indicating the code does not exist.
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code does not exist', $productId, $customerId);
        }

        // Retrieve the details of the code from Redis.
        $couponDetails = Redis::hgetall('wayak:admin:template:code:' . $couponCode);

        // Check if the number of redeemers for the code is set and equals zero.
        if ($couponDetails['number_of_redeemers'] != '' && $couponDetails['number_of_redeemers'] == 0) {
            // If the number of redeemers is zero, it implies the code is expired. Render a view indicating the code has expired.
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code expired.', $productId, $customerId);
        }

        // Check if the expiration date of the code is set and has passed.
        if ($couponDetails['expires_at'] != '' && \Carbon\Carbon::now()->gt(\Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $couponDetails['expires_at']))) {
            // If the current time is greater than the expiration time of the code, render a view indicating the code has expired.
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code expired.', $productId, $customerId);
        }

        // Check if the code is tied to a specific product and if the provided product ID does not match.
        if ($couponDetails['type'] == 'product' && $productId != null && $couponDetails['product_id'] != $productId) {
            // If the code type is 'product' and the product ID does not match the one specified in the code details, render a view with an error message.
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code for this product does not exists.', $productId, $customerId);
        }

        // Check if the code has already been redeemed by the user.
        if ($couponDetails['user_requirement'] == 'anonymous' && isset($customerId) && Redis::exists('wayak:user:' . $customerId . ':code:' . $couponCode)) {
            // If so, render a view with an error message indicating the code has been redeemed.
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code already redeemed by user, go to cart to view your products.', $productId, $customerId);
        }
        
        // echo "<pre>";
        // print_r($request->all());
        // print_r($customerId);
        // exit;

        if ($couponDetails['user_requirement'] == 'logged_in' && !$isLoggedIn) {
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'User is not logged in', $productId, $customerId);
        } elseif($couponDetails['user_requirement'] == 'logged_in' && !$isLoggedIn) {
            $user = Auth::user();
            // If the logged-in user has a customer ID, use it.
            if (isset($user->customer_id)) {
                $customerId = $user->customer_id;
                if (Redis::exists('wayak:user:' . $customerId . ':code:' . $couponCode)) {
                    // If so, render a view with an error message indicating the code has been redeemed.
                    return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code already redeemed by user.', $productId, $customerId);
                }
            } else {
                return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'User session not valid.', $productId, $customerId);
            }
        }


        // Check if the code is tied to a specific category and if that category exists.
        if ($couponDetails['type'] == 'category' && !Redis::exists('wayak:en:categories:' . $couponDetails['category_id'])) {
            // If the code type is 'category' and the category does not exist in Redis, render a view with an error message.
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code for this product does not exists.', $productId, $customerId);
        }

        // If user comes from a product, and coupon is type = 'category' check if product category does not matchs with coupon category.
        if( isset($refURL) && isset($productMetadata->mainCategory) && $couponDetails['type'] == 'category' && '/'.$couponDetails['category_id'] != $productMetadata->mainCategory) {
            return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Product category does not match with coupon category.', $productId, $customerId);    
        }

        // If user comes directly from coupon screen, we got productID from coupon metadata
        if( $couponDetails['type'] == 'product' && $productId == null ){
            $productId = $couponDetails['product_id'];
        }

        // If all conditions pass and the product ID is valid, show editor template.
        if($couponDetails['discountType'] == "free" && $productId != null && $this->processTemplate($couponDetails['type'], $productId, $customerId, $couponCode, $country)){
            return view('editor', [
                'templates' => $productId,
                'purchase_code' => $couponCode,
                'language_code' => 'en',
                'demo_as_id' => 0,
                'user_role' => 'customer'
            ]);
        // If user has some kind of discount, display product detail with discount applied.
        } elseif( ($couponDetails['discountType'] == "percentage" || $couponDetails['discountType'] == "fixed") && isset($productMetadata->slug) ){
            $slugUrl = $productMetadata->slug;
            return redirect()->route('template.productDetail', [
                'country' => $country,
                'customer_id' => $customerId,
                'coupon' => $couponCode,
                'slug' => $slugUrl
            ]);
        // Redirects user user to coupons tied to a category
        } elseif( isset($couponDetails) && $couponDetails['type'] == 'category'){
            
            return redirect($country.'/templates/'.$couponDetails['category_id'].'?coupon='.$couponCode);
            // echo "<pre>";
            // print_r($couponDetails);
            // exit;
            // Redirects to homepage with coupon applied
        } elseif( isset($couponDetails) && ($couponDetails['type'] == 'any_product')){
            return redirect()->route('user.homepage', [
                'country' => $country,
                'customer_id' => $customerId,
                'sale' => $sale,
                'coupon' => $couponCode
            ]);
        }

        // echo $productId;
        // exit;

        return $this->renderValidationCodeView($country, $sale, $menu, $search_query, 'Code is not valid', $productId, $customerId);
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
