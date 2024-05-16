<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Market_subcategory extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'subcategory_name',
        'subcategory_cat'
    ];

    public static function fetch($id = 0, $params = null, $limit = null, $listId = null)
    {
        $subcategories = self::join('market_categories', 'subcategory_cat', 'category_id')->limit($limit)->orderBy('subcategory_id', 'DESC');

        if (isset($params['q']))
        {
            $subcategories->where(function (Builder $query) use ($params) {
                $query->where('subcategory_name',  'like', '%' . $params['q'] . '%')
                ->orWhere('category_name', 'like', '%' . $params['q'] . '%' );
            });
            unset($params['q']);
        }

        if($params) $subcategories->where($params);

        if($listId) $subcategories->where('subcategory_id', '<', $listId);

        if($id) $subcategories->where('subcategory_id', $id);

        return $id ? $subcategories->first() : $subcategories->get();
    }

    public static function submit($param, $id)
    {
        if($id) return self::where('subcategory_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }
}