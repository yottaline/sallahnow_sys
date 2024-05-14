<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MarketRetailerApiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:retailer-api'], ['except' => ['login', 'register']]);
    }

    public function register(Request $request)
    {

    }
}