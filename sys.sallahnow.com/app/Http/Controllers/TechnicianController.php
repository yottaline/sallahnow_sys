<?php

namespace App\Http\Controllers;

use App\Models\Technician;
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
        return view('content.technicians.index');
    }


    public function load()
    {
        $technicians = Technician::orderBy('created_at', 'desc')->limit(15)->get();
        echo json_encode($technicians);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name'            => 'required|string',
            'mobile'          => 'required|numeric',
        ]);

        $param = [
            'name'              => $request->name,
            'email'             => $request->email,
            'tel'               => $request->tel,
            'mobile'            => $request->mobile,
            'birth'             => $request->birth,
            'country_id'        => $request->country_id,
            'state_id'          => $request->state_id,
            'city_id'           => $request->city_id,
            'area_id'           => $request->area_id,
            'address'           => $request->address,
            'identification'    => $request->identification,
            'notes'             => $request->notes,
            'login'             => now(), // TODO: login is nunable
        ];

        $id = intval($request->technician_id);
        // STATUS SHOULD BE BOOLEAN
        if (!$id) {
            $param['code'] = strtoupper($this->uniqidReal());
            $param['password'] = '';
            $param['devise_token'] = '';
            $param['user_id'] = Auth::user()->id;
            $status = Technician::create($param);
            $id = $status->id;
        } else {
            $status = Technician::where('id', $id)->update($param);
        }


        $record = Technician::where('id', $id)->get();
        //$record = Technician::where('id', $id)->first();

        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }


    public function updateActive(Request $request)
    {
        $id = $request->technician_id;
        Technician::where('id', $id)->update(['blocked' => $request->blocked]);
        session()->flash('Add', 'Active Technician has been updated successfully');
        return back();
    }

    public function profile($code)
    {
        $technician = DB::table('technicians')
            ->leftJoin('users', 'users.id', '=', 'technicians.user_id')
            ->where('code', $code)->get()->first();

        return view('content.technicians.profile', compact('technician'));
    }


    private function uniqidReal($lenght = 12)
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            // throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
}