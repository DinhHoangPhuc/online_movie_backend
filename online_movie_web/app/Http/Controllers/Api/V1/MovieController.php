<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Resources\V1\MovieResource;
// use App\Filters\V1\MovieFilter;
use App\Filters\V2\MovieFilter;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        // $movie = Movie::find(1)->with('genres', 'countries', 'director')->paginate(3);
        // return response()->json($movie);

        // return MovieResource::collection($movie);

        // $filter = new MovieFilter();
        // $queryItem = $filter->transform($request);

        // if(count($queryItem) == 0) {
        //     return MovieResource::collection(Movie::with('genres', 'countries', 'actors')->paginate(3));
        // } else {
        //     return MovieResource::collection(Movie::with('genres', 'countries', 'actors')
        //                                             ->where($queryItem)
        //                                             ->paginate(3)
        //                                             ->appends($request->query()));
        // }

        // $filter = new MovieFilter();
        // $queryItems = $filter->transform($request);

        // // return response()->json($queryItems);

        // $query = Movie::with('genres', 'countries', 'actors');

        // foreach ($queryItems as $item) {
        //     if ($item[0] === 'genres') {
        //         $query->whereHas('genres', function ($q) use ($item) {
        //             // echo($item[2] . '<br>');
        //             // $q->where('genre_name', 'LIKE', '%' . $item[2] . '%');
        //             return respone()->json($item[2]);
        //         });
        //     } else {
        //         $query->where($item[0], $item[1], $item[2]);
        //     }
        // }

        // return MovieResource::collection($query->paginate(3)->appends($request->query()));

        $filter = new MovieFilter();
        $queryItems = $filter->transform($request);

        $query = Movie::with('genres', 'countries', 'actors');

        foreach ($queryItems as $item) {
            if ($item[0] === 'genres') {
                $query->whereHas('genres', function ($q) use ($item) {
                    $q->where('genre_name', $item[2]);
                });
            } elseif ($item[0] === 'countries') {
                $query->whereHas('countries', function ($q) use ($item) {
                    $q->where('country_name', $item[2]);
                });
            } else {
                $query->where($item[0], $item[1], $item[2]);
            }
        }

        return MovieResource::collection($query->paginate(3)->appends($request->query()));
    }

    public function latest()
    {
        $latestMovies = Movie::with('genres', 'countries', 'actors')
            ->orderBy('release_year', 'desc')
            ->paginate(3);

        return MovieResource::collection($latestMovies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'release_year' => 'required|integer',
            'script_summary' => 'required',
            'movie_length' => 'required|integer',
            'poster' => 'required|url',
            'genre_id' => 'required|integer|exists:genres,id',
            'country_id' => 'required|integer|exists:countries,id',
            'director_id' => 'required|integer|exists:directors,id',
        ]);
    
        $movie = Movie::create($validatedData);
    
        return response()->json($movie, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show(Movie $movie)
    {
        $movie = Movie::with('genres', 'countries', 'director')->find($movie->id);
        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }
        return response()->json($movie);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function edit(Movie $movie)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        $movie->fill($request->all());
        $movie->save();

        return response()->json($movie);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $movie = Movie::find($id);

        if (!$movie) {
            return response()->json(['message' => 'Movie not found'], 404);
        }

        $movie->delete();

        return response()->json(['message' => 'Movie deleted successfully']);
    }
}
