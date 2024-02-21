<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compatibility extends Model
{
    use HasFactory;

    protected $fillable = [
        'compatibility_part',
        'compatibility_categorie_id'
    ];

    public function compatibility_categorie() {
        return $this->belongsTo(Compatibility_categorie::class, 'compatibility_categorie_id');
    }

    public function models() {
        return $this->belongsToMany(Models::class);
    }
}