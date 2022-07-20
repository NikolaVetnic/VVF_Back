<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth',
    'namespace' => 'App\Http\Controllers'
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
    Route::post('register', 'AuthController@register');
    Route::get('user/{id}', 'AuthController@getUser');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'movies',
    'namespace' => 'App\Http\Controllers'
], function () {
    Route::get('index', 'MovieController@index');
    Route::get('show/{id}', 'MovieController@show');
    Route::post('store', 'MovieController@store');
    Route::delete('destroy/{id}', 'MovieController@destroy');
    Route::post('visit/{id}', 'MovieController@addVisit');
    Route::get('comments/{id}', 'MovieController@getComments');
    Route::get('best', 'MovieController@best');
    Route::get('genre/{genre}', 'MovieController@genre');
    Route::get('index/{term}', 'MovieController@search');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'comments',
    'namespace' => 'App\Http\Controllers'
], function () {
    Route::post('store', 'CommentController@store');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'reactions',
    'namespace' => 'App\Http\Controllers'
], function () {
    Route::post('store', 'ReactionController@store');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'favorites',
    'namespace' => 'App\Http\Controllers'
], function () {
    Route::post('store', 'FavoriteController@store');
    Route::post('destroy', 'FavoriteController@destroy');
    Route::get('index/user/{id}', 'FavoriteController@indexByUser');
    Route::put('update', 'FavoriteController@update');
});
