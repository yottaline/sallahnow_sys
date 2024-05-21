<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Market_order;
use App\Models\Market_order_item;

class MarketOrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('content.markets.orders.index');
    }

    public function load(Request $request)
    {
        $params = $request->q ? ['q' => $request->q] : [];
        $limit  = $request->limit;
        $lastId = $request->last_id;

        if ($request->status) $params[] = ['order_status', $request->status];
        if ($request->date) $params[] = ['order_create', 'like', "%{$request->date}%"];

        echo json_encode(Market_order::fetch(0, $params, $limit, $lastId));
    }

    public function viewOrder($orderId)
    {
        $order = Market_order::fetch($orderId);
        $param[] = ['market_orders.order_id', $orderId];
        $items  = Market_order_item::fetch(0,$param);
        echo json_encode(['order' => $order, 'items' => $items]);

    }
}