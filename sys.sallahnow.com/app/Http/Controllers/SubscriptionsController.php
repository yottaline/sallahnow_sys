<?php

namespace App\Http\Controllers;

use App\Models\Subscriptions;
use App\Models\Package;
use App\Models\Technician;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Psy\Readline\Transient;

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
        $technician_name = DB::table('technicians')
        ->join('subscriptions', 'technicians.id', '=', 'subscriptions.technician_id')->select('technicians.name')
        ->orderBy('subscriptions.created_at', 'desc')
        ->get();
        $subscriptions->technician = $technician_name;
        echo json_encode($subscriptions);
    }

    public function search($item) {
        if ($item) {
            $transient  = Technician::where('mobile',$item)->get();
        } else {
            $err = 'not technician';
            echo json_encode($err);
        }
        echo json_encode($transient);
    }


    public function submit(Request $request) {
        $package = Package::where('id', $request->package_id)->first();
        $pam = [
            'package_id'     => $request->package_id,
            'sub_package_points' =>  $package->pkg_points,
            'sub_package_cost'   => $package->pkg_cost,
            'sub_package_period' => $package->pkg_period,
            'package_priv'       => 'ty',
            'technician_id'      => $request->technician_name,
            'sub_start'          => $request->start,
            'sub_register_by'    => auth()->user()->id,
        ];

        $end = Carbon::parse($request->start)->addMonth($package->pkg_period);
        $technician = Subscriptions::where('id', $request->technician_name)->first();
        $id = $request->sub_id;
        if(!$id) {
            if($technician){
                Subscriptions::where('id', $request->technician_name)->update(['sub_status' => 0]);
                $pam['sub_end'] = $end;
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
        ->join('subscriptions', 'users.id', '=', 'subscriptions.sub_register_by')
        ->orderBy('subscriptions.created_at', 'desc')
        ->get();
        echo json_encode($technician_name);
    }

    public function changeStatus(Request $request) {
        $id = $request->sub_id;
        $sub = Subscriptions::where('id', $id)->first();
        if($sub->sub_status == 1){
           $status = Subscriptions::where('id', $id)->update(['sub_status' => 0]);
        }
        elseif($sub->sub_status == 0){
            $status = Subscriptions::where('id',  $id)->update(['sub_status' => 1]);
        }

        echo json_encode([
            'status' => boolval($status)
        ]);
    }
}