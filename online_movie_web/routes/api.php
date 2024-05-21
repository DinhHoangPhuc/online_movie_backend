<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\MovieController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//api/v1
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
    Route::get('movies/latest', [MovieController::class, 'latest']);
    Route::apiResource('movies', MovieController::class);
    // Route::get('/movies/{id}', 'MovieController@show');
    // Route::put('/movies/{id}', 'MovieController@update');
    // Route::delete('/movies/{id}', 'MovieController@destroy');
    // Route::post('/movies', 'MovieController@store');
});
