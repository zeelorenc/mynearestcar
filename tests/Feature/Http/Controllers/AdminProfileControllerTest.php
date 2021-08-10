<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminProfileControllerTest extends TestCase
{
    use RefreshDatabase;

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

        $response = $this->put(route('profile.update', $user->id), $userProfileData);

        $response->assertSessionHasErrors($expectedSessionErrors);
    }

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
     * @return void
     */
    private function actingAsAdmin(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
    }
}
