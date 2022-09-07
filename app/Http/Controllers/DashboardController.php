<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        // $role=$users[0]->roles;
        // return([$role[0]->name]);
        return view('dashboard', compact('users'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('user.index', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $available_permissions = RolePermission::where('role_id', $request->role)->get('permission_id');
        if (!empty($available_permissions)) {
            $permissions = [];
            foreach ($available_permissions as $available_permission) {
                array_push($permissions, $available_permission->permission_id);
            }
        }
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $user->assignRole($request->role);
        $user->givePermissionTo($permissions);
        event(new Registered($user));

        return redirect(route('dashboard'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('permissions')->find($id);
        // return([$user->permissions]);
        // return([$user]);
        $permissions = Permission::all();
        $roles = Role::all();
        $user_role = Role::where('name', '=', $user->getRoleNames())->get('id');
        return view('user.edit', compact('user', 'permissions', 'roles', 'user_role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->input();
        $myarray = array_filter($data, 'strlen');
        $user = User::find($id);
        $user_role = Role::where('name', '=', $user->getRoleNames())->get('id');

        // return([$myarray['role']]);
        // return([$user_role]);
        if (array_key_exists('role', $myarray)) {
            if ($user_role[0]->id != $myarray['role'])
                $user->removeRole($user_role[0]->id);
            $user->assignRole($myarray['role']);
            $to_remove_permissions = $user->Permissions;
            $to_assign_permissions = RolePermission::where('role_id', '=', $myarray['role'])->get();
            foreach ($to_remove_permissions as $to_remove_permission) {
                $user->revokePermissionTo($to_remove_permission->permission_id);
            }
            foreach ($to_assign_permissions as $to_assign_permission) {
                $user->givePermissionTo($to_assign_permission->permission_id);
            }
        }

        return redirect(route('dashboard'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect(route('dashboard'));
    }
}
