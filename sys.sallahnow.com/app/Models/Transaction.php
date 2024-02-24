<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable =[
        'trans_id',
        'trans_method',
        'trans_amount',
        'trans_process',
        'trans_ref',
        'trans_create_by',
        'trans_tech'
    ];
    protected $casts = [
        'created_at'  => 'date:Y-m-d',
    ];

    public function technician() {
        return $this->belongsTo(Technician::class);
    }
}