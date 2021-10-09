<?php

namespace App\Http\Controllers\Api;

use App\Adapters\StripeAdapter;
use App\Http\Requests\CreateOrderRequest;
use App\Mail\OrderInvoice;
use App\Models\Order;
use App\Models\OrderUber;
use App\Models\Vehicle;
use App\Schemas\OrderStatusSchema;
use App\Schemas\VehicleStatusSchema;
use Carbon\Carbon;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class OrderController extends \Illuminate\Routing\Controller
{
    use ValidatesRequests;

    /**
     * Create an order via API
     *
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(CreateOrderRequest $request)
    {
        $fromDate = Carbon::parse($request->get('from_date'));
        $toDate = Carbon::parse($request->get('to_date'));

        $vehicle = Vehicle::find($request->get('vehicle_id'));
        $rentalDays = $fromDate->floatDiffInDays($toDate);

        $order = Order::create([
            'user_id' => $request->get('user_id'), // @todo change to use middleware/bearer
            'vehicle_id' => $vehicle->id,
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'uber_pickup' => $request->get('uber_pickup'),
            'total' => $vehicle->price * $rentalDays,
            'status' => OrderStatusSchema::UNPAID,
            'user_location' => $request->get('user_location'),
        ]);
        if ($request->get('uber_pickup') === true) {
            $order->uber()->create([
                'route_data' => $request->get('uber_route'),
            ]);
        }
        return $order;
    }

    /**
     * Charge a payment token from stripe
     *
     * @param Order $order
     */
    public function payment(Order $order, Request $request)
    {
        $charge = StripeAdapter::make()
            ->customer([
                'email' => $order->user->email,
                'source' => Arr::get($request->get('stripe'), 'id'),
            ])
            ->charge($order->grand_total + $order->security_deposit, "Rental Order {$order->id}");
        if ($charge['status'] !== 'succeeded') {
            return ['success' => false, 'message' => 'Payment failed'];
        }

        $order->update([
            'status' => OrderStatusSchema::PAID,
            'stripe_charge_id' => $charge['id'],
        ]);
        $order->vehicle()->update([
            'status' => VehicleStatusSchema::BOOKED,
        ]);

        Mail::send(new OrderInvoice($order));

        return ['success' => true, 'message' => $order];
    }
}
