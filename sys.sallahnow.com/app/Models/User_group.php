<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_group extends Model
{
    use HasFactory;

    protected $fillable = [
        'ugroup_id',
        'ugroup_name',
        'ugroup_privileges'
    ];

    public $timestamps = false;

    public function user() {
        return $this->hasOne(User::class);
    }

}