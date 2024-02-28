<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('content.brands.index');
    }

    public function load() {
        $brands = Brand::limit(10)->offset(0)->get();
        echo json_encode($brands);
    }

    public function store(Request $request) {
        // return $request;
        $request->validate([
            'name'   => 'required|max:250',
            'logo'   => 'required'
        ]);

        $logo = $request->file('logo');
        $logoName = $logo->getClientOriginalName();
        $location = 'Image/Brands/';

        $id = intval($request->brand_id);
        if(!$id){
            if($request->file('logo')){


                $logo->move($location , $logoName);

                $logoPath = url('Image/Brands', $logoName);
                $status = Brand::create([
                    'brand_name' => $request->name,
                    'brand_logo' => $logoName,
                ]);
            };
            $id = $status->id;
        }
        else{

            $data = Brand::where('brand_id', $id)->first();

            if($request->file('logo')){
                if(!empty($data->brand_logo) && File::exists($location)){
                    File::delete($location . $data->brand_logo);
                }

                $status = Brand::where('brand_id', $id)->update([
                    'brand_name' => $request->name,
                    'brand_logo' => $logoName,
                ]);
            }
        }
        $record = Brand::where('brand_id', $id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    public function getUsersName(){
        $userName = DB::table('users')
        ->join('brands', 'users.id', '=', 'brands.user_id')
        ->select('brands.brand_name','users.user_name')
        ->get();
        echo json_encode($userName);
    }
}