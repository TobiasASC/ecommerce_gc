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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_pedido')->unique();
            $table->timestamp('fecha_venta')->nullable();
            $table->foreignId('usuario_id')->constrained('usuarios')->onDelete('restrict');
            $table->decimal('total', 10, 2);
            $table->foreignId('metodo_pago_id')->nullable()->constrained('metodo_pagos')->onDelete('set null')->after('usuario_id'); // 'MercadoPago', 'Transferencia', etc.
            $table->string('estado')->default('pendiente');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
