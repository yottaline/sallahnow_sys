<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Technician_ads;
use App\ResponseApi;
use Illuminate\Http\Request;

class AdsApiController extends Controller
{
    use ResponseApi;
    public function __construct()
    {
        return $this->middleware('auth:technician-api');
    }

    public function ads() {
        $ads = Technician_ads::all();
        return $this->returnData('ads', $ads);
    }
}