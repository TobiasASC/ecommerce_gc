<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Producto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_venta',
        'stock_actual',
        'stock_minimo',
        'activo',
        'imagen',
        'imagen_url',
        'categoria_id',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'precio_venta' => 'float', 
    ];

    // Relación: Un producto pertenece a una Categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
}