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
        $posts = self::orderBy('post_create_time', 'desc')->limit($limit);

        if($listId) $posts->where('post_id', '<', $listId);

        if (isset($params['q']))
        {
            $posts->where(function (Builder $query) use ($params) {
                $query->where('post_body', 'like', '%' . $params['q'] . '%')
                    ->orWhere('user_name', $params['q'])
                    ->orWhere('post_title', $params['q']);
            });
            unset($params['q']);
        }

        if ($params) $posts->where($params);
        if ($id) $posts->where('post_id', $id);

        return $id ? $posts->first() : $posts->get();

    }

    public static function editor($code = null)
    {
        $data = $code ? self::join('users', 'posts.post_create_user', '=', 'users.id', 'left')
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
