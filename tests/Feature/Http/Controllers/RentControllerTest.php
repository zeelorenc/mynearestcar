<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Carpark;
use App\Models\User;
use App\Schemas\VehicleStatusSchema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->mockUser();
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_render_the_index_page()
    {
        $response = $this->get(route('rent.index'));
        $response->assertViewIs('rent');
    }

    private function mockUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }
}
