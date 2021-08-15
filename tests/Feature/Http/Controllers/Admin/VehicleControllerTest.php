<?php

namespace Tests\Feature\Admin;

use App\Models\Carpark;
use App\Models\User;
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
        // @todo assert it can see the carpark index view
        $response = $this->get(route('admin.vehicle.create'));
        $response->assertViewIs('admin.vehicle.create');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_render_the_vehicle_create_view(): void
    {
        // @todo assert it can see the carpark index view
        $this->assertTrue(true);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_create_a_vehicle(): void
    {
        // @todo Create a test for creating the car
        $this->assertTrue(true);
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
