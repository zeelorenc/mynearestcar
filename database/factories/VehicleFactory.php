<?php

namespace Database\Factories;

use App\Models\Vehicle;
use App\Schemas\VehicleStatusSchema;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vehicle::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => ucwords($this->faker->words(2, true)) . ' Car',
            'status' => VehicleStatusSchema::AVAILABLE,
            'price' => $this->faker->randomFloat(2, 10, 150),
            'seats' => $this->faker->randomFloat(0, 1, 6),
        ];
    }
}
