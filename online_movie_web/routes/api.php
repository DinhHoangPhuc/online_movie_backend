<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\MovieController;
use App\Http\Controllers\Api\V1\ActorController;
use App\Http\Controllers\Api\V1\DirectorController;

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
    Route::get('movies/test/{parameter}', [MovieController::class, 'myApiMethod']);
    Route::get('movies/filter', [MovieController::class, 'filterMovies']);
    Route::apiResource('movies', MovieController::class);
    Route::get('actor/{id}/movies', [ActorController::class, 'actorMovies']);
    Route::get('actor/search', [ActorController::class, 'filterActors']);
    Route::apiResource('actors', ActorController::class);
    Route::get('director/{id}/movies', [DirectorController::class, 'directorMovies']);
    Route::get('director/search', [DirectorController::class, 'filterDirectors']);
    Route::apiResource('directors', DirectorController::class);
    // Route::get('/movies/{id}', 'MovieController@show');
    // Route::put('/movies/{id}', 'MovieController@update');
    // Route::delete('/movies/{id}', 'MovieController@destroy');
    // Route::post('/movies', 'MovieController@store');
});
