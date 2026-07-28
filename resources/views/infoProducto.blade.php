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
                    </div>

                </div>
            </div>
            
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


</div>






<!-- Scripts del carrito -->
<script>
    function mostrarCantidad(id) {
        document.getElementById('btn-falso-' + id).classList.add('d-none');
        document.getElementById('form-carrito-' + id).classList.remove('d-none');
    }

    function cancelarCantidad(id) {
        document.getElementById('form-carrito-' + id).classList.add('d-none');
        document.getElementById('btn-falso-' + id).classList.remove('d-none');
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