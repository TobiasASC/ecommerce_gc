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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion');
            $table->decimal('precio_venta', 10, 2); 
            $table->integer('stock_actual');
            $table->integer('stock_minimo');
            $table->boolean('activo')->default(true);
            
            // Relación con Categorías
            // constrained() asume automáticamente que la tabla se llama 'categorias'
            // onDelete('restrict') evita que se borre una categoría si tiene productos adentro
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
