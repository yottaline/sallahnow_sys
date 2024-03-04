<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\ResponseApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseApiController extends Controller
{
    use ResponseApi;
    public function __construct()
    {
        return $this->middleware('auth:technician-api');
    }

    public function courses() {
        $courses = DB::table('courses')
        ->join('users', 'courses.course_create_user', '=', 'users.id')
        ->where('course_deleted', 0)->orderByDesc('course_create_time')->get();
        return $this->returnData('courses', $courses);
    }

    public function views(Request $request) {
        $view   = Course::where('course_id', $request->course_id)->first();
        Course::where('course_id', $request->course_id)->update(['course_views' => $view->course_views +1]);
        $course = Course::where('course_id', $request->course_id)->first();
        return $this->returnData('course', $course);
    }
}