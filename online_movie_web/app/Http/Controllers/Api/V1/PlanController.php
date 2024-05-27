<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Plan;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return response()->json($plans, 200);
    }

    public function show($id)
    {
        $plan = Plan::find($id);
        if ($plan) {
            return response()->json($plan, 200);
        } else {
            return response()->json(['message' => 'Plan not found!'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $plan = new Plan();
        $plan->fill($request->all());
        $plan->save();
        return response()->json($plan, 201);
    }

    public function update(Request $request, $id)
    {
        $plan = Plan::find($id);
        if ($plan) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'price' => 'required|numeric',
                'description' => 'required|string|max:255',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
            $plan->fill($request->all());
            $plan->save();
            return response()->json($plan, 200);
        } else {
            return response()->json(['message' => 'Plan not found!'], 404);
        }
    }

    public function destroy($id)
    {
        $plan = Plan::find($id);
        if ($plan) {
            $plan->delete();
            return response()->json(['message' => 'Plan deleted!'], 200);
        } else {
            return response()->json(['message' => 'Plan not found!'], 404);
        }
    }
}
