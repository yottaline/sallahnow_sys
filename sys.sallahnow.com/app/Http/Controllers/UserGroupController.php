<?php

namespace App\Http\Controllers;

use App\Models\User_group;
use Illuminate\Http\Request;

use function Pest\Laravel\json;

class UserGroupController extends Controller
{
    public function index()
   {
        return view('content.user_groups.roles.index');
    }

    public function load() {
        $roles = User_group::all();
        echo json_encode($roles);
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required']);
        User_group::create([
            'ugroup_name' => $request->name,
            'ugroup_privileges'  => 0
        ]);
        session()->flash('Add', 'Role data has been added successfully');
        return back();
    }
    public function addPermissions(Request $request) {

        $name = implode(" ,",$request->name);
        $request->validate(['ugroup_id' => 'required']);
       $status = User_group::where('ugroup_id', $request->ugroup_id)->update([
            'ugroup_privileges' =>$name
        ]);
        $record = User_group::where('ugroup_id', $request->ugroup_id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    public function getPermissions($ugroup_id) {

       $permissions = User_group::where('ugroup_id',$ugroup_id)->first();
       echo json_encode($permissions);
    }
}