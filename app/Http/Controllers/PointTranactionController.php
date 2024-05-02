<?php

namespace App\Http\Controllers;

use App\Models\PointTranaction;
use App\Models\Technician;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PointTranactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('content.points.index');
    }

    public function load(Request $request)
    {
        $param  = $request->q ? ['q' => $request->q] : [];
        $limit  = $request->limit;
        $listId = $request->list_id;

        echo json_encode(PointTranaction::fetch(0, $param, $limit, $listId));
    }

    public function submit(Request $request) {

        $id = $request->point_id;
        $param = 
        [
            'points_count'    => $request->Count,
            'points_src'    => $request->point_source,
            'points_target'   => 1,
            'points_process' => $request->process,
            'points_technician_id' => $request->technician_name,
        ];

        if(!$id) 
        {
            $param['points_register'] = Carbon::now();
        }

        $result = PointTranaction::submit($param, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? PointTranaction::fetch($result) : [],
        ]);
    }

    // public function technicianName($tech_mobile) 
    // {
    //     $technician = Technician::where('tech_mobile', $tech_mobile)->first();
    //     $points = DB::table('point_tranactions')
    //     ->join('technicians', 'point_tranactions.points_tech', '=', 'technicians.tech_id')
    //     ->where('point_tranactions.points_tech', $technician->tech_id)->get();
    //     echo json_encode($points);
    // }

    public function profile($id) 
    {
        return view('content.points.profile');
    }
}