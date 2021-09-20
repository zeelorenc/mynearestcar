<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
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
        $orders = new Order();

        if ($request->has('user_id')) {
            $orders = $orders->where('user_id', $request->get('user_id'));
        }

        $orders = $orders
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.user.search')
            ->with('orders', $orders);
    }


    public function update()
    {

    }

    public function edit()
    {
        // @todo create edit page and handling
    }

    public function store()
    {
        //
    }
}
