<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        $orders = self::join('customers', 'order_customer', 'customer_id')->limit($limit)->orderBy('order_id', 'DESC');

        if($lastId) $orders->where('order_id', '<', $lastId);

        if($params) $orders->where($params);

        if($id) $orders->where('order_id', $id);

        return $id ? $orders->first() : $orders->get();
    }

    public static function submit(int $id, array $orderParam = null, array $orderItemParam = null)
    {
        try {
            DB::beginTransaction();
            $status = $id ? self::where('order_id', $id)->update($orderParam) : self::create($orderParam);
            $id = $id ? $id : $status->id;
            if (!empty($orderItemParam)) {
                for ($i = 0; $i < count($orderItemParam); $i++) {
                 $orderItemParam[$i]['orderItem_order'] = $id;
                }
                Market_order_item::insert($orderItemParam);
            }
            DB::commit();
            return ['status' => true,'id' => $id];

        } catch (\Exception $e) {
            DB::rollBack();
            return ['status' => false,'message' => 'error: ' . $e->getMessage()];
        }
    }
}