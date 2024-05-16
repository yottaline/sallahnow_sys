<?php

namespace App\Http\Controllers;

use App\Models\Market_category;
use App\Models\Market_subcategory;
use Illuminate\Http\Request;

class MarketSubcategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categories = Market_category::fetch();
        return view('content.markets.subcategories.index', compact('categories'));
    }

    public function load(Request $request)
    {
        $params   = $request->q ? ['q' => $request->q] : [];
        $limit    = $request->limit;
        $listId   = $request->last_id;

        echo json_encode(Market_subcategory::fetch(0, $params, $limit, $listId));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name_ar'  => 'required',
            'name_en'  => 'required',
            'category' => 'required'
        ]);

        $id = $request->subcate_id;
        $names = json_encode([
            'en' => $request->name_en,
            'ar' => $request->name_ar,
        ]);

        $param = [
            'subcategory_name' => $names,
            'subcategory_cat'  => $request->category
        ];

        $result = Market_subcategory::submit($param, $id);
        echo json_encode([
            'status' => boolval($result),
            'data'   => $result ? Market_subcategory::fetch($result) : []
        ]);
    }

}