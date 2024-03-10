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
        $technicians = Technician::orderBy('tech_register', 'desc')
            ->limit($request->limit);

        if ($request->q) {
            $technicians->where(function (Builder $query) {
                $query->where('tech_name', 'like', '%' .request('q') . '%')
                ->orWhere('tech_mobile', request('q'))
                ->orWhere('tech_email', request('q'))->get();
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
        $mobile = $request->mobile;
        $email = $request->email;
        $identification = $request->identification;

        if(Technician::where('tech_id', '!=', $id)->where('tech_mobile', '=', $mobile)->first())
        {
            echo json_encode([
                'status' => false,
                'message' =>  $this->validateMessage('number'),
            ]);
            return ;
        }
        if($email && Technician::where('tech_id', '!=', $id)->where('tech_email', '=', $email)->first())
        {
            echo json_encode([
                'status' => false,
                'message' =>  $this->validateMessage('email'),
            ]);
            return ;
        }
        if($identification && Technician::where('tech_id', '!=', $id)->where('tech_identification', '=', $identification)->first())
        {
            echo json_encode([
                'status' => false,
                'message' => $this->validateMessage('identification'),
            ]);
            return ;
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


    public function profile($code)
    {
        $technician = Technician::where('tech_code', $code)->first();
        $country    = Location::where('location_id', $technician->tech_country)->first();
        $state      = Location::where('location_id', $technician->tech_state)->first();
        $city       = Location::where('location_id', $technician->tech_city)->first();
        $area       = Location::where('location_id', $technician->tech_area)->first();
        if($technician)
        {
            return view('content.technicians.profile', compact('technician', 'country', 'state', 'city', 'area'));
        }
        return redirect('/');
    }


    public function addNote(Request $request)
    {
        $tech_id = $request->tech_id;

        $status = Technician::where('tech_id', $tech_id)->update([
            'tech_notes' => $request->note
        ]);

        // $record = Technician::where('tech_id', $tech_id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $status,
        ]);

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