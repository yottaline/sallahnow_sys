<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'pkg_type',
        'pkg_period',
        'pkg_cost',
        'pkg_points',
        'pkg_priv'
    ];
    
    public static function fetch($id = 0, $param = null, $limit = null, $lastId = null)
    {
        $packages = self::limit($limit)->orderby('pkg_id');

        if($id) $packages->where('pkg_id', $id); 
        if($param) $packages->where($param);

        return $id ? $packages->first() : $packages->get();
    }
}