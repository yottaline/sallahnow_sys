<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_group;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('add-users')->only('store');
    }

    public function index(): View
    {
        $roles = User_group::all();
        return view('content.users.index', compact('roles'));
    }

    public function load(Request $request)
    {

       $limit  = $request->limit;
       $lastId = $request->last_id;
       $params = $request->q ? ['q' => $request->q] : [];
       if($request->status) $params[] = ['user_active', $request->status - 1];

        echo json_encode(User::fetch(0, $params, $limit, $lastId));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name'     => 'required|string',
            'mobile'   => 'required|numeric',
            'password' => 'required',
        ]);


        $id = intval($request->user_id);
        $mobile = $request->mobile;
        $email = $request->email;

        if(count(User::fetch(0, [['id', '!=', $id],['user_mobile', $mobile]]))){
            echo json_encode([
                'status' => false,
                'message' =>  $this->validateMessage('number'),
            ]);
            return;
        }

        if($email && count(User::fetch(0, [['id', '!=', $id],['user_email', $email]]))){
            echo json_encode([
                'status' => false,
                'message' =>  $this->validateMessage('email'),
            ]);
            return;
        }

        $param = [
            'user_name'           => $request->name,
            'user_email'          => $request->email,
            'user_password'       => $request->password,
            'user_group'          => $request->role_id,
            'user_mobile'         => $request->mobile,
            'user_create'         => now()
        ];

        $result = User::submit($param, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' => $result ? User::fetch($id) : [],
        ]);
    }

    public function search($item){
        echo json_encode($item);
    }

    public function updateActive(Request $request)
    {
        $id = $request->user_id;
        $active = 1;
        if($request->active) $active = 0;

        $param = ['user_active' => $active];
        $result = User::submit($param, $id);
        echo json_encode([
            'status' => boolval($result),
            'data' =>  $result ? User::fetch($id) : [],
        ]);

    }

    public function addRole(Request $request, Permission $permission)
    {
        $id = $request->user_id;
        $user  = User::find($id);
        $roles = Role::all();
        return view('content.users.add_role', compact('user', 'roles', 'permission'));
    }

    public function addRoleToUser(Request $request, User $user)
    {
        if ($user->hasRole($request->role)) {
            return back()->with('massage', 'Role is exits');
        }

        $user->assignRole($request->role);
        session()->flash('Add', 'assign role successful');
        return back();
    }

    // public function delete(Request $request)
    // {
    //     $id = $request->user_id;
    //     User::destroy($id);
    //     session()->flash('Add', 'User data has been deleted successfully');
    //     return back();
    // }

    public function syncRoles(Request $request)
    {
        $user_id = $request->user_id;
        $role_id = $request->role_id;
        $user    = User::find($user_id);
        $role    = Role::find($role_id);
        $user->roles($role)->detach();
        session()->flash('error', 'Role Deleted successful');
        return back();
    }

    private function validateMessage($message)
    {
        return 'This ' . $message . ' already exists';
    }
}
