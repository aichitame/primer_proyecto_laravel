<?php

namespace App\Providers;

use App\Models\Quote;
use App\Policies\QuotePolicy;
use App\Models\Product;
use App\Policies\ProductPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Product::class=> ProductPolicy::class,
        Quote::class=> QuotePolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
