<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support_ticket extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'ticket_id',
        'ticket_code',
        'ticket_brand',
        'ticket_model',
        'ticket_category',
        'ticket_cost',
        'ticket_context',
        'ticket_status',
        'ticket_tech',
        'ticket_create'
    ];

    public function brand() {
        return $this->belongsTo(Brand::class, 'ticket_brand', 'ticket_id');
    }

    public function model() {
        return $this->belongsTo(Model::class, 'ticket_model', 'ticket_id');
    }

    public function supportCategory() {
        return $this->belongsTo(Support_category::class, 'ticket_category', 'ticket_id');
    }

    public function technician() {
        return $this->belongsTo(Technician::class, 'ticket_tech', 'ticket_id');
    }

    public function supportReplie() {
        return $this->hasMany(Support_replie::class);
    }

    public function supportAttachment() {
        return $this->hasMany(Support_attachment::class);
    }

}