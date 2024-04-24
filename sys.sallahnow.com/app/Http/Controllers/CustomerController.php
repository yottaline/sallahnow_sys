<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Location;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Claims\Custom;
use Illuminate\Database\Eloquent\Builder;

class CustomerController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index()
    {
        $countries = Location::where('location_type', '1')->orderBy('location_id', 'ASC')->get();
        return view('content.customers.index', compact('countries'));
    }

    public function load(Request $request)
    {
        $params   = $request->q ? ['q' => $request->q] : [];
        $limit    = $request->limit;
        $listId   = $request->last_id;
        
        if ($request->status) $params[]      = ['customer_active', $request->status];
        if ($request->area) $params[]        = ['customer_area', $request->area];
        elseif ($request->city) $params[]    = ['customer_city', $request->city];
        elseif ($request->state) $params[]   = ['customer_state', $request->state];
        elseif ($request->country) $params[] = ['customer_country', $request->country];


        echo json_encode(Customer::fetch(0, $params, $limit, $listId));

    }

    public function submit(Request $request)
    {   
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
        
        $id = $request->customer_id;
        $email = $request->customer_email;
        $mobile = $request->customer_mobile;

        if (count(Customer::fetch(0, [['customer_id', '!=', $id], ['customer_mobile', $mobile]])))
        {
            echo json_encode(['status' => false,'message' =>  $this->validateMessage('number')]);
            return; 
        }

        if($email && count(Customer::fetch(0, [['customer_id', '!=', $id], ['customer_email', $email]])))
        {
            echo json_encode(['status' => false,'message' =>  $this->validateMessage('email')]);
            return;
        }
       
        $code   = strtoupper($this->uniqidReal());
        if(!$id){

            $data['customer_code'] = $code;
            $data['customer_password'] = '';
            $data['customer_register'] = Carbon::now();
            $data['customer_notes']    = '';

        } 
        $result = Customer::submit($data, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Customer::fetch($result) : [],
        ]);
    }

    public function updateNote(Request $request)
    {
        $id      = $request->customer_id;
        $context = ['customer_notes'  => $request->note];
        
        $result  = Customer::submit($context, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Customer::fetch($result) : [],
        ]);
    }

    public function updateActive(Request $request)
    {
        $id = $request->customer_id;
        if ($request->customer_active == 1) $params  = ['customer_active' => 2];
        elseif ($request->customer_active == 2) $params  = ['customer_active' => 1];
        
        $result = Customer::submit($params, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Customer::fetch($id) : [],
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

    private function validateMessage($message)
    {
        return 'This ' . $message . ' already exists';
    }
}