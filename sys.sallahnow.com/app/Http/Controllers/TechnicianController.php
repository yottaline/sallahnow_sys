<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Technician;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
// use Illuminate\Support\Facades\Hash;

// use function Pest\Laravel\json;

class TechnicianController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $countries = Location::where('location_type', '1')->orderBy('location_id', 'ASC')->get();

        return view('content.technicians.index', compact('countries'));
    }


    public function load(Request $request)
    {
        $params   = $request->q ? ['q' => $request->q] : [];
        $limit    = $request->limit;
        $listId   = $request->last_id;

        if ($request->package) $params[] = ['tech_pkg', $request->package];
        if ($request->area) $params[]     = ['tech_area', $request->area];
        if ($request->city) $params[]     = ['tech_city', $request->city];
        if ($request->state) $params[]    = ['tech_state', $request->state];
        if ($request->country) $params[]  = ['tech_country', $request->country];


        echo json_encode(Technician::fetch(0, $params ,$limit, $listId));

    }

    public function submit(Request $request)
    {
        $request->validate([
            'name'            => 'required|string',
            'mobile'          => 'required|numeric',
        ]);

        $id = intval($request->technician_id);
        $mobile = $request->mobile;
        $email = $request->email;
        $identification = $request->identification;

        if (count(Technician::fetch(0, [['tech_id', '!=', $id], ['tech_mobile', '=', $mobile]])))
        {
            echo json_encode(['status' => false,'message' =>  $this->validateMessage('number')]);
            return;  
        }

        if ($email && count(Technician::fetch(0, [['tech_id', '!=', $id], ['tech_email', '=', $email]])))
        {
            echo json_encode(['status' => false,'message' =>  $this->validateMessage('email')]);
            return;  
        }
        
        if ($identification && count(Technician::fetch(0, [['tech_id', '!=', $id], ['tech_identification', '=', $identification]])))
        {
            echo json_encode(['status' => false,'message' =>  $this->validateMessage('identification')]);
            return;  
        }
    

        $param = [
            'tech_name'              => $request->name,
            'tech_email'             => $request->email,
            'tech_tel'               => $request->tel,
            'tech_mobile'            => $request->mobile,
            'tech_birth'             => $request->birth,
            'tech_country'           => $request->country_id,
            'tech_state'             => $request->state_id,
            'tech_city'              => $request->city_id,
            'tech_area'              => $request->area_id,
            'tech_address'           => $request->address,
            'tech_identification'    => $request->identification,
            'tech_notes'             => $request->notes,
            'tech_register'          => Carbon::now()
        ];

        if (!$id) {
            $param['tech_code'] = strtoupper($this->uniqidReal());
            $param['tech_password'] = '';
            $param['devise_token'] = strtoupper($this->uniqidReal());
            $param['tech_register_by'] = Auth::user()->id;
        } else {
            $param['tech_modify']    = Carbon::now();
            $param['tech_modify_by'] = Auth::user()->id;
        }


        $result = Technician::submit($param, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Technician::fetch($id) : [],
        ]);
    }


    public function profile($code)
    {
        $params[] = ['tech_code', $code];
        $technician = Technician::fetch(0, $params);
    
        if(count($technician))
        {
            $country_id   = $technician[0]->tech_country;
            $state_id     = $technician[0]->tech_state;
            $city_id      = $technician[0]->tech_city;
            $area_id      = $technician[0]->tech_area;
    
            $countries[] = ['location_id', $country_id];
            $states[]    = ['location_id', $state_id];
            $cites[]     = ['location_id', $city_id];
            $areas[]     = ['location_id', $area_id];
            
            $country    = Location::fetch($countries[0], $countries);
            $state    = Location::fetch($states[0], $states);
            $city    = Location::fetch($cites[0], $cites);
            $area    = Location::fetch($areas[0],$areas);
            
            return view('content.technicians.profile', compact('technician', 'country', 'state', 'city', 'area'));
        }
        
        return redirect('/');
    }


    public function addNote(Request $request)
    {
        $id = $request->tech_id;
        $params = ['tech_notes' => $request->note];
        $status = Technician::submit($params, $id);
        
        echo json_encode(['status' => boolval($status),'data' => $status,]);

    }


    private function validateMessage($message)
    {
        return 'This ' . $message . ' already exists';
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