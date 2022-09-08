<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);
        return redirect(route('role.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user_permissions = DB::select('select permission_id,role_id, roles.name as name,permissions.name as permissions from role_has_permissions as rp join roles on rp.role_id=roles.id join permissions on rp.permission_id=permissions.id where role_id=?', [$id]);
        $role = Role::find($id);
        // return ([$role]);
        $permissions = Permission::all();
        return view('role.edit', compact('role', 'permissions', 'user_permissions'));
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
        $role = Role::find($id);
        $role->update($myarray);
        return view('role.edit', compact('role'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect(route('role.index'));
    }
    public function give_permission(Request $request, $id)
    {
        if (!array_key_exists('assignPermission', $request->all())) {
            return redirect(route('role.edit', $id));
        }
        $role = Role::find($id);
        $permissions = $request->assignPermission;
        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')->updateOrInsert([
                'permission_id' => $permission,
                'role_id' => $role->id,
            ]);
        }
        $users_with_role = DB::table('model_has_roles')->where('role_id', '=', $id)->where('model_type', '=', 'App\Models\User')->get('model_id');
        if (!empty($users_with_role)) {
            foreach ($users_with_role as $user) {
                $user_db = User::find($user->model_id);
                $user_db->givePermissionTo($permissions);
            }
        }
        // $role->givePermissionTo($permissions);
        return redirect(route('role.edit', $id));
    }
    public function revoke_permission(Request $request, $id)
    {
        if (!array_key_exists('revoke_permission', $request->all())) {
            return redirect(route('role.edit', $id));
        }
        $role = Role::find($id);
        $permissions = $request->revoke_permission;
        foreach ($permissions as $permission) {
            DB::table('role_has_permissions')
                ->where('permission_id', $permission)
                ->where('role_id', $role->id)
                ->delete();
        }
        $users_with_role = DB::table('model_has_roles')->where('role_id', '=', $id)->where('model_type', '=', 'App\Models\User')->get('model_id');
        if (!empty($users_with_role)) {
            foreach ($users_with_role as $user) {
                $user_db = User::find($user->model_id);
                foreach ($permissions as $permission) {
                    $user_db->revokePermissionTo($permission);
                }
            }
        }
        return redirect(route('role.edit', $id));
    }
}
