<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;

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
