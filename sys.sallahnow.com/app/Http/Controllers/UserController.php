<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('add-users')->only('store');
    }

    public function index(): View
    {
        return view('content.users.index',);
    }

    public function load()
    {
        $users = User::orderBy('created_at', 'desc')->limit(15)->get();
        echo json_encode($users);
    }

    public function submit(Request $request)
    {

        $request->validate([
            'name'     => 'required|string',
            'mobile'   => 'required|numeric',
            'password' => 'required'
        ]);
        $id = intval($request->user_id);
        if(!$id) {
        $status = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'user_group_id'     => $request->role_id,
            'mobile'    => $request->mobile,
            'password'  => $request->password
        ]);

        $record = User::where('id', $status->id)->get();
        }else{
        $status = User::where('id', $id)->update([
                'name'      => $request->name,
                'email'     => $request->email,
                'user_group_id'     => $request->role_id,
                'mobile'    => $request->mobile,
                'password'  => $request->password
            ]);
        }
        echo json_encode([
            'status' => boolval($status),
            // 'data' => $record,
        ]);
    }


    public function updateActive(Request $request)
    {
        $id = $request->user_id;
        User::where('id', $id)->update(['active' => $request->active]);
        session()->flash('Add', 'Active User has been updated successfully');
        return back();
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

    public function delete(Request $request)
    {
        $id = $request->user_id;
        User::destroy($id);
        session()->flash('Add', 'User data has been deleted successfully');
        return back();
    }

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
}
