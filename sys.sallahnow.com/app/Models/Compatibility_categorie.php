<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compatibility_categorie extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'visible'
    ];

    public function compatibilities() {
        return $this->hasMany(Compatibility::class);
    }

    public function suggestion() {
        return $this->hasOne(Compatibilities_suggestions::class);
    }
}