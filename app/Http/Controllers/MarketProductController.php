<?php

namespace App\Http\Controllers;

use App\Models\Market_category;
use App\Models\Market_product;
use App\Models\Market_store;
use App\Models\Market_subcategory;
use Illuminate\Http\Request;

class MarketProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $param[] = ['store_status', 1];
        $stores = Market_store::fetch(0, $param);
        $categories = Market_category::fetch();
        $subcategories = Market_subcategory::fetch();
        return view('content.markets.products.index', compact('stores', 'categories', 'subcategories'));
    }

    public function load(Request $request)
    {
        $params   = $request->q ? ['q' => $request->q] : [];
        $limit   = $request->limit;
        $lastId  = $request->last_id;

        if($request->store) $params[] = ['product_store', $request->store];
        if($request->category) $params[] = ['product_category', $request->category];
        if($request->subcategory) $params[] = ['product_subcategory', $request->subcategory];

        echo json_encode(Market_product::fetch(0, $params, $limit, $lastId));
    }

    public function changeStatus(Request $request)
    {
        $status = 0;
        if($request->status) $status = 1;
        $param = ['product_show' => $status];
        $id = $request->product_id;
        $result = Market_product::submit($param, $id);
        echo json_encode([
            'status' => boolval($result),
            'data'=> $result ? Market_product::fetch($request->product_id) : []
        ]);

    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $param = ['product_delete' => 1];
        $result  = Market_product::submit($param, $id);
        echo json_encode([
            'status' => boolval($result),
            'data'   => $result ? Market_product::fetch($id) : []
        ]);
    }
}