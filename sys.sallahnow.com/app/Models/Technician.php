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

    public function suggestions() {
        return $this->hasMany(Compatibilities_suggestions::class);
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
}
