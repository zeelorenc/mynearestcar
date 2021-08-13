<?php

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function it_can_render_the_user_profile_view(): void
    {
        $admin = $this->actingAsAdmin();
        // @todo assert it can see the user profile
        $this->assertTrue(true);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_render_the_user_edit_view(): void
    {
        $admin = $this->actingAsAdmin();
        $user = User::factory()->create();
        $response = $this->get(route('admin.profile.edit', $user->id));
        $response->assertViewIs('admin.profile.edit');
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_allow_admin_to_update_user_profile_with_new_name(): void
    {
        $expectedUserProfile = [
            'name' => 'John Doe',
        ];
        $this->actingAsAdmin();
        $user = User::factory()->create();

        $this->put(route('admin.profile.update', $user->id), $expectedUserProfile);

        $this->assertEquals($expectedUserProfile, $user->refresh()->only(array_keys($expectedUserProfile)));
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_allow_admin_to_update_user_profile_with_email(): void
    {
        $expectedUserProfile = [
            'name' => 'John Doe',
            'email' => 'john@rmit.edu.au'
        ];
        $this->actingAsAdmin();

        $user = User::factory()->create();
        $this->put(route('admin.profile.update', $user->id), $expectedUserProfile);

        $this->assertEquals($expectedUserProfile, $user->refresh()->only(array_keys($expectedUserProfile)));
    }

    /**
     * @test
     * @dataProvider provideInvalidUserProfileData
     *
     * @param $userProfileData
     * @param $expectedSessionErrors
     * @return void
     */
    public function it_displays_validation_error_for_invalid_profile_fields(
        $userProfileData,
        $expectedSessionErrors
    ): void {
        $this->actingAsAdmin();
        $user = User::factory()->create();

        $response = $this->put(route('admin.profile.update', $user->id), $userProfileData);

        $response->assertSessionHasErrors($expectedSessionErrors);
    }

    /**
     * @test
     *
     * @return void
     */
    public function it_can_show_email_and_name_on_the_profile_page_for_an_admin(): void
    {
        $admin = $this->actingAsAdmin();

        $response = $this->get(route('admin.profile.index', $admin->id));

        $response->assertSeeText($admin->email);
        $response->assertSeeText($admin->name);
    }

    /**
     * Provides invalid user profile input data
     *
     * @return array[]
     */
    public function provideInvalidUserProfileData(): array
    {
        return [
            'invalid email' => [
                'input' => [
                    'name' => 'Lorenc P',
                    'email' => 'Bad Email',
                ],
                'expected' => ['email']
            ],
            'invalid name' => [
                'input' => [
                    'name' => '',
                    'email' => 'john@example.com',
                ],
                'expected' => ['name'],
            ],
            'both invalid name and invalid email' => [
                'input' => [
                    'name' => '',
                    'email' => 'bad email',
                ],
                'expected' => ['name', 'email'],
            ],
        ];
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
