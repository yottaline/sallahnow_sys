<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Customer extends Authenticatable implements JWTSubject
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'customer_id',
        'customer_code',
        'customer_name',
        'customer_email',
        'customer_mobile',
        'customer_password',
        'customer_country',
        'customer_state',
        'customer_city',
        'customer_area',
        'customer_address',
        'customer_notes',
        'customer_rate',
        'customer_active',
        'customer_login',
        'customer_register'
    ];

    public function location() {
        return $this->belongsTo(Location::class, 'customer_country', 'customer_id');
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
        return ['customer_id'];
    }


}