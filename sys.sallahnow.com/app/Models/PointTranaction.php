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

    public function technician() {
        return $this->belongsTo(Technician::class);
    }
}