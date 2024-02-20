<?php

namespace App\Http\Controllers;

use App\Models\PointTranaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PointTranactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('content.points.index');
    }

    public function load() {
        $points = PointTranaction::orderBy('created_at', 'desc')->limit(15)->get();
        echo json_encode($points);
    }

    public function submit(Request $request) {

        $id = $request->point_id;
        $param = [
            'count'    => $request->Count,
            'src'    => $request->point_source,
            'target'   => 1,
            'process' => $request->process,
            'technician_id' => $request->technician_name,
        ];

        if(!$id) {
            $status = PointTranaction::create($param);
            $id = $status->id;
        }
        else {
            $status = PointTranaction::where('id', $id)->update($param);
        }

        $record = PointTranaction::where('id', $id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    public function technicianName() {
        $technician_name = DB::table('technicians')
        ->join('point_tranactions', 'technicians.id', '=', 'point_tranactions.technician_id')
        ->orderBy('point_tranactions.created_at', 'desc')
        ->get();
        echo json_encode($technician_name);
    }

    public function profile($id) {
        return view('content.points.profile');
    }
}
