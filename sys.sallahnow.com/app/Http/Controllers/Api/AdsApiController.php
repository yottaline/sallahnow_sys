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
        return $this->middleware(['auth:technician-api', 'check_device_token']);
    }

    public function ads()
    {
        $ads = Technician_ads::fetch();

        return $this->returnData('ads', $ads);
    }
}