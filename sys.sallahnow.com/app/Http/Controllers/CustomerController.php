<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Claims\Custom;

class CustomerController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index() {
        return view('content.customers.index');
    }

    public function load() {
        $customers = Customer::limit(15)->offset(0)->orderByDesc('customer_register')->get();
        echo json_encode($customers);
    }

    public function submit(Request $request) {
        // return $request;
        $data = $request->validate([
            'customer_name'  => 'required | string',
            'customer_email' => 'required | string',
            'customer_mobile'   => 'required | numeric',
            'customer_country'  => 'required | numeric',
            'customer_state'    => 'required | numeric',
            'customer_city'     => 'required | numeric',
            'customer_area'     => 'required | numeric',
            'customer_address'  => 'required | string',
        ]);
        $customer_id = $request->customer_id;
        $code        = strtoupper($this->uniqidReal());
        if(!$customer_id){

            $data['customer_code'] = $code;
            $data['customer_password'] = '';
            $data['customer_register'] = Carbon::now();
            $data['customer_notes']    = '';

            $status = Customer::create($data);
            $customer_id = $status->id;

        } else {
            $status = Customer::where('customer_id', $customer_id)->update($data);
        }

        $record = Customer::where('customer_id', $customer_id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    public function updateNote(Request $request) {
        $customer_id = $request->customer_id;
        $status      = Customer::where('customer_id', $customer_id)->update([
            'customer_notes'  => $request->note
        ]);
        $record = Customer::where('customer_id', $customer_id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    public function updateActive(Request $request) {
        $customer_id = $request->customer_id;
        $status      = Customer::where('customer_id', $customer_id)->update([
            'customer_active'  => $request->active
        ]);
        $record = Customer::where('customer_id', $customer_id)->first();
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