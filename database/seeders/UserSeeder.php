<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create default admin and client account
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make(UserFactory::DEFAULT_PASSWORD),
            'remember_token' => Str::random(10),
        ]);
        User::create([
            'name' => 'Client',
            'email' => 'client@example.com',
            'role' => 'client',
            'driver_licence' => '12-34-5678',
            'email_verified_at' => now(),
            'password' => Hash::make(UserFactory::DEFAULT_PASSWORD),
            'remember_token' => Str::random(10),
        ]);

        // create random users
        User::factory(6)
            ->create();
    }
}
