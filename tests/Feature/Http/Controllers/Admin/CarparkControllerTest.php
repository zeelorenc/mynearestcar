<?php

namespace Tests\Feature\Admin;

use App\Models\Carpark;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarparkControllerTest extends TestCase
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
    public function it_can_render_the_carpark_index_view(): void
    {
        $response = $this->get(route('admin.carpark.index'));
        $response->assertViewIs('admin.carpark.index');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_render_the_carpark_create_view(): void
    {
        $response = $this->get(route('admin.carpark.create'));
        $response->assertViewIs('admin.carpark.create');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_create_a_carpark(): void
    {
        $this->post(route('admin.carpark.store'), [
            'name' => 'Example Carpark',
            'latitude' => 0.0,
            'longitude' => 0.0,
        ]);

        $this->assertNotNull(Carpark::first());
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
