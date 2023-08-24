<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Predis\Client;

class TranslateTemplateToFabric extends Command
{
    protected $signature = 'green:template:translate-to-fabric';
    protected $description = 'Translate Redis templates to Fabric format.';

    private $redis;
    private const CONVERTED_SET_KEY = 'converted:green:templates';

    public function __construct()
    {
        parent::__construct();
        $this->redis = new Client();
    }

    public function handle()
    {
        $keys = $this->redis->keys('green:template:*');
        foreach ($keys as $key) {
            // Check if the key has been processed before
            if ($this->redis->sismember(self::CONVERTED_SET_KEY, $key)) {
                $this->info("Skipping already processed key: $key");
                continue;
            }

            $json = $this->redis->get($key);
            $data = json_decode($json, true);

            $fabricJson = $this->convertToFabricJson($key, $data);

            $id = $this->generateId(6);
            $newKey = "template:en:" . $id;
            $this->redis->set($newKey, json_encode($fabricJson));

            // Mark the key as processed
            $this->redis->sadd(self::CONVERTED_SET_KEY, $key);

            $this->info("Processed $key into $newKey");
        }
    }

    private function convertToFabricJson($key, $inputJson)
    {
        $fabricObjects = [];
    
        // Extract [temporal_id] from $key
        preg_match('/\d+/', $key, $matches);
        $temporal_id = $matches[0];

        // Get [template_id] from Redis
        $template_id = $this->redis->get("green:template-metadata:$temporal_id");
        
        // If $inputJson["config"]["pages"][0]["name"] is set
        if (isset($inputJson["config"]["pages"][0]["name"])) {
            // Look for the first image in the directory
            $directory = public_path("design/template/$template_id/assets");
            $images = glob($directory . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
            if (count($images) > 0) {
                // Set the name of the first image as the background
                $inputJson["config"]["pages"][0]["name"] = basename($images[0]);
            }
        }

        $backgroundImageUrl = $inputJson["config"]["pages"][0]["name"];

        // Loop through the pages
        foreach ($inputJson["config"]["pages"] as $page) {
            // Loop through the fields in the page
            foreach ($page["fields"] as $field) {
                $fabricObject = [
                    "type" => "text",
                    "text" => $field["text"],
                    "left" => $field["x"],
                    "top" => $field["y"],
                    "fontSize" => $field["size"],
                    "fontFamily" => $field["font"],
                    "fill" => "#" . $field["color"],
                    "textAlign" => $field["align"],
                    "angle" => $field["rotation"]
                ];
                $fabricObjects[] = $fabricObject;
            }
        }

        $fabricJson = [
            "backgroundImage" => $backgroundImageUrl,
            "objects" => $fabricObjects
        ];

        return $fabricJson;
    }

    private function generateId($length)
    {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)))), 1, $length);
    }
}
