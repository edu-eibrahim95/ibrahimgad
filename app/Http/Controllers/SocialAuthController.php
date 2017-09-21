<?php

namespace App\Http\Controllers;
use Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Socialite;
use Facebook\Facebook;
use App\FacebookUser;
use Auth;

class SocialAuthController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $user = Auth::user();
        $graphNode = Array();
        if ($user->facebook_id != NULL){
            $fb = new Facebook([
                'app_id' => config('facebook.config')['app_id'],
                'app_secret' => config('facebook.config')['app_secret'],
                'default_graph_version' => config('facebook.config')['default_graph_version'],
            ]);
            $access_token = FacebookUser::where('id', $user->facebook_id)->first()['access_token'];
            $response = $fb->get('/382982675402366/feed?since=2017-01-01 00:00:00&until=2017-01-26&limit=100', $access_token);
            $graphNode = $response->getGraphEdge();
        }
    	return view('fb', compact('graphNode'));
    }
    public function redirect()
    {
    	$accessToken = 'EAAE8eff4LWwBAM41R8EzUy9GHRgDoIBaucOBVtOWYIpbUC9xDjjqkNM1qCxQTGbZCHN1AK3fQ7WorZBwPtkphyX3YjD7WaSYK2F2DjOHCSAc0pqyUsF4jsZABYJwkjgZCWPYc3S8IcxTr4eW5GFDSab3y3n6XKgiAAAdfzrfhw0KL5EtNXHh';
        //return Socialite::driver('facebook')->scopes([
          //  'email', 'user_managed_groups'
        //])->userFromToken($accessToken)->getName();
        $fb = new Facebook([
                'app_id' => config('facebook.config')['app_id'],
                'app_secret' => config('facebook.config')['app_secret'],
                'default_graph_version' => config('facebook.config')['default_graph_version'],
        ]);
        //$response = $fb->post('/347969525656940/accounts/test-users', array ('installed' => 'true', 'permissions'=>'user_managed_groups', 'name'=>'ibrahim'),$accessToken);
        $response = $fb->get('/382982675402366/feed?since=2017-01-01 00:00:00&until=2017-01-26&limit=100', $accessToken);
        $graphNode = $response->getGraphEdge();
        return $graphNode[0]->getField('message');
    }   

    public function callback(Facebook $fb)
    {
        $uid = Request::input('uid');
        $access_token = Request::input('access_token');
        $permissions = Request::input('permissions');

        // assuming we have a User model already set up for our database
        // and assuming facebook_id field to exist in users table in database
        $fuser = FacebookUser::firstOrCreate(['facebook_id' => $uid]); 

        // get long term access token for future use
        $oAuth2Client = $fb->getOAuth2Client();

        // assuming access_token field to exist in users table in database
        $fuser->access_token = $oAuth2Client->getLongLivedAccessToken($access_token)->getValue();
        $fuser->save();

        $user = Auth::user();
        $user->facebook_id = $fuser->id;
        $user->save();
        // set default access token for all future requests to Facebook API            
        $fb->setDefaultAccessToken($fuser->access_token);

        // call api to retrieve person's public_profile details
        $fields = "id,cover,name,first_name,last_name,age_range,link,gender,locale,picture,timezone,updated_time,verified";
        $fb_user = $fb->get('/me?fields='.$fields)->getGraphUser();
         return back();
    }
}
