<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Carpark;
use App\Models\Order;
use App\Models\User;
use App\Models\Vehicle;
use App\Schemas\OrderStatusSchema;
use App\Schemas\VehicleStatusSchema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_search_for_a_vehicle(): void
    {
        $order = Order::factory()->create();

        $response = $this->get(route('admin.order.search'), [
            'query' => $order->vehicle->name,
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
        $vehicle = Vehicle::factory()->create(['status' => VehicleStatusSchema::RETURNED]);
        $order = Order::factory()->for($vehicle)->create(['status' => OrderStatusSchema::PAID]);

        $this->put(route('admin.order.update', $order->id));
        $order->refresh();

        $this->assertEquals(OrderStatusSchema::COMPLETED, $order->status);
        $this->assertEquals(VehicleStatusSchema::AVAILABLE, $order->vehicle->status);
    }

    /** @test */
    public function it_can_search_given_vehicle_or_user_names(): void
    {
        $userOne = User::factory()->create(['name' => 'John']);
        $userTwo = User::factory()->create(['name' => 'Mary']);

        $vehicleOne = Vehicle::factory()->create(['name' => 'Tesla Model A']);
        $vehicleTwo = Vehicle::factory()->create(['name' => 'Mercedes AMG GT']);
        $vehicleThree = Vehicle::factory()->create(['name' => 'Ferrari 458']);

        Order::factory()->create(['user_id' => $userTwo, 'vehicle_id' => $vehicleOne]);
        Order::factory()->create(['user_id' => $userOne, 'vehicle_id' => $vehicleTwo]);
        Order::factory()->create(['user_id' => $userOne, 'vehicle_id' => $vehicleThree]);

        $this->get(route('admin.order.search', ['query' => 'John']))
            ->assertSee(['Mercedes', 'Ferrari'])
            ->assertDontSee('Tesla');

        $this->get(route('admin.order.search', ['query' => 'Mary']))
            ->assertSee('Tesla')
            ->assertDontSee(['Mercedes', 'Ferrari']);

        $this->get(route('admin.order.search', ['query' => 'Ferrari']))
            ->assertSee('John');

        $this->get(route('admin.order.search', ['query' => 'Mercedes']))
            ->assertSee('John');

        $this->get(route('admin.order.search', ['query' => 'Tesla']))
            ->assertSee('Mary');
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
