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

Route::middleware('jwt.auth')->get('users', function (Request $request) {
    return auth()->user();
});

Route::post('users/register', 'Api\AuthController@register');
Route::post('users/login', 'Api\AuthController@login');
Route::get('/users', 'Api\UserController@getAllUsers');
Route::middleware(['jwt.auth'])->group(function () {
    Route::post('/users/logout', 'Api\AuthController@logout');
    Route::get('/users/{id}', 'Api\UserController@getUserById');
});
