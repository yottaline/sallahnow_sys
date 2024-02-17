<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner',
        'name',
        'logo',
        'center_cr',
        'email',
        'mobile',
        'tel',
        'center_whatsapp',
        'center_tax',
        'country_id',
        'state_id',
        'city_id',
        'area_id',
        'address',
        'rate',
        'create_by',
        'modify',
        'modify_by'
    ];

    public function location() {
        return $this->belongsTo(Location::class);
    }
}