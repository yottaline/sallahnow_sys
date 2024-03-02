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
        Route::post('register', 'TechnicianApiController@register');
        Route::post('login', 'TechnicianApiController@login');
        Route::post('profile', 'TechnicianApiController@profile');
        Route::put('update/{id}', 'TechnicianApiController@Update');
        //
        Route::get('getModels', 'TechnicianApiController@getModels');
        Route::get('getCompatibilities', 'TechnicianApiController@getCompatibilities');
        //
        Route::get('get-packages', 'TechnicianApiController@getPackages');
        //
        Route::get('get-subscriptions', 'TechnicianApiController@getSubscriptions');
        Route::put('subscriptions/change-status/{id}', 'TechnicianApiController@changeStatus');
        // Route::put('subscriptions/change/status', 'TechnicianApiController@changeStatus');
        Route::post('subscriptions/new-package', 'TechnicianApiController@subNewPackage');

        // posts
        Route::get('ge-posts', 'TechnicianApiController@getPost');
        Route::post('store-post', 'TechnicianApiController@storePost');
        Route::post('post-cost', 'TechnicianApiController@postCost');
        Route::post('add-like', 'TechnicianApiController@addLike');
        Route::get('show-comment/{post_id}', 'TechnicianApiController@showComment');
        Route::post('add-comment', 'TechnicianApiController@addComment');
        Route::get('post-views/{id}', 'TechnicianApiController@postView');
        Route::post('add-post-view', 'TechnicianApiController@addView');
    });

    // Route::prefix('posts')->group( function() {

    // });

    Route::prefix('chats')->group( function() {
        Route::get('get-chats/{tech_id}', 'ChatApiController@chat');
        Route::post('create-room', 'ChatApiController@createRoom');
        Route::post('add-member', 'ChatApiController@addMember');
        Route::post('create-message', 'ChatApiController@createMessage');
    });

    Route::prefix('tickets')->group( function() {
        Route::get('/', 'SupportTicketApiController@getTickets');
        Route::post('add-ticket', 'SupportTicketApiController@addTicket');
        Route::get('replies/{ticket_id}', 'SupportTicketApiController@gtReplies');
        Route::post('add-replie', 'SupportTicketApiController@addReplie');
    });
});
