<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_name',
        'location_type',
        'location_parent',
        'location_visible'
    ];

    public function centers() {
        return $this->hasMany(Center::class);
    }
}