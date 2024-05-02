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

    public static function submit($param, $id = null)
    {
        if ($id) return self::where('attach_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }

    public function supportTicket() {
        return $this->belongsTo(Support_ticket::class, 'attach_ticket', 'attach_id');
    }

    public function supportReply() {
        return $this->belongsTo(Support_replie::class,'attach_reply', 'attach_id');
    }
}