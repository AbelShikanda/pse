<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

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

        return view('admin.users.show')->with([
            'user' => $user,
        ]);
    }
}
