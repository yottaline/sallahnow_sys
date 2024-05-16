<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Market_store;
use Carbon\Carbon;

class MarketStoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $params[] = ['location_type', '1'];
        $countries = Location::fetch(0, $params);
        return view('content.markets.Stores.index', compact('countries'));
    }

    public function load(Request $request)
    {
        $params   = $request->q ? ['q' => $request->q] : [];
        $limit    = $request->limit;
        $listId   = $request->last_id;

        if ($request->status) $params[]      = ['customer_active', $request->status];
        if ($request->area) $params[]        = ['customer_area', $request->area];
        elseif ($request->city) $params[]    = ['customer_city', $request->city];
        elseif ($request->state) $params[]   = ['customer_state', $request->state];
        elseif ($request->country) $params[] = ['customer_country', $request->country];

        echo json_encode(Market_store::fetch(0, $params, $limit, $listId));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'official_name' => 'required',
            'mobile'        => 'required',
            'phone'         => 'required',
            'country_id'    => 'required',
            'state_id'      => 'required',
            'city_id'       => 'required',
            'area_id'       => 'required',
            'address'       => 'required',
        ]);

        $id = $request->store_id;
        $phone  = $request->phone;
        $mobile = $request->mobile;
        $tax    = $request->tax_store;

        if (count(Market_store::fetch(0, [['store_id', '!=', $id], ['store_mobile', '=', $mobile]])))
        {
            echo json_encode(['status' => false,'message' =>  $this->validateMessage('mobile')]);
            return;
        }

        if ($phone && count(Market_store::fetch(0, [['store_id', '!=', $id], ['store_phone', '=', $phone]])))
        {
            echo json_encode(['status' => false,'message' =>  $this->validateMessage('phone')]);
            return;
        }

        if ($tax && count(Market_store::fetch(0, [['store_id', '!=', $id], ['store_tax', '=', $tax]])))
        {
            echo json_encode(['status' => false,'message' =>  $this->validateMessage('Tax Number')]);
            return;
        }


        $params = [
            'store_name' => $request->name,
            'store_code' => $this->uniqidReal(9),
            'store_official_name' => $request->official_name,
            'store_cr'   => $request->cr_store,
            'store_tax'  => $request->tax_store,
            'store_phone' => $phone,
            'store_mobile' => $mobile,
            'store_country' => $request->country_id,
            'store_state'   => $request->state_id,
            'store_city'    => $request->city_id,
            'store_area'    => $request->area_id,
            'store_address' => $request->address,
            'store_cerated' => Carbon::now()
        ];


        $photo = $request->file('cr_photo');
        if ($photo) {
            $photoName = $this->uniqidReal(rand(4, 18));
            $location = 'Image/Markets/stores/';
            $photo->move($location , $photoName);
            $param['store_cr_photo'] = $photoName;
        }

        $result = Market_store::submit($params, $id);

        echo json_encode([
            'status' => boolval($result),
            'data'   => $result ? Market_store::fetch($result) : []
        ]);

    }

    public function ChangeStatus(Request $request)
    {
        $id = $request->store_id;
        $status = 1;
        if($request->status) $status = 0;

        $param = ['store_status' => $status];
        $result = Market_store::submit($param, $id);

        echo json_encode([
            'status' => boolval($result),
            'data' =>  $result ? Market_store::fetch($id) : [],
        ]);
    }

    private function validateMessage($message)
    {
        return 'This ' . $message . ' already exists';
    }

    private function uniqidReal($lenght = 12)
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new \Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
}