@extends('plantilla')
@section('contenido')
<title>{{ $producto->nombre }}</title>
<div class="container py-4">
    <div class="row justify-content-center">
        <!-- Limitamos el ancho en pantallas medianas y grandes para que no se vea gigante -->
        <div class="col-12 col-md-8 col-lg-6">
            
            <!-- Botón Volver arriba a la izquierda -->
            <div class="mb-3 text-start">
                <a href="{{ route('catalogo') }}" class="btn boton-volver-catalogo">
                    <i class="fa-solid fa-arrow-left me-2"></i>Volver al catálogo
                </a>
            </div>

            <!-- Tarjeta del Producto -->
            <div class="card shadow-sm borde-personalizado rounded-4 overflow-hidden">
                
                <!-- Contenedor de la Imagen (Fondo sutil y tamaño controlado) -->
                <div class="bg-light p-4 text-center">
                    <img src="{{ asset($producto->imagen_url) }}" 
                         class="img-fluid" 
                         style="max-height: 350px; width: 100%; object-fit: contain;" 
                         alt="{{ $producto->nombre }}">
                </div>

                <!-- Detalles del Producto -->
                <div class="card-body p-4 d-flex flex-column text-start">
                    
                    <!-- Título -->
                    <h2 class="card-title titulo fw-bold mb-3">{{ $producto->nombre }}</h2>
                    
                    <!-- Descripción -->
                    <p class="card-text subtitulo mb-4">
                        {{ $producto->descripcion ?? 'Descripción no disponible.' }}
                    </p>

                    <!-- Botón Agregar al Carrito (Siempre al fondo) -->
                    <div class="mt-auto">
                        {{-- Idealmente esto debería ser un formulario si envía datos por POST --}}
                        <form action="#" method="POST">
                            @csrf
                            <button type="submit" class="btn boton-agregar btn-lg w-100 rounded-pill shadow-sm">
                                <i class="fa-solid fa-cart-shopping me-2"></i>Agregar al carrito
                            </button>
                        </form>
                    </div>

                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection