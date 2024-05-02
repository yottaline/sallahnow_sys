<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_View extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $table = 'post_views';
    protected $fillable = [
        'view_id',
        'view_device',
        'view_tech',
        'view_post'
    ];

    public static function fetch($post_id)
    {
        $views = self::where('view_post', $post_id)->get();
        return $views;
    }

    public static function submit($param, $id)
    {
        if ($id) return self::where('view_id', $id)->update($param) ? $id : false;

        $status = self::create($param);
        return $status ? $status->id : false;
    }

    public function technician() {
        return $this->belongsTo(Technician::class,'view_tech', 'view_id');
    }

    public function post() {
        return $this->belongsTo(Post::class, 'view_post', 'view_id');
    }
}
