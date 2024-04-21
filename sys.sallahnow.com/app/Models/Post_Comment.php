<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_Comment extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $table = 'post_comments';
    protected $fillable = [
        'comment_id',
        'comment_post',
        'comment_context',
        'comment_visible',
        'comment_review',
        'comment_parent',
        'comment_user',
        'comment_tech',
        'comment_create'
    ];

    public static function fetch($id = 0, $post_id = null)
    {
        $comments = Post_Comment::orderBy('comment_create', 'desc');
        if($id) $comments->where('comment_id', $id);
        if($post_id) $comments->where('comment_post', $post_id);
        return $id ? $comments->first() : $comments->get();
    }

    public static function submit($param)
    {
        $status = Post_Comment::create($param);

        return $status ? $status->id : false;
    } 

    public function posts() {
        return $this->belongsTo(Post::class, 'comment_post', 'comment_id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'comment_user', 'comment_id');
    }

    public function technician(){
        return $this->belongsTo(Technician::class, 'comment_tech', 'comment_id');
    }
}