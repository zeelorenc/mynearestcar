<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsUser();
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_render_the_order_page(): void
    {
        // @todo create mock order then see if it loads page
        $this->assertTrue(true);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_render_the_history_page(): void
    {
        $this->get(route('order.history'))
            ->assertViewIs('order.history');
    }
}
