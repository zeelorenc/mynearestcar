<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FavouritesController extends Controller
{
    public function index() {
        $user = User::find(auth()->user()->id);
        return view('favourites.index')
            ->with('user', $user);
    }
}
