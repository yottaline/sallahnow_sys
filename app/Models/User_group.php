<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_group extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'ugroup_id',
        'ugroup_name',
        'ugroup_privileges'
    ];


    public static function fetch($id = 0, $params = null, $limit = null, $lastId = null)
    {
        $roles = self::limit($limit);

        if ($params) $roles->where($params);

        if ($id) $roles->where('ugroup_id', $id);
        return $id ? $roles->first() : $roles->get();
    }

    public static function submit($param, $id = null)
    {
        if ($id) return self::where('ugroup_id', $id)->update($param) ? $id : false;

        $status = self::create($param);
        return $status ? $status->id : false;
    }


    public function user() {
        return $this->hasOne(User::class);
    }

}