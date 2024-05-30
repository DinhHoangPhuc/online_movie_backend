<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'User index'
        ]);
    }

    public function show($id)
    {
        return response()->json([
            'message' => 'User show'
        ]);
    }

    public function store(Request $request)
    {
        return response()->json([
            'message' => 'User store'
        ]);
    }

    public function update(Request $request, $id)
    {
        return response()->json([
            'message' => 'User update'
        ]);
    }

    public function destroy($id)
    {
        return response()->json([
            'message' => 'User destroy'
        ]);
    }
}
