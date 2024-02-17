<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compatibilities_suggestions extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'act_not',
        'category_id',
        'technician_id',
        'user_id',
        'act_time'
    ];

    public function category() {
        return $this->belongsTo(Compatibility_categorie::class);
    }

    public function technician() {
        return $this->belongsTo(Technician::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function models() {
        return $this->belongsToMany(Models::class, 'compatibilities_suggestions_models','comp_sug_id');
    }

}
