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

    public static function getChatMember($item)
    {
        return self::where('member_id', $item)->first();
    }

   public static function submit($room, $tech)
    {
        $time = Carbon::now();
         return self::create([
            'member_room' => $room,
            'member_tech' => $tech,
            'member_add'  =>$time
         ]);
    }


    public function rooms(){
        return $this->belongsTo(Chat_Room::class, 'member_room', 'member_id');
    }

    public function technicians() {
        return $this->belongsTo(Technician::class, 'member_tech', 'member_id');
    }
}