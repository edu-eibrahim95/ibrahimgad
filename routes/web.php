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
	$homepage = "";
    return view('welcome', compact('homepage'));
});
Route::get('/fb', function() {
	return view('fb');
});
Route::get('/medium', function() {
	$homepage = file_get_contents('http://www.medium.com/');
    return view('welcome', compact('homepage'));
});