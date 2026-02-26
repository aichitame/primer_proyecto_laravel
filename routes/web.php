<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\QuoteLineController;
use App\Http\Controllers\ProductController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function() {
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products',[ProductController::class, 'store'])->name('products.store');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::patch('/products/{product}', [ProductController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');


    //Quotes
Route::get('/quotes', [QuoteController::class, 'index'])->name('quotes.index');
Route::post('/quotes', [QuoteController::class, 'store'])->name('quotes.store');
Route::get('/quotes/{quote}', [QuoteController::class, 'show'])->name('quotes.show');

    //Quote lines
Route::post('/quotes/{quote}/lines', [QuoteLineController::class, 'store'])->name('quotes.lines.store');
Route::patch('/quotes/{quote}/lines/{line}', [QuoteLineController::class, 'update'])->name('quotes.lines.update');
Route::delete('/quotes/{quote}/lines/{line}', [QuoteLineController::class, 'destroy'])->name('quotes.lines.destroy');

});
