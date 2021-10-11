<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Carpark;
use App\Models\User;
use App\Models\Vehicle;
use App\Schemas\VehicleStatusSchema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VehicleControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->mockAdminUser();
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_render_the_vehicle_index_view(): void
    {
        $response = $this->get(route('admin.vehicle.index'));
        $response->assertViewIs('admin.vehicle.index');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_render_the_vehicle_create_view(): void
    {
        $response = $this->get(route('admin.vehicle.create'));
        $response->assertViewIs('admin.vehicle.create');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_create_a_vehicle(): void
    {
        $carpark = Carpark::factory()->create();

        $this->post(route('admin.vehicle.store'), [
            'name' => 'Vehicle Name',
            'carpark_id' => $carpark->id,
            'status' => VehicleStatusSchema::AVAILABLE,
            'price' => 99.99,
            'seats' => 1,
        ]);

        $vehicle = Vehicle::first();
        $this->assertEquals('Vehicle Name', $vehicle->name);
        $this->assertEquals($carpark->id, $vehicle->carpark->id);
        $this->assertEquals(VehicleStatusSchema::AVAILABLE, $vehicle->status);
        $this->assertEquals(99.99, $vehicle->price);
        $this->assertEquals(1, $vehicle->seats);
    }

    /**
     * @test
     *
     * @void
     */
    public function it_throws_validation_errors_when_creating_a_vehicle(): void
    {
        $badVehicleData = [
            'name' => '',
            'carpark_id' => 0,
            'status' => 'bad status',
            'price' => -1,
            'seats' => -1,
        ];
        $response = $this->post(route('admin.vehicle.store'), $badVehicleData);
        $response->assertSessionHasErrors(array_keys($badVehicleData));
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_update_an_existing_vehicle(): void
    {
        $carpark = Carpark::factory()->create();
        $vehicle = Vehicle::factory()->create(['carpark_id' => $carpark->id]);

        $response = $this->put(route('admin.vehicle.update', [$vehicle->id]), [
            'name' => 'Updated Vehicle Name',
            'status' => VehicleStatusSchema::AVAILABLE,
            'price' => 100,
            'seats' => 3,
            'carpark_id' => $carpark->id,
        ]);
        $vehicle->refresh();

        $response->assertSessionHasNoErrors();
        $this->assertEquals('Updated Vehicle Name', $vehicle->name);
        // @todo assert other attributes
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_will_not_update_a_vehicle_with_invalid_attributes(): void
    {
        $carpark = Carpark::factory()->create();
        $vehicle = Vehicle::factory()->create(['carpark_id' => $carpark->id]);

        $response = $this->put(route('admin.vehicle.update', [$vehicle->id]));
        $response->assertSessionHasErrors([
            'name',
            'status',
            'price',
            'seats',
            'carpark_id',
        ]);
    }

    /**
     * Mocks an admin user and logs in as one
     *
     * @return void
     */
    private function mockAdminUser(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
    }
}
