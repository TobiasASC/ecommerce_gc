@extends('plantilla')
@section('contenido')

<title>Catálogo</title>

<!-- ALERTA DE ERROR -->
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show shadow-lg position-fixed top-0 start-50 translate-middle-x mt-4" 
         role="alert" 
         style="z-index: 9999; width: 90%; max-width: 500px; text-align: center;">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
<!-- FIN ALERTA DE ERROR -->

<!-- ENCABEZADO FUERTE (Combina con la Topbar) -->
<div class="encabezado-catalogo mb-5">
    <div class="container text-center">
        <h1 class="titulo-catalogo fw-bold mb-4">Nuestro Catálogo</h1>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <!-- Buscador Principal -->
                <form action="{{ route('catalogo') }}" method="GET" class="mb-4">
                    <div class="input-group shadow rounded-pill overflow-hidden p-1 bg-white">
                        <input type="text" name="buscar" class="form-control border-0 bg-transparent px-4" 
                        placeholder="Buscar artesanías, regalos..." 
                        value="{{ request('buscar') }}" style="box-shadow: none;">
            
                        <button class="btn boton-buscar px-4 fw-bold rounded-pill" type="submit">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> Buscar
                        </button>
                    </div>
                </form>

<!-- Barra de Categorías (Píldoras) -->
<div class="d-flex gap-2 justify-content-center overflow-auto py-2" style="scrollbar-width: none; -ms-overflow-style: none;">
    <!-- Botón "Todas" -->
    <a href="{{ route('catalogo') }}" 
       class="btn btn-categoria-catalogo rounded-pill px-4 text-nowrap shadow-sm {{ !request()->route('id') ? 'bg-white fw-bold border-0' : 'btn-outline-light border-0' }}" 
       style="{{ !request()->route('id') ? 'color: var(--morado_oscuro) !important;' : 'color: rgba(255,255,255,0.8);' }}">
        Todas
    </a>

    <!-- Botones de Categorías -->
    @foreach($categorias as $categoria)
        <a href="{{ route('catalogo.categoria', $categoria->id) }}" 
           class="btn btn-categoria-catalogo rounded-pill px-4 text-nowrap shadow-sm {{ request()->route('id') == $categoria->id ? 'bg-white fw-bold border-0' : 'btn-outline-light border-0' }}"
           style="{{ request()->route('id') == $categoria->id ? 'color: var(--morado_oscuro) !important;' : 'color: rgba(255,255,255,0.8);' }}">
            {{ $categoria->nombre }}
        </a>
    @endforeach
</div>
            </div>
        </div>
    </div>
</div>

<!-- GRILLA DE PRODUCTOS -->
<div class="container mb-5">
    <div class="row g-4">

        @foreach($productos as $producto)
        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
            <div class="card h-100 shadow-sm border-0 texto-secundario tarjeta-custom">
                
                <!-- Área de la Imagen -->
                <div class="card-img-container">
                    <img src="{{ \App\Support\MediaStorage::resolveUrl($producto->imagen_url) }}" class="card-img-top-catalog" alt="{{ $producto->nombre }}">
                </div>
                
                <div class="card-body d-flex flex-column p-3">
                    <!-- Categoría -->
                    <span class="badge categoria-producto mb-2 align-self-start">{{ $producto->categoria->nombre }}</span>

                    <!-- Título -->
                    <h5 class="card-title fw-bold mb-1 subtitulo">{{ $producto->nombre }}</h5>
                    
                    <!-- Descripción corta -->
                    <p class="card-text text-muted small mb-2">{{ Str::limit($producto->descripcion, 70) }}</p>
                    
                    <!-- Precio alineado abajo con mt-auto -->
                    <h4 class="mt-auto fw-bold subtitulo mb-0">${{ number_format($producto->precio_venta, 2) }}</h4>
                    
                    <!-- Etiqueta de Sin Stock -->
                    @if($producto->stock_actual <= 0)
                        <span class="text-danger fw-bold small mb-2 d-block"><i class="fa-solid fa-circle-xmark me-1"></i> Sin Stock</span>
                    @else
                        <!-- Espacio en blanco para mantener la alineación de las tarjetas -->
                        <div class="mb-2"></div>
                    @endif

                    <!-- Botones -->
                    <div class="d-grid gap-2">
                        
                        <!-- Verificamos si hay stock para mostrar los botones de compra -->
                        @if($producto->stock_actual > 0)
                            @auth
                                <!-- Condicional: Solo el cliente puede interactuar con el carrito -->
                                @if(Auth::user()->rol->nombre === 'cliente')
                                    <button type="button" class="btn boton-agregar rounded-pill" id="btn-falso-{{ $producto->id }}" onclick="mostrarCantidad({{ $producto->id }})">
                                        <i class="fa-solid fa-cart-plus me-1"></i> Agregar
                                    </button>
                                    
                                    <!-- Formulario de Cantidades (Oculto por defecto) -->
                                    <form action="{{ route('carrito.agregar') }}" method="POST" id="form-carrito-{{ $producto->id }}" class="d-none w-100">
                                        @csrf 
                                        <input type="hidden" name="producto_id" value="{{ $producto->id }}">

                                        <div class="d-flex align-items-center justify-content-between gap-1 w-100">
                                            <!-- Cancelar -->
                                            <button type="button" class="btn btn-sm btn-outline-danger rounded-circle px-2" onclick="cancelarCantidad({{ $producto->id }})" title="Cancelar">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>

                                            <!-- Menos -->
                                            <button type="button" class="btn btn-sm boton-cantidad rounded-circle px-2" onclick="decrementarCatalogo({{ $producto->id }})">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>

                                            <!-- Cantidad -->
                                            <input type="text" name="cantidad" id="input-cant-{{ $producto->id }}" value="1" class="form-control form-control-sm text-center border-1" style="width: 45px; border-radius: 10px;" readonly>

                                            <!-- Más -->
                                            <button type="button" class="btn btn-sm boton-cantidad rounded-circle px-2" onclick="incrementarCatalogo({{ $producto->id }}, {{ $producto->stock_actual }})">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>

                                            <!-- Confirmar -->
                                            <button type="submit" class="btn btn-success btn-sm rounded-circle px-2 m-0" title="Confirmar">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </div>
                                    </form>
                                @endif
                                <!-- Si es admin, no renderizamos el botón de agregar -->
                            @else
                                <!-- Si es invitado, lo mandamos al login -->
                                <a href="{{ route('login') }}" class="btn boton-agregar rounded-pill text-decoration-none">
                                    <i class="fa-solid fa-cart-plus me-1"></i> Agregar
                                </a>
                            @endauth
                        @endif

                        <!-- El botón de detalles SIEMPRE es visible, haya stock o no -->
                        <a href="{{ route('producto.mostrar', $producto->id) }}" id="btn-vermas-{{ $producto->id }}" class="btn boton-detalle rounded-pill">
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
        <div class="modal-content border-0 rounded-4 shadow text-center p-4">
            <div class="modal-body admin-subtitulo">
                <i class="fa-solid fa-circle-check text-success mb-3" style="font-size: 4rem;"></i>
                <h4 class="fw-bold mb-2 titulo">¡Producto agregado!</h4>
                <p class="text-muted subtitulo">El artículo se añadió a tu carrito correctamente.</p>
                <div class="mt-4 d-flex justify-content-center gap-2">
                    <button type="button" class="btn boton-seguir-compra subtitulo rounded-pill" data-bs-dismiss="modal">Seguir comprando</button>
                    <!-- Usamos el name() de tu ruta GET para ir al carrito -->
                    <a href="{{ route('carrito.mostrar') }}" class="btn boton-agregar subtitulo rounded-pill">Ir a mi carrito</a>
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
        
        let limite = parseInt(maxStock) || 1; 

        if (val < limite) {
            input.value = val + 1;
        } else {
            console.warn("Se alcanzó el límite de stock para este producto");
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