<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Technician;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class CenterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('content.centers.index');
    }

    public function load() {
        $centers = DB::table('centers')
        ->join('technicians', 'centers.center_owner', '=', 'technicians.tech_id')
        ->orderBy('centers.center_create', 'desc')->limit(15)->offset(0)->get();
        echo json_encode($centers);
    }

    public function submit(Request $request) {
        // return $request;
        $request->validate([
            'name' => 'required'
        ]);

        $logo = $request->file('logo');
        $logoName = $logo->getClientOriginalName();
        $location = 'Image/Centers/';
        $logo->move($location , $logoName);

        $logoPath = url($location, $logoName);

        $parm = [
            'center_name'       => $request->name,
            'center_mobile'     => $request->mobile,
            'center_whatsapp'   => $request->center_whatsapp,
            'center_email'      => $request->email,
            'center_tel'        => $request->tel,
            'center_logo'       => $logoName,
            'center_tax'        => $request->center_tax,
            'center_cr'         => $request->center_cr,
            'center_country'    => $request->country_id,
            'center_state'      => $request->state_id,
            'center_city'       => $request->city_id,
            'center_area'       => $request->area_id,
            'center_address'    => $request->address,
            'center_owner'      => $request->technician_name,
            'center_create'     => Carbon::now()
            ];

        $id = $request->center_id;
        if(!$id) {
            $status = Center::create($parm);
            $id = $status->center_id;
        }else {
            $status = Center::where('center_id', $id)->update($parm);
        }

        $record =  Center::where('center_id', $id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    public function getTechnician($item) {
        $technician_name = Technician::where('tech_code', 'like', '%' . $item . '%')->get();
        echo json_encode($technician_name);
    }

    public function addOwner(Request $request){
        $id = $request->center_id;
       $status = Center::where('id', $id)->update([
            'owner'  => $request->technician_name,
        ]);
        echo json_encode([
            'status' => boolval($status),
        ]);
    }

    public function getTechnicianName() {
        // $technician_name = DB::table('technicians')
        // ->join('centers', 'technicians.tech_id', '=', 'centers.owner')
        // ->select('centers.name','technicians.tech_name')->orderBy('centers.created_at', 'desc')
        // ->get();
        // echo json_encode($technician_name);
    }
}