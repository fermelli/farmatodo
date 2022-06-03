<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(3),
            'type' => $this->faker->sentence(3),
            'brand' => $this->faker->sentence(3),
            'price' => $this->faker->randomFloat(3, 1, 9999.999),
            'quantity' => $this->faker->randomNumber(3),
        ];
    }
}
