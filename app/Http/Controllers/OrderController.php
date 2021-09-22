<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Schemas\OrderStatusSchema;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function show(Order $order)
    {
        return view('order.show')
            ->with('order', $order);
    }

    public function history(Request $request)
    {
        $orders = new Order();

        if ($request->has('user_id')) {
            $orders = $orders->where('user_id', $request->get('user_id'));
        }

        $orders = $orders
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('order.history')
            ->with('orders', $orders);
    }
}
