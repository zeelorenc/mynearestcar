<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

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
        User::factory(10)
            ->create();
    }
}
