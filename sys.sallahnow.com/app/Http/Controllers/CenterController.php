<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Technician;
use Illuminate\Http\Request;
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
        $centers = Center::orderBy('created_at', 'desc')->limit(15)->get();
        $technician_name = DB::table('technicians')
        ->join('centers', 'technicians.id', '=', 'centers.owner')
        ->select('centers.center_whatsapp','technicians.code')->orderBy('centers.created_at', 'desc')
        ->get();
        $centers->technicians = $technician_name;
        echo json_encode($centers);
    }

    public function submit(Request $request) {
        $request->validate([
            'name' => 'required'
        ]);

        $logo = $request->file('logo');
        $logoName = $logo->hashName();
        $location = 'Image/Center/';
        $logo->move($location , $logoName);

        $logoPath = url('Image/Center', $logoName);

        $parm = [
            'name'       => $request->name,
            'mobile'     => $request->mobile,
            'whatsapp'   => $request->center_whatsapp,
            'email'      => $request->email,
            'tel'        => $request->tel,
            'logo'       => $logoPath,
            'tax_number' => $request->center_tax,
            'cr_number'  => $request->center_cr,
            'country_id' => $request->country_id,
            'state_id'   => $request->state_id,
            'city_id'    => $request->city_id,
            'area_id'    => $request->area_id,
            'address'    => $request->address,
            'owner'      => 1
            ];



        $id = $request->center_id;
        if(!$id) {
            $status = Center::create($parm);
            $id = $status->id;
        }else {
            $status = Center::where('id', $id)->update($parm);
        }

        $record =  Center::where('id', $id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    public function getTechnician($item) {
        $technician_name = Technician::where('code', 'like', '%' . $item . '%')->get();
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

    // public function getTechnicianName() {
    //     $technician_name = DB::table('technicians')
    //     ->join('centers', 'technicians.id', '=', 'centers.owner')
    //     ->select('centers.name','technicians.name')->orderBy('centers.created_at', 'desc')
    //     ->get();
    //     echo json_encode($technician_name);
    // }
}