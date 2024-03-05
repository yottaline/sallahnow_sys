<?php

namespace App\Http\Controllers;


use App\Models\Location;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        return view('content.settings.index');
    }

    function locationLoad(Request $request)
    {
        $request->type;
        $request->parent;
        $location = Location::where([
            'location_type' => $request->type,
            'location_parent' => $request->parent
        ])->get();
        echo json_encode($location);
    }

    function locationSubmit(Request $request)
    {
        $location = new Location;
        $location->location_name = json_encode([
            'en' => $request->name_en,
            'ar' => $request->name_ar,
        ]);
        $location->location_type = intval($request->type);
        $location->location_parent = intval($request->parent);
        $status = $location->save();

        echo json_encode([
            'status' => $status,
            'data' => $location,
        ]);
    }
}
