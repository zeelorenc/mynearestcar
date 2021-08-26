<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Carpark;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarparkControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function it_can_show_carparks_as_json()
    {
        Carpark::factory()->count(10)->create();
        $carparks = $this->get(route('api.carparks.index'));
        $carparks->assertJsonCount(10);
    }

    /**
     * @test
     *
     * @return
     */
    public function it_can_get_nearest_carpark()
    {
        Carpark::factory()->create(['lat' => 0, 'lng' => 20]);
        Carpark::factory()->create(['lat' => 10, 'lng' => 0]);
        $closest = Carpark::factory()->create(['lat' => -5, 'lng' => 0]);

        $carpark = $this->post(route('api.carparks.nearest'), [
            'lat' => 0.0,
            'lng' => 0.0,
        ]);

        $this->assertEquals($closest->id, $carpark[0]['id']);
    }
}
