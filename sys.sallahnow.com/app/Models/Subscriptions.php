<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'sub_id',
        'sub_start',
        'sub_end',
        'sub_status',
        'sub_tech',
        'sub_pkg',
        'sub_points',
        'sub_cost',
        'sub_period',
        'sub_priv',
        'sub_register_by',
        'sub_register'
    ];

    public function technicians() {
        return $this->belongsToMany(Technician::class);
    }
}