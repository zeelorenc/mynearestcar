<?php

namespace Tests\Feature;

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
}
