<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AIGetImageMetadata extends Command
{
    protected $signature = 'wayak:util:ai:image:get-metadata';
    protected $description = 'Get image metadata using OpenAI Vision API';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Set the OpenAI API key and URL
        // $apiKey = env('OPENAI_API_KEY');
        $apiKey = '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';
        $url = 'https://api.openai.com/v1/chat/completions';

        // Set the request payload
        $payload = [
            'model' => 'gpt-4o',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => [
                        [
                            'type' => 'text',
                            'text' => 'Craft a JSON for an e-commerce product with \'keywords\' (single-word +5 array) and ENGAGING and DESCRIPTIVE \'localizedTitle\' as main keys, in en, es, fr, pt. Detail event, occasion, colors, objects, animals in both keys.

                            {
                              "keywords": {
                                "en": [],
                                "es": [],
                                "fr": [],
                                "pt": []
                              },
                              "localizedTitle": {
                                "en": "",
                                "es": "",
                                "fr": "",
                                "pt": ""
                              }
                            }
                            '
                        ],
                        [
                            'type' => 'image_url',
                            'image_url' => [
                                'url' => 'https://wayak-templates.s3.us-west-1.amazonaws.com/design/template/fccJMVN8Hn/thumbnails/en/Ga9XNl_d7T8pYISug_product_preview.jpg'
                            ]
                        ]
                    ]
                ]
            ],
            'response_format' => [
                'type' => "json_object"
            ]
            // 'max_tokens' => 800
        ];

        // Initialize cURL
        $ch = curl_init($url);
        
        // Set cURL options
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            "Authorization: Bearer $apiKey"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

        // Execute the cURL request
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            $this->error('Request Error: ' . curl_error($ch));
            return;
        }

        // Close cURL
        curl_close($ch);

        // Decode the JSON response
        $responseData = json_decode($response, true);

        // Output the response data
        $this->info('Response: ' . print_r($responseData, true));
    }
}
