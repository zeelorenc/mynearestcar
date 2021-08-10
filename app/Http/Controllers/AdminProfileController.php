<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminProfileController extends Controller
{
    public function index()
    {
        return view('admin.profile.index');
    }

    public function edit()
    {
        return view('admin.profile.edit')
            ->with('user', auth()->user());
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
