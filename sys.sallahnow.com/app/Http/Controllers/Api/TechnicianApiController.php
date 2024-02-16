<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Compatibilities_suggestions;
use App\Models\Compatibility;
use App\Models\Models;
use App\Models\Technician;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class TechnicianApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:technician-api', ['except' => ['login', 'sign_in']]);
    }

    public function register(Request $request)
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
        Technician::create([
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
            'devise_token'    => '03df25c845d460bcd',
            'user_id'         => 1,
            'code'            => $code
        ]);


        $credentials = request(['mobile', 'password']);

        if (!$token = auth('technician-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }


    public function login()
    {

        $credentials = request(['mobile', 'password']);

        if (!$token = auth('technician-api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
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
            'devise_token'    => '03df25c845d460bcdad7802d2vf6fc1dfde97283bf75cc993eb6dca835ea2e2f',
            'user_id'         => 1,
            'code'            => $code
        ]);

        return response('updated successfully');
    }

    public function getCompatibilities() {
        if (request('search')) {
            $compatibilities  = Compatibility::where('name', 'like', '%' . request('search') . '%')->get();
        } else {
            $compatibilities  = Compatibility::all();
        }

        return response()->json($compatibilities);
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

    public function suggestions(){
        $suggestions = Compatibilities_suggestions::all();
        return response()->json($suggestions);
    }

    public function getModels()
    {
        $models = Models::all();
        return response()->json($models);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('technician-api')->factory()->getTTL() * 999999
        ]);
    }

}