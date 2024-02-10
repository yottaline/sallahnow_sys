<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TechnicianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $technicians = Technician::all();

        return view('content.technicians.index', compact('technicians'));
    }

    public function store(Request $request) {

        $request->validate([
        'name'            => 'required|string',
        'mobile'          => 'required|numeric',
        'password'        => 'required',
       ]);

       $randomCode =  Str::random(4);
       Technician::create([
        'name'               => $request->name,
        'code'               => $randomCode,
        'email'              => $request->email,
        'mobile'             => $request->mobile,
        'password'           => Hash::make($request->password),
        'birth'              => $request->birth,
        'country_id'         => $request->country_id,
        'state_id'           => $request->state_id,
        'city_id'            => $request->city_id,
        'area_id'            => $request->area_id,
        'address'            => $request->address,
        'identification'     => $request->identification,
        'bio'                => $request->bio,
        'active'             => 1,
        'blocked'            => 0,
        'login'              => now(),
        'user_id'            => Auth::user()->id,
       ]);
       session()->flash('Add', 'Technician data has been added successfully');
        return back();
    }

    public function update(Request $request) {
        $id = $request->id;
        $request->validate([
            'name'            => 'required|string',
            'mobile'          => 'required|numeric',
            'password'        => 'required',
           ]);

           $randomCode =  Str::random(4);
           Technician::where('id', $id)->update([
            'name'               => $request->name,
            'code'               => $randomCode,
            'email'              => $request->email,
            'tel'              => $request->tel,
            'mobile'             => $request->mobile,
            'password'           => Hash::make($request->password),
            'birth'              => $request->birth,
            'country_id'         => $request->country_id,
            'state_id'           => $request->state_id,
            'city_id'            => $request->city_id,
            'area_id'            => $request->area_id,
            'address'            => $request->address,
            'identification'     => $request->identification,
            'bio'                => $request->bio,
            'active'             => 1,
            'blocked'            => 0,
            'login'              => now(),
            'user_id'            => Auth::user()->id,
           ]);
           session()->flash('Add', 'Technician data has been update successfully');
            return back();
    }

    public function updateActive(Request $request) {
        $id = $request->technician_id;
        Technician::where('id', $id)->update(['active' => $request->active]);
        session()->flash('Add', 'Active Technician has been updated successfully');
        return back();
    }

    public function delete(Request $request) {
        $id = $request->technician_id;
        Technician::destroy($id);
        session()->flash('error', 'Technician data has been deleted successfully');
        return back();
    }
}