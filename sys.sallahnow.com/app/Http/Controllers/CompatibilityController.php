<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Compatibility;
use App\Models\Compatibility_categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompatibilityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Compatibility_categorie::fetch();
        $brands     = Brand::fetch();

        return view('content.compatibilities.index', compact('categories', 'brands'));
    }

    public function load(Request $request)
    {
        $params   = $request->q ? ['q' => $request->q] : [];
        $limit    = $request->limit;
        $listId   = $request->last_id;

        echo json_encode(Compatibility::fetch(0, $params,$limit, $listId));
    }

    public function submit(Request $request)
    {
        $parts = ['en' => $request->name_en, 'ar' => $request->name_ar];
        $part = json_encode($parts);

        $id       = $request->comp_id;
        $model_id = $request->model_id;
        $code     = $this->uniqidReal(8);

        // if (count(Compatibility::fetch(0, [['compat_id', '!=', $id], ['compatible_model', $model_id]])))
        // {
        //     echo json_encode(['status' => false, 'message' => 'Model Is Exts']);
        //     return;
        // }


       $param =
       [
        'compat_part'     => $part,
        'compat_category' => $request->cate_id,
        ];

        if (!$id) $param['compat_code'] = $code;

        $status = Compatibility::submit($param, $id, $model_id);

        echo json_encode([
            'status' => boolval($status),
            'data' => $status ? Compatibility::fetch($status) : [],
        ]);
    }


    public function models($id)
    {
        echo json_encode(Compatibility::getModels($id));
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