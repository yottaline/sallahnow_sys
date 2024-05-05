<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Compatibility extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'compat_part',
        'compat_category',
        'compat_board',
        'compat_code',
    ];

    public static function fetch($id = 0, $params = null, $limit = null, $listId = null)
    {
        $compatibilities = self::join('compatibility_categories', 'compatibilities.compat_category', '=', 'compatibility_categories.category_id')
        ->join('compatibliy_boards', 'compat_board', '=', 'board_id')
        // ->join('models', 'models.model_id', '=', 'compatibility_models.compatible_model')
        ->limit($limit);

        if (isset($params['q']))
        {
            $compatibilities->where(function (Builder $query) use ($params) {
                $query->where('compatibilities.compat_part', 'like', '%' . $params['q'] . '%')
                    ->orWhere('compatibilities.compat_code', $params['q'])
                    ->orWhere('compatibility_categories.category_name', $params['q']);
            });
            unset($params['q']);
        }

        if ($params) $compatibilities->where($params);

        if($listId) $compatibilities->where('compat_id', '<', $listId);

        return $id ? $compatibilities->first() : $compatibilities->get();
    }

    public static function submit($param, $id, $model_id = null)
    {

        if ($id){
            $recode = self::fetch($id);
            $status = $recode->update($param);
            $recode->models()->sync($model_id);
            return $status ? $id : false;
        }
        $status = self::create($param);

        $status->models()->attach($model_id);
        return $status ? $status->id : false;
    }


    public static function getModels($id)
    {
        $models = self::join('compatibility_categories', 'compatibilities.compat_category', '=', 'compatibility_categories.category_id')
        ->join('compatibility_models', 'compatibilities.compat_id', '=', 'compatibility_models.compatible_src')
        ->join('models', 'models.model_id', '=', 'compatibility_models.compatible_model')
        ->where('compat_id', $id)
        ->get();

        return $models;
    }

    public function compatibility_categorie()
    {
        return $this->belongsTo(Compatibility_categorie::class, 'compat_category');
    }

    public function models()
    {
        return $this->belongsToMany(Models::class, 'compatibility_models', 'compatible_src', 'compatible_model');
    }
}
