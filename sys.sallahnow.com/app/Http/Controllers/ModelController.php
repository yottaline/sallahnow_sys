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

    public function load(Request $request)
    {
        $params = $request->q ? ['q' => $request->q] : [];
        $limit  = $request->limit;
        $lastId = $request->last_id;

        echo json_encode(Models::fetch(0, $params, $limit, $lastId));
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
            // 'model_visible'        => 1,
        ];

        $photo = $request->file('photo');
        if ($photo) {
            $photoName = $this->uniqidReal(rand(4, 18));
            $photo->move($this->location, $photoName);
            $param['model_photo'] = $photoName;
        }

        $id = $request->model_id;
        if($id){
            $record = Models::fetch($id);
            if ($photo && $record->model_photo) {
                File::delete($this->location . $record->model_photo);
            }
        }

        $result = Models::submit($param, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Models::fetch($id) : [],
        ]);
    }


    public function getBrandModels($id)
    {
        $param[] = ['brand_id', $id];
       $model = Models::fetch(0, $param);

       echo json_encode(['data' => $model]);
    }

    public function getName($id)
    {
        echo json_encode(Models::fetch($id));
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
