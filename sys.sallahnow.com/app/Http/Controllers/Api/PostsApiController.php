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
        return $this->middleware('auth:technician-api');
    }

    public function getPost(){
        $posts = Post::all();
        return $this->returnData('posts', $posts);
    }


    public function store(Request $request){
        $request->validate([
            'title'  => 'required',
            'body'   => 'required'
        ]);
        $code = strtoupper($this->uniqidReal());
        if($request->file('photo')){ #if has photo add photo

            $photo = $request->file('photo');
            $photoName = $photo->getClientOriginalName();
            $photo->move('media/' , $photoName);
            $photoPath = url('media/', $photoName);

            $status = Post::create([
                'post_code'        => $code,
                'post_title'       => $request->title,
                'post_body'        => $request->body,
                'post_photo'       => $photoName,
                'post_create_tech' => auth()->user()->id,
                'post_archive_time' => now(),
                'post_delete_user' => 0,
                'post_create_time' => now()
            ]);
            $post_id =  $status->id;
        }
        else { # is not have a photo

            $status = Post::create([
                'post_code'        => $code,
                'post_title'       => $request->title,
                'post_body'        => $request->body,
                'post_create_tech' => auth()->user()->id,
                'post_archive_time' => now(),
                'post_delete_user' => 0,
                'post_create_time' => now()
            ]);
            $post_id =  $status->id;
        }
        $data = Post::where('post_id', $post_id)->first();
        return $this->returnData('post', $data, 'post has created successfully');
    }

    public function cost(Request $request) {

        $tech_id = $request->tech_id;
        $post_id = $request->post_id;

        $technician_point = Technician::where('tech_id', $tech_id)->first();
        if($technician_point->tech_points > 0){

            $post  = Post::where('post_id', $post_id)->first();
            PointTranaction::create([
                'points_count'    =>   $post->post_cost,
                'points_src'      =>   9,
                'points_target'   =>   $post_id,
                'points_process'  =>   1,
                'points_tech'     =>   $tech_id,
                'points_register' =>   Carbon::now()
            ]);

            $point =  $technician_point->tech_points - $post->post_cost;
            Technician::where('tech_id', $tech_id)->update([
                'tech_points' => $point
            ]);

            return $this->returnSuccess('Points have been withdrawn successfully');

        }else {
            return $this->returnError("You don't have enough points", 104);
        }

    }

    public function addLike(Request $request) {
        $request->validate([
            'like_tech' => 'required|numeric',
            'like_post' => 'required|numeric'
        ]);

        Post_Like::create([
            'like_tech' => $request->like_tech,
            'like_post' => $request->like_post
        ]);
        return $this->returnSuccess('Like post successfully');
    }

    public function comments($post_id) {
        $comments = Post_Comment::where('comment_post', $post_id)->get();
        return $this->returnData('comments', $comments);
    }

    public function addComment(Request $request) {

        $request->validate([
            'comment_post'  => 'required|numeric',
            'comment_context' => 'required',
        ]);

     $status = Post_Comment::create([
            'comment_post'      => $request->comment_post,
            'comment_context'   => $request->comment_context,
            'comment_tech'      => $request->comment_tech,
            'comment_create'    => now()
        ]);

        $comment_id = $status->id;
        $comment    = Post_Comment::where('comment_id', $comment_id)->first();
        return $this->returnData('comment', $comment, 'Comment created successfully');
    }

    public function postView($post_id) {
        $views = Post_View::where('view_post', $post_id)->get();
        return $this->returnData('post_views', $views);
    }

    public function addView(Request $request) {
      $data = Post_View::create([
            'view_device'  => $request->view_device,
            'view_tech'    => $request->view_tech,
            'view_post'    => $request->view_post
        ]);
        return $this->returnData('view', $data, 'post has created successfully');
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