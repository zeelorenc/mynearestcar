<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function editProfile(Request $request)
    {
        $user = auth()->user();
        return view('user.edit_profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $data = $request->except(['_token', '_method']);
        if ( $data['email'] === null ) {
            unset($data['email']);
        }
        $user = User::where('id', auth()->user()->id)->update($data);

        $user = auth()->user();
        $user->name = $data['name'];
        $user->email = isset($data['email']) ? $data['email'] : $user->email;
        $user->save();

        return back()->with('message', 'Changed profile successfully!');
    }
}
