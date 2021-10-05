<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Carpark;
use App\Models\Order;
use App\Models\User;
use App\Models\Vehicle;
use App\Schemas\OrderStatusSchema;
use App\Schemas\VehicleStatusSchema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAsAdmin();
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_search_for_a_user_by_name(): void
    {
        User::factory()->create(['name' => 'John']);
        User::factory()->create(['name' => 'Mary']);

        $this->get(route('admin.user.search', ['query' => 'John']))
            ->assertSee('John')
            ->assertDontSee('Mary');

        $this->get(route('admin.user.search', ['query' => 'Mary']))
            ->assertSee('Mary')
            ->assertDontSee('John');
    }

    /** @test */
    public function it_can_search_for_a_user_by_email(): void
    {
        User::factory()->create(['email' => 'john@example.com']);
        User::factory()->create(['email' => 'mary@example.com']);

        $this->get(route('admin.user.search', ['query' => 'john']))
            ->assertSee('john@example.com')
            ->assertDontSee('mary@example.com');

        $this->get(route('admin.user.search', ['query' => 'mary']))
            ->assertSee('mary@example.com')
            ->assertDontSee('john@example.com');
    }

    /**
     * Act as an admin in the request
     *
     * @return Model
     */
    private function actingAsAdmin(): Model
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        return $admin;
    }
}
