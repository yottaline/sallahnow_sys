<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable =[
        'method',
        'amount',
        'process',
        'reference',
        'create_by',
        'technician_id'
    ];

    public function technician() {
        return $this->belongsTo(Technician::class);
    }
}