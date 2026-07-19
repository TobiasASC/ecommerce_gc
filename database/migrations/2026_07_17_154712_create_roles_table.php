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
    Schema::create('roles', function (Blueprint $table) {
    $table->id(); // PK autoincremental
    $table->string('nombre')->unique(); // unique() evita roles duplicados
    $table->string('descripcion')->nullable(); // campo opcional
    $table->timestamps(); // created_at y updated_at (automáticos)
    $table->softDeletes(); // deleted_at — borrado lógico
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};