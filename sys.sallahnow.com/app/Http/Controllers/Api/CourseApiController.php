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
        return $this->middleware(['auth:technician-api', 'check_device_token']);
    }

    public function courses()
    {
        $courses = Course::fetch();
        if(!$courses) return $this->returnError('No courses', 107);

        return $this->returnData('courses', $courses);
    }

    public function views(Request $request)
    {
        $request->validate([
            'course_id' => 'required | numeric'
        ]);
        $id = $request->course_id;
        $view   = Course::fetch($id);
        $param = ['course_views' => $view->course_views +1];
        $result = Course::submit($param, $id);

        $course = $result ? Course::fetch($result) : [];

        return $this->returnData('course', $course);
    }
}