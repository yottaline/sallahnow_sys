<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support_replie extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'reply_id',
        'reply_ticket',
        'reply_context',
        'reply_user',
        'reply_tech',
        'reply_create'
    ];

    public function ticket() {
        return $this->belongsTo(Support_ticket::class, 'reply_ticket', 'reply_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'reply_user', 'reply_id');
    }

    public function technician() {
        return $this->belongsTo(Technician::class, 'reply_tech', 'reply_id');
    }

    public function supportAttachment() {
        return $this->hasMany(Support_attachment::class);
    }
}
