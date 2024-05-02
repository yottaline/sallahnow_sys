<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compatibility_categorie;
use Illuminate\Support\Facades\DB;

class CompatibilityCategorieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function load(Request $request)
    {
        $limit  = $request->limit;
        $lastId = $request->last_id;

        echo json_encode(Compatibility_categorie::fetch(0,null, $limit, $lastId));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $id = $request->cate_id;
        $param = [ 'category_name' => $request->name];

        $result = Compatibility_categorie::submit($param, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Compatibility_categorie::fetch($id) : [],
        ]);
    }
}
