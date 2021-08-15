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
    public function it_can_create_a_vehicle_with_a_carpark()
    {
        $carpark = Carpark::factory()->create();
        $vehicle = $carpark
            ->vehicles()
            ->create([
                'name' => 'Mercedes Benz C43 AMG',
                'seats' => 2,
                'price' => 100.00,
                'status' => VehicleStatusSchema::AVAILABLE,
            ]);            

        $this->assertEquals('Mercedes Benz C43 AMG', $vehicle->name);
        $this->assertEquals(VehicleStatusSchema::AVAILABLE, $vehicle->status);
        $this->assertEquals(2, $vehicle->seats);
        $this->assertEquals(100.0, $vehicle->price);
        $this->assertEquals($carpark->id, $vehicle->carpark_id);
    }
}
