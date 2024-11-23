<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuthController extends Controller
{
    public function getLogin(){
        return view('admin.auth.login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if(auth()->guard('admin')->attempt(['email' => $request->input('email'),  'password' => $request->input('password')])){
            $user = auth()->guard('admin')->user();
            if(!$user->is_admin == 1){
                return redirect()->back()->with('error','You have to be an Admin');
            }else {
                return redirect()->route('dashboard.index')->with('success','You are Logged in sucessfully.');
            }
        }else {
            return redirect()->back()->with('error','Whoops! Invalid Credentials');
        }
    }

    public function adminLogout(Request $request)
    {
        auth()->guard('admin')->logout();
        // Session::flush();
        return redirect(route('getLogin'))->with('success', 'You are logout sucessfully');
    }
}
