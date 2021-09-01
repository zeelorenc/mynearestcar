<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\User;
use App\Models\Vehicle;
use App\Schemas\VehicleStatusSchema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function it_can_search_for_a_vehicle(): void
    {
        $this->actingAsAdmin();
        $order = Order::factory()->create();

        $response = $this->post(route('admin.order.search'), [
            'vehicle_id' => $order->vehicle_id,
        ]);
        $searchedOrder = optional($response->viewData('orders'))->first();

        $response->assertViewIs('admin.order.search');
        $this->assertEquals($order->user_id, $searchedOrder->user_id);
        $this->assertEquals($order->id, $searchedOrder->id);
        $this->assertEquals($order->vehicle_id, $searchedOrder->vehicle_id);
        $this->assertEquals($order->vehicle_id, $searchedOrder->vehicle_id);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_mark_a_returned_vehicle_as_available(): void
    {
        $this->actingAsAdmin();
        $vehicle = Vehicle::factory()->create(['status' => VehicleStatusSchema::RETURNED]);
        $order = Order::factory()->for($vehicle)->create();

        $this->put(route('admin.order.update', $order->id));

        $this->assertEquals(VehicleStatusSchema::AVAILABLE, $order->vehicle->status);
    }

    /**
     * Act as an admin in the request
     *
     * @return Model
     */
    private function actingAsAdmin(): Model
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        return $admin;
    }
}
