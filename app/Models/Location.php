<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'location_name',
        'location_type',
        'location_parent',
        'location_visible'
    ];

    public static function fetch($id = 0, $params = null, $limit = null, $lastID = null)
    {
        $locations = self::limit($limit);

        if($lastID) $locations->where('location_id', '<', $lastID);

        if($params) $locations->where($params);

        return $id ? $locations->first() : $locations->get();
    }


    public static function submit($param, $id = null)
    {
        if ($id) return self::where('location_id', $id)->update($param) ? $id : false;

        $status = self::create($param);
        return $status ? $status->id : false;
    }


    public function centers()
    {
        return $this->hasMany(Center::class);
    }
    public function customer() {
        return $this->hasMany(Customer::class);
    }
}
