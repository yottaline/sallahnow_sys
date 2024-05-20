<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market_order_item extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'orderItem_order',
        'orderItem_product',
        'orderItem_productPrice',
        'orderItem_subtotal',
        'orderItem_disc',
        'orderItem_total'
    ];

    public static function fetch($id = 0, $params = null)
    {
        $orderItems = self::join('market_orders', 'orderItem_order', 'order_id')
        ->join('market_products', 'orderItem_product', 'product_id');

        if($params) $orderItems->where($params);

        if($id) $orderItems->where('orderItem_id', $id);

        return $id ? $orderItems->first() : $orderItems->get();
    }

    public static function submit($param, $id)
    {
        if($id) return self::where('orderItem_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }
}