<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('updated_at', 'desc')->get();
        return view('admin.users.index', [
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::with([
            'order',
            'order.orderItems',
            'order.orderItems.products',
            'comments',
            'comments.blog',
            'ratings',
            'ratings.product',
        ])
            ->where('id', $id)
            ->first();
        // // dd($users);

        // $permissions = Permission::get();
        // $permissions = $users->getAllPermissions();
        // $user = $users->hasAnyPermission($permissions);
        // $user = $user->hasRole('Super Super user');

        // dd($user);

        return view('admin.users.show')->with([
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
