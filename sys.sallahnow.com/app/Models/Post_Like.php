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

    public function technician() {
        return $this->belongsTo(Technician::class, 'like_tech', 'like_id');
    }

    public function post(){
        return $this->belongsTo(Post::class, 'like_post', 'post_id');
    }
}