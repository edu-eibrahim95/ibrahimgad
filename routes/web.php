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


$this->get('/blog/login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('/blog/login','Auth\LoginController@login');
$this->post('/blog/logout','Auth\LoginController@logout')->name('logout');

//RegistrationRoutes...
$this->get('/blog/register','Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('/blog/register','Auth\RegisterController@register');

//PasswordResetRoutes...
$this->get('/blog/password/reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
$this->post('/blog/password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
$this->get('/blog/password/reset/{token}','Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('/blog/password/reset','Auth\ResetPasswordController@reset');