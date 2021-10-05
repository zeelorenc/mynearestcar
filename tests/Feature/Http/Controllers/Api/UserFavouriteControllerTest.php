<?php

namespace Tests\Feature\Http\Controllers\Api;

use App\Adapters\StripeAdapter;
use App\Mail\OrderInvoice;
use App\Models\Carpark;
use App\Models\Order;
use App\Models\User;
use App\Models\UserFavourite;
use App\Models\Vehicle;
use App\Schemas\OrderStatusSchema;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class UserFavouriteControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function it_can_show_all_the_user_favourite_vehicles(): void
    {
        [, $user] = User::factory()->count(2)->create();
        $favourites = UserFavourite::factory()->count(10)->create(['user_id' => $user->id]);

        $response = $this->get(route('api.favourite.vehicle.index', $user->id));
        $this->assertEquals($favourites->count(), count($response->json()));
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_add_a_favourite_for_a_vehicle(): void
    {
        $user = User::factory()->create();
        $vehicle = Vehicle::factory()->create();

        $this->post(route('api.favourite.vehicle.store', [$user->id, $vehicle->id]));
        $user->refresh();

        $this->assertNotEmpty($user->favourites);
        $this->assertEquals($user->favourites->first()->id, $vehicle->id);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_will_unfavourte_a_vehicle_if_attempting_to_favourite_again(): void
    {
        $favourite = UserFavourite::factory()->create();
        [$user, $vehicle] = [$favourite->user, $favourite->vehicle];

        $this->post(route('api.favourite.vehicle.store', [$user->id, $vehicle->id]));

        $this->assertEmpty($user->refresh()->favourites);
    }
}
