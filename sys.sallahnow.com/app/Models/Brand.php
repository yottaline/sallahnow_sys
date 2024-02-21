<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_name',
        'brand_logo',
        'brand_visible',
        'brand_user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function models() {
        return $this->hasMany(Models::class);
    }
}
