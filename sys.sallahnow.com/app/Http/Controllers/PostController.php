<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Post_Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{

    // private $location = 'posts/';
    // private $photosPath = 'posts/photos';
    // private $filesPath = 'posts/files';

    private $photosPath = 'posts/photos';
    function index()
    {
        return view('content.posts.index');
    }

    function load(Request $request)
    {
        $cost = $request->cost;
        if($cost){

            $posts = DB::table('posts')
            ->where('post_cost', '=', $cost)->orderBy('post_create_time', 'desc')->get();
            echo json_encode($posts);

        }else{
            $posts = DB::table('posts')
            ->join('users', 'posts.post_create_user', '=', 'users.id')
            // ->join('technicians', 'posts.post_create_tech', '=', 'technicians.tech_id')
            ->where('post_deleted', '=', '0')
            ->orderBy('post_create_time', 'desc')->limit(15)->offset(0)->get();

        echo json_encode($posts);

        }

    }

    function editor($code = null)
    {
        $data = $code ? DB::table('posts')
            ->join('users', 'posts.post_create_user', '=', 'users.id', 'left')
            ->join('technicians', 'posts.post_create_tech', '=', 'technicians.tech_id', 'left')
            ->where('post_code', $code)->first() : null;

        $file = Storage::get('public/' . $code . '.txt');

        return view('content.posts.editor', compact('data', 'file'));
    }

    function submit(Request $request)
    {
        $request->validate([
            'title'  => 'required',
            'body'   => 'required'
        ]);

        $param = [
            'post_title'       => $request->title,
            'post_body'        => $request->body,
        ];

        $photo = $request->file('photo');
        if ($photo) { #if has photo add photo
            $photoName = $this->uniqidReal(rand(4, 18)); //$photo->getClientOriginalName();
            $photo->move($this->photosPath, $photoName);
            $param['post_photo'] = $photoName;
        }

        $id = $request->id;
        if (!$id) {
            $param['post_code'] = strtoupper($this->uniqidReal());
            $param['post_create_user'] = auth()->user()->id;
            $param['post_archive_time'] = now();
            $param['post_delete_user'] = 0;
            $param['post_create_time'] = now();
            $status = Post::create($param);
            if (!$status) {
                echo json_encode([
                    'status' => false,
                ]);
                return;
            }
            $id =  $status->id;
        } else {
            $param['post_modify_user'] = auth()->user()->id;
            $param['post_modify_time'] = now();
            $record = Post::where('post_id', $id)->first();
            if ($photo && $record->post_photo) {
                File::delete($this->photosPath . $record->post_photo);
            }
            $status = Post::where('post_id', $id)->update($param);
        }

        $record = DB::table('posts')
            ->join('users', 'posts.post_create_user', '=', 'users.id', 'left')
            ->join('technicians', 'posts.post_create_tech', '=', 'technicians.tech_id', 'left')
            ->where('post_id', $id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    function fileSubmit(Request $request)
    {
        $post_id = $request->post_id;
        $context = $request->context;

        $post = Post::where('post_id', $post_id)->first();
        $code  = $post->post_code;
        $status = Storage::disk('public')->put($code . '.txt', $context);
        echo json_encode([
            'status' => boolval($status),
        ]);
    }

    function addCost(Request $request)
    {
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



    function updateData(Request $request)
    {
        $post_id  = $request->id;
        if ($request->key == 'post_allow_comment') {
            $status = Post::where('post_id', $post_id)->update(['post_allow_comments' => $request->val]);
        } elseif ($request->key == 'post_archived') {
            $status = Post::where('post_id', $post_id)->update(['post_archived' => $request->val]);
        }
        echo json_encode([
            'status' => boolval($status),
        ]);
    }

    function delete(Request $request)
    {
        $status = Post::where('post_id', $request->post_id)
            ->update(['post_deleted' => 1]);
        echo json_encode([
            'status' => boolval($status),
        ]);
    }

    /// comments

    function getComment(Request $request)
    {
        $post_id = $request->id;
        $comments = Post_Comment::where('comment_post', $post_id)
            ->orderBy('comment_create', 'desc')->get();
        echo json_encode($comments);
    }

    function addComment(Request $request)
    {
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