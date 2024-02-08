<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $locations = Location::all();

        return view('content.settings.locations.index', compact('locations'));
    }
}