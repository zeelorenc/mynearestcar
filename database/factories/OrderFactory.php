<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Vehicle;
use App\Schemas\OrderStatusSchema;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $fromDate = Carbon::now()->addHours(random_int(1, 24))->addDays(random_int(0, 24));
        $toDate = Carbon::make($fromDate)->addHours(random_int(0, 24))->addDays(random_int(1, 24));
        return [
            'user_id' => User::factory(),
            'vehicle_id' => Vehicle::factory(),
            'from_date' => $fromDate,
            'to_date' => $toDate,
            'total' => -1,
            'status' => collect(OrderStatusSchema::all())->random(),
            'user_location' => [
                'lat' => $this->faker->longitude(-37.73, -37.84),
                'lng' => $this->faker->latitude(144.70, 145.14),
            ],
        ];
    }

    /**
     * Configure the factory.
     *
     * @return $this
     */
    public function configure(): self
    {
        return $this->afterCreating(function (Order $order) {
            if ($order->total === -1) {
                $rentalDays = $order->from_date->floatDiffInDays($order->to_date);
                $order->update([
                    'total' => $order->vehicle->price * $rentalDays,
                ]);
            }
        });
    }
}
