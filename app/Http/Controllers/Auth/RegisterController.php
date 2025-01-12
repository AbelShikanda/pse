<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\newAccount;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\-]+$/'],
            'last_name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\-]+$/'],
            'phone' => [
                'required', 'string', 'max:255',
                Rule::unique('users'),  // Check for uniqueness in the users table
                function ($attribute, $value, $fail) {
                    // Ensure the phone number does not exist in user_mirrors with change_type != 'delete'
                    $existing = DB::table('user_mirrors')
                        ->where('phone', $value)
                        ->where('change_type', '!=', 'delete')
                        ->count();
                    if ($existing > 0) {
                        $fail('The phone number is already taken.');
                    }
                }
            ],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users'),  // Check for uniqueness in the users table
                function ($attribute, $value, $fail) {
                    $existing = DB::table('user_mirrors')
                    ->where('email', $value)
                    ->where('change_type', '!=', 'delete')
                    ->count();
                    if ($existing > 0) {
                        $fail('The email is already taken.');
                    }
                }
            ],
            'town' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s\-]+$/'],
            'location' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z0-9\s\-]+$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'first_name.regex' => 'The first name may only contain letters, spaces, and hyphens.',
            'last_name.regex' => 'The last name may only contain letters, spaces, and hyphens.',
            'phone.regex' => 'The phone number must be a valid international number (e.g., +1234567890).',
            'town.regex' => 'The town may only contain letters, spaces, and hyphens.',
            'location.regex' => 'The location may only contain letters, numbers, spaces, and hyphens.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'town' => $data['town'],
            'location' => $data['location'],
            'password' => Hash::make($data['password']),
        ]);
        
        Mail::to('printshopeld@gmail.com')
        ->send(new newAccount($user));

        return $user;
    }
}
