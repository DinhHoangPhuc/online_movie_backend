<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Actor;

class ActorController extends Controller
{
    public function index()
    {
        $actors = Actor::all();
        return response()->json($actors, 200);
    }

    public function show($id)
    {
        $actor = Actor::find($id);
        if ($actor) {
            return response()->json($actor, 200);
        } else {
            return response()->json(['message' => 'Actor not found!'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'country_id' => 'required|integer',
            'picture' => 'required|string|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $actor = new Actor();
        $actor->fill($request->all());
        $actor->save();
        return response()->json($actor, 201);
    }

    public function update(Request $request, $id)
    {
        $actor = Actor::find($id);
        if ($actor) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'country_id' => 'required|integer',
                'picture' => 'required|string|max:255'
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
            $actor->fill($request->all());
            $actor->save();
            return response()->json($actor, 200);
        } else {
            return response()->json(['message' => 'Actor not found!'], 404);
        }
    }

    public function destroy($id)
    {
        $actor = Actor::find($id);
        if ($actor) {
            $actor->delete();
            return response()->json(['message' => 'Actor deleted!'], 200);
        } else {
            return response()->json(['message' => 'Actor not found!'], 404);
        }
    }

    public function filterActors(Request $request)
    {
        if($request->has('name')) {
            $actors = Actor::where('name', 'like', '%' . $request->name . '%')->get();
            if ($actors->isEmpty()) {
                return response()->json(['message' => 'Actor not found!'], 404);
            }
            return response()->json($actors, 200);
        } else {
            return response()->json(['message' => 'Name parameter is required!'], 400);
        }
    }

    public function actorMovies($id)
    {
        $actor = Actor::find($id);
        if ($actor) {
            $movies = $actor->movies;
            return response()->json($movies, 200);
        } else {
            return response()->json(['message' => 'Actor not found!'], 404);
        }
    }
}
