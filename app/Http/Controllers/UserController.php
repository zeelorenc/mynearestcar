<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function edit(Request $request)
    {
        $user = auth()->user();
        return view('user.edit_profile', compact('user'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $user = auth()->user();
        $user->name = $request->get('name');
        $user->email = $request->get('email') ?: $user->email;
        $user->save();

        return back()->with('message', 'Changed profile successfully!');
    }
}
