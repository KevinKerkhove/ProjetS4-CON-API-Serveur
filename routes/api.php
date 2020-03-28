<?php

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

Route::prefix('v2')->group(function () {
    Route::post('login', 'Api\AuthController@login');
    Route::post('register', 'Api\AuthController@register');
});

Route::prefix('v2')->middleware(['auth:api', 'role'])->group(function() {


    // List players
    Route::middleware(['scope:admin'])->get('/user/{id}', 'Api\UserController@show');
    Route::middleware(['scope:admin,auteur,player'])->get('players', 'Api\PlayerController@index');
    Route::middleware(['scope:admin,auteur'])->get('players/{id}', 'Api\PlayerController@show');
    Route::get('getPlayer', 'Api\PlayerController@getPlayer');

    // Add/Edit User
    Route::middleware(['scope:admin,auteur'])->post('/user', 'Api\UserController@create');
    Route::middleware(['scope:admin,auteur'])->put('/user/{userId}', 'Api\UserController@update');
    Route::middleware(['scope:admin,auteur'])->put('players/{id}', 'Api\PlayerController@update');
    Route::middleware(['scope:admin,auteur'])->put('players', 'Api\PlayerController@update');

    // Delete User
    Route::middleware(['scope:admin'])->delete('/user/{userId}', 'Api\UserController@delete');
    Route::middleware(['scope:admin'])->delete('player/{id}', 'Api\PlayerController@destroy');

    Route::post('logout', 'Api\AuthController@logout');

    Route::get('getUser', 'Api\AuthController@getUser');


});
