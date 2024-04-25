<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Support_category extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'category_name',
        'category_cost',
        'category_visible'
    ];

    public static function fetch($id = 0, $params = null, $limit = null, $lastId = null)
    {
        $supportCategories = self::limit($limit)->orderBy('category_id', 'DESC');

        if ($lastId) $supportCategories->where('category_id', '<', $lastId);

        if (isset($params['q']))
        {
            $supportCategories->where(function (Builder $query) use ($params) {
                $query->where('category_cost', 'like', '%' . $params['q'] . '%')
                    ->orWhere('category_name', $params['q']);
            });
            unset($params['q']);
        }

        if ($params) $supportCategories->where($params);

        if ($id) $supportCategories->where('category_id', $id);

        return $id ? $supportCategories->first() : $supportCategories->get();

    }

    public static function submit($param, $id)
    {
        if ($id) return self::where('category_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }


    public function supportTickets() {
        return $this->hasMany(Support_ticket::class);
    }
}