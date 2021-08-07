<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use App\Models\User;

class AdminControllerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Session::start();
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_redirect_to_admin_when_logging_in_as_admin()
    {
        $user = User::factory()->create(['role' => 'admin']);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'admin_redirect' => 'yes',
            '_token' => csrf_token(),
        ]);

        $response->assertRedirect(route('admin.index'));
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_redirect_to_back_when_logging_into_admin_as_guest()
    {
        $user = User::factory()->create(['role' => 'client']);
        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
            'admin_redirect' => 'yes',
            '_token' => csrf_token(),
        ]);

        $response->assertRedirect(route('home'));
    }
}
