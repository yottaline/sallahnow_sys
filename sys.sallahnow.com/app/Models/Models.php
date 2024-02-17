<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    use HasFactory;

    public $title = 'models';

    protected $fillable = [
        'name',
        'photo',
        'url',
        'visible',
        'brand_id',
        'user_id',
    ];

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function compatibilities(){
        return $this->belongsToMany(Compatibility::class);
    }

    public function suggestions() {
        return $this->belongsToMany(Compatibilities_suggestions::class);
    }
}
