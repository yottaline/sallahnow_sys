<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Technician extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'tech_center',
        'tech_name',
        'tech_code',
        'tech_email',
        'tech_mobile',
        'tech_tel',
        'tech_password',
        'tech_identification',
        'tech_birth',
        'country_id',
        'state_id',
        'city_id',
        'area_id',
        'tech_address',
        'tech_bio',
        'tech_notes',
        'devise_token',
        'tech_blocked',
        'tech_login',
        'tech_credit',
        'user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function suggestions() {
        return $this->hasMany(Compatibilities_suggestions::class);
    }

    public function subscription() {
        return $this->hasOne(Subscriptions::class);
    }

    public function points() {
        return $this->hasMany(PointTranaction::class);
    }

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getAuthPassword()
{
    return $this->tech_password;
}
}
