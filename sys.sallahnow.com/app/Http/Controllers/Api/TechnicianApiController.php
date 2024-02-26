<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Compatibilities_suggestions;
use App\Models\Compatibility;
use App\Models\Compatibility_categorie;
use App\Models\Models;
use App\Models\Package;
use App\Models\Subscriptions;
use App\Models\Technician;
use App\ResponseApi;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
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
            'tech_mobile'       => 'required|numeric',
            'tech_password'     => 'required',
            'country_id'   => 'required',
            'state_id'     => 'required',
            'city_id'      => 'required',
            'area_id'      => 'required'
        ]);


        $code = strtoupper($this->uniqidReal());
        $password_hash = Hash::make($request->tech_password);
     $status  = Technician::create([
            'tech_name'            => $request->tech_name,
            'tech_email'           => $request->tech_email,
            'tech_mobile'          => $request->tech_mobile,
            'tech_tel'             => $request->tel,
            'tech_password'        => $password_hash,
            'tech_identification'  => $request->identification,
            'tech_birth'           => $request->birth,
            'tech_country'           => $request->country_id,
            'tech_state'             => $request->state_id,
            'tech_city'              => $request->city_id,
            'tech_area'              => $request->area_id,
            'tech_address'           => $request->address,
            'tech_bio'               => $request->bio,
            'devise_token'           => '0asf10500845d40b91',
            'tech_register_by'       => 1,
            'tech_code'              => $code,
            'tech_register'             => now()
        ]);

        $technician_mobile = Technician::where('tech_mobile', $status->tech_mobile)->first();
        if(!$technician_mobile){
            return $this->returnError('the mobile not found', '420');
        }
        else{
            if($technician_mobile->tech_blocked == 0){
                return $password_hash . $technician_mobile->tech_password;
                if($technician_mobile->tech_password == $password_hash){
                    return $this->returnSuccess('register success');
                }
                else{
                    return $this->returnError('the password not found', '451');
                }

            }else{
                return $this->returnError('the technician has blocked', '423');
            }
        }

        // if( auth('technician-api')->attempt() =){
        //     return 1;
        // }else{
        //     return 12;
        // }

        // $credentials = request(['tech_mobile', 'tech_password']);

        // if ( = auth('technician-api')->attempt($credentials)) {
        //     return response()->json(['error' => 'Unauthorized'], 401);
        // }

        // return $this->respondWithToken($token);
    }


    public function login()
    {
        return request(['tech_mobile', 'tech_password']);

        $credentials = request(['tech_mobile', 'tech_password']);

        if (!$token = auth('technician-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 104);
        }

        return $this->respondWithToken($token);
    }

    public function profile()
    {
        return response()->json(auth('technician-api')->user());
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
        Technician::where('id', $id)->update([
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
            'devise_token'    => '03df25c845d460bcdad7802d2vf6fc1dfde972',
            'user_id'         => 1,
            'code'            => $code
        ]);

        return $this->returnSuccess('updated successfully');
    }

    public function getCompatibilities() {
        if (request('search')) {
            $compatibilities  = Compatibility::where('part', 'like', '%' . request('search') . '%')->get();
        } else {
            $compatibilities  = Compatibility::all();
        }

        return $this->returnData('compatibilities', $compatibilities);
    }

    public function addSuggestions(Request $request){
        $status = Compatibilities_suggestions::create([
            'status' => 0,
            'act_not' => '',
            'act_time' => now(),
            'category_id' => $request->cate_id,
            'technician_id'  => $request->technician_id,
            'user_id' => 1
        ]);
        $status->models()->attach($request->models);
    }

    public function getCategory() {
        $categories  = Compatibility_categorie::all();
        return $this->returnData('categories', $categories);
    }

    public function suggestions(){
        $suggestions = Compatibilities_suggestions::all();
        return $this->returnData('suggestions', $suggestions);
    }

    public function getModels()
    {
        $models = Models::all();
        return $this->returnData('models', $models);
    }

    public function getPackages() {
        $packages = Package::all();
        return $this->returnData('packages', $packages);
    }

    public function getSubscriptions() {
        $subscriptions = Subscriptions::all();
        return $this->returnData('subscriptions', $subscriptions);
    }

    public function changeStatus($id) {
        $subscription = Subscriptions::where('id', $id)->first();
        if($subscription->status == 1){
           $status = Subscriptions::where('id', $id)->update(['status' => 0]);
        }
        else{
            $status = Subscriptions::where('id',  $id)->update(['status' => 1]);
        }
        if(!$status){
            return $this->returnError('status not change');
        }
        return $this->returnSuccess('status change successfully');
    }

    public function subNewPackage(Request $request) {
        $package = Package::where('id', $request->package_id)->first();
        $pam = [
            'package_id'     => $request->package_id,
            'package_points' =>  $package->points,
            'package_cost'   => $package->cost,
            'package_period' => $package->period,
            'package_priv'   => $package->priv,
            'technician_id'  => $request->technician_name,
            'start'          => $request->start,
            'end'            => $request->end,
            'register_by'    => auth()->user()->id
        ];

        $technician = Subscriptions::where('id', $request->technician_name)->first();

        $id = $request->sub_id;
        if(!$id) {
            if($technician){
                Subscriptions::where('id', $request->technician_name)->update(['status' => 0]);
                $status  = Subscriptions::create($pam);
                $id      = $status->id;
            }else {
                $status  = Subscriptions::create($pam);
                $id      = $status->id;
            }
        }
        else {
            $status = Subscriptions::where('id', $id)->update($pam);
        }
        return response()->json('created',$status);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('technician-api')->factory()->getTTL() * 999999
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