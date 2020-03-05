<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});



Route::resource('games', 'GameController');

Route::resource('tags', 'TagController');


Route::post('/comment', 'CommentaireController@store')->name('comment.store');

Route::get('/comment/edit/{id}', 'CommentaireController@edit')->name('comment.edit');

Route::get('/comment/update/{id}', 'CommentaireController@update')->name('comment.update');

Route::get('/comment/destroy/{id}', 'CommentaireController@destroy')->name('comment.destroy');

Route::get('/comment/create/{id}', 'CommentaireController@create')->name('comment.create');

Route::prefix('accueil')->group(function(){
    Route::get('/','AccueilController@index')->name('accueil.index');
    Route::get('apropos','AccueilController@apropos')->name('accueil.apropos');
    Route::get('contacts','AccueilController@contacts')->name('accueil.contact');
});

Auth::routes();

Route::get('/logout','UserController@logout')->name('logout');
