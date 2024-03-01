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

    public function member(){
        return $this->hasMany(Chat_Room_Members::class);
    }

    public function messages() {
        return $this->hasMany(Chat_Room_Message::class);
    }
}