<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $brands = Brand::orderBy('created_at', 'desc')
        ->limit(10)->get();
        echo json_encode($brands);
    }

    public function store(Request $request) {
        // return $request;
        $request->validate([
            'name'   => 'required|max:250',
            'logo'   => 'required'
        ]);

        $id = intval($request->brand_id);
        if(!$id){
            if($request->file('logo')){
                $logo = $request->file('logo');
                $logoName = $logo->hashName();
                $location = '/';

                $logo->move($location , $logoName);

                $logoPath = url('/', $logoName);
        $status = Brand::create([
                    'brand_name' => $request->name,
                    'brand_logo' => $logoPath,
                ]);
            };
        $record = Brand::where('id', $status->id)->get();
        }
        else{
            if($request->file('logo')){
                $logo = $request->file('logo');
                $logoName = $logo->hashName();
                $location = 'Image/Brands';

                $logo->move($location , $logoName);

                $logoPath = url('Image/Brands/', $logoName);
        $status = Brand::where('id', $id)->update([
                    'brand_name' => $request->name,
                    'brand_logo' => $logoPath,
                ]);
        }
        }
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