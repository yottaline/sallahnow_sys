<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;

// use function Pest\Laravel\json;

class TechnicianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $technicians = Technician::all();
        return view('content.technicians.index', compact('technicians'));
    }

    public function load()
    {
        // TODO: get data DESC limited with offset
        $technicians = Technician::all();
        echo json_encode($technicians);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name'            => 'required|string',
            'mobile'          => 'required|numeric',
            'password'        => 'required',
        ]);

        $param = [
            'name'              => $request->name,
            'email'             => $request->email,
            'tel'               => $request->tel,
            'mobile'            => $request->mobile,
            'birth'             => $request->birth,
            'country_id'        => $request->country_id,
            'state_id'          => $request->state_id,
            'city_id'           => $request->city_id,
            'area_id'           => $request->area_id,
            'address'           => $request->address,
            'identification'    => $request->identification,
            'bio'               => '',
            'notes'             => $request->notes,
            'login'             => now(), // TODO: login is nunable
        ];

        $id = intval($request->technician_id);
        // STATUS SHOULD BE BOOLEAN
        if (!$id) {
            $randomCode =  Str::random(4);
            $param['code'] = $randomCode;
            $param['password'] = '';
            $param['devise_token'] = '';
            $param['user_id'] = Auth::user()->id;
            $status = Technician::create($param);
            // TODO: get insert $id
        } else {
            $status = Technician::where('id', $id)->update($param);
        }

        // TODO: get $record data 
        echo json_encode([
            'status' => boolval($status),
            // 'data' => $record,
        ]);
    }


    public function updateActive(Request $request)
    {
        $id = $request->technician_id;
        Technician::where('id', $id)->update(['blocked' => $request->blocked]);
        session()->flash('Add', 'Active Technician has been updated successfully');
        return back();
    }
}
