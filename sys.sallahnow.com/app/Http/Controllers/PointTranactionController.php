<?php

namespace App\Http\Controllers;

use App\Models\PointTranaction;
use App\Models\Technician;
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
        $points = DB::table('point_tranactions')
        ->join('technicians', 'point_tranactions.points_tech', '=', 'technicians.tech_id')
        ->orderByDesc('points_register')->limit(15)->offset(0)->get();
        echo json_encode($points);
    }

    public function submit(Request $request) {

        $id = $request->point_id;
        $param = [
            'points_count'    => $request->Count,
            'points_src'    => $request->point_source,
            'points_target'   => 1,
            'points_process' => $request->process,
            'points_technician_id' => $request->technician_name,
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

    public function technicianName($tech_mobile) {
        $technician = Technician::where('tech_mobile', $tech_mobile)->first();
        $points = DB::table('point_tranactions')
        ->join('technicians', 'point_tranactions.points_tech', '=', 'technicians.tech_id')
        ->where('point_tranactions.points_tech', $technician->tech_id)->get();
        echo json_encode($points);
    }

    public function profile($id) {
        return view('content.points.profile');
    }
}
