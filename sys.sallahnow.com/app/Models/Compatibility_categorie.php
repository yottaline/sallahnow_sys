<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compatibility_categorie extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'category_name',
        'category_visible'
    ];

    public static function fetch($id = 0, $params = null, $limit = null, $lastId = null)
    {
        $compatibilityCategories = self::limit($limit)->orderBy('category_id', 'DESC');

        if ($params) $compatibilityCategories->where($params);

        if ($id) $compatibilityCategories->where('category_id', $id);

        return $id ? $compatibilityCategories->first() : $compatibilityCategories->get();
    }

    public static function submit($param, $id)
    {
        if ($id) return self::where('category_id', $id)->update($param) ? $id : false;

        $status = self::create($param);
        return $status ? $status->id : false;
    }


    public function compatibilities() {
        return $this->hasMany(Compatibility::class);
    }

    public function suggestion() {
        return $this->hasOne(Compatibilities_suggestions::class);
    }
}