@extends('plantilla')
@section('contenido')

<title>Catalogo</title>
<div class="container my-5">
    

    <div class="row g-4">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-4 subtitulo">
            <!-- Buscador Principal -->
            <form action="{{ route('catalogo') }}" method="GET" class="mb-3">
                <div class="input-group shadow-sm rounded">
                <!-- El name debe ser "buscar" para que coincida con request('buscar') de tu controlador -->
                    <input type="text" name="buscar" class="form-control border-0 bg-light p-3" 
                    placeholder="Buscar productos..." 
                    value="{{ request('buscar') }}"> <!-- Mantiene lo que el usuario escribió -->
        
                    <button class="btn boton-buscar px-4 fw-bold" type="submit">Buscar</button>
                </div>
            </form>

            <!-- Barra de Categorías (Píldoras) -->
            <div class="d-flex gap-2 overflow-auto py-2" style="scrollbar-width: none; -ms-overflow-style: none;">
        
        <!-- Botón "Todas" -->
        <a href="{{ route('catalogo') }}" 
        class="btn rounded-pill px-4 text-nowrap shadow-sm pill-categoria {{ !request()->route('id') ? 'btn-dark' : 'btn-outline-secondary bg-white border-0' }}">
            Todas
        </a>

        <!-- Botones de Categorías -->
@foreach($categorias as $categoria)
    <a href="{{ route('catalogo.categoria', $categoria->id) }}" 
       class="btn rounded-pill px-4 text-nowrap shadow-sm pill-categoria {{ request()->route('id') == $categoria->id ? 'btn-dark' : 'btn-outline-secondary bg-white border-0' }}">
        {{ $categoria->nombre }}
    </a>
@endforeach

    </div>
</div>
    </div>
</div>
        @foreach($productos as $producto)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm border-0 texto-secundario">
                
                <!-- Área de la Imagen -->
                <div class="card-img-container">
                <!-- Cambiamos .card-img-top por nuestra nueva clase .card-img-top-catalog -->
                    <img src="{{ asset($producto->imagen_url) }}" class="card-img-top-catalog" alt="{{ $producto->nombre }}">
                </div>
                
                
                
                <div class="card-body d-flex flex-column p-3">
                    <!-- Categoría -->
                    <span class="badge categoria-producto mb-2 align-self-start">{{ $producto->categoria->nombre }}</span>

                    <!-- Título -->
                    <h5 class="card-title fw-bold mb-1 subtitulo">{{ $producto->nombre }}</h5>
                    
                    <!-- Descripción corta -->
                    <p class="card-text text-muted small mb-2">{{ Str::limit($producto->descripcion, 70) }}</p>
                    
                    <!-- Precio alineado abajo con mt-auto -->
                    <h4 class="mt-auto fw-bold subtitulo mb-2">${{ number_format($producto->precio_venta, 2) }}</h4>
                    
                    <!-- Botones -->
                    <div class="d-grid gap-2">
                        <button class="btn boton-agregar">
                            <i class="fa-solid fa-cart-plus me-1"></i> Agregar
                        </button>
                        <a href="{{ route('producto.mostrar', $producto->id) }}" id="btn-vermas-{{ $producto->id }}" class="btn boton-detalle">
                            Ver detalles
                        </a>
                        {{-- <a href="{{ route('productos.show', $producto->id) }}" class="btn btn-outline-dark">Ver detalles</a> --}}
                    </div>
                </div>
            </div>
        </div>
        
        @endforeach 

        </div>

    </div>
@endsection