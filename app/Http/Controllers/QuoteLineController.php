<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuoteLineRequest;
use App\Models\Quote;
use App\Models\QuoteLine;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateQuoteLineRequest;

class QuoteLineController extends Controller
{
    public function store(StoreQuoteLineRequest $request, Quote $quote){
        $this->authorize('update', $quote);

        $data = $request->validated();

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

    public function update(UpdateQuoteLineRequest $request, Quote $quote, QuoteLine $line){
        $this->authorize('update', $quote);
        if($line->quote_id !== $quote->id){
            abort(404);
        }

        $data = $request->validated();

        $line->qty= $data['qty'];
        $line->discount_rate = $data['discount_rate'] ?? $line->discount_rate;

        $line->recalc();
        $line->save();

        $quote->load('lines');
        $quote->recalcTotals();

        return redirect()->route('quotes.show', $quote);
    }

    public function destroy(Quote $quote, QuoteLine $line){
        $this->authorize('update', $quote);
        if($line->quote_id !== $quote->id){
            abort(404);
        }

        $line->delete();

        $quote->load('lines');
        $quote->recalcTotals();

        return redirect()->route('quotes.show', $quote);
    }
}
