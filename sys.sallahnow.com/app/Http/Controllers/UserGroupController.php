<?php

namespace App\Http\Controllers;

use App\Models\User_group;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

class UserGroupController extends Controller
{
    public function index(){
        return view('content.user_groups.roles.index');
    }

    public function load() {
        $roles = User_group::all();
        echo json_encode($roles);
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required']);
        User_group::create([
            'user_group_name' => $request->name,
            'user_group_privileges'  => 0
        ]);
        session()->flash('Add', 'Role data has been added successfully');
        return back();
    }
    public function addPermissions(Request $request) {
        $request->validate(['role_id' => 'required']);

        User_group::where('id', $request->role_id)->update([
            'user_group_privileges' => $request->name
        ]);
        session()->flash('Add', 'Permissions data has been added successfully');
        return back();
    }

    public function getPermissions($id) {
       $permissions = User_group::find($id);
       return json_decode($permissions->user_group_privileges);
       echo json_encode($id);
    }
}
