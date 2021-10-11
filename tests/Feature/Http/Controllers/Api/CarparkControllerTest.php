<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Models\Carpark;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
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

    /** @test */
    public function it_can_get_the_nearest_filtered_car(): void
    {
        $carparkOne = Carpark::factory()->create(['lat' => 0, 'lng' => 20]);
        Vehicle::factory()->count(3)->create([
            'carpark_id' => $carparkOne->id,
            'model' => 'Ferrari',
        ]);

        $carparkTwo = Carpark::factory()->create(['lat' => 10, 'lng' => 0]);
        Vehicle::factory()->count(3)->create([
            'carpark_id' => $carparkTwo->id,
            'model' => 'Mercedes',
        ]);

        $carparks = $this->post(route('api.carparks.filter'), [
            'lat' => 0.0,
            'lng' => 0.0,
            'vehicle_model' => 'Ferrari'
        ])->json();
        $this->assertCount(1, $carparks);
        $this->assertEquals($carparkOne->id, Arr::get($carparks, '0.id'));

        $carparks = $this->post(route('api.carparks.filter'), [
            'lat' => 0.0,
            'lng' => 0.0,
            'vehicle_model' => 'Mercedes'
        ])->json();
        $this->assertCount(1, $carparks);
        $this->assertEquals($carparkTwo->id, Arr::get($carparks, '0.id'));

        $carparks = $this->post(route('api.carparks.filter'))->json();
        $this->assertCount(2, $carparks);
    }
}
