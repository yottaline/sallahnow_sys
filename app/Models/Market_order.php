<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market_order extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'order_code',
        'order_customer',
        'order_note',
        'order_status',
        'order_subtotal',
        'order_disc',
        'order_totaldisc',
        'order_total',
        'order_create',
        'order_exec',
        'order_approved',
        'order_delivered'
    ];


    public static function fetch($id = 0, $params = null, $limit = null, $lastId = null)
    {
        $orders = self::join('customers', 'order_customer', 'customer_id')->limit($limit);

        if($lastId) $orders->where('order_id', '<', $lastId);

        if($params) $orders->where($params);

        if($id) $orders->where('order_id', $id);

        return $id ? $orders->first() : $orders->get();
    }

    public static function submit($param, $id)
    {
        if($id) return self::where('order_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }
}