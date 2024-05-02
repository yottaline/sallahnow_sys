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

    public function load()
    {
        echo json_encode(Package::fetch(0));
    }

    public function submit(Request $request)
    {
        $id = $request->package_id;

        $pam = [
            'pkg_type'     => $request->type,
            'pkg_period'   => $request->period,
            'pkg_cost'     => $request->cost,
            'pkg_points'    => $request->point,
            'pkg_priv'     => ''
        ];

        // if(!$id) {
        //     $status = Package::create($pam);
        //     $id = $status->id;
        // }
        // else {
        //     $status = Package::where('id', $id)->update($pam);
        // }

        $result = Package::submit($pam, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Package::fetch($id) : [],
        ]);
    }
}