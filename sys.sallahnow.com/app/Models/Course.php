<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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

    public static function fetch($id = 0, $params = null, $limit = null, $lastId = null)
    {
        $courses = self::join('users', 'courses.course_create_user', '=', 'users.id')
        ->where('course_deleted', 0)->orderByDesc('course_create_time')
        ->limit($limit);

        if($lastId) $courses->where('course_id', '<', $lastId);

        if (isset($params['q']))
        {
            $courses->where(function (Builder $query) use ($params) {
                $query->where('course_code', 'like', '%' . $params['q'] . '%')
                    ->orWhere('course_title', $params['q'])
                    ->orWhere('course_body', 'like', '%' . $params['q'] . '%');
            });
            unset($params['q']);
        }

        if($params) $courses->where($params);

        if($id) $courses->where('course_id', $id);

        return $id ? $courses->first() : $courses->get();
    }

    public static function editor($code)
    {
        return self::join('users', 'courses.course_create_user', '=', 'users.id')
        ->where('course_code', $code)->first();
    }
}
