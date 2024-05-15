<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Market_category extends Model
{
    use HasFactory;
    public $timestamps = false;

    public $fillable = ['category_name'];

    public static function fetch($id = 0, $params = null, $limit = null, $listId = null)
    {
        $categories = self::limit($limit);

        if (isset($params['q']))
        {
            $categories->where(function (Builder $query) use ($params) {
                $query->where('category_name', 'like', '%' . $params['q'] . '%');;
            });
            unset($params['q']);
        }

        if($listId) $categories->where('category_id', '<', $listId);

        if($params) $categories->where($params);

        if($id) $categories->where('category_id', $id);

        return $id ? $categories->first() : $categories->get();
    }

    public static function submit($param, $id)
    {
        if($id) return self::where('category_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }
}