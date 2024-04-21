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

    public function index() 
    {
        return view('content.subscriptions.index');
    }

    public function load(Request $request) 
    {
        $params   = $request->q ? ['q' => $request->q] : [];
        $limit    = $request->limit;
        $listId   = $request->last_id;
        
        echo json_encode(Subscriptions::fetch(0, $params, $limit, $listId));
    }

    // public function search($item) {
    //     if ($item) {
    //         $transient  = Technician::where('mobile',$item)->get();
    //     } else {
    //         $err = 'not technician';
    //         echo json_encode($err);
    //     }
    //     echo json_encode($transient);
    // }


    public function submit(Request $request)
    {   
       $package = Package::where('pkg_id', $request->package_id)->first();
       $technician_id =  $request->technician_name;
       
        $pam = [
            'sub_pkg'            => $request->package_id,
            'sub_points'         =>  $package->pkg_points,
            'sub_cost'           => $package->pkg_cost,
            'sub_period'         => $package->pkg_period,
            'sub_priv'           => 'ty',
            'sub_tech'           => $technician_id,
            'sub_start'          => $request->start,
            'sub_register_by'    => auth()->user()->id,
            'sub_register'       => now()
        ];

        $realTime = $request->start;
        $time     = $package->pkg_period;
        $end      = Subscriptions::parse($realTime, $time);

        // 0105060A4CA7
        $technician = Subscriptions::condition('sub_tech', '=', $technician_id);
        
        $id = $request->sub_id;
        
        if(!$id) {
           $pam['sub_end'] = $end;
            if($technician){
                Subscriptions::changeStatus($technician_id);
            }
        }

        $result = Subscriptions::submit($pam, $id);

        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Subscriptions::fetch($result) : [],
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