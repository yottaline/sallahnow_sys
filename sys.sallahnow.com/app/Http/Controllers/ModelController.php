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
        $models = Models::all();
        echo json_encode($models);
    }

    public function store(Request $request) {

        $request->validate([
            'name'   => 'required',
            'photo'  => 'required',
            'url'    => 'required',
            'brand'  => 'required'
        ]);

        if($request->model_id == 0){
            if($request->file('photo')){
                $photo = $request->file('photo');
                $photoName = $photo->hashName();
                $location = 'Image/Brands';

                $photo->move($location , $photoName);

                $photoPath = url('Image/Brands/', $photoName);
                Models::create([
                    'name'     => $request->name,
                    'url'      => $request->url,
                    'photo'    => $photoPath,
                    'brand_id' => $request->brand,
                    'visible'  => 1,
                    'user_id'  => auth()->user()->id
                ]);
                session()->flash('Add', 'Model data has been added successfully');
                return back();
            };
        }
        if($request->model_id > 0) {
            $id = $request->model_id;
            if($request->file('photo')){
                $photo = $request->file('photo');
                $photoName = $photo->hashName();
                $location = 'Image/Brands';

                $photo->move($location , $photoName);

                $photoPath = url('Image/Brands/', $photoName);
                Models::where('id', $id)->update([
                    'name' => $request->name,
                    'photo' => $photoPath,
                    'user_id' => auth()->user()->id
                ]);
                session()->flash('Add', 'Brand data has been updated successfully');
                return back();
            };
        }
    }

    public function getBrandsName(){
        $brandName = DB::table('brands')
        ->join('models', 'brands.id', '=', 'models.brand_id')
        ->select('models.name','brands.name')
        ->get();
        echo json_encode($brandName);
    }

    public function getUsersName(){
        $userName = DB::table('users')
        ->join('models', 'users.id', '=', 'models.user_id')
        ->select('models.name','users.name')
        ->get();
        echo json_encode($userName);
    }
}