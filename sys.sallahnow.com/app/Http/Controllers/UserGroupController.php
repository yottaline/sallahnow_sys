<?php

namespace App\Http\Controllers;

use App\Models\User_group;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

class UserGroupController extends Controller
{
    public function index(){

        // $roles = User_group::where('id', 1)->first();
        // return explode(',',$roles->user_group_privileges);
        return view('content.user_groups.roles.index');
    }

    public function load() {
        $roles = User_group::all();
        echo json_encode($roles);
    }

    public function store(Request $request) {
        return $request;
        $request->validate(['name' => 'required']);
        User_group::create([
            'ugroup_name' => $request->name,
            'ugroup_privileges'  => 0
        ]);
        session()->flash('Add', 'Role data has been added successfully');
        return back();
    }
    public function addPermissions(Request $request) {
        // return (',', $arr);
        $request->validate(['role_id' => 'required']);
        $arr = implode(',',$request->name);
        User_group::where('ugroup_id', $request->role_id)->update([
            'ugroup_privileges' => $arr
        ]);
        session()->flash('Add', 'Permissions data has been added successfully');
        return back();
    }

    public function getPermissions($id) {
       $permissions = User_group::find($id);
       return json_decode($permissions->ugroup_privileges);
       echo json_encode($id);
    }
}