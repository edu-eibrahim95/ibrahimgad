<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewBlockedController extends Controller
{
    public function medium(){
		$homepage = file_get_contents('http://www.medium.com/');
    	return view('welcome', compact('homepage'));
    }
    public function forUrl($url){
    	$homepage = file_get_contents(str_replace('|', '/', $url);
    	return view('welcome', compact('homepage'));
    }
}
