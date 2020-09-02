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
use App\Mail\NewUserWelcomeEmail;


Auth::routes();
Route::get('/email', function()
{
    return new NewUserWelcomeEmail();
});

Route::get('/', 'PostsController@index');
Route::post('/follow/{user}','followController@store');


Route::get('/profile/{user}/edit', 'ProfilesController@edit');
Route::patch('/profile/{user}', 'ProfilesController@update');
Route::get('/profile/{user}', 'ProfilesController@index');
Route::get('/profile/{user}/following', 'ProfilesController@show');
Route::get('/profile/{user}/followers', 'ProfilesController@show');


Route::get('/p/create', 'PostsController@create');
Route::post('/p', 'PostsController@store');
Route::get('/p/{post}', 'PostsController@show');


