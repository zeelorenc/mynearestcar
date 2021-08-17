<?php

namespace Tests\Feature\Http\Controllers;

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
    public function it_can_create_a_carpark()
    {
        $carpark = Carpark::create([
            'name' => 'Some Carpark Name',
            'lat' => 0.0,
            'lng' => 0.0,
        ]);
        $this->assertEquals('Some Carpark Name', $carpark->name);
    }
}
