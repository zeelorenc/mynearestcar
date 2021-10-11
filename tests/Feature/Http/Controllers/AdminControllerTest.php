<?php

namespace Tests\Feature\Http\Controllers;

use App\Schemas\UserSchema;
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
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $response = $this->get(route('admin.index'));
        $response->assertViewIs('admin.home');
        $response->assertSeeText('Admin Dashboard');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_render_the_admin_login(): void
    {
        $response = $this->get(route('admin.login'));
        $response->assertViewIs('admin.auth.login');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_render_the_admin_register(): void
    {
        $response = $this->get(route('admin.register'));
        $response->assertViewIs('admin.auth.register');
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
    public function it_can_redirect_to_home_when_logging_as_guest(): void
    {
        $response = $this->postUserLogin(['role' => 'client']);
        $response->assertRedirect(route('home'));
    }

    /**
     * @test
     *
     * @return
     */
    public function it_can_register_an_admin_if_the_email_provided_matches_pattern()
    {
        $res = $this->post(route('register'), [
            'role' => UserSchema::ROLE_ADMIN,
            'name' => 'John Doe',
            'email' => 'admin' . UserSchema::ADMIN_EMAIL_PATTERN,
            'password' => 'cool-beans',
            'password_confirmation' => 'cool-beans',
        ]);
        $res->assertSessionHasNoErrors();
        $this->assertNotNull(User::first());
    }

    /**
     * @test
     *
     * @return
     */
    public function it_will_not_register_an_admin_if_the_email_provided_matches_pattern()
    {
        $res = $this->post(route('register'), [
            'role' => UserSchema::ROLE_ADMIN,
            'name' => 'John Doe',
            'email' => 'admin@bad.email.address',
            'password' => 'cool-beans',
            'password_confirmation' => 'cool-beans',
        ]);
        $res->assertSessionHasErrors('email');
        $this->assertNull(User::first());
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
