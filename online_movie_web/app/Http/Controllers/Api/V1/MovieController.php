<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Resources\V1\MovieResource;
// use App\Filters\V1\MovieFilter;
use App\Filters\V2\MovieFilter;
use App\Http\Requests\ParameterRequest;

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

        // $filter = new MovieFilter();
        // $queryItems = $filter->transform($request);

        // $query = Movie::with('genres', 'countries', 'actors');

        // foreach ($queryItems as $item) {
        //     if ($item[0] === 'genres') {
        //         $query->whereHas('genres', function ($q) use ($item) {
        //             $q->where('genre_name', $item[2]);
        //         });
        //     } elseif ($item[0] === 'countries') {
        //         $query->whereHas('countries', function ($q) use ($item) {
        //             $q->where('country_name', $item[2]);
        //         });
        //     } else {
        //         $query->where($item[0], $item[1], $item[2]);
        //     }
        // }

        // return MovieResource::collection($query->paginate(3)->appends($request->query()));
        // return MovieResource::collection(Movie::with('genres', 'countries', 'actors')->paginate(3));
        // return response()->json(Movie::with('genres', 'countries', 'actors')->get());
        // return response()->json(MovieResource::collection(Movie::with('genres', 'countries', 'actors')->get()));
        $movies = Movie::with('genres', 'countries', 'actors')
            ->paginate(3);
        return response()->json($movies, 200);
    }

    // public function myApiMethod(ParameterRequest $request)
    // {
    //     $parameter = $request->input('parameter');

    //     // Process the parameter after validation
    //     $response = [
    //         'parameter' => $parameter,
    //         'message' => 'This is your parameter'
    //     ];

    //     return response()->json($response);
    // }

    public function myApiMethod(Request $request, $parameter)
    {
        // Merge the parameter into the request object
        $request->merge(['parameter' => $parameter]);

        // Define the validation rules
        $rules = [
            'parameter' => 'required|alpha_num|min:3|max:10',
        ];

        // Define custom error messages
        $messages = [
            'parameter.required' => 'The parameter field is required.',
            'parameter.alpha_num' => 'The parameter must only contain letters and numbers.',
            'parameter.min' => 'The parameter must be at least 3 characters.',
            'parameter.max' => 'The parameter must not be more than 10 characters.',
        ];

        // // Validate the request with custom messages
        // $validatedData = $request->validate($rules, $messages);

        // // Process the parameter after validation
        // $response = [
        //     'parameter' => $parameter,
        //     'message' => 'This is your parameter'
        // ];

        // return response()->json($response);

        $validator = \Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } else {
            $response = [
                'parameter' => $parameter,
                'message' => 'This is your parameter'
            ];

            return response()->json($response, 200);
        }
    }

    public function latest()
    {
        $latestMovies = Movie::with('genres', 'countries', 'actors')
            ->orderBy('release_year', 'desc')
            ->paginate(3);

        // return MovieResource::collection($latestMovies);
        return response()->json($latestMovies, 200);
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

            return response()->json($movies, 200);
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

            return response()->json($movies, 200);
        } else if($request->has('genre') && $request->has('year')) {
            $genre = $request->input('genre');
            $year = $request->input('year');

            $movies = Movie::with('genres', 'countries', 'actors')
                ->whereHas('genres', function ($query) use ($genre) {
                    $query->where('genre_name', $genre);
                })
                ->where('release_year', $year)
                ->paginate(5);

            return response()->json($movies, 200);
        } else if($request->has('country') && $request->has('year')) {
            $country = $request->input('country');
            $year = $request->input('year');

            $movies = Movie::with('genres', 'countries', 'actors')
                ->whereHas('countries', function ($query) use ($country) {
                    $query->where('country_name', $country);
                })
                ->where('release_year', $year)
                ->paginate(5);

            return response()->json($movies, 200);
        } else if($request->has('genre')) {
            $genre = $request->input('genre');

            $movies = Movie::with('genres', 'countries', 'actors')
                ->whereHas('genres', function ($query) use ($genre) {
                    $query->where('genre_name', $genre);
                })
                ->paginate(5);

            return response()->json($movies, 200);
        } else if($request->has('country')) {
            $country = $request->input('country');

            $movies = Movie::with('genres', 'countries', 'actors')
                ->whereHas('countries', function ($query) use ($country) {
                    $query->where('country_name', $country);
                })
                ->paginate(5);

            return response()->json($movies, 200);
        } else if($request->has('year')) {
            $year = $request->input('year');

            $movies = Movie::with('genres', 'countries', 'actors')
                ->where('release_year', $year)
                ->paginate(5);

            return response()->json($movies, 200);
        } else {
        return response()->json(['message' => 'No filter criteria provided'], 400);
        }
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
        // return response()->json(MovieResource::make($movie), 200);
        // return MovieResource::make($movie);
        return response()->json($movie, 200);
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
        // return MovieResource::make($movie);
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
