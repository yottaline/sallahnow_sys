<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        return view('content.users.index',);
    }

    public function load(Request $request)
    {

        $users = DB::table('users')
        ->join('user_groups', 'users.user_group', '=', 'user_groups.ugroup_id')
        ->orderBy('users.user_create', 'desc')
        ->limit($request->limit);

    if ($request->q) {
        $users= User::where(function (Builder $query) {
            $query->where('user_name', 'like', '%' .request('q') . '%')
            ->orWhere('user_email', request('q'))
            ->orWhere('user_mobile', request('q'));
        });
    }
    if($request->status)
    {
        $users->where('user_active', $request->status);
    }
        echo json_encode($users->get());

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

        if(User::where('id', '!=', $id)->where('user_mobile', '=', $mobile)->first())
        {
            echo json_encode([
                'status' => false,
                'message' =>  $this->validateMessage('number'),
            ]);
            return ;
        }
        if($email && User::where('id', '!=', $id)->where('user_email', '=', $email)->first())
        {
            echo json_encode([
                'status' => false,
                'message' =>  $this->validateMessage('email'),
            ]);
            return ;
        }


        $parma = [
            'user_name'           => $request->name,
            'user_email'          => $request->email,
            'user_password'       => $request->password,
            'user_group'          => $request->role_id,
            'user_mobile'         => $request->mobile,
            'user_create'         => now()
        ];

        if(!$id) {
        $status = User::create($parma);
        $id     = $status->id;
        }else{
        $status = User::where('id', $id)->update($parma);
        }
        $record = User::where('id', $id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
        ]);
    }

    public function search($item){
        echo json_encode($item);
    }

    public function updateActive(Request $request)
    {
        $id = $request->user_id;
        if($request->user_active == 1) {
            $status = User::where('id', $id)->update(['user_active' => 0]);
        }else {
            $status = User::where('id', $id)->update(['user_active' => 1]);
        }
       $record = User::where('id', $id)->first();
        echo json_encode([
            'status' => boolval($status),
            'data' => $record,
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

    private function validateMessage($message)
    {
        return 'This ' . $message . ' already exists';
    }
}