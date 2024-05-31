<?php

namespace App\Filters\V2;

use Illuminate\Http\Request;

class MovieFilter
{
    public function transform(Request $request)
    {
        $queryItems = [];

        if ($request->has('genre')) {
            $queryItems[] = ['genres', 'genre_name', $request->input('genre')];
        }

        if ($request->has('country')) {
            $queryItems[] = ['countries', 'country_name', $request->input('country')];
        }

        if ($request->has('year')) {
            $queryItems[] = ['release_year', '=', $request->input('year')];
        }

        return $queryItems;
    }
}