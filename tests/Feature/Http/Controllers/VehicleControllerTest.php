<?php

namespace Tests\Feature;

use App\Models\Carpark;
use App\Schemas\VehicleStatusSchema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VehicleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function it_can_create_a_carpark_associated_vehicle()
    {
        $carpark = Carpark::factory()->create();
        $vehicle = $carpark->vehicles()->create([
            'name' => 'Mercedes Benz C43 AMG',
            'seats' => 2,
            'price' => 100.00,
            'status' => VehicleStatusSchema::AVAILABLE,
        ]);
        $this->assertEquals('Mercedes Benz C43 AMG', $vehicle->name);
        $this->assertEquals(VehicleStatusSchema::AVAILABLE, $vehicle->status);
        // @todo assert other attributes
    }
}
