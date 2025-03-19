<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Review;
use App\Models\ReviewToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth:admin', 'permission:View Admins'])->only(['index', 'show']);
    //     $this->middleware(['auth:admin', 'permission:Create Admins'])->only(['create', 'store']);
    //     $this->middleware(['auth:admin', 'permission:Edit Admins'])->only(['edit', 'update']);
    //     $this->middleware(['auth:admin', 'permission:Delete Admins'])->only(['destroy']);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::latest()->get();
        return view('admin.admins.index', with([
            'admins' => $admins,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.admins.create', [
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'user_name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'admin' => 'nullable|integer',
            'staff' => 'nullable|integer',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'role' => 'required|array',
            'role.*' => 'exists:roles,name',
        ]);

        $isAdmin = $request->has('admin') ? 1 : 0;
        $isStaff = $request->has('staff') ? 1 : 0;

        try {
            DB::beginTransaction();

            // Logic for saving admin data
            $createAdmin = Admin::create([
                'username' => $request->user_name,
                'name' => $request->first_name,
                'email' => $request->email,
                'is_admin' => $isAdmin,
                'is_staff' => $isStaff,
                'password' => Hash::make($request->password)  // Ensure the password is hashed properly
            ]);

            if (!$createAdmin) {
                DB::rollBack();
                return back()->with('error', 'Something went wrong while saving user data');
            }

            $roles = $request->get('role');
            $createAdmin->assignRole($roles);

            DB::commit();
            return redirect()->route('admins.index')->with('message', 'Admin Created Successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'An error occurred: ' . $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $admin = Admin::with('roles')->where('id', $id)->first();
        // dd($admin);

        return view('admin.admins.show')->with([
            'admin' => $admin
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $admin = Admin::find($id);
        $roleName = $admin->getRoleNames()->all();
        $roles = Role::get();

        if (!$admin) {
            return back()->with('error', 'admins Not Found');
        }

        return view('admin.admins.edit')->with([
            'admin' => $admin,
            'roles' => $roles,
            'roleName' => $roleName,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'first_name' => '',
            'user_name' => '',
            'email' => 'email|unique:admins,email,' . $admin->id,
            'admin' => 'nullable|integer',
            'staff' => 'nullable|integer',
            'password' => 'nullable|min:6|confirmed',
            'password_confirmation' => 'nullable|same:password',
            'role' => 'required|array',
            'role.*' => 'exists:roles,name',
        ]);

        $isAdmin = $request->has('admin') ? 1 : 0;
        $isStaff = $request->has('staff') ? 1 : 0;

        try {
            DB::beginTransaction();

            if ($admin) {
                if ($request->password) {
                    $hashedPassword = Hash::make($request->password);
                    $admin->password = $hashedPassword;
                }
                if ($request->username) {
                    $username = $request->username;
                    $admin->username = $username;
                }
                if ($request->first_name) {
                    $first_name = $request->first_name;
                    $admin->name = $first_name;
                }
                if ($request->email) {
                    $email = $request->email;
                    $admin->email = $email;
                }
                if ($isAdmin) {
                    $isAdmin = $isAdmin;
                    $admin->is_admin = $isAdmin;
                }
                if ($isStaff) {
                    $isStaff = $isStaff;
                    $admin->is_staff = $isStaff;
                }
                $admin->save();
            }

            $roles = $request->get('role');
            $admin->assignRole($roles);

            DB::commit();
            return redirect()->route('admins.index')->with('message', 'Admin Created Successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'An error occurred: ' . $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $deleteAdmin = Admin::whereId($id)->delete();

            if (!$deleteAdmin) {
                DB::rollBack();
                return back()->with('error', 'There is an error while deleting user.');
            }

            DB::commit();
            return redirect()->route('admins.index')->with('message', 'User Deleted successfully.');
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function generateToken()
    {
        $token = Str::uuid();
        $url = url('/review/create?token=' . $token);

        $reviewToken = ReviewToken::create([
            'token' => $token,
            'url' => $url,
            'expires_at' => now()->addMonths(6),
        ]);

        return redirect()
            ->route('review_tokens.index')
            ->with([
                'message' => 'Token generated successfully!',
                'token' => $reviewToken->token,
                'url' => $reviewToken->url
            ]);
    }
}
