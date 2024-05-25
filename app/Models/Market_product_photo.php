<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market_product_photo extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'photo_file',
        'photo_product',
        'photo_cerated'
    ];

    public static function fetch($id = 0, $params = null, $lastId = null)
    {
        $images = self::join('market_products', 'photo_product', 'product_id');

        if($params) $images->where($params);

        if($lastId) $images->where('photo_id', '<', $lastId);

        if($id) $images->where('photo_id', $id);

        return $id ? $images->first() : $images->get();
    }

    public static function submit($param, $id)
    {
        if($id) return self::where('photo_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }
}