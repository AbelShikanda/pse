<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth:admin', 'permission:View Roles'])->only(['index', 'show']);
    //     $this->middleware(['auth:admin', 'permission:Create Roles'])->only(['create', 'store']);
    //     $this->middleware(['auth:admin', 'permission:Edit Roles'])->only(['edit', 'update']);
    //     $this->middleware(['auth:admin', 'permission:Delete Roles'])->only(['destroy']);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::latest()->get();
        return view('admin.roles.index', with([
            'roles' => $roles,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('admin.roles.create', [
            'permissions' => $permissions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,',
        ]);

        $roleName = $request->get('name');
        $permissions = $request->get('permission');

        $role = Role::create([
            'name' => $roleName,
            'guard_name' => 'admin',
        ]);

        $role->syncPermissions($permissions);
        // $role->revokePermissionTo($permission);

        return redirect()
            ->route('roles.index')
            ->with('message', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role = Role::with('permissions')->find($role->id);

        // dd($role);
        // foreach ($role as $roles) {
        //     // dd($roles);
        //     foreach ($roles->permissions as $r) {
        //         dd($r->name);
        //     }
        // }

        return view('admin.roles.show',  [
            'role' => $role,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $role = $role;
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $permissions = Permission::get();

        return view('admin.roles.edit',  [
            'role' => $role,
            'rolePermissions' => $rolePermissions,
            'permissions' => $permissions,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $roleName = $request->get('name');
        $permissions = $request->get('permission');

        $role->update([
            'name' => $roleName
        ]);

        $role->syncPermissions($permissions);

        return redirect()
            ->route('roles.index')
            ->with('message', 'Role created successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()
            ->route('roles.index')
            ->with('message', 'Role deleted successfully');
    }
}
