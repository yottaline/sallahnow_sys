<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'course_id',
        'course_code',
        'course_title',
        'course_body',
        'course_file',
        'course_photo',
        'course_type',
        'course_cost',
        'course_archived',
        'course_archive_user',
        'course_archive_time',
        'course_deleted',
        'course_delete_user',
        'course_delete_time',
        'course_views',
        'course_requests',
        'course_create_user',
        'course_create_time',
        'course_modify_user',
        'course_modify_time'
    ];
}