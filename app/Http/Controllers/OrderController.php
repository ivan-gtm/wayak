<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Template;
use Illuminate\Support\Facades\Redis;
use Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function confirmation($country, $order_id){
        
        $language_code = 'en';
        $country = strtolower($country);
        $locale = self::getLocale($country);
        $menu = json_decode(Redis::get('wayak:'.$country.':menu'));
        $search_query = '';

        if( isset($request->searchQuery) ) {
            $search_query = $request->searchQuery;
        }
        
        if( !in_array($locale, ['en', 'es']) ){
            abort(400);
        }

        $dbOrder = DB::table('orders')
            ->select('status','klarna_order_id','template_id')
            ->where('order_id', '=', $order_id)
            ->first();
        
        
            
        $klarna_order_id = $dbOrder->klarna_order_id;
        // echo "<pre>";
        // print_r( $klarna_order_id );
        // // print_r( $klarnaOrderObj );
        // exit;

        $klarnaOrderObj = self::getKlarnaOrderAPIRequest( $klarna_order_id );
        
        
        App::setLocale($locale);
        $template_id = $dbOrder->template_id;
        $template = self::getTemplateMetadata($template_id);
        // $related_templates = self::getRelatedTemplates( $template->mainCategory, $language_code );
        
        return view('order.confirmation',[
            'country' => $country,
            'language_code' => $language_code,
            'template' => $template,
            'klarnaOrder' => $klarnaOrderObj,
            'menu' => $menu,
            'search_query' => $search_query,
            // 'related_templates' => $related_templates
        ]);
    }

    function getRelatedTemplates($mainCategory, $language_code){

        $total = Template::where('mainCategory','=', $mainCategory )->count();
        $per_page = 20;
        $tota_pages = floor( $total / $per_page );
        $page = rand( 1, $tota_pages );
        $skip = $page * $per_page;
        
        $related_content = Template::select([
                'title',
                'preview_image',
                'format',
                'categories',
                'mainCategory',
                'previewImageUrls',
                'width',
                'height',
                'forSubscribers',
                'measureUnits',
                'createdAt',
                'updatedAt'
            ])
            ->where('mainCategory','=', $mainCategory )
            // ->orderBy('rand')
            ->skip($skip)
            ->take($per_page)
            ->get();
        
        $related_templates = [];
        foreach ($related_content as $related_template) {
            
            if( App::environment() == 'locals' ){
                $related_template->preview_image = asset( 'design/template/'.$related_template->_id.'/thumbnails/'.$language_code.'/'.$related_template->previewImageUrls["product_preview"] );
            } else {
                $related_template->preview_image = Storage::disk('s3')->url( 'design/template/'.$related_template->_id.'/thumbnails/'.$language_code.'/'.$related_template->previewImageUrls["product_preview"] );
            }

            $related_templates[] = $related_template;
        }

        return $related_templates;
    }

    function getTemplateMetadata($template_id){
        // $template = Template::where('_id','=',$template_id)
        //     ->first([
        //         'title',
        //         'preview_image',
        //         'format',
        //         'categories',
        //         'mainCategory',
        //         'previewImageUrls',
        //         'width',
        //         'height',
        //         'forSubscribers',
        //         'measureUnits',
        //         'createdAt',
        //         'updatedAt'
        //     ]);
        
        return [
            '_id' => $template_id,
            'title' => 'Example'
        ];

    }

    public function checkout($country, $template_key){

        $order_id = Str::random(10);
        $orderLines = self::buildOrderLines($template_key);
        
        // JSON
        $api_response = self::orderAPIRequest($orderLines, $order_id);
        $resposeObj = json_decode($api_response);

        echo $template_key;
        
        DB::table('orders')->insert([
            'order_id' => $order_id,
            'template_id' => $template_key,
            'quantity' => 1,
            'created_on' => Carbon::now(),
            'status' => $resposeObj->status,
            'unit_price' => $resposeObj->order_lines[0]->unit_price,
            'tax_rate' => $resposeObj->order_lines[0]->tax_rate,
            'total' => $orderLines['total_amount'],
            'klarna_order_id' => $resposeObj->order_id,
        ]);
        
        echo $resposeObj->html_snippet;

    }

    function orderAPIRequest( $orderLines, $order_id ){
        $country = 'US';

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api-na.playground.klarna.com/checkout/v3/orders',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "purchase_country": "US",
            "purchase_currency": "USD",
            "locale": "en-US",
            "order_amount": '.$orderLines['total_amount'].',
            "order_tax_amount": '.$orderLines['tax_rate'].',
            "order_lines": [
                {
                    "type": "digital",
                    "reference": "'.$orderLines['reference'].'",
                    "name": "'.$orderLines['name'].'",
                    "quantity": '.$orderLines['quantity'].',
                    "quantity_unit": "'.$orderLines['quantity_unit'].'",
                    "unit_price": '.$orderLines['unit_price'].',
                    "tax_rate": '.$orderLines['tax_rate'].',
                    "total_amount": '.$orderLines['total_amount'].',
                    "total_discount_amount": 0,
                    "total_tax_amount": 0
                }
            ],
            "merchant_urls": {
                "terms": "'.url('/terms.html').'",
                "checkout": "'.url('/checkout.html').'",
                "confirmation": "'.url('/'.$country.'/order/'.$order_id.'/confirmation').'",
                "push": "'.url('/api/push').'"
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic UE4wNjYyOF9iMjZkYjE1ZTE0ZjU6OUMyaFpJWGVFMWU2SEc5Ng==',
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        return $response;
    }

    function refundAPIRequest($order_id){
        $order_id = 'be3bf0a4-c75f-453f-b412-5895d4ec4939';
        
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api-na.playground.klarna.com/ordermanagement/v1/orders/'.$order_id.'/refunds',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "refunded_amount": 10,
            "description": "string",
            "reference": "string",
            "order_lines": [
                {
                    "reference": "75001",
                    "type": "physical",
                    "quantity": 1,
                    "quantity_unit": "pcs.",
                    "name": "Some product refound",
                    "total_amount": 10,
                    "unit_price": 10,
                    "total_discount_amount": 0,
                    "tax_rate": 0,
                    "total_tax_amount": 0,
                    "merchant_data": "Some metadata",
                    "product_url": "https://yourstore.example/product/headphones",
                    "image_url": "https://yourstore.example/product/headphones.png",
                    "product_identifiers": {
                        "category_path": "Electronics Store > Computers & Tablets > Desktops",
                        "global_trade_item_number": "735858293167",
                        "manufacturer_part_number": "BOXNUC5CPYH",
                        "brand": "Intel"
                    }
                }
            ]
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic UE4wNjYyOF9iMjZkYjE1ZTE0ZjU6OUMyaFpJWGVFMWU2SEc5Ng==',
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;
        return $response;

    }

    function getKlarnaOrderAPIRequest( $klarna_order_id ){
                
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api-na.playground.klarna.com/ordermanagement/v1/orders/'.$klarna_order_id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic UE4wNjYyOF9iMjZkYjE1ZTE0ZjU6OUMyaFpJWGVFMWU2SEc5Ng=='
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        return json_decode($response);

    }

    function cancelAPIRequest($order_id){
        $order_id = '1f799bb8-266c-4fa5-8a9f-95dc35aacd2d';

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api-na.playground.klarna.com/ordermanagement/v1/orders/'.$order_id.'/cancel',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic UE4wNjYyOF9iMjZkYjE1ZTE0ZjU6OUMyaFpJWGVFMWU2SEc5Ng=='
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }

    function getLocale($country){
        if( in_array($country, ['us', 'ca']) ){
            $locale = 'en';
        } elseif( in_array($country, ['es','mx','co','ar','bo','ch','cu','do','sv','hn','ni', 'pe', 'uy', 've','py','pa','gt','pr','gq']) ){
            $locale = 'es';
        } else {
            $locale = 'en';
        }
        
        return $locale;
    }

    function klarnaDemo( $country ){

        $order_id = Str::random(10); // Create internal ecom ID
        $orderLines = self::buildOrderLines($order_id);

        DB::table('orders')->insert([
            'order_id' => $order_id,
            'template_id' => Str::random(5),
            'quantity' => 1,
            'created_on' => Carbon::now(),
            'name' => $orderLines['name'],
            'unit_price' => $orderLines['unit_price'],
            'tax_rate' => $orderLines['tax_rate'],
            'total' => $orderLines['total_amount'],
        ]);

        $klarnaSession = self::generateSession( $orderLines );

        // echo "<pre>";
        // print_r( $klarnaSession );
        // exit;
        
        return view('order.klarna_checkout',[
            'country' => $country,
            'client_token' => $klarnaSession->client_token,
            'klarnaSession' => $klarnaSession,
            'orderLines' => $orderLines,
            'order_item' => json_encode($orderLines)
        ]);
    }

    function generateSession( $orderLines ){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api-na.playground.klarna.com/payments/v1/sessions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "purchase_country": "us",
            "purchase_currency": "usd",
            "locale": "en-US",
            "order_amount": '.$orderLines['total_amount'].',
            "order_tax_amount": '.$orderLines['tax_rate'].',
            "order_lines": [
                {
                    "image_url": "https://www.klarna.com/demo/static/images/products/t-shirt.jpg",
                    "type": "digital",
                    "reference": "'.$orderLines['reference'].'",
                    "name": "'.$orderLines['name'].'",
                    "quantity": '.$orderLines['quantity'].',
                    "unit_price": '.$orderLines['unit_price'].',
                    "tax_rate": '.$orderLines['tax_rate'].',
                    "total_amount": '.$orderLines['total_amount'].',
                    "total_discount_amount": 0,
                    "total_tax_amount": '.$orderLines['tax_rate'].'
                }
            ],
            "billing_address": {
                "given_name": "John",
                "family_name": "Doe",
                "email": "john@doe.com",
                "title": "Mr",
                "street_address": "2425 Example Rd",
                "street_address2": "",
                "postal_code": "43221",
                "city": "Columbus",
                "region": "OH",
                "phone": "6145675309",
                "country": "US"
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic UE4wNjYyOF9iMjZkYjE1ZTE0ZjU6OUMyaFpJWGVFMWU2SEc5Ng==',
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode( $response );
        
    }

    function klarnaPlaceOrder( Request $request ){
        
        $authorization_token = $request->authorizationToken;
        $order_id = $request->order_id;
        
        $dbOrder = DB::table('orders')
            ->select('*')
            ->where('order_id', '=', $order_id)
            ->first();
        
        $payment_response = self::paymentAuthorizationCurl($authorization_token, $dbOrder);
        
        // Store order id on database
        DB::statement("UPDATE orders SET klarna_order_id = '".$payment_response->order_id."' where order_id = '".$order_id."'");

        return response()->json($payment_response);

    }

    function paymentAuthorizationCurl( $authorization_token, $order ){
        $country = 'us';

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api-na.playground.klarna.com/payments/v1/authorizations/' . $authorization_token . '/order',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "purchase_country": "US",
            "purchase_currency": "USD",
            "billing_address": {
                "given_name": "John",
                "family_name": "Doe",
                "email": "john@doe.com",
                "title": "Mr",
                "street_address": "144 2nd Ave",
                "postal_code": "10003",
                "city": "New York",
                "region": "United States",
                "phone": "+12122289682",
                "country": "US"
            },
            "order_amount": '.$order->total.',
            "order_tax_amount": '.$order->tax_rate.',
            "order_lines": [
                {
                    "type": "digital",
                    "reference": "'.$order->order_id.'",
                    "name": "'.$order->name.'",
                    "quantity": '.$order->quantity.',
                    "unit_price": '.$order->unit_price.',
                    "tax_rate": '.$order->tax_rate.',
                    "total_amount": '.$order->total.',
                    "total_discount_amount": 0,
                    "total_tax_amount": '.$order->tax_rate.',
                    "product_url": "https://www.klarna.com/demo/static/images/products/t-shirt.jpg",
                    "image_url": "https://www.klarna.com/demo/static/images/products/t-shirt.jpg"
                }
            ],
            "merchant_urls": {
                "confirmation": "'.url('/'.$country.'/order/'.$order->order_id.'/confirmation').'",
                "notification": "https://example.com/pending" 
            },
            "merchant_reference1": "45aa52f387871e3a210645d4"
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic UE4wNjYyOF9iMjZkYjE1ZTE0ZjU6OUMyaFpJWGVFMWU2SEc5Ng==',
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        return json_decode( $response );
    }

    function buildOrderLines($template_key){
        $order_info = null;
        
        $product = self::getTemplateMetadata($template_key);

        $price = rand(350,10000) ;

        $product['reference'] = $template_key;
        $product['name'] = 'Round neck organic t-shirt';
        $product['quantity'] = 1;
        $product['quantity_unit'] = 'pza';
        $product['unit_price'] = $price;
        $product['tax_rate'] = 1;
        $product['total_amount'] = round($product['quantity'] * $product['unit_price'] );
        
        return $product;
    }
}
