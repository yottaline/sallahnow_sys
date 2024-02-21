<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointTranaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'points_count',
        'points_src',
        'points_target',
        'points_process',
        'points_technician_id',
        'points_register'
    ];

    protected $casts = [
        'created_at'  => 'date:Y-m-d',
    ];

    public function technician() {
        return $this->belongsTo(Technician::class);
    }

}