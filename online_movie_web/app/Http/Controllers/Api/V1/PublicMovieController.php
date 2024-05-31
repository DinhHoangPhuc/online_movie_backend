<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Http\Resources\V1\MovieResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PublicMovieController extends Controller
{
    public function index()
    {
        $movies = Movie::with('genres', 'countries', 'actors')->get();
        return MovieResource::collection($movies);
    }

    public function show($id)
    {
        $movie = Movie::with('genres', 'countries', 'actors')->find($id);
        if ($movie) {
            return new MovieResource($movie);
        } else {
            return response()->json(['message' => 'Movie not found!'], 404);
        }
    }

    public function latest()
    {
        // $movies = Movie::with('genres', 'countries', 'actors')->get();

        $movies = DB::table('movie')->orderBy('release_year', 'desc')->get();

        return response()->json($movies, 200);
    }

    public function filterMovies(Request $request)
    {
        if($request->has('genre') && $request->has('country') && $request->has('year')) {
            $genre = $request->input('genre');
            $country = $request->input('country');
            $year = $request->input('year');

            $movies = Movie::with('genres', 'countries', 'actors')
                ->whereHas('genres', function ($query) use ($genre) {
                    $query->where('genre_name', $genre);
                })
                ->whereHas('countries', function ($query) use ($country) {
                    $query->where('country_name', $country);
                })
                ->where('release_year', $year)
                ->paginate(5);

            return MovieResource::collection($movies);
        } else if($request->has('genre') && $request->has('country')) {
            $genre = $request->input('genre');
            $country = $request->input('country');

            $movies = Movie::with('genres', 'countries', 'actors')
                ->whereHas('genres', function ($query) use ($genre) {
                    $query->where('genre_name', $genre);
                })
                ->whereHas('countries', function ($query) use ($country) {
                    $query->where('country_name', $country);
                })
                ->paginate(5);

            return MovieResource::collection($movies);
        } else if($request->has('genre') && $request->has('year')) {
            $genre = $request->input('genre');
            $year = $request->input('year');

            $movies = Movie::with('genres', 'countries', 'actors')
                ->whereHas('genres', function ($query) use ($genre) {
                    $query->where('genre_name', $genre);
                })
                ->where('release_year', $year)
                ->paginate(5);

            return MovieResource::collection($movies);
        } else if($request->has('country') && $request->has('year')) {
            $country = $request->input('country');
            $year = $request->input('year');

            $movies = Movie::with('genres', 'countries', 'actors')
                ->whereHas('countries', function ($query) use ($country) {
                    $query->where('country_name', $country);
                })
                ->where('release_year', $year)
                ->paginate(5);

            return MovieResource::collection($movies);
        } else if($request->has('genre')) {
            $genre = $request->input('genre');

            $movies = Movie::with('genres', 'countries', 'actors')
                ->whereHas('genres', function ($query) use ($genre) {
                    $query->where('genre_name', $genre);
                })
                ->paginate(5);

            return MovieResource::collection($movies);
        } else if($request->has('country')) {
            $country = $request->input('country');

            $movies = Movie::with('genres', 'countries', 'actors')
                ->whereHas('countries', function ($query) use ($country) {
                    $query->where('country_name', $country);
                })
                ->paginate(5);

            return MovieResource::collection($movies);
        } else if($request->has('year')) {
            $year = $request->input('year');

            $movies = Movie::with('genres', 'countries', 'actors')
                ->where('release_year', $year)
                ->paginate(5);

            return MovieResource::collection($movies);
        } else {
        return response()->json(['message' => 'No filter criteria provided'], 400);
        }
    }
}
