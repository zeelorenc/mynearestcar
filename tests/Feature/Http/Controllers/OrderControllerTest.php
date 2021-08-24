<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Carpark;
use App\Models\Order;
use App\Models\User;
use App\Models\Vehicle;
use App\Schemas\OrderStatusSchema;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function it_can_create_an_order()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $carpark = Carpark::factory()->create();
        $vehicle = Vehicle::factory()->create(['carpark_id' => $carpark->id]);

        $this->post(route('order.create'), [
            'vehicle_id' => $vehicle->id,
            'from_date' => Carbon::now(),
            'to_date' => Carbon::now()->addDay(),
            'uber_pickup' => false,
            'total' => 100.00,
        ]);

        $this->assertNotNull(Order::first());
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_cannot_create_an_order_without_valid_fields()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('order.create'), [
            'vehicle_id' => 999,
            'from_date' => 'bad_date',
            'to_date' => 1233123,
            'uber_pickup' => 'false',
        ]);

        $response->assertSessionHasErrors([
            'vehicle_id',
            'from_date',
            'to_date',
            'uber_pickup',
        ]);
    }
}
