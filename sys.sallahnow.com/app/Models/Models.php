<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    use HasFactory;

    public $title = 'models';
    public $timestamps = false;
    protected $fillable = [
        'model_id',
        'model_name',
        'model_photo',
        'model_url',
        'model_visible',
        'model_brand'
    ];

    public function brand() {
        return $this->belongsTo(Brand::class, 'model_brand');
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