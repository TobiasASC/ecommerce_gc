<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pedido extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pedidos';

    protected $fillable = [
        'codigo_pedido',
        'usuario_id',
        'total',
        'estado',
        'metodo_pago_id',
        'fecha_venta',
    ];

    protected $casts = [
        'total' => 'float',
        'fecha_venta' => 'datetime',
    ];

    /**
     * Relación: Un Pedido pertenece a un Usuario (Muchos a Uno)
     * 
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id'); 
    }
    
    /**
     * Relación: Un Pedido tiene muchos detalles/productos (Uno a Muchos)
     * 
     */
    public function detalles()
    {
        return $this->hasMany(DetallePedido::class, 'pedido_id'); 
    }

    /**
     * Relación: Un Pedido pertenece a un Método de Pago (Muchos a Uno)
     * */
    public function metodoPago()
    {
        return $this->belongsTo(MetodoPago::class, 'metodo_pago_id');
    }

}
