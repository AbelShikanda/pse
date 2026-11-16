<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
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
}
