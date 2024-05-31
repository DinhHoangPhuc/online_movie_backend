<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return response()->json($countries, 200);
    }

    public function show($id)
    {
        $country = Country::find($id);
        if ($country) {
            return response()->json($country, 200);
        } else {
            return response()->json(['message' => 'Country not found!'], 404);
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
        $country = new Country();
        $country->fill($request->all());
        $country->save();
        return response()->json($country, 201);
    }

    public function update(Request $request, $id)
    {
        if(Gate::denies('isAdmin')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $country = Country::find($id);
        if ($country) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
            $country->fill($request->all());
            $country->save();
            return response()->json($country, 200);
        } else {
            return response()->json(['message' => 'Country not found!'], 404);
        }
    }

    public function destroy($id)
    {
        if(Gate::denies('isAdmin')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        $country = Country::find($id);
        if ($country) {
            $country->delete();
            return response()->json(['message' => 'Country deleted!'], 200);
        } else {
            return response()->json(['message' => 'Country not found!'], 404);
        }
    }
}
