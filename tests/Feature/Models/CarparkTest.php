<?php

namespace Tests\Feature\Models;

use App\Models\Carpark;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CarparkTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function it_can_get_nearest_vehicles_to_carpark_given_coordinates(): void
    {
        $carparks = Carpark::factory()
            ->hasVehicles(5)
            ->count(10)
            ->create();
    }
}
