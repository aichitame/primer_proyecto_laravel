<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Database\QueryException;

class ProductController extends Controller
{
    public function index(){
        $this->authorize('viewAny', Product::class);
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }

    public function create(){
        $this->authorize('create', Product::class);
        return view ('products.create');
    }

    public function store(StoreProductRequest $request){
        $this->authorize('create', Product::class);

        Product::create($request->validated());
        
        return redirect()->route('products.index');
    }

    public function edit(Product $product){
        $this->authorize('update', $product);

        return view('products.edit', compact('product'));
    }

    public function update (UpdateProductRequest $request, Product $product){
        $this->authorize('update', $product);

        $product->update($request->validated());

        return redirect()->route('products.index');
    }

    public function destroy (Product $product){
        $this->authorize('delete', $product);

        try{
            $product->active = false;
            $product->save();
            return redirect()->route('products.index')->with('success', 'Producto desactivado');
        } catch (QueryException $e){
            return redirect()->route('products.index')->with('success', 'No se puede borrar: el producto está usado en presupuestos. Desactívalo');
        }
    }
}
