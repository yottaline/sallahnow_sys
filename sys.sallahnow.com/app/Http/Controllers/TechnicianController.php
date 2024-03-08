<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Technician;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $technicians = Technician::orderBy('tech_register', 'desc')
            ->limit($request->limit);

        if ($request->q) {
            $technicians->where(function (Buiulder $query) {
                $query->where('tech_name', 'like', request('q'))
                    ->orLike();
            });
        }
        if ($request->package) {
            $technicians->where('tech_pkg', $request->package);
        }
        if ($request->last_id) {
            $technicians->where('tech_id', '<', $request->last_id);
        }

        if ($request->area) {
            $technicians->where('tech_area', $request->area);
        } elseif ($request->city) {
            $technicians->where('tech_city', $request->city);
        } elseif ($request->state) {
            $technicians->where('tech_state', $request->state);
        } elseif ($request->country) {
            $technicians->where('tech_country', $request->country);
        }

        echo json_encode($technicians->get());
    }

    public function submit(Request $request)
    {
        // return $request;
        $request->validate([
            'name'            => 'required|string',
            'mobile'          => 'required|numeric',
        ]);

        $id = intval($request->technician_id);
        // $mobile = $request->mobile;
        // $email = $request->email;
        // $identification = $request->identification;

        // if(Technician::where('tech_id', '!=', $id)->where('tech_mobile', '=', $mobile)->first())
        // if($email && Technician::where('tech_id', '!=', $id)->where('tech_email', '=', $email)->first())
        // if($identification && Technician::where('tech_id', '!=', $id)->where('tech_identification', '=', $identification)->first())

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
            $request->validate([
                'mobile' => 'required | unique:technicians,tech_mobile',
                'email'  => 'required | unique:technicians,tech_email',
            ]);
            $param['tech_code'] = strtoupper($this->uniqidReal());
            $param['tech_password'] = '';
            $param['devise_token'] = strtoupper($this->uniqidReal());
            $param['tech_register_by'] = Auth::user()->id;
            $status = Technician::create($param);

            $id = $status->tech_id;
        } else {
            $status = Technician::where('tech_id', $id)->update($param);
        }

        $record = Technician::where('tech_id', $id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }


    // public function updateActive(Request $request)
    // {
    //     $id = $request->technician_id;
    //     Technician::where('id', $id)->update(['tech_blocked' => $request->blocked]);
    //     session()->flash('Add', 'Active Technician has been updated successfully');
    //     return back();
    // }


    public function profile($code)
    {
        $technician = Technician::where('tech_code', $code)->first();
        return view('content.technicians.profile', compact('technician'));
    }

    // public function test(Request $request)
    // {
    //     $package = $request->package;
    //     $country = $request->country;
    //     $city    = $request->city;

    //     if($package && $country && $city){
    //         $technician = Technician::where('tech_pkg', $package)
    //                       ->orWhere('tech_country', $country)
    //                       ->orWhere('tech_city', $city)->get();
    //         echo json_encode($technician);
    //     }elseif($package){
    //         $technician = Technician::where('tech_pkg', $package)->get();
    //         echo json_encode($technician);
    //     }elseif($country){
    //         $technician = Technician::where('tech_country', $country)->get();
    //         echo json_encode($technician);
    //     }elseif($city){
    //         $technician = Technician::where('tech_city', $city)->get();
    //         echo json_encode($technician);
    //     }
    // }

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
