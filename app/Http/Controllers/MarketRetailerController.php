<?php

namespace App\Http\Controllers;

use App\Models\Market_retailer;
use App\Models\Market_store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class MarketRetailerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $params[] = ['store_status', 1];
        $stores = Market_store::fetch(0, $params);
        return view('content.markets.Retailers.index', compact('stores'));
    }

    public function load(Request $request)
    {
        $params   = $request->q ? ['q' => $request->q] : [];
        $limit    = $request->limit;
        $listId   = $request->last_id;
        if($request->store) $params[]  = ['store_id','=', $request->store];

        echo json_encode(Market_retailer::fetch(0, $params, $limit, $listId));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'phone' => 'required',
            'store' => 'required',
            'email' => 'required',
        ]);

        $id    = $request->retailer_id;
        $phone = $request->phone;
        $email = $request->email;


        if (count(Market_retailer::fetch(0, [['retailer_id', '!=', $id], ['retailer_phone', '=', $phone]])))
        {
            echo json_encode(['status' => false,'message' =>  $this->validateMessage('phone')]);
            return;
        }

        if ($email && count(Market_retailer::fetch(0, [['retailer_id', '!=', $id], ['retailer_email', '=', $email]])))
        {
            echo json_encode(['status' => false,'message' =>  $this->validateMessage('email')]);
            return;
        }

        $param = [
            'retailer_name'  => $request->name,
            'retailer_email' => $email,
            'retailer_phone' => $phone,
            'retailer_store'    => $request->store,
            'retailer_admin'    => $request->admin ? $request->admin : 0,
            'retailer_active'    => $request->active ? $request->active : 0,
            'retailer_approved_by' => 1,
        ];

        if(!$id)
        {
            $param['retailer_register']  = Carbon::now();
            $param['retailer_password'] = Hash::make($request->password);
        }

        $result = Market_retailer::submit($param, $id);

        echo json_encode([
            'status' => boolval($result),
            'data'   => $result ? Market_retailer::fetch($result) : []
        ]);

    }

    public function change(Request $request)
    {

        $id = $request->id;
        // $param[] = ['retailer_approved', '!=', 0];
        // if (Market_retailer::fetch($id, $param))
        // {
        //     echo json_encode(['status' => false,'message' => 'This account is currently active']);
        //     return;
        // }

        $param = [
            'retailer_approved' => 1,
            'retailer_approved_by' => auth()->user()->id
        ];

        $result = Market_retailer::submit($param, $id);

        echo json_encode([
            'status' => boolval($result),
            'data'   => $result ?  Market_retailer::fetch($result) : []
        ]);

    }


    private function validateMessage($message)
    {
        return 'This ' . $message . ' already exists';
    }
}