<?php

namespace App\Http\Controllers;

use App\Models\Technician_ads;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TechnicianAdsController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index() {
        return view('content.ads.index');
    }

    public function load() {
        $ads = DB::table('technician_ads')
        ->join('users', 'technician_ads.ads_create_user', '=', 'users.id')
        ->orderByDesc('ads_create_time')->limit(15)->offset(0)->get();
        echo json_encode($ads);
    }

    public function submit(Request $request) {
        $request->validate([
            'title' => 'required',
            'body'  => 'required',
            'url'   => 'required',
            'photo' => 'required'
        ]);

        $photo = $request->file('photo');
        $photoName = $photo->getClientOriginalName();
        $location = 'Image/Ads/';

        $ads_id = $request->ads_id;
        if(!$ads_id) {
            $photo->move($location , $photoName);

            $status = Technician_ads::create([
                'ads_title'        => $request->title,
                'ads_photo'        => $photoName,
                'ads_body'         => $request->body,
                'ads_url'          => $request->url,
                'ads_start'        => $request->start,
                'ads_end'          => $request->end,
                'ads_create_user'  => auth()->user()->id,
                'ads_create_time'  => Carbon::now()
            ]);
            $ads_id = $status->id;
        }else {
            // return $request;
           $data = Technician_ads::where('ads_id', $ads_id)->first();
            if(!empty($data->ads_photo) && File::exists($location)){
                File::delete($location . $data->ads_photo);
            }

            $photo->move($location , $photoName);
            $status = Technician_ads::where('ads_id', $ads_id)->update([
                'ads_title'        => $request->title,
                'ads_photo'        => $photoName,
                'ads_body'         => $request->body,
                'ads_url'          => $request->url,
                'ads_start'        => $request->start,
                'ads_end'          => $request->end,
                'ads_create_user'  => auth()->user()->id,
                'ads_create_time'  => Carbon::now()
            ]);
        }

        $record = Technician_ads::where('ads_id', $ads_id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }
}