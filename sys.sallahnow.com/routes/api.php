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

        // Route::post('post-cost', 'TechnicianApiController@postCost');
    });

    Route::prefix('posts')->group( function() {
        // posts
        Route::get('/', 'PostsApiController@getPost');
        Route::post('store_post', 'PostsApiController@store');
        Route::post('post_cost', 'PostsApiController@cost');
        Route::post('like', 'PostsApiController@addLike');
        // comments
        Route::get('comments/{post_id}', 'PostsApiController@comments');
        Route::post('add_comment', 'PostsApiController@addComment');
        // post view
        Route::get('post_views/{post_id}', 'PostsApiController@postView');
        Route::post('add_post-view', 'PostsApiController@addView');

    });

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

    Route::prefix('courses')->group( function() {
        Route::get('/', 'CourseApiController@courses');
        Route::post('view', 'CourseApiController@views');
    });

    Route::prefix('ads')->group( function() {
        Route::get('/', 'AdsApiController@ads');
    });

    // customer app
    Route::prefix('customer') ->group( function() {
        Route::post('register', 'CustomerApiController@register');
        Route::post('login', 'CustomerApiController@login');
        Route::get('profile', 'CustomerApiController@profile');

    });


});