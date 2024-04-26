<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BrandController extends Controller
{
    private $location = 'Image/Brands/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('content.brands.index');
    }

    public function load(Request $request)
    {
        $limit  = $request->limit;
        $lastId = $request->last_id;

        echo json_encode(Brand::fetch(0,null,$limit, $lastId));
    }

    public function store(Request $request) {

        $request->validate([
            'name'   => 'required|max:250',
            'logo'   => 'required'
        ]);

        $param = [
            'brand_name' => $request->name,
        ];

        $photo = $request->file('logo');
        if ($photo) {
            $photoName = $this->uniqidReal(rand(4, 18));
            $photo->move($this->location, $photoName);
            $param['brand_logo'] = $photoName;
        }

        $id = intval($request->brand_id);
        if($id)
        {
            $data = Brand::fetch($id);
            if(!empty($data->brand_logo) && File::exists($this->location)){
                File::delete($this->location . $data->brand_logo);
            }
        }
        $result = Brand::submit($param, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Brand::fetch($id) : [],
        ]);
    }

    // public function getUsersName()
    // {
    //     $userName = DB::table('users')
    //     ->join('brands', 'users.id', '=', 'brands.user_id')
    //     ->select('brands.brand_name','users.user_name')
    //     ->get();
    //     echo json_encode($userName);
    // }



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
