<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'center_id',
        'center_owner',
        'center_name',
        'center_logo',
        'center_cr',
        'center_email',
        'center_mobile',
        'center_tel',
        'center_whatsapp',
        'center_tax',
        'center_country',
        'center_state',
        'center_city',
        'center_area',
        'center_address',
        'center_rate',
        'center_create_by',
        'center_modify',
        'center_modify_by',
        'center_create'
    ];

    public function location() {
        return $this->belongsTo(Location::class);
    }
}