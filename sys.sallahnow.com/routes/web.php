<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::prefix('users')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', 'UserController@index')->name('users');
    Route::post('load', 'UserController@load');
<<<<<<< Updated upstream
    Route::match(['post', 'put'],'store', 'UserController@store')->name('user_store');
=======
    Route::match(['post', 'put'], 'submit', 'UserController@submit');
>>>>>>> Stashed changes
    Route::put('update', 'UserController@update')->name('user_update');
    Route::put('update/active', 'UserController@updateActive')->name('user_update_active');
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
    Route::get('/', 'TechnicianController@index')->name('technician_index');
    Route::post('load', 'TechnicianController@load');
    Route::match(['post', 'put'],'store', 'TechnicianController@store')->name('technician_store');
    Route::put('update/active', 'TechnicianController@updateActive')->name('technician_update_active');
    Route::post('add/note', 'TechnicianController@addNote')->name('technician_add_note');
    // Route::put('update', 'TechnicianController@update')->name('technician_update');
    Route::delete('delete', 'TechnicianController@delete')->name('technician_delete');
});


Route::prefix('brands')->middleware('auth')->group( function() {
    Route::get('/', 'BrandController@index')->name('brand_index');
    Route::post('load', 'BrandController@load');
<<<<<<< Updated upstream
    Route::match(['post', 'put'], 'store', 'BrandController@store')->name('brand_store');
    Route::post('getUserName','BrandController@getUsersName');
=======
    Route::match(['post', 'put'], 'submit', 'BrandController@store');
    Route::post('getUserName', 'BrandController@getUsersName');
>>>>>>> Stashed changes
});

Route::prefix('models')->middleware('auth')->group( function() {
    Route::get('/','ModelController@index')->name('model_index');
    Route::post('load', 'ModelController@load');
<<<<<<< Updated upstream
    Route::match(['post', 'put'], 'store', 'ModelController@store')->name('model_store');
    Route::post('getBrandsName','ModelController@getBrandsName');
    Route::post('getUserName','ModelController@getUsersName');
=======
    Route::match(['post', 'put'], 'submit', 'ModelController@submit');
    Route::post('getBrandsName', 'ModelController@getBrandsName');
    Route::post('getUserName', 'ModelController@getUsersName');
>>>>>>> Stashed changes
});

Route::prefix('settings')->middleware('auth')->group(function () {
    Route::get('/', 'SettingController@index')->name('setting_index');
    Route::post('store/location', 'SettingController@storeLocation')->name('location_store');
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';