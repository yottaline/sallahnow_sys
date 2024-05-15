<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Market_store;
use App\ResponseApi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MarketStoreApiController extends Controller
{
    use ResponseApi;
    public function __construct()
    {
        // $this->middlewer('api')
    }

    public function getStores()
    {
        $stores = Market_store::fetch();
        echo json_encode($stores);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'official_name' => 'required',
            'mobile'        => 'required|unique:market_stores,store_mobile',
            'phone'         => 'required',
            'country_id'    => 'required',
            'state_id'      => 'required',
            'city_id'       => 'required',
            'area_id'       => 'required',
            'address'       => 'required',
            'tax_store'     => 'required|unique:market_stores,store_tax'
        ]);

        $phone  = $request->phone;
        $mobile = $request->mobile;
        $tax    = $request->tax_store;


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

        $result = Market_store::submit($params, null);

        echo json_encode([
            'status' => boolval($result),
            'data'   => $result ? Market_store::fetch($result) : []
        ]);

    }

    public function loadLocation(Request $request)
    {
        $params[] = ['location_type', '1'];
        $countries = Location::fetch(0, $params);
        echo json_encode(
           [ 'status' => true,
            'data'   => $countries]
        );
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
