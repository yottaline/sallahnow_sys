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

    public function getPosts(Request $request)
    {
        $limit  = $request->limit;
        $listId = $request->list_id;
        $posts = Post::fetch(0, null, $limit, $listId);

        if(!$posts) return $this->returnError('There are no posts', '108');

        return $this->returnData('data', $posts);
    }

    public function getPost(Request $request)
    {
        $id = $request->id;
        $post = Post::fetch($id);
        return $this->returnData('data', $post[0]);
    }

    public function file(Request $request)
    {
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

            return $this->returnData('data', 'storage/app/public/post/' . $post->post_file);

        }else {
            return $this->returnError("You don't have enough points", 104);
        }
    }


    public function store(Request $request)
    {
        $request->validate([
            'title'  => 'required',
            'body'   => 'required'
        ]);

        $id = $request->id;

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

        $result = Post::submit($param, $id);
        $data = $result ? Post::fetch($result) : false;
        return $this->returnData('post', $data, 'post has created successfully');
    }

    public function cost(Request $request)
    {

        $request->validate([
            'tech' => 'required | numeric',
            'post' => 'required | numeric'
        ]);

        $tech_id = $request->tech;
        $post_id = $request->post;
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
        $id = $request->id;
        $request->validate([
            'tech' => 'required|numeric',
            'post' => 'required|numeric'
        ]);

        $param = [
            'like_tech'  => $request->tech,
            'like_post'  => $request->post
        ];

        Post_Like::submit($param, $id);
        return $this->returnSuccess('Like post successfully');
    }

    public function comments(Request $request)
    {
        $limit  = $request->limit;
        $listId = $request->list_id;
        $post_id = $request->post;

        $comments = Post_Comment::fetch(0, $post_id, $limit, $listId);

        return $this->returnData('data', $comments);
    }

    public function addComment(Request $request)
    {
       $request->validate([
            'post'  => 'required|numeric',
            'text' => 'required',
        ]);
        $id = $request->id;
        $param = [
            'comment_post'    => $request->post,
            'comment_context' => $request->text,
            'comment_tech'    => $request->tech,
            'comment_create'  => Carbon::now()
        ];

        $result  = Post_Comment::submit($param, $id);

        $comment    = $result ? Post_Comment::fetch($result) : [];

        return $this->returnData('data', $comment, 'Comment created successfully');
    }

    public function postView(Request $request)
    {
        $post_id = $request->post;
        $views = Post_View::fetch($post_id);

        return $this->returnData('data', $views);
    }

    public function addView(Request $request)
    {

        $request->validate([
            'deviceId'  => 'required',
            'tech'      => 'required|numeric',
            'post'      => 'required|numeric'
        ]);
        $param =
        [
            'view_device'  => $request->deviceId,
            'view_tech'    => $request->tech,
            'view_post'    => $request->post
        ];
        Post_View::submit($param, null);
        return $this->returnSuccess( 'view post successfully');
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
