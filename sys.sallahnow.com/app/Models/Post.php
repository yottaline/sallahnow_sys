<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
