<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;


class Template extends Model
{
    // use HasFactory;
    protected $connection = 'mongodb';
    protected $fillable = ['prices', 'sales', 'stars', 'in_sale'];

    public function getTotalDocumentsByFormat()
    {
        $formatCounts = Template::raw(function ($collection) {
            return $collection->aggregate([
                [
                    '$group' => [
                        '_id' => '$format',
                        'total' => ['$sum' => 1],
                    ],
                ],
                [
                    '$project' => [
                        'format' => '$_id',
                        'total' => 1,
                        '_id' => 0,
                    ],
                ],
            ]);
        });

        return $formatCounts;
    }

    public function searchByTitle($searchTerm)
    {
        $documents = Template::where('title', 'regex', new \MongoDB\BSON\Regex($searchTerm, 'i'))->get();
        return $documents;
    }

    public function searchByTitleAndCategory($searchTerm, $category)
    {
        $documents = Template::where('title', 'regex', new \MongoDB\BSON\Regex($searchTerm, 'i'))
            ->where('category', $category)
            ->get();

        return $documents;
    }

    public function filterBySearchTermAndPrice($searchTerm, $minPrice, $maxPrice)
    {
        $documents = Document::where('title', 'regex', new \MongoDB\BSON\Regex($searchTerm, 'i'))
            ->where('price', '>=', $minPrice)
            ->where('price', '<=', $maxPrice)
            ->get();

        return $documents;
    }

    public function filterDocuments($searchTerm = null, $category = null, $minPrice = null, $maxPrice = null, $sale = null, $skip = 0, $per_page = 100)
    {
        $query = Template::query();

        if ($searchTerm !== null) {
            // $query->where('title', 'regex', new \MongoDB\BSON\Regex($searchTerm, 'i'));
            $query->whereRaw(array('$text' => array('$search' => $searchTerm)));
        }

        if ($category !== null) {
            $query->where('category', $category);
        }

        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
        
        if ($sale !== null) {
            $query->where('in_sale', '=', 1);
        }

        $total = $query->count();
        $documents = $query->skip($skip)->take($per_page)->get(['title', 'prices', 'slug', 'in_sale', 'studioName', 'previewImageUrls']);

        return ['total' => $total, 'documents' => $documents];            
    }
}
