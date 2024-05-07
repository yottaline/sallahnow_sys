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
    private $photosPath = 'photos';
    // private $filesPath = 'posts/files';
    function index()
    {
        return view('content.posts.index');
    }

    function load(Request $request)
    {
        $params = $request->q ? ['q' => $request->q] : [];
        $limit  = $request->limit;
        $listId = $request->list_id;
        if ($request->cost) $params[] = ['post_cost', $request->cost];

        echo json_encode(Post::fetch(0, $params, $limit, $listId));

    }

    function editor($code = null)
    {
       $post = Post::editor($code);

       $data = $post['data'];
       $file = $post['file'];

       return view('content.posts.editor', compact('data', 'file'));
    }

    function submit(Request $request)
    {
        $request->validate(['title'=> 'required','body'=> 'required']);

        $param = [
            'post_title'       => $request->title,
            'post_body'        => $request->body,
            'post_cost'        => $request->cost
        ];

        $photo = $request->file('photo');
        if ($photo) { #if has photo add photo
            $extension = $photo->getClientOriginalExtension();
            $photoName = $this->uniqidReal(rand(4, 18));
            $nameEx    = $photoName.'.'. $extension;
            $photo->storeAs($this->photosPath,$nameEx,'posts');
            $param['post_photo'] = $photoName;
        }

        $id = $request->id;
        if (!$id)
        {
            $param['post_code'] = strtoupper($this->uniqidReal());
            $param['post_create_user'] = auth()->user()->id;
            $param['post_archive_time'] = now();
            $param['post_delete_user'] = 0;
            $param['post_create_time'] = now();

        } else {

            $param['post_modify_user'] = auth()->user()->id;
            $param['post_modify_time'] = now();

            $record = Post::fetch($id);
            if ($photo && $record->post_photo) {
                File::delete($this->photosPath . $record->post_photo);
            }

        }

        $result = Post::submit($param, $id);
        $id = $result;
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Post::fetch($id) : [],
        ]);

    }

    function fileSubmit(Request $request)
    {
        $post_id = $request->post_id;
        $context = $request->context;
        $post = Post::fetch($post_id);

       $status = Post::file($post, $context);
        echo json_encode(['status' => boolval($status)]);
    }

    // function addCost(Request $request)
    // {
    //     $request->validate(['cost' => 'required|numeric']);

    //     $id    = $request->post_id;
    //     $params = ['post_cost' => $request->cost];

    //     $result = Post::submit($params, $id);
    //     echo json_encode([
    //         'status' => boolval($result),
    //         'data' => $result ? Post::fetch($id) : [],
    //     ]);
    // }

    function updateData(Request $request)
    {
        $id    = $request->id;
        $key   = $request->key;
        $value = $request->val;
        $user  = auth()->user()->id;
        $time  = Carbon::now();


        if ($key == 'post_allow_comment')
        {
            $params = ['post_allow_comments' => $value];
        }
        elseif ($key == 'post_archived')
        {
            $params = [
                'post_archived' => $value,
                'post_archive_user' => $user,
                'post_archive_time' => $time,
            ];
        }
        elseif ($key == 'post_post_delete')
        {
            $params = [
                'post_deleted' => $value,
                'post_delete_user' => $user,
                'post_delete_time' => $time
            ];
        }

       $result = Post::submit($params, $id);
        echo json_encode(['status' => boolval($result)]);
    }

    function delete(Request $request)
    {
        $id = $request->post_id;
        $status = Post::submit(['post_deleted' => 1], $id);
        echo json_encode([
            'status' => boolval($status),
        ]);
    }

    /// comments

    function getComment(Request $request)
    {
        $id = $request->post_id;
        echo json_encode($id ? Post_Comment::fetch(0, $id) : []);
    }

    function addComment(Request $request)
    {
        $params = [
            'comment_post'     => $request->post_id,
            'comment_context'  => $request->comment,
            'comment_create'   => Carbon::now(),
            'comment_user'     => auth()->user()->id
        ];

        $result = Post_Comment::submit($params);
        $id = $result;
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Post_Comment::fetch($id) : [],
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