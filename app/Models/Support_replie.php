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


    public static function fetch($id = 0, $params = null, $limit = null, $lastId = null)
    {
        $supportReplies = self::join('support_tickets', 'reply_ticket', 'ticket_id')->
        limit($limit)->orderBy('reply_create', 'DESC');

        if ($lastId) $supportReplies->where('reply_id', '<', $lastId);

        if ($params) $supportReplies->where($params);

        if ($id) $supportReplies->where('reply_id', $id);

        return $id ? $supportReplies->first() : $supportReplies->get();
    }

    public static function submit($param, $id = null)
    {
        if ($id) return self::where('reply_id', $id)->update($param) ? $id : false;
        $status = self::create($param);
        return $status ? $status->id : false;
    }


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