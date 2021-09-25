<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /** @var User $currentUser */
    protected $currentUser;

    /**
     * Create and act as the user in the application
     *
     * @param array $attributes
     * @return void
     */
    protected function actingAsUser(array $attributes = []): void
    {
        $this->currentUser = User::factory()->create($attributes);
        $this->actingAs($this->currentUser);
    }
}
