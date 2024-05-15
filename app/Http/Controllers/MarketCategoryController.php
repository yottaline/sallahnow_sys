<?php

namespace App\Http\Controllers;

use App\Models\Market_category;
use Illuminate\Http\Request;

class MarketCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('content.markets.categories.index');
    }

    public function load(Request $request)
    {
        $params   = $request->q ? ['q' => $request->q] : [];
        $limit    = $request->limit;
        $listId   = $request->last_id;

        echo json_encode(Market_category::fetch(0, $params, $limit, $listId));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name_ar' => 'required',
            'name_en' => 'required'
        ]);

        $id = $request->cate_id;
        $names = json_encode([
            'en' => $request->name_en,
            'ar' => $request->name_ar,
        ]);

        $param = [
            'category_name' => $names
        ];

        $result = Market_category::submit($param, $id);

        echo json_encode([
            'status' => boolval($result),
            'data'    => $result ? Market_category::fetch($result) : []
        ]);
    }
}
