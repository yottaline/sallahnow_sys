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
        $params = [['location_type', $request->type], ['location_parent', $request->parent]];

        echo json_encode(Location::fetch(0,$params));
    }

    function locationSubmit(Request $request)
    {
        $names = json_encode([
            'en' => $request->name_en,
            'ar' => $request->name_ar,
        ]);

        $params = [
            'location_type'   => intval($request->type),
            'location_parent' => intval($request->parent),
            'location_name'   => $names,
        ];

        $result = Location::submit($params);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Location::fetch($result) : [],
        ]);
    }
}