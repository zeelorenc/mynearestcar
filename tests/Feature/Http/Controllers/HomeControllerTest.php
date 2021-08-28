<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Carpark;
use App\Models\User;
use App\Schemas\VehicleStatusSchema;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
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
    public function it_can_render_the_home_page()
    {
        $response = $this->get(route('home'));
        $response->assertViewIs('home');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_render_the_contact_page()
    {
        $response = $this->get(route('contact'));
        $response->assertViewIs('contact');
    }

    private function mockUser()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
    }
}
