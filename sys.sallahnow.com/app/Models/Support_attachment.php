<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support_attachment extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'attach_id',
        'attach_file',
        'attach_ticket',
        'attach_reply',
        'attach_time'
    ];

    public function supportTicket() {
        return $this->belongsTo(Support_ticket::class, 'attach_ticket', 'attach_id');
    }

    public function supportReply() {
        return $this->belongsTo(Support_replie::class,'attach_reply', 'attach_id');
    }
}