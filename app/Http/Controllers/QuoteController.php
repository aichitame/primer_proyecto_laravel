<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\User;
use App\Models\Product;
use App\Http\Requests\StoreQuoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuoteController extends Controller
{
    public function index(){
    $this->authorize('viewAny', Quote::class);

    $query = Quote::with(['user', 'lines.product'])->latest();

    /**
     * @var User $user
     */
    $user = Auth::user();

    if(!$user->isAdmin()){
        $query->where('user_id', $user->id);
    }

    $quotes = $query->get();

    return view ('quotes.index', compact('quotes'));
    }

    public function store(StoreQuoteRequest $request){
        $this->authorize('create', Quote::class);

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
        $this->authorize('view', $quote);
        $quote->load(['user', 'lines.product']);
        $products = Product::active()->get();

        return view('quotes.show', compact('quote', 'products'));
    }
}
