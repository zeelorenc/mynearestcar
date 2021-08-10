<?php

namespace Tests\Feature\Providers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function it_can_add_authenticated_user_model_to_all_views(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('home'));

        $response->assertViewHas('currentUser', $user);
        $response->assertViewHas('loggedIn', true);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_add_null_user_model_to_all_views_as_guest(): void
    {
        $response = $this->followingRedirects()->get(route('home'));

        $response->assertViewHas('currentUser', null);
        $response->assertViewHas('loggedIn', false);
    }
}
