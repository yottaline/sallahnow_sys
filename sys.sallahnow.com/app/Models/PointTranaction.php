<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointTranaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'count',
        'src',
        'target',
        'process',
        'technician_id'
    ];

    protected $casts = [
        'created_at'  => 'date:Y-m-d',
    ];

    public function technician() {
        return $this->belongsTo(Technician::class);
    }

}