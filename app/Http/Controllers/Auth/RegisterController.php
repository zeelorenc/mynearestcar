<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Schemas\UserSchema;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    public function redirectTo()
    {
        if (auth()->user()->role === 'client') {
            return RouteServiceProvider::HOME;
        } else {
            return RouteServiceProvider::ADMIN_HOME;
        }
    }

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
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $role = $data['role'] ?? 'client';
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:2', 'confirmed'],
            'driver_licence' => [
                $role === 'client' ? 'required' : 'nullable',
                'string',
                'regex:/\d{2}-\d{2}-\d{4}/',
                'unique:users,driver_licence'
            ],
        ])->sometimes('email', 'prohibited', function ($input) {
            return $input->role === UserSchema::ROLE_ADMIN
                && !str_contains($input->email, UserSchema::ADMIN_EMAIL_PATTERN);
        });
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $role = $data['role'] ?? 'client';

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $role,
            'driver_licence' => $role === 'client' ? $data['driver_licence'] : '',
        ]);
    }
}
