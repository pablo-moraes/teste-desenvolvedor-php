<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company(),
            'bar_code' => $this->faker->postcode(),
            'price' => $this->faker->numberBetween(10, 1500)
        ];
    }
}
