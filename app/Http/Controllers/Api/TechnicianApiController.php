<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Compatibilities_suggestions;
use App\Models\Compatibility;
use App\Models\Compatibility_categorie;
use App\Models\Models;
use App\Models\Package;
use App\Models\PointTranaction;
use App\Models\Post;
use App\Models\Post_Comment;
use App\Models\Post_Like;
use App\Models\Post_View;
use App\Models\Post_Views;
use App\Models\Subscriptions;
use App\Models\Technician;
use App\ResponseApi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class TechnicianApiController extends Controller
{
    use ResponseApi;
    public function __construct()
    {
        $this->middleware(['auth:technician-api', 'check_device_token'], ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'         => 'required',
            'email'        => 'required|unique:technicians,tech_email',
            'mobile'       => 'required|numeric|unique:technicians,tech_mobile',
            'password'     => 'required',
            'country'      => 'required',
            'state'        => 'required',
            'city'         => 'required',
            'area'         => 'required'
        ],[
            'email.unique' => 'This email address is already registered'
        ]);


        $code = strtoupper($this->uniqidReal());
        $devise_token = strtoupper($this->uniqidReal());
        $param = [
            'tech_name'              => $request->name,
            'tech_email'             => $request->email,
            'tech_mobile'            => $request->mobile,
            'tech_tel'               => $request->tel,
            'tech_password'          => Hash::make($request->password),
            'tech_identification'    => $request->identification,
            'tech_birth'             => $request->birth,
            'tech_country'           => $request->country,
            'tech_state'             => $request->state,
            'tech_city'              => $request->city,
            'tech_area'              => $request->area,
            'tech_address'           => $request->address,
            'tech_bio'               => $request->bio,
            'devise_token'           => $devise_token,
            'tech_register_by'       => null,
            'tech_code'              => $code,
            'tech_register'          => Carbon::now()
        ];

        Technician::submit($param);
        $params[] = ['tech_mobile', $request->mobile];
        $technician = Technician::fetch(0, $params);
        if(!$technician[0]) {
            return response()->json(['error' => 'Unauthorized'], 104);
        }else {
            $passwords = Hash::check(request('password'), $technician[0]->tech_password);
            if(!$passwords) {
                return response()->json(['error' => 'Unauthorized'], 104);
            }else {
                $token = auth()->guard('technician-api')->login($technician[0]);
                $technician[0]->token = $token;
                return $this->returnSuccess('');
                // return $this->respondWithToken($technician[0]);
            }
        }

        // $credentials = request(['tech_mobile', 'password']);

        // if (! $token = auth()->guard('technician-api')->attempt($credentials)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        // return $this->respondWithToken($token);
    }


    public function login()
    {
        $params[] = ['tech_mobile', request('mobile')];
        $technician = Technician::fetch(0, $params);

        if (!count($technician)) return $this->returnError('Sorry, you don`t have an account', 104);

        if(!$technician[0]){
            return $this->returnError('Sorry, you don`t have an account', 104);
        }else {

            $passwords = Hash::check(request('password'), $technician[0]->tech_password);

            if(!$passwords) {

                return $this->returnError('The password is incorrect', 102);

            }else {
                $token = auth()->guard('technician-api')->login($technician[0]);

                $technician[0]->token = $token;

                $param[] = ['sub_tech', $technician[0]->tech_id];
                $param[] = ['sub_status', '=', 1];
                $subscription = Subscriptions::fetch(0, $param);
                if(!count($subscription))
                {
                    return $this->respondWithToken($technician[0]);
                }

                $technician[0]->subscription = $subscription[0];

                return $this->returnData('data', $technician[0], '');
                return $this->respondWithToken($technician[0]);

            }
        }
        // $credentials = request(['tech_mobile', 'password']);
        // if (! $token = auth('technician-api')->attempt($credentials)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        // return $this->respondWithToken($token);
    }

    public function profile()
    {
        return $this->returnData('data', auth('technician-api')->user());
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'         => 'required',
            'mobile'       => 'required|numeric',
            'password'     => 'required',
            'country'   => 'required',
            'state'     => 'required',
            'city'      => 'required',
            'area'      => 'required'
        ]);

        $id = $request->id;
        $mobile = $request->mobile;
        $email  = $request->email;
        $identification = $request->identification;

        if (count(Technician::fetch(0, [['tech_id', '!=', $id], ['tech_mobile', '=', $mobile]])))
        {
            return $this->returnError('This  mobile number already exists', 108);
        }

        if ($email && count(Technician::fetch(0, [['tech_id', '!=', $id], ['tech_email', '=', $email]])))
        {
            return $this->returnError('This email already exists', 108);
        }

        if ($identification && count(Technician::fetch(0, [['tech_id', '!=', $id], ['tech_identification', '=', $identification]])))
        {
            return $this->returnError('This identification already exists', 108);
        }

        $code = Str::random(4);
        $param =
        [
            'name'            => $request->name,
            'email'           => $request->email,
            'mobile'          => $request->mobile,
            'tel'             => $request->tel,
            'password'        => Hash::make($request->password),
            'identification'  => $request->identification,
            'birth'           => $request->birth,
            'country_id'      => $request->country,
            'state_id'        => $request->state,
            'city_id'         => $request->city,
            'area_id'         => $request->area,
            'address'         => $request->address,
            'bio'             => $request->bio,
            'login'           => $request->login,
            'devise_token'    => '03df25c845ds460bcdad7802d2vf6fc1dfde972',
            'user_id'         => 1,
            'code'            => $code
        ];
        Technician::submit($param, $id);

        return $this->returnSuccess('updated successfully');
    }

    public function getCompatibilities()
    {

        if (request('search'))
        {
            $params[] = ['part', 'like', '%' . request('search') . '%'];
            $compatibilities  = Compatibility::fetch(0, $params);
        }
        else {
            $compatibilities  = Compatibility::fetch();
        }

        return $this->returnData('compatibilities', $compatibilities);
    }

    public function addSuggestions(Request $request)
    {
        $param =
        [
            'status' => 0,
            'act_not' => '',
            'act_time' => now(),
            'category_id' => $request->cate_id,
            'technician_id'  => $request->technician_id,
            'user_id' => 1
        ];
        $status = Compatibilities_suggestions::submit($param);
        $status->models()->attach($request->models);
    }

    public function getCategory()
    {
        $categories  = Compatibility_categorie::fetch();
        return $this->returnData('categories', $categories);
    }

    public function suggestions()
    {
        $suggestions = Compatibilities_suggestions::fetch();
        return $this->returnData('suggestions', $suggestions);
    }

    public function getModels()
    {
        $models = Models::fetch();
        return $this->returnData('data', $models);
    }

    public function getPackages()
    {
        $packages = Package::fetch();
        return $this->returnData('data', $packages);
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