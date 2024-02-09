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
        // $this->middleware('permission:add-users')->only(['create', 'store']);
        // $this->middleware('permission:view-users')->only(['index', 'show']);
        // $this->middleware('permission:update-users')->only(['edit', 'update']);
        // $this->middleware('permission:delete-users')->only('destroy');
    }

    public function index() : View {
       $users = User::all();
       return view('content.users.index', compact('users'));
    }

    public function store(Request $request) {
        $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'mobile'   => 'required|numeric',
            'password' => 'required'
        ]);

        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'group'     => 1,
            'mobile'    => $request->mobile,
            'password'  => $request->password
        ]);
        session()->flash('Add', 'User data has been added successfully');
        return back();
    }

    public function update(Request $request) {
        $id = $request->user_id;
        User::where('id', $id)->update([
            'name'     => $request->user_name,
            'email'    => $request->user_email,
            'group'     => 1,
            'mobile'    => $request->user_mobile,
            'password'  => $request->user_password
        ]);
        session()->flash('Add', 'User data has been updated successfully');
        return back();
    }

    public function updateActive(Request $request) {
        $id = $request->user_id;
        User::where('id', $id)->update(['active' => $request->active]);
        session()->flash('Add', 'Active User has been updated successfully');
        return back();
    }

    public function addRole(Request $request, Permission $permission) {
        $id = $request->user_id;
        $user  = User::find($id);
        $roles = Role::all();
        return view('content.users.add_role', compact('user', 'roles', 'permission'));
    }

    public function addRoleToUser(Request $request, User $user){
        if($user->hasRole($request->role)){
            return back()->with('massage', 'Role is exits');
        }

        $user->assignRole($request->role);
        session()->flash('Add', 'assign role successful');
        return back();
     }

     public function delete(Request $request) {
        $id = $request->user_id;
        User::destroy($id);
        session()->flash('Add', 'User data has been deleted successfully');
        return back();
     }

     public function syncRoles(Request $request){
        $user_id = $request->user_id;
        $role_id = $request->role_id;
        $user    = User::find($user_id);
        $role    = Role::find($role_id);
        $user->roles($role)->detach();
        session()->flash('error', 'Role Deleted successful');
        return back();
     }

}
