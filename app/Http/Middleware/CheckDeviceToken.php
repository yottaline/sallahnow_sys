<?php

namespace App\Http\Middleware;

use App\Models\Technician;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDeviceToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $deviceToken = $request->header('device_Token');

        if(!$deviceToken)
        {
            return response()->json(['error' => 'Device token not provided'], 401);
        }

        $validDeviceToken = Technician::where('devise_token', $deviceToken)->first();
        if(!$validDeviceToken)
        {
            return response()->json(['error' => 'Invalid device token'], 401);
        }

        return $next($request);
    }
}