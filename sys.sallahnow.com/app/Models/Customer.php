<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Builder;

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

    public static function fetch($id = 0, $params = null, $limit = null, $listId = null)
    {
        $customers = self::limit($limit)->orderByDesc('customer_register');

        if($listId) $customers->where('customer_id', '<', $listId);
        
        if (isset($params['q']))
        {
            $customers->where(function (Builder $query) use ($params) {
                $query->where('customer_name', 'like', '%' . $params['q'] . '%')
                        ->orWhere('customer_mobile', $params['q'])
                        ->orWhere('customer_email', $params['q']);
            });
            unset($params['q']);
        }
        
        if($params) $customers->where($params);

        return $id ? $customers->first() : $customers->get();
    }

    public static function submit($param, $id)
    {
        if($id) return self::where('customer_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->customer_id : false;
    }
    
    
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