<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'post_id',
        'post_code',
        'post_title',
        'post_body',
        'post_file',
        'post_photo',
        'post_type',
        'post_cost',
        'post_allow_comments',
        'post_archived',
        'post_archive_user',
        'post_archive_time',
        'post_views',
        'post_likes',
        'post_deleted',
        'post_delete_user',
        'post_delete_time',
        'post_create_user',
        'post_create_tech',
        'post_create_time',
        'post_modify_user',
        'post_modify_time'
    ];

    public static function fetch($id = 0, $params = null, $limit = null, $listId = null, $cost = null)
    {
        $posts = self::join('users', 'posts.post_create_user', '=', 'users.id')
        ->where('post_deleted', '=', '0')
        ->orderBy('post_create_time', 'desc')->limit($limit);

        if($cost) $posts->where('posts.post_cost', $cost);
        
        if (isset($params['q']))
        {
            $posts->where(function (Builder $query) use ($params) {
                $query->where('post_body', 'like', '%' . $params['q'] . '%')
                    ->orWhere('user_name', $params['q'])
                    ->orWhere('post_title', $params['q']);
            });
            unset($params['q']);
        }
        
        if($listId) $posts->where('posts.post_id', '<', $listId);

        return $id ? $posts->first() : $posts->get();
        
    }

    public static function editor($code = null)
    {
        $data = $code ? DB::table('posts')
            ->join('users', 'posts.post_create_user', '=', 'users.id', 'left')
            ->join('technicians', 'posts.post_create_tech', '=', 'technicians.tech_id', 'left')
            ->where('post_code', $code)->first() : null;

        $file = Storage::get('public/post/' . $code . '.txt');

        return ['data' => $data, 'file' => $file];
    }

    public static function submit($param, $id)
    {
        if ($id) return  self::where('post_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }

    public static function file($post, $context)
    {
        $code  = $post->post_code;
        $status = Storage::disk('posts')->put($code . '.txt', $context);
        return $status ? $status : false;
    }
    
    public static function cost($id, $cost)
    {
        $data = Post::where('post_id', $id)->update(['post_cost' => $cost]);

        return $data ? $data : false;
    }

    public static function changes($id, $key, $value)
    {
        if($key == 'post_allow_comment')
        {
             $status = Post::where('post_id', $id)->update(['post_allow_comments' => $value]);
        } 
        elseif($key == 'post_archived')
        {
            $status = Post::where('post_id', $id)->update(['post_archived' => $value]);
        }

        return $status ? $status : false;
    }

    public static function deleteItem($id)
    {
        $status = Post::where('post_id', $id)->update(['post_deleted' => 1]);

        return $status ? $status : false;
    }

    function get($column, $value)
    {
        DB::table('posts')
            ->join('users', 'posts.post_create_user', '=', 'users.id', 'left')
            ->join('technicians', 'posts.post_create_tech', '=', 'technicians.tech_id', 'left')
            ->where($column, $value)->first();
    }

    public function likes()
    {
        return $this->hasMany(Post_Like::class, 'like_post', 'post_id');
    }

    public function views()
    {
        return $this->hasMany(Post_View::class);
    }

    public function comments()
    {
        return $this->hasMany(Post_Comment::class);
    }
}