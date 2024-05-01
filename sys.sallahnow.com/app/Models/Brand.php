<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'brand_name',
        'brand_logo',
        'brand_visible',
        'user_id'
    ];

    public static function fetch($id = 0, $params = null, $limit = null, $lastId = null)
    {
        $brands = self::limit($limit)->orderBy('brand_id', 'DESC');

        if ($lastId) $brands->where('brand_id', '<', $lastId);

        if ($params) $brands->where($params);

        if ($id) $brands->where('brand_id', $id);

        return $id ? $brands->first() : $brands->get();
    }

    public static function submit($param, $id)
    {
        if ($id) return self::where('brand_id', $id)->update($param) ? $id : false;

        $status = self::create($param);
        return $status ? $status->id : false;
    }


    public function user() {
        return $this->belongsTo(User::class);
    }

    public function models() {
        return $this->hasMany(Models::class);
    }

    public function supportTickets() {
        return $this->hasMany(Support_ticket::class);
    }
}