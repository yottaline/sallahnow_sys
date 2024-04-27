<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat_Room_Message extends Model
{
    use HasFactory;

    public $table = 'chat_room_messages';
    public $timestamps = false;

    protected $fillable = [
        'msg_id',
        'msg_room',
        'msg_from',
        'msg_context',
        'msg_create'
    ];

    public static function fetch($id = 0, $params = null)
    {
        $chatRoomMessages = self::join('chat_rooms', 'chat_room_messages.msg_room', '=', 'chat_rooms.room_id')
        ->join('technicians', 'chat_room_messages.msg_from', 'technicians.tech_id')
        ->where('chat_room_messages.msg_room', 'chat_rooms.room_id');

        if ($params) $chatRoomMessages->where($params);
        if ($id) $chatRoomMessages->where('msg_id', $id);

        return $id ? $chatRoomMessages->first() : $chatRoomMessages->get();
    }

    public static function submit($param, $id)
    {
        if ($id) return self::where('msg_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }

    public static function msg_room($id)
    {
        $messages = self::join('chat_rooms', 'chat_room_messages.msg_room', '=', 'chat_rooms.room_id')
        ->join('technicians', 'chat_room_messages.msg_from', 'technicians.tech_id')
        ->where('chat_room_messages.msg_room', $id);
        return $messages->get();
    }

    public static function getFirstElementById($item)
    {
        return self::where('msg_id', $item)->first();
    }

    public function room() {
        return $this->belongsTo(Chat_Room::class, 'msg_room', 'msg_id');
    }

    public function technician() {
        return $this->belongsTo(Technician::class, 'msg_from', 'msg_id');
    }
}
