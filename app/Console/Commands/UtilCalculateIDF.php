<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Jenssegers\Mongodb\Eloquent\Builder;
use App\Models\Template;
use Illuminate\Support\Facades\Redis;

class UtilCalculateIDF extends Command
{
    protected $signature = 'calculate:idf';

    protected $description = 'Calculate IDF for terms and store in Redis';

    protected $redis;

    // public function __construct(Client $redis)
    // {
    //     parent::__construct();
    //     $this->redis = $redis;
    // }

    public function handle()
    {
        // Define the collection and field you want to analyze
        $collection = 'templates'; // Change this to your collection name
        $field = 'title'; // Change this to the field you want to analyze

        // Retrieve all documents from the MongoDB collection
        $documents = Template::raw(function ($collection) use ($field) {
            return $collection->find([], [$field]);
        });

        // Initialize a dictionary to store DF (Document Frequency)
        $documentFrequency = [];

        // Count DF for each term in the specified field
        foreach ($documents as $document) {
            $terms = explode(' ', strtolower($document->{$field}));
            $uniqueTerms = array_unique($terms);

            foreach ($uniqueTerms as $term) {
                if (!isset($documentFrequency[$term])) {
                    $documentFrequency[$term] = 0;
                }
                $documentFrequency[$term]++;
            }
        }

        // Calculate the total number of documents
        $totalDocuments = count($documents);

        // Calculate IDF for each term and store it in Redis
        foreach ($documentFrequency as $term => $df) {
            $idf = log($totalDocuments / ($df + 1)); // Adding 1 to avoid division by zero

            // Store the IDF value in Redis using Predis
            Redis::hset("wayak:idf:dictionary",$term, $idf);

            // For demonstration purposes, we'll also print it here
            $this->info("Term: $term, IDF: $idf");
        }

        $this->info('IDF calculation completed and stored in Redis.');
    }
}
