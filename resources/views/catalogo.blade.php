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
                            <input type="text" name="buscar" class="form-control border-0 bg-light p-3" 
                            placeholder="Buscar productos..." 
                            value="{{ request('buscar') }}">
                
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
                        @auth
                            <!-- Condicional: Solo el cliente puede interactuar con el carrito -->
                            @if(Auth::user()->rol->nombre === 'cliente')
                                <button type="button" class="btn boton-agregar" id="btn-falso-{{ $producto->id }}" onclick="mostrarCantidad({{ $producto->id }})">
                                    <i class="fa-solid fa-cart-plus me-1"></i> Agregar
                                </button>
                                
                                <!-- Formulario de Cantidades (Oculto por defecto) -->
                                <form action="{{ route('carrito.agregar') }}" method="POST" id="form-carrito-{{ $producto->id }}" class="d-none w-100">
                                    @csrf 
                                    <input type="hidden" name="producto_id" value="{{ $producto->id }}">

                                    <div class="d-flex align-items-center justify-content-between gap-1 w-100">
                                        <!-- Cancelar -->
                                        <button type="button" class="btn btn-sm btn-outline-danger px-2" onclick="cancelarCantidad({{ $producto->id }})" title="Cancelar">
                                            <i class="fa-solid fa-xmark"></i>
                                        </button>

                                        <!-- Menos -->
                                        <button type="button" class="btn btn-sm btn-outline-secondary px-2" onclick="decrementarCatalogo({{ $producto->id }})">
                                            <i class="fa-solid fa-minus"></i>
                                        </button>

                                        <!-- Cantidad -->
                                        <input type="text" name="cantidad" id="input-cant-{{ $producto->id }}" value="1" class="form-control form-control-sm text-center px-1" style="width: 40px;" readonly>

                                        <!-- Más (Le pasamos un límite arbitrario alto o el stock si lo tienes) -->
                                        <button type="button" class="btn btn-sm btn-outline-secondary px-2" onclick="incrementarCatalogo({{ $producto->id }}, {{ $producto->stock ?? 99 }})">
                                            <i class="fa-solid fa-plus"></i>
                                        </button>

                                        <!-- Confirmar -->
                                        <button type="submit" class="btn btn-success btn-sm px-2 m-0" title="Confirmar">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </div>
                                </form>
                            @endif
                            <!-- Si es admin, no renderizamos el botón de agregar -->
                        @else
                            <!-- Si es invitado, lo mandamos al login -->
                            <a href="{{ route('login') }}" class="btn boton-agregar text-decoration-none">
                                <i class="fa-solid fa-cart-plus me-1"></i> Agregar
                            </a>
                        @endauth

                        <!-- El botón de detalles siempre visible (hasta que se abra el form de cantidad) -->
                        <a href="{{ route('producto.mostrar', $producto->id) }}" id="btn-vermas-{{ $producto->id }}" class="btn boton-detalle">
                            Ver detalles
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach 

    </div>
</div>

<!-- Modal de Éxito -->
<div class="modal fade" id="modalExito" tabindex="-1" aria-labelledby="modalExitoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
            <div class="modal-body admin-subtitulo">
                <i class="fa-solid fa-circle-check text-success mb-3" style="font-size: 4rem;"></i>
                <h4 class="fw-bold mb-2">¡Producto agregado!</h4>
                <p class="text-muted">El artículo se añadió a tu carrito correctamente.</p>
                <div class="mt-4 d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Seguir comprando</button>
                    <!-- Usamos el name() de tu ruta GET para ir al carrito -->
                    <a href="{{ route('carrito.mostrar') }}" class="btn boton-agregar">Ir a mi carrito</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts del carrito -->
<script>
    function mostrarCantidad(id) {
        document.getElementById('btn-falso-' + id).classList.add('d-none');
        document.getElementById('btn-vermas-' + id).classList.add('d-none');
        document.getElementById('form-carrito-' + id).classList.remove('d-none');
    }

    function cancelarCantidad(id) {
        document.getElementById('form-carrito-' + id).classList.add('d-none');
        document.getElementById('btn-falso-' + id).classList.remove('d-none');
        document.getElementById('btn-vermas-' + id).classList.remove('d-none');
        document.getElementById('input-cant-' + id).value = 1;
    }

    function incrementarCatalogo(id, maxStock) {
        let input = document.getElementById('input-cant-' + id);
        let val = parseInt(input.value);
        // Ahora sí funciona, si maxStock no se pasa, toma un límite alto por defecto
        let limite = maxStock || 99; 
        if (val < limite) {
            input.value = val + 1;
        }
    }

    function decrementarCatalogo(id) {
        let input = document.getElementById('input-cant-' + id);
        let val = parseInt(input.value);
        if (val > 1) {
            input.value = val - 1;
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        @if(session('success'))
            var modalExito = new bootstrap.Modal(document.getElementById('modalExito'));
            modalExito.show();
        @endif
    });
</script>

@endsection