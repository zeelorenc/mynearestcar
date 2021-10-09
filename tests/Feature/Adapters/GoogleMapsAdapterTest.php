<?php

namespace Tests\Feature\Adapters;

use App\Adapters\GoogleMapsAdapter;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Carpark;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class GoogleMapsAdapterTest extends TestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        if (empty(config('services.google.key'))) {
            $this->markTestSkipped('Skipping test as Google key is unavailable');
        }
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_return_the_location_of_a_coordinate(): void
    {
        $location = GoogleMapsAdapter::make(-33.86820, 151.1945860)
            ->search();

        $this->assertEquals('Sydney', Arr::get($location, 'name'));
        $this->assertEquals('Sydney', Arr::get($location, 'vicinity'));
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_return_the_details_of_the_location(): void
    {
        $location = GoogleMapsAdapter::make(-33.86820, 151.1945860)
            ->searchWithDetails();

        $this->assertEquals('Sydney NSW, Australia', Arr::get($location, 'details.formatted_address'));
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_will_return_empty_if_location_is_invalid(): void
    {
        $location = GoogleMapsAdapter::make(-203123.0, -1239013.0)
            ->search();
        $this->assertEmpty($location);

        $location = GoogleMapsAdapter::make(null, null)
            ->search();
        $this->assertEmpty($location);
    }
}
