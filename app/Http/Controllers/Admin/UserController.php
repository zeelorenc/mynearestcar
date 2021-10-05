<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Schemas\OrderStatusSchema;
use App\Schemas\VehicleStatusSchema;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        //
    }

    public function search(Request $request)
    {
        $users = User::query();

        if (filled($query = $request->get('query'))) {
            $users = $users->where('name', 'like', "%{$query}%")
                ->orWhere('email', 'like', "%{$query}%");
        }

        $users = $users
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.user.search')
            ->with('users', $users);
    }

    public function update(Request $request)
    {

    }

    public function edit()
    {
        // @todo create edit page and handling
    }

    public function store(Request $request)
    {
        //
    }
}
