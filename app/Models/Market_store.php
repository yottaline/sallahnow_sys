<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Market_store extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'store_name',
        'store_code',
        'store_official_name',
        'store_cr',
        'store_cr_photo',
        'store_tax',
        'store_phone',
        'store_mobile',
        'store_country',
        'store_state',
        'store_city',
        'store_area',
        'store_address',
        'store_status',
        'store_cerated'
    ];

    public static function fetch($id = 0, $params = null, $limit = null, $lastId = null)
    {
        // $stores = self::join('market_retailers', 'market_stores.store_id', 'market_retailers.retailer_store')->limit($limit);
        $stores = self::limit($limit);

        if (isset($params['q']))
        {
            $stores->where(function (Builder $query) use ($params) {
                $query->where('store_official_name', 'like', '%' . $params['q'] . '%')
                        ->orWhere('store_name', $params['q'])
                        ->orWhere('retailer_name', $params['q']);
            });
            unset($params['q']);
        }

        if($lastId) $stores->where('store_id', '<', $lastId);

        if($params) $stores->where($params);

        if($id) $stores->where('store_id', $id);

        return $id ? $stores->first() : $stores->get();
    }

    public static function submit($param, $id)
    {
        if($id) return self::where('store_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }
}