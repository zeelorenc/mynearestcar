<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create and act as the user in the application
     *
     * @param array $attributes
     * @return void
     */
    protected function actingAsUser(array $attributes = []): void
    {
        $user = User::factory()->create($attributes);
        $this->actingAs($user);
    }
}
