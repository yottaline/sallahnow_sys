<?php

namespace App\Http\Controllers;

use App\Models\Center;
use App\Models\Technician;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class CenterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() 
    {    
        $countries = Location::where('location_type', '1')->orderBy('location_id', 'ASC')->get();
        
        return view('content.centers.index', compact('countries'));
    }

    public function load(Request $request) 
    {    
        $params   = $request->q ? ['q' => $request->q] : [];
        $limit    = $request->limit;
        $listId   = $request->last_id;

        echo json_encode(Center::fetch(0, $params, $limit, $listId));

    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $mobile     = $request->mobile;
        $email      = $request->email;
        $whatsapp   = $request->center_whatsapp;
        $center_tax = $request->center_tax;
        $center_cr = $request->center_cr;
        
        $id = $request->center_id;
        
        if(Center::towCondition('center_id', '!=', $id, 'center_mobile', '=', $mobile))
        {
            echo json_encode(['status' => false,'message' =>  $this->validateMessage('number')]);
            return ;
        }

        if($email && Center::towCondition('center_id', '!=', $id, 'center_email', '=', $email))
        {
            echo json_encode(['status' => false,'message' =>  $this->validateMessage('email')]);
            return ;  
        }
    
        if($whatsapp && Center::towCondition('center_id', '!=', $id, 'center_whatsapp', '=', $whatsapp))
        {
            echo json_encode(['status' => false,'message' =>  $this->validateMessage('Whatsapp Number')]);
            return ;  
        }
        
        // if($center_tax && Center::towCondition('center_id', '!=', $id, 'center_tax', '=', $center_tax))
        // {
        //     echo json_encode(['status' => false,'message' =>  $this->validateMessage('Tax Number')]);
        //     return ;  
        // }
        // if($center_cr && Center::towCondition('center_id', '!=', $id, 'center_cr', '=', $center_cr))
        // {
        //     echo json_encode(['status' => false,'message' =>  $this->validateMessage('Commercial Registry')]);
        //     return ;  
        // }

        $logo = $request->file('logo');
        $logoName = $logo->getClientOriginalName();
        $location = 'Image/Centers/';
        $logo->move($location , $logoName);

        $logoPath = url($location, $logoName);

        $parm = [
            'center_name'       => $request->name,
            'center_mobile'     => $request->mobile,
            'center_whatsapp'   => $request->center_whatsapp,
            'center_email'      => $request->email,
            'center_tel'        => $request->tel,
            'center_logo'       => $logoName,
            'center_tax'        => $request->center_tax,
            'center_cr'         => $request->center_cr,
            'center_country'    => $request->country_id,
            'center_state'      => $request->state_id,
            'center_city'       => $request->city_id,
            'center_area'       => $request->area_id,
            'center_address'    => $request->address,
            'center_owner'      => $request->technician_name,
        ];
        
        if(!$id) {
            $parm['center_create']    = Carbon::now();
            $parm['center_create_by'] = auth()->user()->id;
        }else {
            $parm['center_modify']    = Carbon::now();
            $parm['center_modify_by'] = auth()->user()->id;
        }

        $result = Center::submit($parm, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Center::fetch($id) : [],
        ]);
    }

    public function getTechnician($item) {
        $technician_name = Technician::where('tech_code', 'like', '%' . $item . '%')->get();
        echo json_encode($technician_name);
    }

    // public function addOwner(Request $request){
    //     $id = $request->center_id;
    //    $status = Center::where('id', $id)->update([
    //         'owner'  => $request->technician_name,
    //     ]);
    //     echo json_encode([
    //         'status' => boolval($status),
    //     ]);
    // }
    
    private function validateMessage($message)
    {
        return 'This ' . $message . ' already exists';
    }
    
    public function getTechnicianName() {
        // $technician_name = DB::table('technicians')
        // ->join('centers', 'technicians.tech_id', '=', 'centers.owner')
        // ->select('centers.name','technicians.tech_name')->orderBy('centers.created_at', 'desc')
        // ->get();
        // echo json_encode($technician_name);
    }
}