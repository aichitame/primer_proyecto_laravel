<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quote_lines', function (Blueprint $table) {
            $table->id();

            $table->foreignId('quote_id')->constrained()->cascadeOnDelete();

            $table->foreignId('product_id')->constrained()->restrictOnDelete();

            $table->unsignedInteger('qty')->default(1);

            //Copias
            $table->decimal('unit_price', 12, 2);
            $table->decimal('discount_rate', 5, 2)->default(0);
            $table->decimal('tax_rate', 5, 2)->default(21.00);

            //Totales por línea
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount_amount', 12, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            
            $table->timestamps();

            $table->unique(['quote_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_lines');
    }
};
