<?php

namespace Database\Factories;

use App\Models\User;
use Faker\Core\Number;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Default password of a factory user
     *
     * @var string
     */
    public const DEFAULT_PASSWORD = 'test';

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $role = collect(['client', 'admin'])->random();
        $str = str_pad(mt_rand(1,99999999),8,'0',STR_PAD_LEFT);
        $str = substr_replace($str, '-', 2, 0);
        $str = substr_replace($str, '-', 5, 0);

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'role' => $role,
            'driver_licence' => $role === 'client' ? $str : '',
            'email_verified_at' => now(),
            'password' => Hash::make(self::DEFAULT_PASSWORD),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
