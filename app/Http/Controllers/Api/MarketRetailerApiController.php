<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Market_retailer;
use App\ResponseApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MarketRetailerApiController extends Controller
{
    use ResponseApi;
    public function __construct()
    {
        $this->middleware(['auth:retailer-api'], ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'phone' => 'required',
            'store' => 'required',
            'email' => 'required|email|unique:market_retailers,retailer_email',
        ]);

        $param = [
            'retailer_name'  => $request->name,
            'retailer_email' => $request->email,
            'retailer_phone' => $request->phone,
            'retailer_store'    => $request->store,
            // 'retailer_admin'    => $request->admin ? $request->admin : 0,
            // 'retailer_active'    => $request->active ? $request->active : 0,
            'retailer_approved_by' => 1,
            'retailer_register'    => Carbon::now(),
            'retailer_password'    => Hash::make($request->password)
        ];

        $result = Market_retailer::submit($param, null);

        echo json_encode([
            'status' => boolval($result),
            'data'   => $result ? Market_retailer::fetch($result) : []
        ]);
        return;
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone'    => 'required',
            'password' => 'required'
        ]);

        $params[] = ['retailer_phone', $request->phone];
        $retailer = Market_retailer::fetch(0, $params);

        if (count($retailer) == 0) return $this->returnError('Sorry, you don`t have an account', 104);

        if(!$retailer[0]){
            return $this->returnError('Sorry, you don`t have an account', 104);
        }else {

            $passwords = Hash::check($request->password, $retailer[0]->retailer_password);
            if(!$passwords) {

                return $this->returnError('The password is incorrect', 102);

            }else {
                if($retailer[0]->retailer_approved == 1){

                    $token = auth()->guard('retailer-api')->login($retailer[0]);
                    $retailer[0]->token = $token;
                    return $this->returnData('data', $retailer[0]);
                }else{
                    return $this->returnError('Sorry, your account don`t approved', 106);
                }

            }
        }
    }



    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('technician-api')->factory()->getTTL() * 9999999,
            'status_code' => '100'
        ]);
    }
}
