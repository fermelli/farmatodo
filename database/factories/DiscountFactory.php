<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Discount>
 */
class DiscountFactory extends Factory
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
            'percentage' => $this->faker->numberBetween(1, 15),
            'start_date' => now()->addDays(rand(1, 5))->format('Y-m-d'),
            'end_date' => now()->addDays(rand(6, 30))->format('Y-m-d'),
        ];
    }
}
