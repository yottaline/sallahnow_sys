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
        return view('content.settings.index');
    }

    public function load() {
        $location = Location::orderBy('created_at', 'desc')->get();
        echo json_encode($location);
    }

    public function storeLocation(Request $request) {
        $location_names = ['en' => $request->location_name_en, 'ar' => $request->location_name_ar];
        $json_encode_location = json_encode($location_names);
       $status = Location::create([
            'location_name'     => $json_encode_location,
            'location_type'     => $request->location_type,
            'location_parent'   => $request->location_parent,
        ]);

        echo json_encode([
            'status' => boolval($status),
            // 'data' => $record,
        ]);
    }

}