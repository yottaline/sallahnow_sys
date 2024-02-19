<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function load() {
        // $packages = Package::orderBy('created_at', 'desc')->limit(15)->get();
        $packages = Package::all();
        echo json_encode($packages);
    }

    public function submit(Request $request) {
        $id = $request->package_id;

        $pam = [
            'type'     => $request->type,
            'period'   => $request->period,
            'cost'     => $request->cost,
            'points'    => $request->point,
            'priv'     => ''
        ];

        if(!$id) {
            $status = Package::create($pam);
            $id = $status->id;
        }
        else {
            $status = Package::where('id', $id)->update($pam);
        }

        $record = Package::where('id', $id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }
}
