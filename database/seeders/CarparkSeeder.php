<?php

namespace Database\Seeders;

use App\Models\Carpark;
use Illuminate\Database\Seeder;

class CarparkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Carpark::factory()
            ->count(10)
            ->create();
    }
}
