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

    public function update()
    {
        // @todo handle form submission
    }
}
