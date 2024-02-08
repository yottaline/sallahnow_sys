<?php

namespace App\Http\Controllers;

use App\Models\Technician;
use Illuminate\Http\Request;

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
     $data = $request->validate([
        'name'            => 'required|string',
        'email'           => 'required|email',
        'mobile'          => 'required|numeric',
        'tel'             => 'required|numeric',
        'password'        => 'required',
        'birth'           => 'required|date',
        'address'         => 'required|string',
        'identification'  => 'required|string',
         'bio'            => 'required|string',
       ]);

       $code = 0;

       Technician::create([
        'name' => $request->name,

        'email' => $request->email,
       ]);
       session()->flash('Add', 'Technician data has been added successfully');
        return back();
    }
}