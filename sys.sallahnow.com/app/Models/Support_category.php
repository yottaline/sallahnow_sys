<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support_category extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'category_name',
        'category_cost',
        'category_visible'
    ];

    public function supportTickets() {
        return $this->hasMany(Support_ticket::class);
    }
}
