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
    public function store(){
        $user = Auth::user();
        $graphNode = Array();
        if ($user->facebook_id != NULL){
            $fb = new Facebook([
                'app_id' => config('facebook.config')['app_id'],
                'app_secret' => config('facebook.config')['app_secret'],
                'default_graph_version' => config('facebook.config')['default_graph_version'],
            ]);
            $access_token = FacebookUser::where('id', $user->facebook_id)->first()['access_token'];
            $start = "17-01-01";
            $prev = $start;
            for ($next = date('y-m-d', strtotime($prev. '+1 day')); $next != date('y-m-d');$next=date('y-m-d', strtotime($prev. '+1 day'))){
                $response = $fb->get('/382982675402366/feed?since='.$prev.'&until='.$next.'&limit=10000', $access_token);
                $graphEdge = $response->getGraphEdge();
                $post_all = "";
                foreach ($graphEdge as $edge){
                    $id = $edge->getField('id');
                    $post_response = $fb->get('/'.$id.'?fields=id,message, picture,from,created_time', $access_token);
                    $graphPost = $post_response->getGraphNode();
                    // post details
                    $post_owner = $graphPost->getField('from')->getField('name');
                    $post_time = $graphPost->getField('created_time')->format('y-m-d');
                    $post_message = $graphPost->getField('message');
                    $post_pic = $graphPost->getField('picture');
                    $post_id = $graphPost->getField('id');

                    $post_all .= "POST BY : " . $post_owner . '|' . $post_time . '
                    ';
                    $post_all .= $post_message . '
                    ' . $post_pic .'
                    ';
                    $post_all .= "\t\t----------------------------------------------------------------";

                    $comments_response = $fb->get('/'.$post_id.'/comments?fields=comments,message,from,created_time&limit=100000', $access_token);
                    $comments = $comments_response->getGraphEdge();
                    foreach ($comments as $comment) {
                        // comments details
                        $comment_owner = $comment->getField('from')->getField('name');
                        $comment_time = $comment->getField('created_time')->format('y-m-d');
                        $comment_message = $comment->getField('message');


                        $post_all .= "COMMENT BY : " . $comment_owner . '|' . $comment_time . '
                        ';
                        $post_all .= $comment_message . '
                        ';
                        $post_all .= "\t\t----------------------------------------------------------------";

                        $comment_replies = $comment->getField('comments');
                        
                        if ($comment_replies != ""){
                        // replies details
                        foreach ($comment_replies as  $reply) {
                            $reply_owner = $reply->getField('from')->getField('name');
                            $reply_time = $reply->getField('created_time')->format('y-m-d');
                            $reply_message = $reply->getField('message');

                            $post_all .= "REPLY BY : " . $reply_owner . '|' . $reply_time . '
                            ';
                            $post_all .= $reply_message . '
                            ';
                            $post_all .= "\t\t----------------------------------------------------------------";
                             
                         }
                         } 
                    }
                    $post_all .= "\t\t================================================================";
                    return $post_all;
                }
                $prev = $next;
            }
        }
        else {
            redirect("/fb");
        }
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
        //$response = $fb->get('/382982675402366/feed?since=2017-01-01 00:00:00&until=2017-01-26&limit=100', $accessToken);
        $response = $fb->get('/382982675402366_384175135283120/comments?fields=comments,message,from,created_time', $accessToken);
        //$response = $fb->get('/1833747763317212/comments?fields=message,from,updated_time', $accessToken);
        $graphNode = $response->getGraphEdge();
        //$phpWord = new \PhpOffice\PhpWord\PhpWord();

//         $section = $phpWord->addSection();

//         $description = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
// tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
// quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
// consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
// cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
// proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

//         $section->addImage("http://itsolutionstuff.com/frontTheme/images/logo.png");
//         $section->addText($description);

//         $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
//         try {
//             $objWriter->save(storage_path('helloWorld.docx'));
//         } catch (Exception $e) {
//         }
        return $graphNode;
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
