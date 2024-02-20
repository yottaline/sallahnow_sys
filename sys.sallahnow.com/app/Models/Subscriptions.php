<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',
        'end',
        'status',
        'technician_id',
        'package_id',
        'package_points',
        'package_cost',
        'package_period',
        'package_priv',
        'register_by'
    ];

    public function technicians() {
        return $this->belongsToMany(Technician::class);
    }
}