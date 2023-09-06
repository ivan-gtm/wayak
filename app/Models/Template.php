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
        $documents = Template::where('title', 'regex', new \MongoDB\BSON\Regex($searchTerm, 'i'))
            ->where('price', '>=', $minPrice)
            ->where('price', '<=', $maxPrice)
            ->get();

        return $documents;
    }

    public function filterDocuments($searchTerm = null, $category = null, $minPrice = null, $maxPrice = null, $productsInSale = null, $skip = 0, $per_page = 100)
    {
        $tokens = $searchTerm !== null ? explode(' ', strtolower($searchTerm)) : [];

        $query = Template::raw(function ($collection) use ($tokens, $category, $minPrice, $maxPrice, $productsInSale, $skip, $per_page) {

            $matchStage = [];

            if (!empty($tokens)) {
                $regexOrArray = [];
                foreach ($tokens as $token) {
                    $regexOrArray[] = ['title' => ['$regex' => new \MongoDB\BSON\Regex(preg_quote($token), 'i')]];
                }
                $matchStage['$or'] = $regexOrArray;
            }

            if ($category !== null) {
                $matchStage['mainCategory'] = $category;
            }

            if ($minPrice !== null) {
                $matchStage['price']['$gte'] = $minPrice;
            }

            if ($maxPrice !== null) {
                $matchStage['price']['$lte'] = $maxPrice;
            }

            if ($productsInSale !== null) {
                $matchStage['in_sale'] = 1;
            }

            $pipeline = [
                ['$match' => $matchStage],
                ['$addFields' => [
                    'matchCount' => [
                        '$size' => [
                            '$setIntersection' => [
                                $tokens,
                                ['$split' => [['$toLower' => '$title'], ' ']]
                            ]
                        ]
                    ]
                ]],
                ['$sort' => ['matchCount' => -1, '_id' => 1]],
                ['$skip' => $skip],
                ['$limit' => $per_page]
            ];

            return $collection->aggregate($pipeline)->toArray();
        });

        // Get the total count
        $totalCountQuery = Template::query();
        if (!empty($tokens)) {
            foreach ($tokens as $token) {
                $regex = new \MongoDB\BSON\Regex(preg_quote($token), 'i');
                $totalCountQuery->orWhere('title', 'regex', $regex);
            }
        }
        if ($category !== null) {
            $totalCountQuery->where('mainCategory', $category);
        }
        if ($minPrice !== null) {
            $totalCountQuery->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $totalCountQuery->where('price', '<=', $maxPrice);
        }
        if ($productsInSale !== null) {
            $totalCountQuery->where('in_sale', '=', 1);
        }
        $total = $totalCountQuery->count();

        // Aggregation Query for top_keywords
        $aggregationQuery = [];

        if ($searchTerm !== null) {
            foreach ($tokens as $token) {
                $aggregationQuery[] = ['$match' => ['title' => ['$regex' => new \MongoDB\BSON\Regex($token, 'i')]]];
            }
        }

        if ($category !== null) {
            $aggregationQuery[] = ['$match' => ['mainCategory' => $category]];
        }

        if ($minPrice !== null) {
            $aggregationQuery[] = ['$match' => ['price' => ['$gte' => $minPrice]]];
        }

        if ($maxPrice !== null) {
            $aggregationQuery[] = ['$match' => ['price' => ['$lte' => $maxPrice]]];
        }

        if ($productsInSale !== null) {
            $aggregationQuery[] = ['$match' => ['in_sale' => 1]];
        }

        $aggregationQuery[] = ['$unwind' => '$keywords.en'];
        $aggregationQuery[] = ['$group' => ['_id' => '$keywords.en', 'count' => ['$sum' => 1]]];
        $aggregationQuery[] = ['$sort' => ['count' => -1]];

        $keywords = Template::raw(function ($collection) use ($aggregationQuery) {
            return $collection->aggregate($aggregationQuery);
        });

        // Aggregation Query for category_totals
        $categoryAggregationQuery = [];

        if ($searchTerm !== null) {
            foreach ($tokens as $token) {
                $categoryAggregationQuery[] = ['$match' => ['title' => ['$regex' => new \MongoDB\BSON\Regex($token, 'i')]]];
            }
        }

        if ($minPrice !== null) {
            $categoryAggregationQuery[] = ['$match' => ['price' => ['$gte' => $minPrice]]];
        }

        if ($maxPrice !== null) {
            $categoryAggregationQuery[] = ['$match' => ['price' => ['$lte' => $maxPrice]]];
        }

        if ($productsInSale !== null) {
            $categoryAggregationQuery[] = ['$match' => ['in_sale' => 1]];
        }

        $categoryAggregationQuery[] = ['$group' => ['_id' => '$mainCategory', 'count' => ['$sum' => 1]]];
        $categoryAggregationQuery[] = ['$sort' => ['count' => -1]];

        $categoryTotals = Template::raw(function ($collection) use ($categoryAggregationQuery) {
            return $collection->aggregate($categoryAggregationQuery);
        });

        return ['total' => $total, 'documents' => $query, 'top_keywords' => $keywords, 'category_totals' => $categoryTotals];
    }
}
