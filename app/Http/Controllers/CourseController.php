<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    private $photosPath = '/photos';
    public function index()
    {
        return view('content.courses.index');
    }

    public function load(Request $request)
    {
        $params = $request->q ? ['q' => $request->q] : [];
        $limit  = $request->limit;
        $lastId = $request->last_id;

        echo json_encode(Course::fetch(0, $params, $limit, $lastId));
    }

    public function editor($code = null)
    {
        $data = $code ? Course::editor($code) : null;
        $file = Storage::get('public/courses/' . $code . '.txt');
        return view('content.courses.create', compact('data', 'file'));
    }


    public function submit(Request $request)
    {
        $request->validate([
            'title'     => 'required',
            'body'      => 'required',
            'cost'      => 'required | numeric',
            'package'   => 'required | numeric',
            'discount'  => 'required'
        ]);
        $pak_disc = ['package_id' => $request->package, 'discount' => $request->discount];
        $package_disc = json_encode($pak_disc);

        $photo = $request->file('photo');
        if ($photo) {
            $photoName = $this->uniqidReal(rand(4, 18));
            $extension = $photo->getClientOriginalExtension();
            $nameEx    = $photoName.'.'. $extension;
            $photo->storeAs($this->photosPath,$nameEx,'posts');
            $param['post_photo'] = $photoName;
        }

        $param = [
            'course_title'          => $request->title,
            'course_body'           => $request->body,
            'course_cost'           => $request->cost,
            'package_disc'          => $package_disc,
        ];

        $id = $request->id;
        if(!$id){
            $param['course_create_user'] = auth()->user()->id;
            $param['course_code']        = strtoupper($this->uniqidReal());
        }else {
            $param['course_modify_user'] = auth()->user()->id;
            $param['course_modify_time'] = Carbon::now();
        }

        $result = Course::submit($param, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Course::fetch($result) : [],
        ]);

    }

    // public function cost(Request $request) {
    //   $course_id = $request->course_id;
    //   $request->validate(['cost' => 'required | numeric']);
    //   $status = Course::where('course_id', $course_id)->update(['course_cost' => $request->cost]);
    //   $record = Course::where('course_id', $course_id)->first();
    //   echo json_encode([
    //       'status' => boolval($status),
    //       'data' => $record,
    //   ]);
    // }

    public function addFile(Request $request)
    {
        $id = $request->course_id;
        $context   = $request->context;

        $course  = Course::fetch($id);
        $code   = $course->course_code;
        $status = Storage::disk('courses')->put($code . '.txt', $context);
        echo json_encode([
            'status' => boolval($status),
        ]);


    }

    public function updateArchived(Request $request)
    {
        $id = $request->id;
        $time = Carbon::now();
        $user = auth()->user()->id;
        $request->key == 'post_deleted' ? $param = ['course_deleted' => $request->val, 'course_create_time' => $time, ['course_delete_user' => $user]] : $param = ['course_archived' => $request->val, 'course_archive_user' => $user];

        $result = Course::submit($param, $id);
        echo json_encode([
            'status' => boolval($result),
        ]);
    }

    // public function delete(Request $request) {
    //     $course_id = $request->course_id;
    //     $status    = Course::where('course_id', $course_id)->update(['course_deleted' => 1]);
    //     $record = Course::where('course_id', $course_id)->first();
    //     echo json_encode([
    //         'status' => boolval($status),
    //         'data'   => $record,
    //     ]);
    // }

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