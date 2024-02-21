<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_group extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_group_name',
        'user_group_privileges'
    ];

    // public $timestamps = false;

    public function user() {
        return $this->hasOne(User::class);
    }

}