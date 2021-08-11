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
            'lat' => $this->randomBetween(-37.7, -37.8),
            'lng' => $this->randomBetween(144.7, 145.1),
        ];
    }

    /**
     * Random between two numbers
     *
     * @param float $min
     * @param float $max
     * @return float
     */
    private function randomBetween(float $min, float $max): float
    {
        return ($min + ($max - $min) * (mt_rand() / mt_getrandmax()));
    }
}
