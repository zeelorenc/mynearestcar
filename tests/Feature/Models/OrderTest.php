<?php

namespace Tests\Feature\Models;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Tests\Traits\StripeMockable;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    use StripeMockable;

    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_calculate_security_deposit(): void
   {
        $order = Order::factory()->create(['total' => 100]);
        $expectedDeposit = $order->grand_total * Order::SECURITY_DEPOSIT_PERCENT / 100;
        $this->assertEquals($expectedDeposit, $order->security_deposit);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_refund_security_deposit_only_once(): void
    {
        $this->requireStripeToBeConfigured();
        $order = Order::factory()->create([
            'total' => 100,
            'from_date' => now(),
            'to_date' => now(),
        ]);
        $this->post(route('api.order.payment', $order->id), [
            'stripe' => $this->mockStripeCardToken(),
        ]);
        $refund = $order->refresh()->refund();

        $this->assertNotNull($refund);
        $this->assertEquals($order->security_deposit, $refund['amount'] / 100);
        $this->assertNotNull($order->stripe_refund_id);
        $this->assertNull($order->refresh()->refund());
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_refund_unused_rental_period(): void
    {
        $this->requireStripeToBeConfigured();
        $order = Order::factory()->create([
            'from_date' => now(),
            'to_date' => now()->addDays(10),
        ]);
        $this->post(route('api.order.payment', $order->id), [
            'stripe' => $this->mockStripeCardToken(),
        ]);
        $refund = $order->refresh()->refund();

        $this->assertNotNull($refund);
        $this->assertGreaterThan($order->security_deposit, $refund['amount'] / 100);
        $this->assertNotNull($order->stripe_refund_id);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_not_refund_elapsed_due_rentals(): void
    {
        $this->requireStripeToBeConfigured();
        $order = Order::factory()->create([
            'from_date' => now()->subDay(),
            'to_date' => now()->subDays(2),
        ]);
        $this->post(route('api.order.payment', $order->id), [
            'stripe' => $this->mockStripeCardToken(),
        ]);
        $this->assertNull($order->refresh()->refund());
    }
}
