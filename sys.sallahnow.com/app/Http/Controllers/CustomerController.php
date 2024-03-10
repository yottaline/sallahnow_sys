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
        $customers = Customer::limit($request->limit)->orderByDesc('customer_register');

        if ($request->q) {
            $customers->where(function (Builder $query) {
                $query->where('customer_name', 'like', '%' .request('q') . '%')
                ->orWhere('customer_mobile', request('q'))
                ->orWhere('customer_email', request('q'))->get();
            });
        }
        if ($request->status) {
            $customers->where('customer_active', $request->status);
        }

        if ($request->last_id) {
            $customers->where('customer_id', '<', $request->last_id);
        }

        if ($request->area) {
            $customers->where('customer_area', $request->area);
        } elseif ($request->city) {
            $customers->where('customer_city', $request->city);
        } elseif ($request->state) {
            $customers->where('customer_state', $request->state);
        } elseif ($request->country) {
            $customers->where('customer_country', $request->country);
        }

        echo json_encode($customers->get());
    }

    public function submit(Request $request)
    {
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
        $email = $request->customer_email;
        $mobile = $request->customer_mobile;

        if(Customer::where('customer_id', '!=', $customer_id)->where('customer_mobile', '=', $mobile)->first())
        {
            echo json_encode([
                'status' => false,
                'message' =>  $this->validateMessage('number'),
            ]);
            return ;
        }
        if($email && Customer::where('customer_id', '!=', $customer_id)->where('customer_email', '=', $email)->first())
        {
            echo json_encode([
                'status' => false,
                'message' =>  $this->validateMessage('email'),
            ]);
            return ;
        }


        $code   = strtoupper($this->uniqidReal());
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

    public function updateNote(Request $request)
     {
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

    public function updateActive(Request $request)
    {
        $customer_id = $request->customer_id;
        $record = Customer::where('customer_id', $customer_id)->first();
        if($record->customer_active == 1)
        {
           $status = $record->update(['customer_active' => 2]);
        }
        else
        {
            $status = $record->update(['customer_active' => 1]);
        }
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

    private function validateMessage($message)
    {
        return 'This ' . $message . ' already exists';
    }
}