<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::all();
        return response()->json($subscriptions, 200);
    }

    public function show($id)
    {
        $subscription = Subscription::find($id);
        if ($subscription) {
            return response()->json($subscription, 200);
        } else {
            return response()->json(['message' => 'Subscription not found!'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'plan_id' => 'required|integer',
            'users_id' => 'required|integer',
            'status' => 'required|string|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $subscription = new Subscription();
        $subscription->fill($request->all());
        $subscription->save();
        return response()->json($subscription, 201);
    }
}
