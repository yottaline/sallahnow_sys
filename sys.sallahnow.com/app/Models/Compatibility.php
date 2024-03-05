<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compatibility extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'compat_part',
        'compat_category'
    ];

    public function compatibility_categorie()
    {
        return $this->belongsTo(Compatibility_categorie::class, 'compat_category');
    }

    public function models()
    {
        return $this->belongsToMany(Models::class);
    }
}
