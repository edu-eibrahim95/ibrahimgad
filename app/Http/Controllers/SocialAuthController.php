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
        for ($i=1; $i<10; $i++)
            file_put_contents(storage_path('0'.$i.'.txt'), "");
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
            for ($next = date('y-m-d', strtotime($prev. ' +1 day')); $next != date('y-m-d', strtotime(date('y-m-d'). '+1 day'));$next=date('y-m-d', strtotime($prev. ' +1 day'))){
                $response = $fb->get('/382982675402366/feed?since='.$prev.'&until='.$next.'&limit=1000', $access_token);
                $graphEdge = $response->getGraphEdge();
                foreach ($graphEdge as $edge){
                    $post_all = "";
                    $id = $edge->getField('id');
                    $post_response = $fb->get('/'.$id.'?fields=id,message, full_picture,from,created_time', $access_token);
                    $graphPost = $post_response->getGraphNode();
                    // post details
                    $post_owner = $graphPost->getField('from')->getField('name');
                    $post_time = $graphPost->getField('created_time')->format('y-m-d');
                    $post_message = $graphPost->getField('message');
                    $post_pic = $graphPost->getField('full_picture');
                    $post_id = $graphPost->getField('id');
                    $pic_del = ($post_pic == "") ? "" : "##";

                    $post_all .= "POST BY : " . trim($post_owner) . ' | ' . trim($post_time) . ' | ' . trim($id) .'
';
                    $post_all .= trim($post_message) . '
' . $pic_del . trim($post_pic) .$pic_del.'
';
                    $post_all .= '----------------------------------------------------------------
';

                    $comments_response = $fb->get('/'.$post_id.'/comments?fields=id,comments,message,from,created_time&limit=1000', $access_token);
                    $comments = $comments_response->getGraphEdge();
                    foreach ($comments as $comment) {
                        // comments details
                        $comment_id = $comment->getField('id');
                        $comment_owner = $comment->getField('from')->getField('name');
                        $comment_time = $comment->getField('created_time')->format('y-m-d');
                        $comment_message = $comment->getField('message');
                        
                        $comments_pic_response = $fb->get('/'.$comment_id.'?fields=attachment', $access_token);
                        $comment_pic_node = $comments_pic_response->getGraphNode();
                        if ($comment_pic_node->getField('attachment') != ""){
                            if ($comment_pic_node->getField('attachment')->getField('media') != ""){
                        $comment_pic = $comment_pic_node->getField('attachment')->getField('media')->getField('image')->getField('src');
                        }else{
                            $comment_pic =  "";
                        }
                        }else{
                            $comment_pic =  "";
                        }
                        $comment_pic_del = ($comment_pic == "") ? "" : "##";

                        $post_all .= "COMMENT BY : " . trim($comment_owner) . ' | ' . trim($comment_time) . '
';
                        $post_all .= trim($comment_message) . '
' . $comment_pic_del . trim($comment_pic) .$comment_pic_del.'
';
                        $post_all .= '----------------------------------------------------------------
';

                        $comment_replies = $comment->getField('comments');
                        
                        if ($comment_replies != ""){
                        // replies details
                        foreach ($comment_replies as  $reply) {
                            $reply_id = $reply->getField('id');
                            $reply_owner = $reply->getField('from')->getField('name');
                            $reply_time = $reply->getField('created_time')->format('y-m-d');
                            $reply_message = $reply->getField('message');

                            $reply_pic_response = $fb->get('/'.$reply_id.'?fields=attachment', $access_token);
                            $reply_pic_node = $reply_pic_response->getGraphNode();
                            if ($reply_pic_node->getField('attachment') != ""){
                                if ($reply_pic_node->getField('attachment')->getField('media') != ""){
                            $reply_pic = $reply_pic_node->getField('attachment')->getField('media')->getField('image')->getField('src');
                            }else{
                                $reply_pic = "";
                            }
                            }else{
                                $reply_pic = "";
                            }
                            $reply_pic_del = ($reply_pic == "") ? "" : "##";

                            $post_all .= "REPLY BY : " . trim($reply_owner) . ' | ' . trim($reply_time) . '
';
                            $post_all .= trim($reply_message) . '
' . $reply_pic_del . trim($reply_pic) .$reply_pic_del.'
';
                            $post_all .= '----------------------------------------------------------------
';
                             
                         }
                         } 
                    }
                    $post_all .= '================================================================
';
                    file_put_contents(storage_path(date('m', strtotime($next)).'.txt'), $post_all, FILE_APPEND | LOCK_EX);
                    //usleep(500000);
                    //return $post_all;
                }
                $prev = $next;
            }
            return "SUCCESS :D";
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
        $response = $fb->get('/504770779890221?fields=attachment,message,from,created_time', $accessToken);
        //$response = $fb->get('/1833747763317212/comments?fields=message,from,updated_time', $accessToken);
        $graphNode = $response->getGraphNode();
//         $phpWord = new \PhpOffice\PhpWord\PhpWord();

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
//             $objWriter->save(storage_path('hello.docx'));
//             $one = \PhpOffice\PhpWord\IOFactory::load(storage_path('hello.docx'));
//             $one->getSections()[0]->addText('a7a');
//             $one->save(storage_path('hello_again.docx'));
//             return $one->getSections();
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
