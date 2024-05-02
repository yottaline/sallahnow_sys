<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compatibliy_board extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['board_name'];

    public static function fetch($id = 0, $params = null, $limit = null, $lastId = null)
    {
        $motherBoards = self::limit($limit)->orderBy('board_id', 'DESC');

        if ($lastId) $motherBoards->where('board_name', '<', $lastId);

        if ($params) $motherBoards->where($params);

        if ($id) $motherBoards->where('board_name', $id);

        return $id ? $motherBoards->first() : $motherBoards->get();
    }

    public static function submit($param, $id)
    {
        if ($id) return self::where('board_id', $id)->update($param) ? $id : false;

        $status = self::create($param);
        return $status ? $status->id : false;
    }
}