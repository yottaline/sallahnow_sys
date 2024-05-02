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

    public function index()
    {
        return view('content.ads.index');
    }

    public function load(Request $request)
    {
        $params = $request->q ? ['q' => $request->q] : [];
        $limit  = $request->limit;
        $lastId = $request->last_id;

        echo json_encode(Technician_ads::fetch(0, $params, $limit, $lastId));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body'  => 'required',
            'url'   => 'required',
            'photo' => 'required'
        ]);

        $params = [
            'ads_title'        => $request->title,
            // 'ads_photo'        => $photoName,
            'ads_body'         => $request->body,
            'ads_url'          => $request->url,
            'ads_start'        => $request->start,
            'ads_end'          => $request->end,
            'ads_create_user'  => auth()->user()->id,
            'ads_create_time'  => Carbon::now()
        ];

        $photo = $request->file('photo');
        $photoName = $this->uniqidReal(rand(4, 18));
        $location = 'Image/Ads/';
        $photo->move($location , $photoName);

        $ads_id = $request->ads_id;
        if(!$ads_id) {
            $params['ads_photo'] = $photoName;
        }else {
           $data = Technician_ads::fetch($ads_id);
            if(!empty($data->ads_photo) && File::exists($location)){
                File::delete($location . $data->ads_photo);
            }

            $params['ads_photo'] = $photoName;
        }

        $result = Technician_ads::submit($params, $ads_id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? Technician_ads::fetch($ads_id) : [],
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