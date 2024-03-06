<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('users')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', 'UserController@index')->name('users');
    Route::post('load', 'UserController@load');
    Route::post('search/{item}', 'UserController@search');
    Route::match(['post', 'put'], 'submit', 'UserController@submit');
    Route::put('update', 'UserController@update')->name('user_update');
    Route::put('update/active', 'UserController@updateActive');
    Route::get('add_role', 'UserController@addRole')->name('user_add_role');
    Route::post('add_role_to_user/{user}', 'UserController@addRoleToUser')->name('user_add_role_to_user');
    Route::delete('delete/user', 'UserController@delete')->name('user_delete');
    Route::delete('delete/role', 'UserController@syncRoles')->name('user_remove_role');
});

Route::prefix('permission')->middleware('auth')->group(function () {
    Route::get('/', 'PermissionController@index')->name('permission_index');
    Route::post('store', 'PermissionController@store')->name('permission_store');
    Route::post('getRole/{id}', 'PermissionController@getRole');
    Route::get('edit', 'PermissionController@edit')->name('permission_edit');
    Route::put('update/{permission}', 'PermissionController@update')->name('permission_update');
    Route::delete('delete', 'PermissionController@delete')->name('permission_delete');
    Route::post('assign/{permission}', 'PermissionController@assign')->name('permission_assign');
    Route::delete('removeRole', 'PermissionController@removeRole')->name('permission_remove_role');
});

Route::prefix('roles')->middleware('auth')->group(function () {
    Route::get('/', 'UserGroupController@index')->name('role_index');
    Route::post('load', 'UserGroupController@load');
    Route::post('store', 'UserGroupController@store')->name('role_store');
    Route::put('addPermissions', 'UserGroupController@addPermissions')->name('addPermissions');
    Route::post('getPermission/{id}', 'UserGroupController@getPermissions');
    Route::put('update/{role}', 'RoleController@update')->name('role_update');
    Route::delete('delete', 'RoleController@delete')->name('role_delete');
    Route::post('give_permission/{role}', 'RoleController@givePermission')->name('role_give_permission');
    Route::delete('revoke', 'RoleController@revoke')->name('role_revoke_permission');
});

Route::prefix('technicians')->middleware(['auth'])->group(function () {
    Route::get('/', 'TechnicianController@index');
    Route::post('load', 'TechnicianController@load');
    Route::match(['post', 'put'], 'submit', 'TechnicianController@submit');
    Route::get('profile/{technician}', 'TechnicianController@profile');
});

Route::prefix('centers')->middleware('auth')->group(function () {
    Route::get('/', 'CenterController@index');
    Route::post('load', 'CenterController@load');
    Route::match(['post', 'put'], 'submit', 'CenterController@submit');
    Route::get('getTechnician/{item}', 'CenterController@getTechnician');
    Route::put('addOwner', 'CenterController@addOwner');
    Route::post('getTechnicianName', 'CenterController@getTechnicianName');
});

Route::prefix('brands')->middleware('auth')->group(function () {
    Route::get('/', 'BrandController@index')->name('brand_index');
    Route::post('load', 'BrandController@load');
    Route::match(['post', 'put'], 'submit', 'BrandController@store');
    Route::post('getUserName', 'BrandController@getUsersName');
});

Route::prefix('models')->middleware('auth')->group(function () {
    Route::post('load', 'ModelController@load');
    Route::match(['post', 'put'], 'submit', 'ModelController@submit');
    Route::post('getBrandsName', 'ModelController@getBrandsName');
    Route::post('getUserName', 'ModelController@getUsersName');
});

Route::prefix('CompatibilityCategories')->middleware('auth')->group(function () {
    Route::post('load', 'CompatibilityCategorieController@load');
    Route::match(['post', 'put'], 'submit', 'CompatibilityCategorieController@submit');
});

Route::prefix('compatibilities')->middleware('auth')->group(function () {
    Route::get('/', 'CompatibilityController@index');
    Route::post('load', 'CompatibilityController@load');
    Route::match(['post', 'put'], 'submit', 'CompatibilityController@submit');
    Route::post('getCateName', 'CompatibilityController@getCateName');
});

Route::prefix('suggestions')->middleware('auth')->group(function () {
    Route::get('/', 'CompatibilitiesSuggestionsController@index');
    Route::post('load', 'CompatibilitiesSuggestionsController@load');
    Route::post('store', 'CompatibilitiesSuggestionsController@store')->name('i.suggestions');
    Route::match(['post', 'put'], 'submit', 'CompatibilitiesSuggestionsController@submit');
});

Route::prefix('packages')->middleware('auth')->group(function () {
    Route::post('load', 'PackageController@load');
    Route::match(['post', 'put'], 'submit', 'PackageController@submit');
});

Route::prefix('subscriptions')->middleware('auth')->group(function () {
    Route::get('/', 'SubscriptionsController@index');
    Route::post('load', 'SubscriptionsController@load');
    Route::get('search/{item}', 'SubscriptionsController@search');
    Route::match(['post', 'put'], 'submit', 'SubscriptionsController@submit');
    Route::post('subGetTechnician', 'SubscriptionsController@technicianName');
    Route::post('subGetUser', 'SubscriptionsController@userName');
    Route::put('change', 'SubscriptionsController@changeStatus');
});

Route::prefix('transactions')->middleware('auth')->group(function () {
    Route::get('/', 'TransactionController@index');
    Route::post('load', 'TransactionController@load');
    Route::match(['post', 'put'], 'submit', 'TransactionController@submit');
    // Route::post('subTranTechnician', 'TransactionController@technicianName');
    Route::put('change', 'TransactionController@changeProcess');
    Route::get('profile/{reference}', 'TransactionController@profile');
});

Route::prefix('points')->middleware('auth')->group(function () {
    Route::get('/', 'PointTranactionController@index');
    Route::post('load', 'PointTranactionController@load');
    Route::match(['post', 'put'], 'submit', 'PointTranactionController@submit');
    Route::post('subPointTechnician', 'PointTranactionController@technicianName');
    Route::get('profile/{id}', 'TransactionController@profile');
});

Route::prefix('posts')->middleware('auth')->group(function () {
    Route::get('/', 'PostController@index');
    Route::post('load', 'PostController@load');
    Route::get('editor/{code?}', 'PostController@editor');
    Route::post('submit', 'PostController@submit');
    Route::post('file_submit', 'PostController@fileSubmit');
    // Route::put('add-cost', 'PostController@addCost');
    // Route::post('update-data', 'PostController@updateData');
    // Route::post('add-attach', 'PostController@addAttach');
    // Route::delete('delete', 'PostController@delete');
    // comments
    // Route::post('get-comment', 'PostController@getComment');
    // Route::post('add-comment', 'PostController@addComment');
});

Route::prefix('chats')->middleware('auth')->group(function () {
    Route::get('/', 'ChatRoomController@index');
    // Route::post('load/{tech}', 'ChatRoomController@load');
    Route::match(['post', 'put'], 'submit', 'ChatRoomController@submit');
    Route::get('get-technician/{tech_code}', 'ChatRoomController@getTechnician');
    Route::get('get-chat-room/{tech_id}', 'ChatRoomController@getChatRoom');
    Route::post('get-chat-msg/{room_id}', 'ChatRoomController@getMessage');
});


Route::prefix('supports')->middleware('auth')->group(function () {
    Route::get('/', 'SupportCategoryController@index');
    Route::post('load', 'SupportCategoryController@load');
    Route::match(['post', 'put'], 'submit', 'SupportCategoryController@submit');
    Route::put('update-cost', 'SupportCategoryController@updateCost');
});

Route::prefix('tickets')->middleware('auth')->group(function () {
    Route::get('/', 'SupportTicketController@index');
    Route::post('load', 'SupportTicketController@load');
    Route::put('change-status', 'SupportTicketController@changeStatus');
    Route::put('add-replie', 'SupportTicketController@replie');
    Route::get('get-replie/{tcket_id}', 'SupportTicketController@getReplie');
});


Route::prefix('courses')->middleware('auth')->group(function () {
    Route::get('/', 'CourseController@index');
    Route::post('load', 'CourseController@load');
    Route::get('create', 'CourseController@create');
    Route::get('edit/{course_code}', 'CourseController@edit');
    Route::match(['post', 'put'], 'submit', 'CourseController@submit');
    Route::put('cost', 'CourseController@cost');
    Route::put('add_file', 'CourseController@addFile');
    Route::post('update_archived', 'CourseController@updateArchived');
    Route::delete('delete', 'CourseController@delete');
});

Route::prefix('ads')->middleware('auth')->group(function () {
    Route::get('/', 'TechnicianAdsController@index');
    Route::post('load', 'TechnicianAdsController@load');
    Route::match(['post', 'put'], 'submit', 'TechnicianAdsController@submit');
});

Route::prefix('customers')->middleware('auth')->group(function () {
    Route::get('/', 'CustomerController@index');
    Route::post('load', 'CustomerController@load');
    Route::match(['post', 'put'], 'submit', 'CustomerController@submit');
    Route::put('update_note', 'CustomerController@updateNote');
    Route::put('update_active', 'CustomerController@updateActive');
});


Route::prefix('settings')->middleware('auth')->group(function () {
    Route::get('/', 'SettingController@index');
    Route::post('location/load', 'SettingController@locationLoad');
    Route::post('location/submit', 'SettingController@locationSubmit');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
