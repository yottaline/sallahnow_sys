<?php

namespace App\Http\Controllers;

use App\Models\Support_category;
use Illuminate\Http\Request;

class SupportCategoryController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        return view('content.supports.index');
    }

    public function load(Request $request)
    {
        $params = $request->q ? ['q' => $request->q] : [];
        $limit  = $request->limit;
        $lastId = $request->last_id;

        echo json_encode(Support_category::fetch(0, $params, $limit, $lastId));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name_en'  => 'required | string',
            'name_ar'  => 'required | string'
        ]);
        $names =  ['en' => $request->name_en, 'ar' => $request->name_ar];
        $category_name = json_encode($names);

        $params = [
            'category_name' => $category_name
        ];

        $id = $request->cate_id;

        $result =  Support_category::submit($params, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Support_category::fetch($id) : [],
        ]);
    }

    public function updateCost(Request $request)
    {
        $request->validate(['cost' => 'required|numeric']);
        $id = $request->cate_id;
        $params = ['category_cost' => $request->cost];

        $result = Support_category::submit($params, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Support_category::fetch($id) : [],
        ]);
    }
}