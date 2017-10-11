<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewBlockedController extends Controller
{
    public function medium(Request $request){
    	$url = $start = $request->url;
    	$url = ($url == "" ) ? 'http://www.medium.com/' : $url;
		$homepage = @file_get_contents($url);
        if ($homepage != "") return view('blocked', compact('homepage'));
        else return abort(404);   
        
    }
    public function forUrl($url){
    	$homepage = file_get_contents(str_replace('|', '/', $url));
    	$homepage = str_replace('<a href=/', '<a href=https://www.medium.com/', $homepage);
    	$homepage = str_replace('/', '|', $homepage);
    	$homepage = str_replace('<a href="https:||www.medium.com', '<a href="http://ibrahimgad.com/medium/https:||www.medium.com', $homepage);
    	return view('blocked', compact('homepage'));
    }
}
