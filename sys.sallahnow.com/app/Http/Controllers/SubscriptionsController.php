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
        $subscriptions = DB::table('subscriptions')
        ->join('technicians', 'subscriptions.sub_tech', '=', 'technicians.tech_id')
        ->join('users', 'subscriptions.sub_register_by','=', 'users.id')->orderBy('subscriptions.sub_register', 'desc')->limit(15)->offset(0)->get();
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
       $package = Package::where('pkg_id', $request->package_id)->first();
        $pam = [
            'sub_pkg'     => $request->package_id,
            'sub_points' =>  $package->pkg_points,
            'sub_cost'   => $package->pkg_cost,
            'sub_period'         => $package->pkg_period,
            'sub_priv'           => 'ty',
            'sub_tech'           => $request->technician_name,
            'sub_start'          => $request->start,
            'sub_register_by'    => auth()->user()->id,
            'sub_register'       => now()
        ];

        $end = Carbon::parse($request->start)->addMonth($package->pkg_period);
        $technician = Subscriptions::where('sub_tech', $request->technician_name)->get();
        $id = $request->sub_id;
        if(!$id) {
           $pam['sub_end'] = $end;
            if($technician){
                Subscriptions::where('sub_tech', $request->technician_name)->update(['sub_status' => 0]);
                $status  = Subscriptions::create($pam);
                $id      = $status->id;
            }else {
                $status  = Subscriptions::create($pam);
                $id      = $status->id;
            }
        }
        else {
            $status = Subscriptions::where('sub_id', $id)->update($pam);
        }

        $record =  Subscriptions::where('sub_id', $id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    public function technicianName() {
        $technician_name = DB::table('technicians')
        ->join('subscriptions', 'technicians.tech_id', '=', 'subscriptions.sub_tech')->get();
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
        $sub = Subscriptions::where('sub_id', $id)->first();
        if($sub->sub_status == 1){
           $status = Subscriptions::where('sub_id', $id)->update(['sub_status' => 0]);
        }
        elseif($sub->sub_status == 0){
            $status = Subscriptions::where('sub_id',  $id)->update(['sub_status' => 1]);
        }

        echo json_encode([
            'status' => boolval($status)
        ]);
    }
}
