<?php

namespace App\Http\Controllers;

use App\Models\Subscriptions;
use App\Models\Package;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('content.subscriptions.index');
    }

    public function load() {
        $subscriptions = Subscriptions::orderBy('created_at', 'desc')->limit(15)->get();
        echo json_encode($subscriptions);
    }

    public function submit(Request $request) {
        $package = Package::where('id', $request->package_id)->first();
        $pam = [
            'package_id'     => $request->package_id,
            'package_points' =>  $package->points,
            'package_cost'   => $package->cost,
            'package_period' => $package->period,
            'package_priv'   => $package->priv,
            'technician_id'  => $request->technician_name,
            'start'          => $request->start,
            'end'            => $request->end,
            'register_by'    => auth()->user()->id
        ];

        $technician = Subscriptions::where('id', $request->technician_name)->first();

        $id = $request->sub_id;
        if(!$id) {
            if($technician){
                Subscriptions::where('id', $request->technician_name)->update(['status' => 0]);
                $status  = Subscriptions::create($pam);
                $id      = $status->id;
            }else {
                $status  = Subscriptions::create($pam);
                $id      = $status->id;
            }
        }
        else {
            $status = Subscriptions::where('id', $id)->update($pam);
        }

        $record =  Subscriptions::where('id', $id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    public function technicianName() {
        $technician_name = DB::table('technicians')
        ->join('subscriptions', 'technicians.id', '=', 'subscriptions.technician_id')
        ->orderBy('subscriptions.created_at', 'desc')
        ->get();
        echo json_encode($technician_name);
    }

    public function userName() {
        $technician_name = DB::table('users')
        ->join('subscriptions', 'users.id', '=', 'subscriptions.register_by')
        ->orderBy('subscriptions.created_at', 'desc')
        ->get();
        echo json_encode($technician_name);
    }

    public function changeStatus(Request $request) {
        $id = $request->sub_id;
        $sub = Subscriptions::where('id', $id)->first();
        if($sub->status == 1){
           $status = Subscriptions::where('id', $id)->update(['status' => 0]);
        }
        else{
            $status = Subscriptions::where('id',  $id)->update(['status' => 1]);
        }

        echo json_encode([
            'status' => boolval($status)
        ]);
    }
}