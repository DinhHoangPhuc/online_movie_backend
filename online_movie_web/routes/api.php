<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\MovieController;
use App\Http\Controllers\Api\V1\ActorController;
use App\Http\Controllers\Api\V1\DirectorController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\GenreController;
use App\Http\Controllers\Api\V1\CountryController;
use App\Http\Controllers\Api\V1\PlanController;
use App\Http\Controllers\Api\V1\SubscriptionController;

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

// public routes
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::get('movies', [MovieController::class, 'index']);
    Route::get('movies/latest', [MovieController::class, 'latest']);
    Route::get('movies/filter', [MovieController::class, 'filterMovies']);
    Route::get('movies/{id}', [MovieController::class, 'show']);
    Route::get('actors', [ActorController::class, 'index']);
    Route::get('actors/search', [ActorController::class, 'filterActors']);
    Route::get('actors/{id}/movies', [ActorController::class, 'actorMovies']);
    Route::get('actors/{id}', [ActorController::class, 'show']);
    Route::get('directors/search', [DirectorController::class, 'filterDirectors']);
    Route::get('directors', [DirectorController::class, 'index']);
    Route::get('directors/{id}/movies', [DirectorController::class, 'directorMovies']);
    Route::get('genres', [GenreController::class, 'index']);
    Route::get('genres/{id}/movies', [GenreController::class, 'genreMovies']);
    Route::get('genres/{id}', [GenreController::class, 'show']);
    Route::get('countries', [CountryController::class, 'index']);
    Route::get('countries/{id}', [CountryController::class, 'show']);
    Route::get('plans', [PlanController::class, 'index']);
    Route::get('plans/{id}', [PlanController::class, 'show']);
});

// protected routes
Route::prefix('v1/private')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('movies', [MovieController::class, 'store']);
        Route::put('movies/{id}', [MovieController::class, 'update']);
        Route::delete('movies/{id}', [MovieController::class, 'destroy']);
        Route::post('actors', [ActorController::class, 'store']);
        Route::put('actors/{id}', [ActorController::class, 'update']);
        Route::delete('actors/{id}', [ActorController::class, 'destroy']);
        Route::post('directors', [DirectorController::class, 'store']);
        Route::put('directors/{id}', [DirectorController::class, 'update']);
        Route::delete('directors/{id}', [DirectorController::class, 'destroy']);
        Route::post('genres', [GenreController::class, 'store']);
        Route::put('genres/{id}', [GenreController::class, 'update']);
        Route::delete('genres/{id}', [GenreController::class, 'destroy']);
        Route::post('countries', [CountryController::class, 'store']);
        Route::put('countries/{id}', [CountryController::class, 'update']);
        Route::delete('countries/{id}', [CountryController::class, 'destroy']);
        Route::post('plans', [PlanController::class, 'store']);
        Route::put('plans/{id}', [PlanController::class, 'update']);
        Route::delete('plans/{id}', [PlanController::class, 'destroy']);
        Route::apiResource('subscriptions', SubscriptionController::class);
    });
});