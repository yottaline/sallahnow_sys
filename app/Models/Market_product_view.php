<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market_product_view extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'view_customer',
        'view_product',
        'view_cerated'
    ];

    public static function fetch($id =0, $params = null, $lastId = null)
    {
        $views = self::join('market_products', 'view_product', 'product_id')
        ->join('customers', 'view_customer', 'customer_id');

        if($params) $views->where($params);

        if($lastId) $views->where('view_id', '<', $lastId);

        if($id) $views->where('view_id', $id);
        return $id ? $views->first() : $views->get();
    }

    public static function submit($param, $id)
    {
        if($id) return self::where('view_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }
}