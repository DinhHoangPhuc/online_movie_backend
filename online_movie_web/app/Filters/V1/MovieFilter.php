<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class MovieFilter extends ApiFilter {
    protected $safeParms = [
        'id' => ['eq'],
        'title' => ['eq', 'like'],
        'releaseYear' => ['eq', 'gt', 'lt'],
        'scriptSummary' => ['eq', 'like'],
        'movieLength' => ['eq', 'gt', 'lt'],
        'poster' => ['eq', 'like'],
        'genre_id' => ['eq'],
        'country_id' => ['eq']
    ];

    protected $columnMap = [
        'title' => 'title',
        'releaseYear' => 'release_year',
        'scriptSummary' => 'script_summary',
        'movieLength' => 'movie_length',
        'poster' => 'poster',
        'genre_id' => 'genre_id',
        'country_id' => 'country_id'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'like' => 'like',
        'gt' => '>',
        'lt' => '<'
    ];
}