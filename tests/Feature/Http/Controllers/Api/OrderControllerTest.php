<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Adapters\StripeAdapter;
use App\Models\Carpark;
use App\Models\Order;
use App\Models\User;
use App\Models\Vehicle;
use App\Schemas\OrderStatusSchema;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @var User */
    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->actingAs($this->user = User::factory()->create());
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_create_an_order(): void
    {
        $carpark = Carpark::factory()->create();
        $vehicle = Vehicle::factory()->create(['carpark_id' => $carpark->id]);

        $this->post(route('api.order.create'), [
            'user_id' => $this->user->id, // @todo change to use middleware/bearer
            'vehicle_id' => $vehicle->id,
            'from_date' => Carbon::now(),
            'to_date' => Carbon::now()->addDay(),
            'uber_pickup' => false,
            'total' => 100.00,
        ]);

        $this->assertNotNull(Order::first());
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_cannot_create_an_order_without_valid_fields(): void
    {
        $response = $this->post(route('api.order.create'), [
            'vehicle_id' => 999,
            'from_date' => 'bad_date',
            'to_date' => 1233123,
            'uber_pickup' => 'false',
        ]);

        $response->assertSessionHasErrors([
            'vehicle_id',
            'from_date',
            'to_date',
            'uber_pickup',
        ]);
    }

    /**
     * @test
     *
     * @return
     */
    public function it_can_charge_a_stripe_token_and_mark_order_as_paid(): void
    {
        if (empty(config('services.stripe.secret'))) {
            $this->markTestSkipped('Skipping test as Stripe secret key is unavailable');
        }

        $carpark = Carpark::factory()->create();
        $vehicle = Vehicle::factory()->create(['carpark_id' => $carpark->id]);
        $order = $this->mockOrder($vehicle);

        $response = $this->post(route('api.order.payment', $order->id), [
            'stripe' => $this->mockStripeCardToken(),
        ]);

        $this->assertTrue($response->json('success'));
        $this->assertEquals(OrderStatusSchema::PAID, $order->refresh()->status);
    }

    /**
     * @param Vehicle $vehicle
     * @return Order
     */
    private function mockOrder(Vehicle $vehicle): Order
    {
        return Order::create([
            'user_id' => $this->user->id,
            'vehicle_id' => $vehicle->id,
            'from_date' => Carbon::now(),
            'to_date' => Carbon::now()->addDay(),
            'uber_pickup' => false,
            'total' => 100.00,
            'status' => OrderStatusSchema::UNPAID,
        ]);
    }

    /**
     * Mock a stripe token
     *
     * @return array
     * @throws \Stripe\Exception\ApiErrorException
     */
    private function mockStripeCardToken(): array
    {
        return StripeAdapter::make()
            ->stripe()
            ->tokens->create([
                'card' => [
                    'number' => '4242424242424242',
                    'exp_month' => 8,
                    'exp_year' => 2022,
                    'cvc' => '314',
                ],
            ])
            ->toArray();
    }
}
