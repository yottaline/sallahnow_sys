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
        $models = Models::orderBy('created_at', 'desc')->get();
        echo json_encode($models);
    }

    public function submit(Request $request) {

        $request->validate([
            'name'   => 'required',
            'photo'  => 'required',
            'url'    => 'required',
            'brand'  => 'required'
        ]);

        $id = $request->model_id;

        if(!$id){
            if($request->file('photo')){
                $photo = $request->file('photo');
                $photoName = $photo->hashName();
                $location = 'Image/Brands';

                $photo->move($location , $photoName);

                $photoPath = url('Image/Brands/', $photoName);
                $status = Models::create([
                    'model_name'     => $request->name,
                    'model_url'      => $request->url,
                    'model_photo'    => $photoPath,
                    'brand_id' => $request->brand,
                    'visible'  => 1,
                    'user_id'  => auth()->user()->id
                ]);
            };
            $record = Models::where('id', $status->id)->get();
        }
        else{
            if($request->file('photo')){
                $photo = $request->file('photo');
                $photoName = $photo->hashName();
                $location = 'Image/Brands';

                $photo->move($location , $photoName);

                $photoPath = url('Image/Brands/', $photoName);
                $status = Models::where('id', $id)->update([
                    'model_name' => $request->name,
                    'model_photo' => $photoPath,
                    'user_id' => auth()->user()->id
                ]);
            };
        }
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    public function getBrandsName(){
        $brandName = DB::table('brands')
        ->join('models', 'brands.id', '=', 'models.brand_id')
        ->select('models.model_name','brands.brand_name')->orderBy('models.created_at', 'desc')
        ->get();
        echo json_encode($brandName);
    }

    public function getUsersName(){
        $userName = DB::table('users')
        ->join('models', 'users.id', '=', 'models.user_id')
        ->select('models.model_name','users.user_name')
        ->get();
        echo json_encode($userName);
    }
}