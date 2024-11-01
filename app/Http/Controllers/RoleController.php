<?php

namespace App\Http\Controllers;


use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Spatie\Permission\PermissionRegistrar;

class RoleController extends Controller
{
    protected function index()
    {
        $roles = Role::paginate(20);
        return view('users.roles.index', compact('roles'));
    }

    public function show(Role $role){
        return view('users.roles.edit', compact('role'));
    }

    protected function create()
    {
    }

    protected function createPermissions(Role $role)
    {
        $permissions = Permission::all();
        return view('users.roles.add_permissions', compact('role', 'permissions'));
    }

    protected function storePermissions(Role $role, Request $request)
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
//        $role = Role::where('id', $id)->first();

//        foreach ($request->permission as $key => $value) {
//            $role->givePermissionTo($value);
//        }

        $role->givePermissionTo(Permission::findById($request->get('permission')));

        return redirect()->route('roles.edit', $role)->withStatus('Permissions granted successfully');
    }

    protected function store()
    {
    }

    protected function edit(Role $role)
    {
        return view('users.roles.edit', ['role' => $role]);
    }

    protected function update()
    {
    }

    protected function destroy()
    {
    }
}
