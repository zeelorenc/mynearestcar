<?php

namespace Tests\Feature\Http\Requests;

use App\Http\Requests\CreateOrderRequest;
use App\Models\Carpark;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class CreateOrderRequestTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();

        Route::post('/test', function (CreateOrderRequest $request) {
            return $request->all();
        });
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_validate_encoded_uber_route_data()
    {
        $this->post('/test', $this->withDefaultRequestParameters([
            'uber_pickup' => true,
            'uber_route' => ['test_data' => 'hello'],
        ]))->assertStatus(JsonResponse::HTTP_OK);

        $this->post('/test', $this->withDefaultRequestParameters([
            'uber_pickup' => true,
            'uber_route' => 'This Is Bad Data',
        ]))->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_require_an_uber_route_if_uber_is_enabled(): void
    {
        $postData = $this->withDefaultRequestParameters(['uber_pickup' => true]);
        unset($postData['uber_route']);

        $this->post('/test', $postData)->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param array $data
     * @return array
     */
    public function withDefaultRequestParameters(array $data): array
    {
        $carpark = Carpark::factory()->create();
        $vehicle = Vehicle::factory()->create(['carpark_id' => $carpark->id]);
        return array_merge([
            'user_id' => User::factory()->create()->id,
            'vehicle_id' => $vehicle->id,
            'from_date' => Carbon::now(),
            'to_date' => Carbon::now()->addDay(),
            'uber_pickup' => false,
            'uber_route' => '',
            'total' => 100.00,
            'user_location' => [
                'lat' => 10.0,
                'lng' => 20.0,
            ],
        ], $data);
    }
}
