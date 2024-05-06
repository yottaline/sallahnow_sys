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
        $subscriptions = Subscriptions::fetch();
        if(!$subscriptions)
        {
            return $this->returnError('There are no subscriptions', '108');
        }

        return $this->returnData('subscriptions', $subscriptions);
    }


    public function changeStatus($sub_id)
    {
        $subscription = Subscriptions::fetch($sub_id);

        if(!$subscription) return $this->returnError('There are no subscriptions', '108');

        $sub_status = 1;
        if($subscription->sub_status) $sub_status = 0;
        $param = ['sub_status' => $sub_status];
        $status = Subscriptions::submit($param, $sub_id);

        if(!$status) return $this->returnError('status not change', '103');

        return $this->returnSuccess('status change successfully');
    }

    public function subPackage(Request $request)
    {
        $package_id = $request->package_id;
        $package = Package::fetch($package_id);

        $parm = [
            'sub_pkg'        => $package->pkg_id,
            'sub_points'     => $package->pkg_period,
            'sub_cost'       => $package->pkg_cost,
            'sub_period'     => $package->pkg_period,
            'sub_priv'       => $package->pkg_priv,
            'sub_tech'       => $request->tech_id,
            'sub_start'      => $request->sub_start,
            'sub_register'   => Carbon::now()
        ];
        $end = Subscriptions::parse($request->sub_start, $package->pkg_period);
        $parm['sub_end'] = $end;
        $params[] = ['sub_tech', $request->tech_id];
        $technician = Subscriptions::fetch(0, $params);

        if (!count($technician)){
            Subscriptions::submit($parm);
            return $this->returnSuccess('You have successfully subscribed');
        }

        if($technician[0])
        {
            Subscriptions::changeStatus($request->tech_id);
            Subscriptions::submit($parm);
        }

        return $this->returnSuccess('You have successfully subscribed');
    }
}