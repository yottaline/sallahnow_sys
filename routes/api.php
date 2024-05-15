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

    Route::get('get_models', 'TechnicianApiController@getModels');

    Route::prefix('technicians')->group(function() {
        Route::post('register', 'TechnicianApiController@register');
        Route::post('login', 'TechnicianApiController@login');
        Route::post('profile', 'TechnicianApiController@profile');
        // Route::put('update', 'TechnicianApiController@Update');
        Route::post('update', 'TechnicianApiController@Update');
        //
        Route::get('get_models', 'TechnicianApiController@getModels');
        Route::get('getCompatibilities', 'TechnicianApiController@getCompatibilities');
        //
        Route::get('get_packages', 'TechnicianApiController@getPackages');

        // Route::post('post-cost', 'TechnicianApiController@postCost');
    });

    Route::prefix('subscriptions')->group( function()
    {
        // Route::get('/' , 'SubscriptionsApiController@getAll');
        // Route::put('change_status/{tech_id}', 'SubscriptionsApiController@changeStatus');
        Route::post('sub_package', 'SubscriptionsApiController@subPackage');
    });


    Route::prefix('posts')->group( function() {
        // posts
        Route::get('load', 'PostsApiController@getPosts');
        Route::get('post', 'PostsApiController@getPost');
        Route::post('submit_post', 'PostsApiController@store');
        Route::post('file', 'PostsApiController@file');
        Route::post('post_cost', 'PostsApiController@cost');
        Route::post('like', 'PostsApiController@addLike');
        // comments
        Route::post('load_comments', 'PostsApiController@comments');
        Route::post('submit_comment', 'PostsApiController@addComment');
        // post view
        Route::post('post_views', 'PostsApiController@postView');
        Route::post('add_post_view', 'PostsApiController@addView');

    });

    Route::prefix('chats')->group( function()
    {
        Route::get('get_chats', 'ChatApiController@chat');
        Route::post('create_room', 'ChatApiController@createRoom');
        Route::post('add_member', 'ChatApiController@addMember');
        Route::post('submit_message', 'ChatApiController@createMessage');
    });

    Route::prefix('tickets')->group( function()
    {
        Route::post('load_ticket', 'SupportTicketApiController@getTickets');
        Route::post('add_ticket', 'SupportTicketApiController@addTicket');
        Route::post('replies', 'SupportTicketApiController@gtReplies');
        Route::post('add_reply', 'SupportTicketApiController@addReplie');
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


    // markets api route
    // stores route
    Route::prefix('stores')->group(function(){
        Route::post('get_stores','MarketStoreApiController@getStores');
        Route::match(['put', 'post'], 'submit', 'MarketStoreApiController@submit');
        Route::post('locations', 'MarketStoreApiController@loadLocation');
    });
    // retailer route
    Route::prefix('retailers')->group(function(){
        Route::post('register', 'MarketRetailerApiController@register');
        Route::post('login', 'MarketRetailerApiController@login');
    });


    // locations rouets
    Route::prefix('locations')->group(function () {
        Route::post('load', 'LocationApiController@load');
    });
});