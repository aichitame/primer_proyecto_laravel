<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Quote;
use App\Models\QuoteLine;
use App\Models\User;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        //Productos
        Product::factory()->count(10)->create();

        //Usuario demo
        $user = User::where('email', 'admin@admin.com')->firstOrFail();

        Quote::factory()
        ->count(3)
        ->create(['user_id' => $user->id])
        ->each(function(Quote $quote) {
            $linesCount = rand(2, 5);

            $products = Product::inRandomOrder()->take($linesCount)->get();
            foreach($products as $product){
                QuoteLine::create([
                    'quote_id' =>$quote->id,
                    'product_id' =>$product->id,
                    'qty'=> rand(1, 5),
                    'discount_rate'=> rand(0, 20),

                    'unit_price'=> null,
                    'tax_rate'=> null,
                    'subtotal'=> 0,
                    'discount_amount'=> 0,
                    'tax_amount'=> 0,
                    'total'=> 0,
                ]);
            }

            $quote->load('lines');
            $quote->recalcTotals();
        });
    }
}
