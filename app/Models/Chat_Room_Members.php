<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Chat_Room_Members extends Model
{
    use HasFactory;

    public $table = 'chat_room_members';
    public $timestamps = false;

    protected $fillable = [
        'member_id',
        'member_room',
        'member_tech',
        'member_admin',
        'member_add'
    ];

    public static function fetch($id = 0, $params = null)
    {
        $chatRoomMembers = self::join('chat_rooms', 'chat_room_members.member_room', '=', 'chat_rooms.room_id')
        ->where('chat_room_members.member_tech', '=', 'technicians.tech_id');

        if ($params) $chatRoomMembers->where($params);
        if ($id) $chatRoomMembers->where('member_id', $id);

        return $id ? $chatRoomMembers->first() : $chatRoomMembers->get();
    }

    public static function getteh($id)
    {
        $chatRoomMembers = self::join('chat_rooms', 'chat_room_members.member_room', '=', 'chat_rooms.room_id')
        ->where('chat_room_members.member_tech', '=', $id);
        return $chatRoomMembers->get();
    }

    // I use it in api to get alone member by id
    public static function getChatMember($item)
    {
        return self::where('member_id', $item)->first();
    }

   public static function submit($param, $id)
    {
        if ($id) return self::where('member_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }


    public function rooms(){
        return $this->belongsTo(Chat_Room::class, 'member_room', 'member_id');
    }

    public function technicians() {
        return $this->belongsTo(Technician::class, 'member_tech', 'member_id');
    }
}