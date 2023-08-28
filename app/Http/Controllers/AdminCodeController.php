<?php

namespace App\Http\Controllers;

// use App\Models\Template;
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
    public function createCode(Request $request)
    {
        $four_digit_code = rand(1000, 9999);
        $type = $request->input('type');
        $product_id = $request->input('product_id');
        $category_id = ($type == 'product' || $type == 'any_product') ? null : $request->input('category_id');

        // Store the promotional code in Redis
        $promoKey = 'wayak:admin:template:code:' . $four_digit_code;
        Redis::hmset($promoKey, [
            'type' => $type,
            'product_id' => $product_id,
            'category_id' => $category_id
        ]);
        Redis::expire($promoKey, self::EXPIRATION_TIME);  // Set an expiration for the promo code

        // Optionally, send a response to the user, e.g., redirecting back with a success message
        return redirect()->back()->with('success', 'Promotional code created successfully!');
    }


    // function createCode($country, $template_key){

    //     if( $country == 'mx' ){
    //         $language_code = 'es';
    //     } else {
    //         $language_code = 'en';
    //     }

    //     // Create a template replica, for final user.

    //     // echo "<pre>";
    //     // print_r($template_key);
    //     // print_r($template_temp_key);

    //     // Access to certain product
    //     // Access to any product on category
    //     // Access to any product

    //     // wayak:template:code:2344
    //     // type:[product|category|any_product]
    //     // product_id
    //     // category_id
    //     // user_id
    //     // expires_at



    //     // Creates user code
    //     // Valida condiciones del codigo
    //         // Si es de tipo producto, valida que el template sea el valido
    //         // Si es de tipo category, valida que el template sea de la categoria valida.
    //         // SI es de tipo da acceso a la plataforma
    //     // wayak:user:{{user_id}}:code:2344

    //     $purchase_code = rand(1111, 9999);

    //     $original_template_key = $template_key;
    //     $temporal_customer_key = 'temp:'.$purchase_code;

    //     Redis::set('temp:template:relation:temp:'.$purchase_code, $original_template_key);
    //     Redis::expire('temp:template:relation:temp:'.$purchase_code, 2592000); // Codigo valido por 30 dias - 60*60*24*30 = 2592000

    //     Redis::set('template:'.$language_code.':'.$temporal_customer_key.':jsondata' ,Redis::get('template:'.$language_code.':'.$original_template_key.':jsondata'));
    //     Redis::expire('template:'.$temporal_customer_key.':jsondata', 2592000); // Codigo valido por 30 dias - 60*60*24*30 = 2592000

    //     Redis::set('code:'.$purchase_code, $temporal_customer_key);
    //     Redis::expire('code:'.$purchase_code, 2592000); // Codigo valido por 30 dias - 60*60*24*30 = 2592000

    // 	// return str_replace('http://localhost/design/','http://localhost:8000/design/', Redis::get($template_key) );
    //     // exit;
    //     // return view('generate_code');
    //     // Redis::keys()

    //     // return back()->with('success', 'Nuevo codigo generado con exito');
    //     return redirect()->action(
    //         [AdminController::class,'manageCodes'], [
    //             'country' => $country
    //         ]
    //     );
    // }

    function getCode($redis_key_code)
    {
        // Use preg_match to extract digits
        if (preg_match('/(\d+)/', $redis_key_code, $matches)) {
            $digit_part = $matches[1];
            return $digit_part;  // Outputs: 9177
        }

        return false;
    }

    function manageCodes($country)
    {

        $redis_codes = Redis::keys('wayak:admin:template:code:*');
        $details = [];
        
        foreach ($redis_codes as $redis_key_code) {

            $details = Redis::hgetall($redis_key_code);
            $details['code'] = $this->getCode($redis_key_code);

            if ($details['type'] == 'product') {
                $details['template_img'] = $this->getThumbnailUrl($details['product_id']);
            }
            $codes[] = $details;
        }

        /// debug $codes
        // echo "<pre>";
        // print_r($codes);
        // exit;

        return view('admin.create_code_form', [
            'country' => $country,
            'codes' => $codes
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

    public function deleteCode($country, $four_digit_code)
    {
        $codeKey = 'wayak:admin:template:code:' . $four_digit_code;
        Redis::del($codeKey);
        
        return redirect()->action(
            [AdminCodeController::class,'manageCodes'], ['country' => $country]
        )->with('success', 'Code deleted successfully!');
    }
}
