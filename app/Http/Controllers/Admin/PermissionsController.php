<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth:admin', 'permission:View Permissions'])->only(['index', 'show']);
    //     $this->middleware(['auth:admin', 'permission:Create Permissions'])->only(['create', 'store']);
    //     $this->middleware(['auth:admin', 'permission:Edit Permissions'])->only(['edit', 'update']);
    //     $this->middleware(['auth:admin', 'permission:Delete Permissions'])->only(['destroy']);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::latest()->get();
        return view('admin.permissions.index', with([
            'permissions' => $permissions,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('admin.permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // $request->validate([
        //     'pName' => 'required|unique:permissions,name,'
        // ]);

        // Permission::create([
        //     'name' => $request->input('pName'),
        //     'guard_name' => 'admin',
        // ]);

        // return redirect()
        // ->route('permissions.index')
        // ->with('message', 'Permission created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
        // return view('admin.permissions.edit', [
        //     'permission' => $permission
        // ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        // $request->validate([
        //     'pName' => 'required|unique:permissions,name,'.$permission->id,
        // ]);

        // $permission->update([
        //     'name' => $request->input('pName'),
        // ]);

        // return redirect()
        // ->route('permissions.index')
        // ->with('message', 'Permission updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        // $permission->delete();

        // return redirect()
        // ->route('permissions.index')
        // ->with('message', 'Permission deleted successfully.');
    }
}
