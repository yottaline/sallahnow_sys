<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
        // private $location = 'posts/';
    // private $photosPath = 'posts/photos';
    // private $filesPath = 'posts/files';

    private $photosPath = 'courses/photos';
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

    public function editor($code = null)
    {
        $data = $code ?DB::table('courses')
        ->join('users', 'courses.course_create_user', '=', 'users.id')
        ->where('course_code', $code)->first() : null;
        $file = Storage::get('public/' . $code . '.txt');

        return view('content.courses.create', compact('data', 'file'));
    }


    public function submit(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body'  => 'required',
            'cost'  => 'required | numeric'
        ]);

        $photo = $request->file('photo');
        if ($photo) {
            $photoName = $this->uniqidReal(rand(4, 18));
            $photo->move($this->photosPath, $photoName);
            $param['post_photo'] = $photoName;
        }

        $parma = [
            'course_title'          => $request->title,
            'course_body'           => $request->body,
            'course_cost'           => $request->cost,
        ];

        $course_id = $request->id;
        if(!$course_id){
            $parma['course_create_user'] = auth()->user()->id;
            $parma['course_code']        = strtoupper($this->uniqidReal());
            $parma['course_create_time'] = Carbon::now();
            $parma['course_delete_user'] = 1;

            $status = Course::create($parma);
            $course_id =  $status->id;
        }else {
            $parma['course_modify_user'] = auth()->user()->id;
            $parma['course_modify_time'] = Carbon::now();
            $status = Course::where('course_id', $course_id)->update($parma);
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

    public function updateArchived(Request $request)
    {
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