<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_start',
        'sub_end',
        'sub_status',
        'technician_id',
        'package_id',
        'sub_package_points',
        'sub_package_cost',
        'sub_package_period',
        'package_priv',
        'sub_register_by'
    ];

    public function technicians() {
        return $this->belongsToMany(Technician::class);
    }
}