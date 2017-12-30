<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Moment;
class MomentsController extends Controller
{
    public function index(Request $request){
    	$moments = Moment::orderBy('id', 'DESC')->paginate(15);
    	return view('web.moments_index', compact('moments'));
    }
}
