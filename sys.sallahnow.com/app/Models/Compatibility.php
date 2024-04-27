<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Compatibility extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'compat_part',
        'compat_category'
    ];

    public static function fetch($id = 0, $params = null, $limit = null, $listId = null)
    {
        $compatibilities = self::join('compatibility_categories', 'compatibilities.compat_category', '=', 'compatibility_categories.category_id')
        ->limit($limit);

        if (isset($params['q']))
        {
            $compatibilities->where(function (Builder $query) use ($params) {
                $query->where('compatibilities.compat_part', 'like', '%' . $params['q'] . '%')
                    ->orWhere('compatibility_categories.category_name', $params['q']);
            });
            unset($params['q']);
        }

        if ($params) $compatibilities->where($params);

        if($listId) $compatibilities->where('compat_id', '<', $listId);

        return $id ? $compatibilities->first() : $compatibilities->get();
    }


    public function compatibility_categorie()
    {
        return $this->belongsTo(Compatibility_categorie::class, 'compat_category');
    }

    public function models()
    {
        return $this->belongsToMany(Models::class, 'compatibility_models','compatible_src');
    }
}
