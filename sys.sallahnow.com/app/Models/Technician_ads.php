<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician_ads extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'ads_id',
        'ads_title',
        'ads_photo',
        'ads_body',
        'ads_url',
        'ads_start',
        'ads_end',
        'ads_create_user',
        'ads_create_time'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'ads_create_user', 'ads_id');
    }
}