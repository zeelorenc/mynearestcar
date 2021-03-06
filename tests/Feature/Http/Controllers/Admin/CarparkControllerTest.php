<?php

namespace Tests\Feature\Admin;

use App\Models\Carpark;
use App\Models\User;
use App\Models\Vehicle;
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

    /** @test */
    public function it_can_delete_a_carpark(): void
    {
        $carpark = Carpark::factory()->create();
        Vehicle::factory()->create(['carpark_id' => $carpark->id]);

        $this->delete(route('admin.carpark.destroy', $carpark->id));

        $this->assertNull(Carpark::find($carpark->id));
        $this->assertEmpty(Vehicle::all());
    }

    /** @test */
    public function it_can_edit_a_carpark(): void
    {
        $carpark = Carpark::factory()->create();

        $this->put(route('admin.carpark.update', $carpark->id), [
            'name' => 'Changed Name',
            'latitude' => 1,
            'longitude' => 1,
        ]);
        $carpark->refresh();

        $this->assertEquals('Changed Name', $carpark->name);
        $this->assertEquals(1, $carpark->lat);
        $this->assertEquals(1, $carpark->lng);
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
