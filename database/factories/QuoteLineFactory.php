<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\QuoteLine;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\QuoteLine>
 */
class QuoteLineFactory extends Factory
{
    protected $model = QuoteLine::class;
    public function definition(): array
    {
        $product = \App\Models\Product::inRandomOrder()->first();
        return [
            'product_id' => $product->id,
            'quantity' => $this->faker->numberBetween(1, 5),
            'unit_price' => $product->price,
            'discount_percent' => $this->faker->randomFloat(2, 0, 20),
            'tax_percent' => 21,
            'subtotal' => 0, //se calcula después
            'discount' => 0,
            'tax' => 0,
            'total' => 0,
        ];
    }
}
