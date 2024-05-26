<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Director;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $directors = Director::all();
        return response()->json($directors, 200);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'country_id' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $director = new Director();
        $director->fill($request->all());
        $director->save();
        return response()->json($director, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $director = Director::find($id);
        if ($director) {
            return response()->json($director, 200);
        } else {
            return response()->json(['message' => 'Director not found!'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'country_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $director = Director::find($id);
        if ($director) {
            $director->fill($request->all());
            $director->save();
            return response()->json($director, 200);
        } else {
            return response()->json(['message' => 'Director not found!'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $director = Director::find($id);
        if ($director) {
            $director->delete();
            return response()->json(['message' => 'Director deleted!'], 200);
        } else {
            return response()->json(['message' => 'Director not found!'], 404);
        }
    }

    public function filterDirectors(Request $request)
    {
        if($request->has('name')) {
            $directors = Director::where('director_name', 'like', '%' . $request->name . '%')->get();
            if($directors->isEmpty()) {
                return response()->json(['message' => 'No director found!'], 404);
            } else {
                return response()->json($directors, 200);
            }
        } else {
            return response()->json(['message' => 'Name parameter is required!'], 400);
        }
    }

    public function directorMovies($id)
    {
        $director = Director::find($id);
        if ($director) {
            return response()->json($director->movies, 200);
        } else {
            return response()->json(['message' => 'Director not found!'], 404);
        }
    }
}
