<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'pkg_type',
        'pkg_period',
        'pkg_cost',
        'pkg_points',
        'pkg_priv'
    ];

    public $timestamps = false;
}
