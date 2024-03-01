<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function rooms(){
        return $this->belongsTo(Chat_Room::class, 'member_room', 'member_id');
    }

    public function technicians() {
        return $this->belongsTo(Technician::class, 'member_tech', 'member_id');
    }
}
