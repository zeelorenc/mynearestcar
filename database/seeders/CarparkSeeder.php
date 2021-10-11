<?php

namespace Database\Seeders;

use App\Models\Carpark;
use App\Models\Vehicle;
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
            ->create()
            ->each(function ($carpark) {
                $carpark->vehicles()
                    ->saveMany(
                         Vehicle::factory()
                            ->count(random_int(0, 5))
                            ->make()
                    );
            });
    }
}
