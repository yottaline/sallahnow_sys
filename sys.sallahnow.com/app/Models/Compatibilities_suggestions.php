<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compatibilities_suggestions extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'sugg_status',
        'sugg_points',
        'sugg_act_note',
        'sugg_act_time',
        'sugg_category',
        'sugg_tech',
        'sugg_act_by'
    ];

    public function category() {
        return $this->belongsTo(Compatibility_categorie::class, 'sugg_category' , 'category_id');
    }

    public function technician() {
        return $this->belongsTo(Technician::class, 'sugg_tech', 'tech_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'sugg_act_by');
    }

    public function models() {
        return $this->belongsToMany(Models::class, 'compatibilities_suggestions_models','comp_sug_id');
    }

}