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
        $this->middleware('auth:technician-api', ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'tech_name'         => 'required',
            'tech_email'        => 'required|unique:technicians,tech_email',
            'tech_mobile'       => 'required|numeric|unique:technicians,tech_mobile',
            'tech_password'     => 'required',
            'country_id'        => 'required',
            'state_id'          => 'required',
            'city_id'           => 'required',
            'area_id'           => 'required'
        ],[
            'tech_email.unique' => 'This email address is already registered'
        ]);


        $code = strtoupper($this->uniqidReal());
        $devise_token = strtoupper($this->uniqidReal());
        $param = [
            'tech_name'              => $request->tech_name,
            'tech_email'             => $request->tech_email,
            'tech_mobile'            => $request->tech_mobile,
            'tech_tel'               => $request->tel,
            'tech_password'          => Hash::make($request->tech_password),
            'tech_identification'    => $request->identification,
            'tech_birth'             => $request->birth,
            'tech_country'           => $request->country_id,
            'tech_state'             => $request->state_id,
            'tech_city'              => $request->city_id,
            'tech_area'              => $request->area_id,
            'tech_address'           => $request->address,
            'tech_bio'               => $request->bio,
            'devise_token'           => $devise_token,
            'tech_register_by'       => null,
            'tech_code'              => $code,
            'tech_register'          => Carbon::now()
        ];

        Technician::submit($param);
        $params[] = ['tech_mobile', $request->tech_mobile];
        $technician = Technician::fetch(0, $params);
        if(!$technician[0]) {
            return response()->json(['error' => 'Unauthorized'], 104);
        }else {
            $passwords = Hash::check(request('tech_password'), $technician[0]->tech_password);
            if(!$passwords) {
                return response()->json(['error' => 'Unauthorized'], 104);
            }else {
                $token = auth()->guard('technician-api')->login($technician[0]);
                $technician[0]->token = $token;
                return $this->respondWithToken($technician[0]);
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
        $params[] = ['tech_mobile', request('tech_mobile')];
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
                return $this->respondWithToken($technician[0]);

            }
        }
        $credentials = request(['tech_mobile', 'password']);
        // if (! $token = auth('technician-api')->attempt($credentials)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        // return $this->respondWithToken($token);
    }

    public function profile()
    {
        return $this->returnData('technician', auth('technician-api')->user());
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'name'         => 'required',
            'mobile'       => 'required|numeric',
            'password'     => 'required',
            'country_id'   => 'required',
            'state_id'     => 'required',
            'city_id'      => 'required',
            'area_id'      => 'required'
        ]);


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
            'country_id'      => $request->country_id,
            'state_id'        => $request->state_id,
            'city_id'         => $request->city_id,
            'area_id'         => $request->area_id,
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
        return $this->returnData('models', $models);
    }

    public function getPackages()
    {
        $packages = Package::fetch();
        return $this->returnData('packages', $packages);
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