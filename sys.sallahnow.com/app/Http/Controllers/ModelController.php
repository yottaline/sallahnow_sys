<?php

namespace App\Http\Controllers;

use App\Models\Models;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ModelController extends Controller
{
   private $location = 'Image/Models/';

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('content.models.index');
    }

    public function load()
    {
        $models =  DB::table('models')
        ->join('brands', 'models.model_brand', '=', 'brands.brand_id')->limit(15)->offset(0)->get();
        echo json_encode($models);
    }

    public function submit(Request $request)
    {

        $request->validate([
            'name'   => 'required',
            'photo'  => 'required',
            'url'    => 'required',
            'brand'  => 'required'
        ]);

        $param = [
            'model_name'     => $request->name,
            'model_url'      => $request->url,
            'model_brand'    => $request->brand,
            'visible'        => 1,
        ];

        $photo = $request->file('photo');
        if ($photo) {
            $photoName = $this->uniqidReal(rand(4, 18));
            $photo->move($this->location, $photoName);
            $param['model_photo'] = $photoName;
        }

        $id = $request->model_id;
        if(!$id){
            $status = Models::create($param);
            $id = $status->id;
        }
        else
        {
            $record = Models::where('model_id', $id)->first();
            if ($photo && $record->model_photo) {
                File::delete($this->location . $record->model_photo);
            }
            $status = Models::where('model_id', $id)->update($param);
        }
        $record = Models::where('model_id', $id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
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