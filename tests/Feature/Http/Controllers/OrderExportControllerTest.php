<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderExportControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsUser();
    }

    /** @test */
    public function it_can_download_a_file(): void
    {
        Order::factory()->create(['user_id' => $this->currentUser->id]);
        $this->get(route('order.export'))
            ->assertDownload('orders-' . date('Y-m-d-His') . '.csv');
    }

    /** @test */
    public function it_can_not_download_without_some_orders(): void
    {
        $this->get(route('order.export'))
            ->assertUnprocessable();
    }

    /** @test */
    public function it_can_show_many_orders_in_the_csv_file(): void
    {
        $orders = Order::factory()->count(10)->create(['user_id' => $this->currentUser->id]);
        $response = $this->get(route('order.export'));

        $lines = collect(explode("\n", $response->streamedContent()))->filter();
        $this->assertEquals($orders->count() + 1, $lines->count());
    }
}
