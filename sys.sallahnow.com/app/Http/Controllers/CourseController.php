<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function index() {
        return view('content.courses.index');
    }

    public function load() {
        $courses = DB::table('courses')
        ->join('users', 'courses.course_create_user', '=', 'users.id')
        ->where('course_deleted', 0)->orderByDesc('course_create_time')
        ->limit(15)->offset(0)->get();

        echo json_encode($courses);
    }

    public function create() {
        return view('content.courses.create');
    }

    public function edit($course_code) {
       $data = DB::table('courses')
        ->join('users', 'courses.course_create_user', '=', 'users.id')
        ->where('course_code', $course_code)->first();
        return view('content.courses.create', compact('data'));
    }

    public function submit(Request $request) {
        $photo = $request->file('photo');
        $photoName = $photo->getClientOriginalName();
        $location = 'Image/Courses/Photo';

        $parm = [
            'course_title'          => $request->title,
            'course_body'           => $request->body,
            'course_photo'          => $photoName,
            'course_cost'           => $request->cost,
            'course_create_user'    => auth()->user()->id,
            'course_code'           =>  strtoupper($this->uniqidReal()),
            'course_create_time'    =>  Carbon::now()
        ];
        $course_id = $request->id;
        if(!$course_id){
            $status = Course::create($parm);
            $course_id =  $status->id;
        }else {
            $status = Course::where('course_id', $course_id)->update($parm);
        }

        $record = Course::where('course_id', $course_id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);

    }

    public function cost(Request $request) {
      $course_id = $request->course_id;
      $request->validate(['cost' => 'required | numeric']);
      $status = Course::where('course_id', $course_id)->update(['course_cost' => $request->cost]);
      $record = Course::where('course_id', $course_id)->first();
      echo json_encode([
          'status' => boolval($status),
          'data' => $record,
      ]);
    }

    public function addFile(Request $request) {
        // return $request;
        $course_id = $request->course_id;
        $request->validate(['course_file' => 'required|file']);

        $attach = $request->file('course_file');
        $attachName = $attach->getClientOriginalName();
        $location = 'Image/Courses/Files';

        $status = Course::where('course_id', $course_id)->update(['course_file' => $attachName]);
        $record = Course::where('course_id', $course_id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    public function updateArchived(Request $request) {
        $course_id = $request->id;
        $status     = Course::where('course_id', $course_id)->update([
            'course_archived'       => $request->val,
            'course_archive_user'   => auth()->user()->id
        ]);
        echo json_encode([
            'status' => boolval($status),
        ]);
    }

    public function delete(Request $request) {
        $course_id = $request->course_id;
        $status    = Course::where('course_id', $course_id)->update(['course_deleted' => 1]);
        $record = Course::where('course_id', $course_id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data'   => $record,
        ]);
    }

    private function uniqidReal($lenght = 12)
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new \Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
}