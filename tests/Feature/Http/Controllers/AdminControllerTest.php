<?php

namespace Tests\Feature\Http\Controllers;

use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;
use App\Models\User;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

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
    public function it_can_render_the_admin_index(): void
    {
        // @todo assert it can see the admin login
        $this->assertTrue(true);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_render_the_admin_login(): void
    {
        // @todo assert it can see the admin login
        $this->assertTrue(true);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_redirect_to_admin_when_logging_in_as_admin(): void
    {
        $response = $this->postUserLogin(['role' => 'admin']);
        $response->assertRedirect(route('admin.index'));
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_redirect_to_home_when_logging_into_admin_as_guest(): void
    {
        $response = $this->postUserLogin(['role' => 'client']);
        $response->assertRedirect(route('home'));
    }

    /**
     * Perform a post to login using a particular user
     *
     * @param array $userAttributes
     * @return TestResponse
     */
    private function postUserLogin(array $userAttributes = []): TestResponse
    {
        $user = User::factory()->create($userAttributes);
        return $this->post('/login', [
            'email' => $user->email,
            'password' => UserFactory::DEFAULT_PASSWORD,
            'admin_redirect' => 'yes',
            '_token' => csrf_token(),
        ]);
    }
}
