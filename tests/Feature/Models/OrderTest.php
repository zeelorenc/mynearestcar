<?php

namespace Tests\Feature\Models;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

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
}
