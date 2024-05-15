<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationApiController extends Controller
{
    public function load(Request $request)
    {
        $locations = Location::where('location_type', $request->type)
        ->where('location_parent', $request->parent)
        ->orderBy('location_id', 'ASC')->get();
        echo json_encode($locations);
    }
}