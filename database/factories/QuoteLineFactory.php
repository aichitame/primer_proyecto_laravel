<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Quote;
use App\Models\QuoteLine;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteLineFactory extends Factory
{
    protected $model = QuoteLine::class;
    public function definition(): array
    {
        return [
            'quote_id' => Quote::factory(),
            'product_id' => Product::factory(),
            'qty' => $this->faker->numberBetween(1, 5),

            //Podemos pasarlos o dejarlos a null para que booted()->creating los copie
            'unit_price' => null,
            'discount_rate' => $this->faker->randomFloat(2, 0, 20),
            'tax_rate' => null,

            //Se calculan en saving()->recalc()
            'subtotal' => 0,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 0,
            ];
    }
}
