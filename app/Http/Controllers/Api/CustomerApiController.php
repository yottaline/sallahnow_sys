<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\ResponseApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CustomerApiController extends Controller
{
    use ResponseApi;
    public function __construct()
    {
        return $this->middleware('auth:customer-api',['except' => ['login', 'register']]);
    }

    public function register(Request $request) {

        $request->validate([
            'name'         => 'required | string',
            'email'        => 'required | email',
            'mobile'       => 'required | unique:customers,customer_mobile',
            'password'     => 'required ',
            'country_id'   => 'required | numeric',
            'state_id'     => 'required | numeric',
            'city_id'      => 'required | numeric',
            'area_id'      => 'required | numeric',
            'address'      => 'required'
        ]);

        $code = strtoupper($this->uniqidReal());
        $password = Hash::make($request->password);
        Customer::create([
            'customer_code'         => $code,
            'customer_name'         => $request->name,
            'customer_email'        => $request->email,
            'customer_mobile'       => $request->mobile,
            'customer_password'     => $password,
            'customer_country'      => $request->country_id,
            'customer_state'        => $request->state_id,
            'customer_city'         => $request->city_id,
            'customer_area'         => $request->area_id,
            'customer_address'      => $request->address,
            'customer_notes'        => '',
            'customer_register'     => Carbon::now()
        ]);

        $customer = Customer::where('customer_mobile', $request->mobile)->first();
        if(!$customer) {
            return response()->json(['error' => 'Unauthorized'], 104);
        }else {
            $passwords = Hash::check(request('password'), $customer->customer_password);
            if(!$passwords) {
                return response()->json(['error' => 'Unauthorized'], 104);
            }else {
                $token = auth()->guard('customer-api')->login($customer);
                return $this->respondWithToken($token);
            }
        }
    }

    public function login(Request $request) {
        $customer = Customer::where('customer_mobile', $request->mobile)->first();
        if(!$customer) {
            return response()->json(['error' => 'Unauthorized'], 104);
        }else {
            $passwords = Hash::check(request('password'), $customer->customer_password);
            if(!$passwords) {
                return response()->json(['error' => 'Unauthorized'], 104);
            }else {
                $token = auth()->guard('customer-api')->login($customer);
                return $this->respondWithToken($token);
            }
        }
    }

    public function profile() {
        return $this->returnData('customer', auth()->guard('customer-api')->user());
    }

    public function logout()
    {
        auth()->guard('customer-api')->logout();
        return $this->returnSuccess('Successfully logged out');
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('technician-api')->factory()->getTTL() * 9999999
        ]);
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