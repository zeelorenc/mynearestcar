<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AdminChangePassword;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    public function index(User $user)
    {
        return view('admin.profile.index')
            ->with('user', $user);
    }

    public function edit(User $user)
    {
        return view('admin.profile.edit')
            ->with('user', $user);
    }

    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $user->name = $request->get('name');
        $user->email = $request->get('email') ?: $user->email;
        $user->save();

        return back()->with('message', 'Changed profile successfully!');
    }

    //PUT admin.profile.password
    public function password(User $user, Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->password = Hash::make($request->get('password'));
        $user->save();

        Mail::send(new AdminChangePassword($user));

        return back()->with('message', 'Changed password successfully!');
    }
}
