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
//        User::create([
//            'name' => 'Test User',
//            'email' => 'test@test.com',
//            'password' => Hash::make('test'),
//        ]);
        User::create([
            'name' => 'admin',
            'email' => 'admin@staff.mynearestcar.com',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => Hash::make(UserFactory::DEFAULT_PASSWORD),
            'remember_token' => Str::random(10),
        ]);
        User::factory(10)
            ->create();
    }
}
