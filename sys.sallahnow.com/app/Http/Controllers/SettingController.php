<?php

namespace App\Http\Controllers;


use App\Models\Location;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $locations = Location::all();

        return view('content.settings.index', compact('locations'));
    }

    public function storeLocation(Request $request) {
        return $request;
        $location_names = ['en' => $request->location_name_en, 'ar' => $request->location_name_ar];
        $json_encode_location = json_encode($location_names);

        Location::create([
            'name'     => $json_encode_location,
            'type'     => $request->location_type,
            'parent'   => $request->location_parent,
        ]);

        session()->flash('Add', 'Location data has been added successfully');
        return back();
    }

}