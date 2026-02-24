<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\QuoteLine;
use Illuminate\Http\Request;

class QuoteLineController extends Controller
{
    public function store(Request $request, Quote $quote){
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'qty' => ['required', 'integer', 'min:1'],
            'discount_rate' => ['nullable', 'numeric', 'min:0'],
        ]);

        $existingLine = $quote->lines()
        ->where('product_id', $data['product_id'])
        ->first();

        if ($existingLine){
            $existingLine->qty += $data['qty'];

            if(isset ($data['discount_rate'])){
                $existingLine->discount_rate = $data['discount_rate'];
            }

            $existingLine->recalc();
            $existingLine->save();

        } else{
            $line = $quote->lines()->create([
                'product_id' => $data['product_id'],
                'qty' => $data['qty'],
                'discount_rate' => $data['discount_rate'] ?? 0,
            ]);

            $line->recalc();
            $line->save();
        }

        $quote->load('lines');
        $quote->recalcTotals();

        return redirect()->route('quotes.show', $quote);
    }

    public function update(Request $request, Quote $quote, QuoteLine $line){
        if($line->quote_id !== $quote->id){
            abort(404);
        }

        $data = $request->validate([
            'qty' => ['required', 'integer', 'min:1'],
            'discount_rate' => ['nullable', 'numeric', 'min:0'],
        ]);

        $line->qty= $data['qty'];
        $line->discount_rate = $data['discount_rate'] ?? $line->discount_rate;

        $line->recalc();
        $line->save();

        $quote->load('lines');
        $quote->recalcTotals();

        return redirect()->route('quotes.show', $quote);
    }

    public function destroy(Quote $quote, QuoteLine $line){
        if($line->quote_id !== $quote->id){
            abort(404);
        }

        $line->delete();

        $quote->load('lines');
        $quote->recalcTotals();

        return redirect()->route('quotes.show', $quote);
    }
}
