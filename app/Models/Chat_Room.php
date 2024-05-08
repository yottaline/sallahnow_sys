<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat_Room extends Model
{
    use HasFactory;

    public $table = 'chat_rooms';
    public $timestamps = false;

    protected $fillable = [
        'room_id',
        'room_code',
        'room_type',
        'room_name'
    ];

    public static function fetch($id = 0, $params = null)
    {
        $chatRooms = self::orderBy('room_id');

        if ($params) $chatRooms->where($params);
        if ($id) $chatRooms->where('room_id', $id);

        return $id ? $chatRooms->first() :  $chatRooms->get();
    }

    public static function submit($param, $id)
    {
        if ($id) return self::where('room_id', $id)->update($param) ? $id : false;

        $status = self::create($param);
        return $status ? $status->id : false;
    }

    public function member(){
        return $this->hasMany(Chat_Room_Members::class);
    }

    public function messages() {
        return $this->hasMany(Chat_Room_Message::class);
    }
}
