<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetallePedido extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'detalle_pedidos';

    protected $fillable = [
        'pedido_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
        'subtotal',
    ];

    protected $casts = [
        'cantidad' => 'integer',
        'precio_unitario' => 'float',
        'subtotal' => 'float',
    ];

    /**
     * Relación: El detalle pertenece a un Pedido
     */
    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'pedido_id');
    }

    /**
     * Relación: El detalle apunta a un Producto específico
     *
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}