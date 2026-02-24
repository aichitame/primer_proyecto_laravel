<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    public function index(){

    $quotes = Quote::with(['user', 'lines.product'])->latest()->get();

    return view('quotes.index', compact('quotes'));
    }

    public function store(Request $request){
        $quote = Quote::create([
            'user_id' => Auth::id(),
            'status' => 'draft',
            'subtotal' => 0,
            'discount_total' => 0,
            'tax_total' => 0,
            'total' => 0
        ]);

        return redirect()->route('quotes.show', $quote);
    }

    public function show(Quote $quote){
        $quote->load(['user', 'lines.product']);
        $products = Product::active()->get();

        return view('quotes.show', compact('quote', 'products'));
    }
}
