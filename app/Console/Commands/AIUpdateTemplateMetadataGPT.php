<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Carbon\Carbon;
use Storage;
use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Log;

class AIUpdateTemplateMetadataGPT extends Command
{
    protected $signature = 'wayak:util:ai:gpt:update-metadata';
    protected $description = 'Update templates metadata from GPT API';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->info('Fetching up to 200 completed templates...');
        // Exclude templates that have status 'failed'
        $templates = Template::where('status', 'completed')->take(200)->get();

        if ($templates->isEmpty()) {
            $this->info('No templates found to update.');
            return 0;
        }

        $consecutiveFailures = 0;  // Initialize consecutive failure counter

        foreach ($templates as $index => $template) {

            // if ($consecutiveFailures >= 2) {
            //     $this->error('Two consecutive failures occurred. Stopping the process.');
            //     break;  // Exit the loop after two consecutive failures
            // }

            $this->info('Processing template ' . ($index + 1) . ' of ' . $templates->count() . '...');
            $fileName = $template->_id . '/thumbnails/en/' . $template->previewImageUrls['large'];

            $this->info('Sending request to external API for template ID: ' . $template->_id);
            $jsonResponse = self::fetchImageAnalysis($fileName);
            $GPTArray = self::extractContentJson($jsonResponse);

            if (self::validateJsonStructure(json_encode($GPTArray)) == false) {
                $this->error('JSON not valid: ' . $template->_id . ' due >>' . json_encode($GPTArray));
                $template->status = 'failed';
                $template->save();
                $consecutiveFailures = $consecutiveFailures + 1;  // Increment consecutive failure counter
                continue;
            }

            // Print the response to console
            $this->line('Response for template ID ' . $template->_id . '>>  ' . json_encode($GPTArray));


            // $responseData = $response->json();
            if ($GPTArray == null) {
                $this->error('Failed to process template ID: ' . $template->_id . ' due to invalid JSON response.');
                $template->status = 'failed';
                $consecutiveFailures = $consecutiveFailures + 1;  // Increment consecutive failure counter
                $template->save();
                continue;
            }

            if ($this->isValidResponse($GPTArray)) {
                $this->info('Response received and validated. Updating template metadata...');
                $this->updateTemplate($template, $GPTArray);
                $consecutiveFailures = 0;  // Reset consecutive failure counter after any save action

            } else {
                $this->error('Failed to process template ID: ' . $template->_id . ' due to invalid response structure.');
                $template->status = 'failed';
                $consecutiveFailures = $consecutiveFailures + 1;
                $template->save();
            }

            // Sleep for 20 to 30 seconds
            sleep(rand(3, 5));
        }

        $this->info('Processing completed.');
        return 0;
    }

    protected function isValidResponse(array $response): bool
    {
        return isset(
            // $response['title'],
            $response['keywords'],
            $response['localizedTitle']
        );
    }

    protected function updateTemplate(Template $template, array $metadata): void
    {
        $template->title = $metadata['localizedTitle']['en'];
        $template->keywords = $metadata['keywords'];
        $template->localizedTitle = $metadata['localizedTitle'];
        $template->languages = ['en', 'es', 'fr', 'pt'];
        $template->status = 'gpt';
        $template->updated_at = Carbon::now()->toIso8601String();
        // print_r($template);
        $template->save();
        $this->info('Template ID: ' . $template->_id . ' updated successfully.');
    }

    private function fetchImageAnalysisTest($imageName)
    {
        return '{
            "id": "chatcmpl-8RRl9PKKk1cOGNyqb9F8sUf2PQV0D",
            "object": "chat.completion",
            "created": 1701552255,
            "model": "gpt-4-1106-vision-preview",
            "usage": {
                "prompt_tokens": 491,
                "completion_tokens": 233,
                "total_tokens": 724
            },
            "choices": [
                {
                    "message": {
                        "role": "assistant",
                        "content": "```json\n{\n  \"keywords\": {\n    \"en\": [\"babyshower\", \"celebration\", \"elephant\", \"zebra\", \"blue\", \"invitation\"],\n    \"es\": [\"bienvenida\", \"celebración\", \"elefante\", \"cebra\", \"azul\", \"invitación\"],\n    \"fr\": [\"naissance\", \"célébration\", \"éléphant\", \"zèbre\", \"bleu\", \"invitation\"],\n    \"pt\": [\"chádebebê\", \"celebração\", \"elefante\", \"zebra\", \"azul\", \"convite\"]\n  },\n  \"localizedTitle\": {\n    \"en\": \"Baby Shower Invitation - Blue Elephant and Zebra Theme\",\n    \"es\": \"Invitación de Baby Shower - Tema de Elefante y Cebra Azules\",\n    \"fr\": \"Invitation de Baby Shower - Thème Éléphant et Zèbre Bleu\",\n    \"pt\": \"Convite para Chá de Bebê - Tema de Elefante e Zebra Azul\"\n  }\n}\n```"
                    },
                    "finish_details": {
                        "type": "stop",
                        "stop": "<|fim_suffix|>"
                    },
                    "index": 0
                }
            ]
        }';
    }


    private function fetchImageAnalysis($imageName)
    {
        // try {
        $imageUrl = Storage::disk('s3')->url('design/template/' . $imageName);
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.openai.com/v1/chat/completions',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'model' => 'gpt-4-vision-preview',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => [
                            ['type' => 'text', 'text' => 'Craft a JSON for an e-commerce engaging product ONLY with \'keywords\' (single-word +5 array) and \'localizedTitle\' as main keys, both in en, es, fr, pt, detailing event, occasion, colors, objects, animals, ensuring these elements are echoed both keys.'],
                            ['type' => 'image_url', 'image_url' => ['url' => $imageUrl]]
                        ]
                    ]
                ],
                'max_tokens' => 300
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer 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',
            ],
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;

        // } catch (\Exception $e) {
        //     // Optionally log the error
        //     // Log::error("An error occurred while extracting JSON content: " . $e->getMessage());
        //     return null;
        // }
    }

    function validateJsonStructure($jsonString)
    {
        $requiredKeys = ['keywords', 'localizedTitle'];
        $requiredLangs = ['en', 'es', 'fr', 'pt'];

        try {
            // Decode the JSON string.
            $data = json_decode($jsonString, true);

            // Check for JSON decoding errors.
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON format.');
            }

            // Validate required keys and their value types.
            foreach ($requiredKeys as $key) {
                if (!isset($data[$key])) {
                    throw new \Exception("Missing required key: $key");
                }

                foreach ($requiredLangs as $lang) {
                    if (!isset($data[$key][$lang])) {
                        throw new \Exception("Missing $lang entry in $key");
                    }

                    // Validate value types.
                    if ($key === 'keywords' && !is_array($data[$key][$lang])) {
                        throw new \Exception("The $lang entry in $key should be an array.");
                    }

                    if ($key === 'localizedTitle' && !is_string($data[$key][$lang])) {
                        throw new \Exception("The $lang entry in $key should be a string.");
                    }
                }
            }

            return true;
        } catch (\Exception $e) {
            // Handle the error as needed, e.g., log it or return false.
            return false;
        }
    }

    function extractContentJson($jsonResponse)
    {
        try {
            // Decode the JSON response into an associative array.
            $responseArray = json_decode($jsonResponse, true);

            // Check if 'choices' is present and is an array with at least one item.
            if (isset($responseArray['choices'][0]['message']['content'])) {
                // Extract the JSON string from the 'content' field.
                $content = $responseArray['choices'][0]['message']['content'];

                // Extract the JSON part of the 'content' field using regex to match everything between curly braces.
                if (preg_match('/\{(?:[^{}]|(?R))*\}/', $content, $matches)) {
                    // Decode the JSON string and return the array.
                    return json_decode($matches[0], true);
                    // return $matches[0];
                }
            }

            return null;
        } catch (\Exception $e) {
            // Optionally log the error
            // Log::error("An error occurred while extracting JSON content: " . $e->getMessage());
            return null;
        }
    }
}
