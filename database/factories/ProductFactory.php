<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
        'name' => $this->faker->words(3, true),
        'active' => true,
        'price' => $this->faker->randomFloat(2, 5, 200),
        'tax_rate' => 21.00,
        ];
    }
}
