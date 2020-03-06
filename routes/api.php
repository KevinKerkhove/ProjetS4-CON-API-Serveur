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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\PlayerController@store');

Route::post('players', 'Api\PlayerController@store');

Route::group(['middleware' => 'auth.jwt'], function () {
    Route::post('logout', 'Api\AuthController@logout');
    Route::get('me', 'Api\AuthController@me');
    Route::post('refresh', 'Api\AuthController@refresh');
    Route::get('players', 'Api\PlayerController@index');
    Route::get('players/{id}', 'Api\PlayerController@show');
    Route::put('players/{id}', 'Api\PlayerController@update');
    Route::delete('players/{id}', 'Api\PlayerController@destroy');
});