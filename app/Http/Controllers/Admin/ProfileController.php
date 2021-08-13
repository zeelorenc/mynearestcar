<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
}
