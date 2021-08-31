<?php

namespace Database\Factories;

use App\Models\Vehicle;
use App\Schemas\VehicleStatusSchema;
use Faker\Provider\Fakecar;
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
        $this->faker->addProvider(new Fakecar($this->faker));
        return [
            'name' => $this->faker->vehicle,
            'status' => VehicleStatusSchema::AVAILABLE,
            'price' => $this->faker->randomFloat(2, 10, 150),
            'seats' => $this->faker->vehicleSeatCount,
            'type' => $this->faker->vehicleType,
            'brand' => $this->faker->vehicleBrand,
            'model' => $this->faker->vehicleModel,
        ];
    }
}
