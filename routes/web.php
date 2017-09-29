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
Route::get('/fb', 'SocialAuthController@index');
Route::get('/fb/group', 'SocialAuthController@store');
Route::get('/fb/top', 'SocialAuthController@top');
Route::post('/fb', 'SocialAuthController@callback');
Route::get('/medium', 'ViewBlockedController@medium');
//Route::get('/medium/{url}', 'ViewBlockedController@forUrl');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('fb/redirect', 'SocialAuthController@redirect');
//Route::get('fb/callback', 'SocialAuthController@callback');