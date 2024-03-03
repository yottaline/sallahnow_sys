<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Post_Comment;
use App\Models\Post_Like;
use App\Models\Post_View;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('content.posts.index');
    }

    public function load() {
        $posts = DB::table('posts')
        ->where('post_deleted', '=', '0')
        ->orderBy('post_create_time', 'desc')->limit(15)->offset(0)->get();

        echo json_encode($posts);
    }

    public function create(){
        return view('content.posts.create');
    }

    public function edit($code){
        $data   = Post::where('post_code', $code)->first();
        $likes  = Post_Like::where('like_post', $data->post_id)->count();
        $views  = Post_View::where('view_post', $data->post_id)->count();

        return view('content.posts.create', compact('data', 'likes', 'views'));
    }

    public function submit(Request $request){
        // return $request;
        $request->validate([
            'title'  => 'required',
            'body'   => 'required'
        ]);

        $photo = $request->file('photo');
        $photoName = $photo->getClientOriginalName();
        $location = 'Image/Posts/';
        $photo->move($location , $photoName);
        $photoPath = url($location, $photoName);

        $id = $request->id;
        if(!$id){
            $code = strtoupper($this->uniqidReal()); #post code
            if($request->file('photo')){ #if has photo add photo

                $status = Post::create([
                    'post_code'        => $code,
                    'post_title'       => $request->title,
                    'post_body'        => $request->body,
                    'post_photo'       => $photoName,
                    'post_create_user' => auth()->user()->id,
                    'post_archive_time' => now(),
                    'post_delete_user' => 0,
                    'post_create_time' => now()
                ]);
            }
            else { # is not have a photo

                $status = Post::create([
                    'post_code'        => $code,
                    'post_title'       => $request->title,
                    'post_body'        => $request->body,
                    'post_create_user' => auth()->user()->id,
                    'post_archive_time' => now(),
                    'post_delete_user' => 0,
                    'post_create_time' => now()
                ]);
            }
            $id =  $status->post_id;
        }else {
            # update post
            if($request->file('photo')){

                $status = Post::where('post_id', $id)->update([
                    'post_title'       => $request->title,
                    'post_body'        => $request->body,
                    'post_photo'       => $photoName,
                    'post_create_user' => auth()->user()->id,
                    'post_delete_user' => 0,
                ]);
            }
            else {
                $status = Post::where('post_id', $id)->update([
                    'post_title'       => $request->title,
                    'post_body'        => $request->body,
                    'post_create_user' => auth()->user()->id,
                    'post_delete_user' => 0,
                ]);
            }
        }

        $record = Post::where('post_id', $id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    public function addCost(Request $request) {
        $request->validate([
            'cost' => 'required|numeric'
        ]);
        $post_id = $request->post_id;
        $status = Post::where('post_id', $post_id)->update([
            'post_cost'  => $request->cost
        ]);

        $record = Post::where('post_id', $post_id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }



    public function updateData(Request $request){
        // return $request->val;
        $post_id  = $request->id;
        if($request->key == 'post_allow_comment'){
            $status = Post::where('post_id', $post_id)->update(['post_allow_comments' => $request->val]);
        }
        elseif($request->key == 'post_archived'){
                $status = Post::where('post_id', $post_id)->update(['post_archived' => $request->val]);
        }
        echo json_encode([
            'status' => boolval($status),
        ]);
    }

    public function addAttach(Request $request) {
        $post = Post::where('post_id', $request->post_id)->first();
        // $name = $request->file('files')->getClientOriginalName();
        // file_put_contents($post->post_code . '.txt', $request->attach);
        // file_put_contents($post->post_code . '.txt', file_get_contents($name));
        // return response()->download($post->post_code . '.txt',$post->post_code . '.txt');


        $code  = $post->post_code;
        $status = Storage::disk('public')->put($code.'.txt', $request);
        echo json_encode([
            'status' => boolval($status),
        ]);
    }

    public function delete(Request $request){
        $status = Post::where('post_id', $request->post_id)
        ->update(['post_deleted' => 1]);
        echo json_encode([
            'status' => boolval($status),
        ]);
    }

    /// comments

    public function getComment(Request $request){
        $post_id = $request->post_id;
        $comments = Post_Comment::where('comment_post', $post_id)
        ->orderBy('comment_create', 'desc')->limit(15)->offset(0)->get();
        echo json_encode($comments);
    }

    public function addComment(Request $request){
        $status = Post_Comment::create([
            'comment_post'     => $request->post_id,
            'comment_context'  => $request->comment,
            'comment_create'   => Carbon::now(),
            'comment_user'     => auth()->user()->id
        ]);
        $comment_id = $status->status;
        $record     = Post_Comment::where('comment_id', $comment_id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
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
