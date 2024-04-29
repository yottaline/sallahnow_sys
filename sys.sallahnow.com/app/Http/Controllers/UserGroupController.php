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

    public function load()
    {
        echo json_encode(User_group::fetch());
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        $param = [
            'ugroup_name' => $request->name,
            'ugroup_privileges'  => 0
        ];

        $result = User_group::submit($param);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? User_group::fetch($result) : [],
        ]);
    }
    public function addPermissions(Request $request)
    {

        $name = implode(" ,",$request->name);
        $request->validate(['ugroup_id' => 'required']);
        $id  = $request->ugroup_id;
        $param = ['ugroup_privileges' =>$name];

        $result = User_group::submit($param, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? User_group::fetch($result) : [],
        ]);
    }

    public function getPermissions($ugroup_id)
    {
        $id = $ugroup_id;
       $permissions = User_group::fetch($id);
       echo json_encode($permissions);
    }
}