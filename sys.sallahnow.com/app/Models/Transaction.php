<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable =[
        'trans_method',
        'trans_amount',
        'trans_process',
        'trans_reference',
        'trans_create_by',
        'technician_id',
        'reference'
    ];
    protected $casts = [
        'created_at'  => 'date:Y-m-d',
    ];

    public function technician() {
        return $this->belongsTo(Technician::class);
    }
}
