<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(User $user)
    {
        return view('user.index')
            ->with('user', $user);
    }

    public function edit(Request $request)
    {
        $user = auth()->user();
        return view('user.edit_profile', compact('user'));
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

    public function password(User $user, Request $request)
    {
        $this->validate($request, [
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->password = Hash::make($request->get('password'));
        $user->save();

        return back()->with('message', 'Changed password successfully!');
    }
}
