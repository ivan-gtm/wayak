<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;
use App\Models\Template;
use Storage;
use Illuminate\Support\Facades\App;

class AIGenerateCarouselTitles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wayak:util:ai:generate:carousel-titles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate carousel titles and related keywords for a wedding campaign using the ChatGPT API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = new Client();
        $apiKey = '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';
        $prompt = "Generate a JSON array with at least 10 carousels, composed by titles, related keywords, and search terms for a wedding campaign. The titles should be captivating and suitable for an invitation design templates platform. Ensure each entry in the array has title, keywords, and search_term properties and is a direct child of the JSON root. Do not nest the entries under another key.";

        $this->info('Sending request to OpenAI API...');

        try {
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => $prompt
                        ]
                    ],
                    'response_format' => [
                        'type' => "json_object"
                    ]
                    // 'max_tokens' => 500,
                    // 'temperature' => 0.7,
                ],
            ]);

            $this->info('Received response from OpenAI API.');
            $this->info('Response body: ' . $response->getBody());

            $responseData = json_decode($response->getBody(), true, 512, JSON_INVALID_UTF8_IGNORE);
            // $jsonString = $response->getBody();

            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->error('Error parsing response data: ' . json_last_error_msg());
                return 1;
            }

            // $this->info('Parsed response data:');
            // print_r($responseData);

            if (!isset($responseData['choices'][0]['message']['content'])) {
                $this->error('Expected data structure not found in the response.');
                return 1;
            }

            $jsonString = $responseData['choices'][0]['message']['content'];

            // $this->info('Raw content:');
            // echo $jsonString . "\n";

            $parsedData = json_decode($jsonString, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->error('Error parsing JSON: ' . json_last_error_msg());
                $this->info('Raw JSON string:');
                $this->info($jsonString);
                return 1;
            }

            // $this->info('Parsed data:');
            // print_r($parsedData);

            $validatedData = $this->parseResults($parsedData);

            // $this->info('Validated data:');
            // print_r($validatedData);

            if (is_array($validatedData) && count($validatedData) > 0) {
                $populatedCarousels = $this->populateAICarousels($validatedData);

                $country = 'us';
                $homeCarouselsKey = 'wayak:' . $country . ':home:carousels';
                if (Redis::exists($homeCarouselsKey)) {
                    if (is_array($populatedCarousels) && count($populatedCarousels) > 0) {
                        $homeCarouselsArr = json_decode(Redis::get($homeCarouselsKey));
                        $homeCarouselsArr = array_merge($populatedCarousels, $homeCarouselsArr);
                        Redis::set($homeCarouselsKey, json_encode($homeCarouselsArr));
                        // $this->info('Parsed and validated data:');
                        // print_r(json_encode($homeCarouselsArr));
                    }
                }
            }
        } catch (\Exception $e) {
            $this->error('Error while calling OpenAI API: ' . $e->getMessage());
            return 1;
        }
        

        return 0;
    }

    /**
     * Parse and ensure the API results contain the required keys.
     *
     * @param array $data
     * @return array
     */
    private function parseResults($data)
    {
        if (!is_array($data)) {
            $this->warn('Invalid data structure received.');
            return [];
        }

        $validatedData = [];

        // If $data is a single-element array with another array inside, use the inner array
        if (count($data) === 1 && is_array(reset($data))) {
            $data = reset($data);
        }

        // If $data is an associative array, get the first element that is an array
        if (array_keys($data) !== range(0, count($data) - 1)) {
            $data = current(array_filter($data, 'is_array'));
        }

        // Now $data should be our list of items, regardless of the original structure
        foreach ($data as $item) {
            if (is_array($item) && isset($item['title'])) {
                $validatedItem = [
                    'title' => $item['title'],
                    'keywords' => $item['keywords'] ?? [],
                    'search_term' => $item['search_term'] ?? ''
                ];
                $validatedData[] = $validatedItem;
            }
        }

        return $validatedData;
    }

    private function populateAICarousels($carouselsData)
    {
        $populatedCarousels = [];

        foreach ($carouselsData as $item) {
            // $carouselMetadata = [
            //     'slider_id' => Str::random(5),
            //     'title' => $item['title'] ?? 'Untitled',
            //     'keywords' => $item['keywords'] ?? [],
            //     'search_term' => $item['search_term'] ?? '',
            //     'items' => 
            // ];
            // if (isset($carouselMetadata['items']) && sizeof($carouselMetadata['items']) > 2) {
            $populatedCarousels[] = $this->getCarouselItems($item['title'], $item['search_term'], $item['keywords']);
            // }
        }

        $this->info('populatedCarousels');
        print_r(json_encode($populatedCarousels));

        return $populatedCarousels;
    }

    private function getCarouselItems($title, $serachTerm, $keywords)
    {
        $this->warn('getCarouselItems');
        $this->warn('serachTerm >>' . $serachTerm);

        $country = 'us';
        $language_code = 'en';
        $category = $minPrice = $maxPrice = $author = $productsInSale = null;
        $skip = 0;
        $per_page = 30;
        // $total_items_per_carousel = 30;

        $result = (new Template())->filterDocuments(strtolower($serachTerm), $category, $minPrice, $maxPrice, $author, $productsInSale, $skip, $per_page);
        $total_documents = $result['total'];
        $search_result = $result['documents'];

        // $search_result = Template::where('title', 'like', '%' . $serachTerm . '%')
        //     // ->where('width', '=', '5')
        //     // ->where('height', '=', '7')
        //     ->take($total_items_per_carousel)
        //     ->get([
        //         'title',
        //         'slug',
        //         'previewImageUrls',
        //         'width',
        //         'height',
        //         'forSubscribers',
        //         'previewImageUrls'
        //     ]);

        $this->warn('Total carousel items >>' . $total_documents);

        $templates = [];
        foreach ($search_result as $template) {

            if (App::environment() == 'local') {
                $template->preview_image_url = asset('design/template/' . $template->_id . '/thumbnails/' . $language_code . '/' . $template->previewImageUrls['product_preview']);
            } else {
                $template->preview_image_url = Storage::disk('s3')->url('design/template/' . $template->_id . '/thumbnails/' . $language_code . '/' . $template->previewImageUrls['product_preview']);
            }
            $templates[] = $template;
        }
        $sliderMetadata = [
            'slider_id' => Str::random(5),
            'title' => $title,
            'keywords' => $keywords,
            'search_term' => 'baby shower',
            'items' => $templates
        ];

        // $this->warn('sliderMetadata >>');
        // print_r(json_encode($sliderMetadata));

        return $sliderMetadata;
    }
}
