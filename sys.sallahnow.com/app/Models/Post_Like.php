<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_Like extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'like_id',
        'like_tech',
        'like_post'
    ];

    public static function fetch($id = 0, $params = null, $limit = null)
    {
        $likes = self::limit($limit);

        if ($params) $likes->where($params);
        if ($id) $likes->where('like_id', $id);

        return $id ? $likes->first() : $likes->get();
    }

    public static function submit($param, $id)
    {
        if ($id) return self::where('like_id', $id)->update($param) ? $id : false;

        $status = self::create($param);
        return $status ? $status->id : false;
    }

    public function technician() {
        return $this->belongsTo(Technician::class, 'like_tech', 'like_id');
    }

    public function post(){
        return $this->belongsTo(Post::class, 'like_post', 'post_id');
    }
}