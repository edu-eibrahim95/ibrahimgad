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
    return view('home');
});
Route::get('home', function () {
    return view('home');
});
Route::get('/fb', 'SocialAuthController@index');
Route::get('/fb/group', 'SocialAuthController@store');
Route::get('/fb/top', 'SocialAuthController@top');
Route::post('/fb', 'SocialAuthController@callback');
Route::get('/medium', 'ViewBlockedController@medium');
Route::get('blog', 'BlogController@index')->name('blog');
//Route::get('/medium/{url}', 'ViewBlockedController@forUrl');
//Auth::routes();

Route::get('fb/redirect', 'SocialAuthController@redirect');
//Route::get('fb/callback', 'SocialAuthController@callback');

Route::group(['prefix' => 'blog'], function () {
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login','Auth\LoginController@login');
	Route::post('logout','Auth\LoginController@logout')->name('logout');

	//RegistrationRoutes...
	Route::get('register','Auth\RegisterController@showRegistrationForm')->name('register');
	Route::post('register','Auth\RegisterController@register');

	//PasswordResetRoutes...
	Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}','Auth\ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('password/reset','Auth\ResetPasswordController@reset');
});