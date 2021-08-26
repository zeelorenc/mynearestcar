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
}