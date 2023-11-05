<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
// use Illuminate\Support\Facades\Log;

class UpdateTemplateMetadata extends Command
{
    protected $signature = 'ai:bard:update-metadata';
    protected $description = 'Update templates metadata from external API';

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

        foreach ($templates as $index => $template) {
            $this->info('Processing template ' . ($index + 1) . ' of ' . $templates->count() . '...');
            $fileName = $template->_id . '/thumbnails/en/' . $template->previewImageUrls['large'];

            $this->info('Sending request to external API for template ID: ' . $template->_id);
            $response = Http::timeout(40)->post('http://bard:5000/get_image_description', [
                'file_name' => $fileName,
                'prompt_text' => 'Describe this image',
            ]);

            // Print the response to console
            $this->line('Response for template ID ' . $template->_id . ': ' . json_encode($response->json()));

            if ($response->failed()) {
                $this->error('Failed to process template ID: ' . $template->_id . ' due to HTTP error.');
                $template->status = 'failed';
                $template->save();
                continue;
            }

            $responseData = $response->json();
            if ($responseData === null) {
                $this->error('Failed to process template ID: ' . $template->_id . ' due to invalid JSON response.');
                $template->status = 'failed';
                $template->save();
                continue;
            }

            if ($this->isValidResponse($responseData)) {
                $this->info('Response received and validated. Updating template metadata...');
                $this->updateTemplate($template, $responseData);
            } else {
                $this->error('Failed to process template ID: ' . $template->_id . ' due to invalid response structure.');
                $template->status = 'failed';
                $template->save();
            }

            // Sleep for 5 minutes
            sleep(120);
        }

        $this->info('Processing completed.');
        return 0;
    }

    protected function isValidResponse(array $response): bool
    {
        return isset(
            $response['title'],
            $response['keywords'],
            $response['localizedTitle']
        );
    }

    protected function updateTemplate(Template $template, array $metadata): void
    {
        $template->title = $metadata['title'];
        $template->keywords = $metadata['keywords'];
        $template->localizedTitle = $metadata['localizedTitle'];
        $template->languages = ['en', 'es', 'fr', 'pt'];
        $template->status = 'gpt';
        $template->updated_at = Carbon::now()->toIso8601String();
        $template->save();
        $this->info('Template ID: ' . $template->_id . ' updated successfully.');
    }
}
