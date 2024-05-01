<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Models extends Model
{
    use HasFactory;

    public $title = 'models';
    public $timestamps = false;
    protected $fillable = [
        'model_id',
        'model_name',
        'model_photo',
        'model_url',
        'model_visible',
        'model_brand'
    ];

    public static function fetch($id = 0, $params = null, $limit = null, $lastId = null)
    {
        $models = self::join('brands', 'models.model_brand', '=', 'brands.brand_id')->limit($limit);

        if ($lastId) $models->where('model_id', $lastId);

        if (isset($params['q']))
        {
            $models->where(function (Builder $query) use ($params) {
                $query->where('model_name', 'like', '%' . $params['q'] . '%')
                    ->orWhere('model_visible', $params['q'])
                    ->orWhere('brand_name', $params['q'])
                    ->orWhere('model_url', 'like', '%' . $params['q'] . '%');
            });
            unset($params['q']);
        }

        if ($params) $models->where($params);

        if ($id) $models->where('model_id', $id);

        return $id ? $models->first() : $models->get();
    }


    public static function submit($param, $id)
    {
        if ($id) return self::where('model_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }


    public function brand() {
        return $this->belongsTo(Brand::class, 'model_brand');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function compatibilities(){
        return $this->belongsToMany(Compatibility::class, 'compatibility_models', 'compatible_model', 'compatible_src');
    }

    public function suggestions() {
        return $this->belongsToMany(Compatibilities_suggestions::class);
    }

    public function supportTickets() {
        return $this->hasMany(Support_ticket::class);
    }
}
