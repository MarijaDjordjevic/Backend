<?php

use Illuminate\Http\Request;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::middleware('jwt.auth')->get('users', function (Request $request) {
//    return auth()->user();
//});


Route::post('users/register', 'Api\AuthController@register');
Route::post('users/login', 'Api\AuthController@login');
Route::middleware(['jwt.auth'])->group(function () {
    Route::post('users/logout', 'Api\AuthController@logout');
    Route::get('users', 'Api\UserController@getAppliedUsers');
    //Route::get('users/{id}', 'Api\UserController@getUserById');
    Route::post('games/{user_id}', 'Api\GameController@createGame');
    Route::post('games/{game_id}/{position}', 'Api\MoveController@createMove');
    Route::get('games/{game_id}/table', 'Api\GameController@getTable');
    Route::put('games/apply', 'Api\GameController@applyToGame');
    Route::get('games/status', 'Api\GameController@checkGameStatus');

    Route::post('challenges/{challenged_id}', 'Api\UserController@setChallenge');
    Route::get('challenges', 'Api\UserController@getChallengers');
    Route::post('challenges/accept/{challenger_id}', 'Api\UserController@acceptChallenge');
    Route::post('challenges/reject/{challenger_id}', 'Api\UserController@rejectChallenge');

});
