<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class GenreController extends Controller
{
    public function index()
    {
        $genres = Genre::all();
        return response()->json($genres, 200);
    }

    public function show($id)
    {
        $genre = Genre::find($id);
        if ($genre) {
            return response()->json($genre, 200);
        } else {
            return response()->json(['message' => 'Genre not found!'], 404);
        }
    }

    public function store(Request $request)
    {
        if(Gate::denies('isAdmin')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $genre = new Genre();
        $genre->fill($request->all());
        $genre->save();
        return response()->json($genre, 201);
    }

    public function update(Request $request, $id)
    {
        if(Gate::denies('isAdmin')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        $genre = Genre::find($id);
        if ($genre) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
            $genre->fill($request->all());
            $genre->save();
            return response()->json($genre, 200);
        } else {
            return response()->json(['message' => 'Genre not found!'], 404);
        }
    }

    public function destroy($id)
    {
        if(Gate::denies('isAdmin')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $genre = Genre::find($id);
        if ($genre) {
            $genre->delete();
            return response()->json(['message' => 'Genre deleted!'], 200);
        } else {
            return response()->json(['message' => 'Genre not found!'], 404);
        }
    }

    public function genreMovies($id)
    {
        $genre = Genre::find($id);
        if ($genre) {
            $movies = $genre->movies;
            return response()->json($movies, 200);
        } else {
            return response()->json(['message' => 'Genre not found!'], 404);
        }
    }
}
