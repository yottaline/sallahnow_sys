<?php

use App\Http\Controllers\TechnicianController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('api')->group(function() {
    Route::prefix('technicians')->group(function() {
        Route::post('sign_in', 'TechnicianApiController@sign_in');
        Route::post('login', 'TechnicianApiController@login');
        Route::post('profile', 'TechnicianApiController@profile');
        Route::put('update/{id}', 'TechnicianApiController@Update');
        Route::get('getModels', 'TechnicianApiController@getModels');
    });
});