<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $permissions = Permission::all();

        return view('content.user_groups.index', compact('permissions'));
    }

    public function store(Request $request) {
        $request->validate(['permission_name'        => 'required']);

        Permission::create(['name' => $request->permission_name]);

        session()->flash('Add', 'Permissions information has been added successfully');
        return back();
     }

     public function getRole($id){
        echo json_decode($id);
     }

     public function edit(Request $request) {
        $id = $request->permission_id;
        $permission = Permission::find($id);
        $roles      = Role::all();
        return view('content.user_groups.edit', compact('permission','roles'));
     }

     public function update(Request $request, $id) {
        $request->validate(['permission_name'=>'required']);
        Permission::where('id', $id)->update([
            'name' => $request->permission_name,
        ]);
        session()->flash('Add', 'Permissions information has been updated successfully');
        return back();
     }

     public function delete(Request $request) {
        $id = $request->permission_id;
        Permission::destroy($id);
        session()->flash('error', 'Permissions information has been deleted successfully');
        return back();
     }

     public function assign(Request $request, Permission $permission) {
        if($permission->hasRole($request->role)){

        session()->flash('error', 'Role is exits');
            return back();
        }

        $permission->assignRole($request->role);
        session()->flash('Add', 'assign role successful');
        return back();
     }
     public function removeRole(Request $request) {
        $permission = Permission::find($request->permission_id);
        $role = Role::find($request->role_permission_id);

        $permission->removeRole($role);
        session()->flash('error', 'delete role successful');
        return back();
     }
}
