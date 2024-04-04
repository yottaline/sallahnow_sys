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