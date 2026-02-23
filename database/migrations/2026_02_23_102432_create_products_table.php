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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            //Nombre del producto
            $table->string('name');

            $table->boolean('active')->default('true');

            //Precio del producto (dinero = SIEMPRE decimal)
            $table->decimal('price', 12, 2);

            //Para manejar IVA por producto
            $table->decimal('tax_rate', 5, 2)->default(21.00);

            //Para activar/desactivar sin borrar
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
