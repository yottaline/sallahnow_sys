<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $roles = Role::all();
        return view('content.user_groups.roles.index', compact('roles'));
    }

    public function load() {
        $roles = Role::all();
        echo json_encode($roles);
    }

    public function getPermissions($id){
        $role = Role::find($id);
        echo json_encode($role);
    }

    public function store(Request $request) {
       $data=  $request->validate(['name'  => 'required', ]);

        Role::create($data);

        session()->flash('Add', 'Role information has been added successfully');
        return back();
     }

     public function edit(Request $request) {
        $id = $request->role_id;
        $role = Role::find($id);
        $permissions = Permission::all();

        return view('content.user_groups.roles.edit', compact('role', 'permissions'));
     }

     public function update(Request $request, $id) {
        $request->validate(['role_name'=>'required']);
        Role::where('id', $id)->update([
            'name' => $request->role_name,
        ]);
        session()->flash('Add', 'Role information has been updated successfully');
        return back();
     }

     public function delete(Request $request) {
        $id = $request->role_id;
        Role::destroy($id);
        session()->flash('error', 'Role information has been deleted successfully');
        return back();
     }

     public function givePermission(Request $request, Role $role){
        return $request->input('name.*.name');
        if($role->hasPermissionTo($request->permission)){
            session()->flash('error', 'permission is exist');
            return back();
        }
        $role->givePermissionTo($request->permission);
        session()->flash('Add', 'Give successful');
        return back();
     }

     public function revoke(Request $request) {
        $role = Role::find($request->role_id);
        $permission = Permission::find($request->permission_role_id);
        $role->revokePermissionTo($permission);
        session()->flash('error', 'Role information has been deleted successfully');
        return back();
     }
}
