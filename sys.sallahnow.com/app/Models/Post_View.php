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

    public function technician() {
        return $this->belongsTo(Technician::class,'view_tech', 'view_id');
    }

    public function post() {
        return $this->belongsTo(Post::class, 'view_post', 'view_id');
    }
}
