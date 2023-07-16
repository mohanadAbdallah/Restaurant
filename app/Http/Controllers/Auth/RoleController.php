<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::all();
        return \view('auth.roles.index', compact('roles'));

    }

    public function create(): View
    {
        $permissions = Permission::get();
        return view('auth.roles.create', compact('permissions'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string'],
            'permission' => ['required'],
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')->with('status', 'Role Created Successfully');
    }

    public function edit(Role $role): View
    {
        $permissions = Permission::get();

        $rolePermissions = $role->getAllPermissions()->pluck('id')->all();

        return \view('auth.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        $request->validate([
            'name'=>['required'],
            'permission'=>['required'],
        ]);
        $role->name = $request->input('name');
        $role->save();
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('roles.index')->with('status','Role Updated Successfully.');

    }

    public function destroy(Role $role): RedirectResponse
    {
        $role->delete();
        return redirect()->route('roles.index')->with('status','Role Deleted Successfully');
    }
}
