@extends('plantilla')
@section('contenido')

@include('componentes.sidebar')

<div class="container my-5 d-flex justify-content-center align-items-center" style="min-height: 60vh;">
    <div class="card p-5 shadow-sm border-0 text-center" style="max-width: 550px; width: 100%;" data-aos="zoom-in">
        <div class="card-body">
            
            <!-- Icono de éxito animado (Usa el color verde que ya tienes en tu CSS) -->
            <div class="mb-4">
                <i class="fa-solid fa-circle-check" style="font-size: 5rem; color: var(--verde_confirmar);"></i>
            </div>
            
            <!-- Título principal -->
            <h1 class="fw-bold titulo-inicio mb-3">¡Compra Confirmada!</h1>
            
            <!-- Mensaje de agradecimiento -->
            <p class="fs-5 texto-secundario text-muted mb-4">
                Muchas gracias por elegir las creaciones de GC Diseños. Tu pedido se ha registrado correctamente. Pronto nos comunicaremos para coordinar los detalles.
            </p>
            
            <!-- Botón de retorno al carrito -->
            <a href="{{ route('carrito.mostrar') }}" class="btn boton-volver rounded-pill px-4 py-2 mt-2 fw-bold">
                <i class="fa-solid fa-arrow-left me-2"></i> Volver a mi carrito
            </a>
            
        </div>
    </div>
</div>

@endsection