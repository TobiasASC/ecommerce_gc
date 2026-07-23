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
        Schema::create('detalle_pedidos', function (Blueprint $table) {
            $table->id();

            // Relación con el Pedido (Si se borra el pedido en cascada, se borran sus detalles)
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('cascade');

            // Relación con el Producto (onDelete restrict evita borrar un juguete que ya fue vendido)
            $table->foreignId('producto_id')->constrained('productos')->onDelete('restrict');

            // Cantidad de unidades de este producto en el carrito
            $table->integer('cantidad');

            // Se Guarda el precio al que se vendió HOY. 
            // Si el producto aumenta el mes que viene, el detalle de esta compra vieja no debe alterarse.
            $table->decimal('precio_unitario', 10, 2);
            
            // Subtotal de este renglón (cantidad * precio_unitario)
            $table->decimal('subtotal', 10, 2);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_pedidos');
    }
};