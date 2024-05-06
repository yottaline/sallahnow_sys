<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\ResponseApi;
use App\Models\Post;
use App\Models\Technician;
use App\Models\PointTranaction;
use App\Models\Post_Comment;
use App\Models\Post_Like;
use App\Models\Post_View;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PostsApiController extends Controller
{
    use ResponseApi;
    public function __construct()
    {
        return $this->middleware(['auth:technician-api', 'check_device_token']);
    }

    public function getPost()
    {
        $posts = Post::fetch();
        if(!$posts) return $this->returnError('There are no posts', '108');

        return $this->returnData('posts', $posts);
    }


    public function store(Request $request)
    {
        $request->validate([
            'title'  => 'required',
            'body'   => 'required'
        ]);

        $code = strtoupper($this->uniqidReal());

        if($request->file('photo'))
        {
            $photo = $request->file('photo');
            $photoName = $photo->getClientOriginalName();
            $photo->move('media/' , $photoName);
            $photoPath = url('media/', $photoName);
        }

        $param =
        [
            'post_code'        => $code,
            'post_title'       => $request->title,
            'post_body'        => $request->body,
            'post_photo'       => $request->file('photo') ? $photoName : null,
            'post_create_tech' => auth()->user()->id,
            'post_archive_time' => now(),
            'post_delete_user' => 0,
            'post_create_time' => now()
        ];


        $result = Post::submit($param,null);
        $data = $result ? Post::fetch($result) : false;
        return $this->returnData('post', $data, 'post has created successfully');
    }

    public function cost(Request $request)
    {

        $request->validate([
            'tech_id' => 'required | numeric',
            'post_id' => 'required | numeric'
        ]);

        $tech_id = $request->tech_id;
        $post_id = $request->post_id;
        $technician = Technician::fetch($tech_id);

        if($technician->tech_points > 0)
        {
            $post  = Post::fetch($post_id);
            $param =
            [
                'points_count'    =>   $post->post_cost,
                'points_src'      =>   9,
                'points_target'   =>   $post_id,
                'points_process'  =>   1,
                'points_tech'     =>   $tech_id,
                'points_register' =>   Carbon::now()
            ];
            PointTranaction::submit($param, null);

            $point =  $technician->tech_points - $post->post_cost;
            $par = ['tech_points' => $point];
            Technician::submit($par, $tech_id);
            return $this->returnSuccess('Points have been withdrawn successfully');

        }else {
            return $this->returnError("You don't have enough points", 104);
        }

    }

    public function addLike(Request $request)
    {
      $data =  $request->validate([
            'like_tech' => 'required|numeric',
            'like_post' => 'required|numeric'
        ]);

        Post_Like::submit($data, null);
        return $this->returnSuccess('Like post successfully');
    }

    public function comments($post_id)
    {
        $comments = Post_Comment::fetch(0, $post_id);

        return $this->returnData('comments', $comments);
    }

    public function addComment(Request $request)
    {

     $data = $request->validate([
            'comment_post'  => 'required|numeric',
            'comment_context' => 'required',
        ]);

        $data['comment_tech']   = $request->comment_tech;
        $data['comment_create'] = now();

        $result  = Post_Comment::submit($data, null);

        $comment    = $result ? Post_Comment::fetch($result) : [];

        return $this->returnData('comment', $comment, 'Comment created successfully');
    }

    public function postView($post_id)
    {

        $views = Post_View::fetch($post_id);

        return $this->returnData('post', $views);
    }

    public function addView(Request $request)
    {

        $request->validate([
            'tech_device'  => 'required',
            'view_tech'    => 'required|numeric',
            'view_post'    => 'required|numeric'
        ]);
        $param =
        [
            'view_device'  => $request->view_device,
            'view_tech'    => $request->view_tech,
            'view_post'    => $request->view_post
        ];
        Post_View::submit($param, null);
        return $this->returnSuccess( 'post has created successfully');
    }


    private function uniqidReal($lenght = 12)
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new \Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
}