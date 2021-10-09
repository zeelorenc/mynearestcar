<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Order;
use App\Schemas\OrderStatusSchema;
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
        $order = Order::factory()->create();
        $this->get(route('order.show', $order->id))
            ->assertViewIs('order.show');
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

    /** @test */
    public function it_can_take_the_user_to_the_current_order_page(): void
    {
        $order = Order::factory()->create([
            'user_id' => $this->currentUser->id,
            'status' => OrderStatusSchema::PAID,
        ]);

        $response = $this->get(route('order.current'));
        $response->assertViewIs('order.show');
        $response->assertSeeText("Rental Booking Order #{$order->id}");
    }
}
