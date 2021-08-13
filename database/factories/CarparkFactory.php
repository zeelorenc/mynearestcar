<?php

namespace Database\Factories;

use App\Models\Carpark;
use Faker\Provider\en_AU\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarparkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Carpark::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new Address($this->faker));
        return [
            'name' => "{$this->faker->streetName} Carpark",
            'lat' => $this->faker->longitude(-37.73, -37.84),
            'lng' => $this->faker->latitude(144.70, 145.14),
        ];
    }
}
