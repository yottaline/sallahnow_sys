<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technician extends Model
{
    use HasFactory;

    protected $fillable = [
        'center',
        'name',
        'code',
        'email',
        'mobile',
        'tel',
        'password',
        'identification',
        'birth',
        'country_id',
        'state_id',
        'city_id',
        'area_id',
        'address',
        'bio',
        'notes',
        'devise_token',
        'blocked',
        'login',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}