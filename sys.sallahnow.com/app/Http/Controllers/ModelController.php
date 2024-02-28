<?php

namespace App\Http\Controllers;

use App\Models\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ModelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('content.models.index');
    }

    public function load() {
        $models =  DB::table('models')
        ->join('brands', 'models.model_brand', '=', 'brands.brand_id')->limit(15)->offset(0)->get();
        echo json_encode($models);
    }

    public function submit(Request $request) {

        $request->validate([
            'name'   => 'required',
            'photo'  => 'required',
            'url'    => 'required',
            'brand'  => 'required'
        ]);

        $photo = $request->file('photo');
        $photoName = $photo->getClientOriginalName();
        $location = 'Image/Models/';

        $id = $request->model_id;
        if(!$id){
            if($request->file('photo')){

                $photo->move($location , $photoName);
                $photoPath = url($location, $photoName);
                $status = Models::create([
                    'model_name'     => $request->name,
                    'model_url'      => $request->url,
                    'model_photo'    => $photoName,
                    'model_brand'    => $request->brand,
                    'visible'        => 1,
                ]);
            };
            $id = $status->id;
        }
        else{
            if($request->file('photo')){
                $status = Models::where('model_id', $id)->update([
                    'model_name' => $request->name,
                    'model_photo' => $photoName,
                    'user_id' => auth()->user()->id
                ]);
            };
        }
        $record = Models::where('model_id', $id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    // public function getBrandsName(){
    //     $brandName = DB::table('brands')
    //     ->join('models', 'brands.id', '=', 'models.brand_id')
    //     ->select('models.model_name','brands.brand_name')->orderBy('models.created_at', 'desc')
    //     ->get();
    //     echo json_encode($brandName);
    // }

    // public function getUsersName(){
    //     $userName = DB::table('users')
    //     ->join('models', 'users.id', '=', 'models.user_id')
    //     ->select('models.model_name','users.user_name')
    //     ->get();
    //     echo json_encode($userName);
    // }
}
