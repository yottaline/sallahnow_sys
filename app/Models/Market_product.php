<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Market_product extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'product_code',
        'product_name',
        'product_store',
        'product_category',
        'product_subcategory',
        'product_photo',
        'product_desc',
        'product_price',
        'product_disc',
        'product_views',
        'product_show',
        'product_delete',
        'product_cerated'
    ];

    public static function fetch($id =0, $params = null, $limit = null, $lastId = null)
    {
        $products = self::join('market_stores', 'product_store', 'store_id')
        ->join('market_categories', 'category_id', 'product_category')
        ->join('market_subcategories', 'subcategory_id', 'product_subcategory')->limit($limit);

        if($lastId) $products->where('product_id', '<', $lastId);

        if($params) $products->where($params);

        if($id) $products->where('product_id', $id);

        return $id ? $products->first() : $products->get();
    }

    public static function submit($param, $id)
    {
        if($id) return self::where('product_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }
}
