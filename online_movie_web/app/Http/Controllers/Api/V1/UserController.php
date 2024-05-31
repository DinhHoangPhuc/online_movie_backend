<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if(Gate::allows('isAdmin')) {
            $users = User::all()->makeHidden(['password', 'remember_token']);
            return response()->json($users, 200);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            if(Gate::allows('isAdmin')) {
                $user->makeHidden(['password', 'remember_token']);
                return response()->json($user, 200);
            } else {
                $user->makeHidden(['password', 'remember_token', 'email_verified_at', 'created_at', 'updated_at', 'role']);
                return response()->json($user, 200);
            }
        } else {
            return response()->json(['message' => 'User not found!'], 404);
        }
    }

    public function store(Request $request)
    {
        if(Gate::allows('isAdmin')) {
            $user = new User();
            $user->fill($request->all());
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json($user->makeHidden(['password', 'remember_token']), 201);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    // public function update(Request $request, $id)
    // {
    //     return response()->json([
    //         'message' => 'User update'
    //     ]);
    // }

    // public function destroy($id)
    // {
    //     return response()->json([
    //         'message' => 'User destroy'
    //     ]);
    // }
}
