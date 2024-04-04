<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscriptions;
use App\Models\Package;
use App\ResponseApi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionsApiController extends Controller
{
    use ResponseApi;
    public function __construct()
    {
        $this->middleware(['auth:technician-api','check_device_token']);
    }

    public function getAll()
    {
        $subscriptions = Subscriptions::all();
        if(!$subscriptions)
        {
            return $this->returnError('There are no subscriptions', '108');
        }

        return $this->returnData('subscriptions', $subscriptions);
    }

    public function changeStatus($sub_id)
    {
        $subscription = Subscriptions::where('sub_id', $sub_id)->first();
        if(!$subscription)
        {
            return $this->returnError('There are no subscriptions', '108');
        }

        if($subscription->sub_status == 1){
           $status = Subscriptions::where('sub_id', $sub_id)->update(['sub_status' => 0]);
        }
        else{
            $status = Subscriptions::where('sub_id',  $sub_id)->update(['sub_status' => 1]);
        }
        if(!$status){
            return $this->returnError('status not change', '103');
        }
        return $this->returnSuccess('status change successfully');
    }

    public function subPackage(Request $request)
    {
        $package = Package::where('pkg_id', $request->package_id)->first();
        // return $package;
        $pam = [
            'sub_pkg'        => $package->pkg_id,
            'sub_points'     => $package->pkg_period,
            'sub_cost'       => $package->pkg_cost,
            'sub_period'     => $package->pkg_period,
            'sub_priv'       => $package->pkg_priv,
            'sub_tech'       => $request->tech_id,
            'sub_start'      => $request->sub_start,
            'sub_register'   => Carbon::now()
        ];

        $end = Carbon::parse($request->sub_start)->addMonth($package->pkg_period);
        $pam['sub_end'] = $end;
        $technician = Subscriptions::where('sub_tech', $request->tech_id)->first();
            if($technician){
                Subscriptions::where('sub_tech', $request->tech_id)->update(['sub_status' => 0]);
                Subscriptions::create($pam);
            }

        return $this->returnSuccess('You have successfully subscribed');
    }
}