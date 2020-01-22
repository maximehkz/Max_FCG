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

Auth::routes();

Route::get('/email', function() {
    return new \App\Mail\NewUserWelcomeMail();
});

Route::post('follow/{user}', 'FollowsController@store');

Route::get('/', 'PostsController@index');

Route::get('/p/{post}', 'PostsController@show');

Route::get('/post/create', 'PostsController@create');

Route::post('/p', 'PostsController@store'); //To store a post

Route::get('/profile/{user}', 'ProfilesController@index')->name('profile.show');//Route allows you to redirect one page to another on the web app.For example here once you log in or register you are afterwards redirected to the main page.

Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');

Route::patch('/profile/{user}', 'ProfilesController@update')->name('profile.update');
