<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;

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
    $prompt = "Generate JSON with wedding carousel titles, related keywords, and search terms for a wedding campaign. Titles should be captivating and suitable for a invitation design templates platform. Ensure each entry has `title`, `keywords`, and `search_term`.";

    $this->info('Sending request to OpenAI API...');

    try {
        $response = $client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-4o',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful assistant.'
                    ],
                    [
                        'role' => 'user',
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

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Error parsing response data: ' . json_last_error_msg());
            return 1;
        }

        $this->info('Parsed response data:');
        print_r($responseData);

        if (!isset($responseData['choices'][0]['message']['content'])) {
            $this->error('Expected data structure not found in the response.');
            return 1;
        }

        $jsonString = $responseData['choices'][0]['message']['content'];

        $this->info('Raw content:');
        echo $jsonString . "\n";

        if (substr(trim($jsonString), -1) !== ']') {
            $this->warn('The JSON response appears to be incomplete. Attempting to fix...');
            $jsonString = $jsonString . ']}]';
        }

        $parsedData = json_decode($jsonString, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error('Error parsing JSON: ' . json_last_error_msg());
            $this->info('Raw JSON string:');
            $this->info($jsonString);
            return 1;
        }

        $this->info('Parsed data:');
        print_r($parsedData);

        $validatedData = $this->parseResults($parsedData);

        $this->info('Parsed and validated data:');
        print_r($validatedData);

    } catch (\Exception $e) {
        $this->error('Error while calling OpenAI API: ' . $e->getMessage());
        return 1;
    }

    return 0;
}

    /**
     * Parse and ensure the API results contain the required keys.
     *
     * @param string $result
     * @return array
     */
    private function parseResults($data)
{
    if (!is_array($data)) {
        $this->warn('Invalid data structure received.');
        return [];
    }

    $validatedData = [];

    foreach ($data as $item) {
        $validatedItem = [
            'title' => $item['title'] ?? 'Untitled',
            'keywords' => $item['keywords'] ?? [],
            'search_term' => $item['search_term'] ?? ''
        ];

        $validatedData[] = $validatedItem;
    }

    return $validatedData;
}
}
