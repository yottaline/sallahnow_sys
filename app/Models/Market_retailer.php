<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Builder;

class Market_retailer  extends Authenticatable implements JWTSubject
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'retailer_id';

    protected $fillable = [
        'retailer_name',
        'retailer_email',
        'retailer_phone',
        'retailer_password',
        'retailer_store',
        'retailer_admin',
        'retailer_active',
        'retailer_approved',
        'retailer_approved_by',
        'retailer_register'
    ];

    public static function fetch($id = 0, $params = null, $limit = null, $lastId = null)
    {
        $retailers = self::join('market_stores', 'retailer_store', 'store_id')->limit($limit);

        if($lastId) $retailers->where('retailer_id', '<', $lastId);

        if (isset($params['q']))
        {
            $retailers->where(function (Builder $query) use ($params) {
                $query->where('retailer_phone', 'like', '%' . $params['q'] . '%')
                ->orWhere('store_name', $params['q'])
                    ->orWhere('retailer_name', $params['q'])
                    ->orWhere('retailer_email', $params['q']);
            });
            unset($params['q']);
        }

        if($params) $retailers->where($params);

        if($id) $retailers->where('retailer_id', $id);

        return $id ? $retailers->first() : $retailers->get();
    }

    public static function submit($param, $id)
    {
        if($id) return self::where('retailer_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
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
        return ['retailer_id'];
    }
}