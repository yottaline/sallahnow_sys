<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class compatibility_model extends Model
{
    use HasFactory;
    public $table = 'compatibility_models';
    public $timestamps = false;
    protected $fillable = [
        'compatible_src',
        'compatible_model',
    ];
}