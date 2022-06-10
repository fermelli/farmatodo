<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Purchase>
 */
class PurchaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $minDate = strtotime('2022-06-01');
        $maxDate = strtotime(now()->format('Y-m-d'));
        $randomDate = date('Y-m-d', mt_rand($minDate, $maxDate));

        return [
            'created_at' => $randomDate,
            'updated_at' => $randomDate,
        ];
    }
}
