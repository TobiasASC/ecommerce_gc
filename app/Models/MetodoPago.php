<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; 


class MetodoPago extends Model
{
    use HasFactory, SoftDeletes;

    // Le decimos a Laravel el nombre exacto de la tabla en la BD
    protected $table = 'metodo_pagos';

    // Definimos los campos que se pueden cargar masivamente (asignación masiva)
    protected $fillable = [
        'nombre',
    ];
    
    //
}
