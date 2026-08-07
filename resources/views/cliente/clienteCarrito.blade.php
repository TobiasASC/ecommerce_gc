@extends('plantilla')
@section('contenido')

<title>Mi carrito</title>
<div class="container-fluid px-0">
    <div class="row g-0"> 
        @include('componentes.sidebar')

        <main class="col-12 col-md-9 p-3 p-md-4">
            
            <!-- TARJETA PRINCIPAL: MI CARRITO -->
            <div class="card shadow-sm border-1 rounded-4 mb-4">
                <div class="card-body p-4">
                    
                    <h3 class="card-title mb-3 titulo fw-bold">Mi Carrito</h3>
                    <hr>

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm panel-alerta mb-4" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm panel-alerta mb-4" role="alert">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- TABLA DEL CARRITO -->
                    <div class="table-responsive panel-card mt-3 subtitulo">
                        <table class="table panel-table align-middle mb-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="py-3 px-4">Producto</th>
                                    <th scope="col" class="py-3 text-center">Precio unitario</th>
                                    <th scope="col" class="py-3 text-center">Cantidad</th>
                                    <th scope="col" class="py-3 text-center">Subtotal</th>
                                    <th scope="col" class="py-3 text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($items as $item)
                                    <tr>
                                        <td class="px-4">
                                            <div class="d-flex align-items-center gap-3">
                                                @if($item->producto->imagen_url)
                                                    <img src="{{ \App\Support\MediaStorage::resolveUrl($item->producto->imagen_url) }}" 
                                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;" 
                                                    class="shadow-sm" 
                                                    alt="{{ $item->producto->nombre }}">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center text-muted bg-light shadow-sm" 
                                                    style="width: 80px; height: 80px; border-radius: 8px;">
                                                        <i class="fa-solid fa-image fs-4"></i>
                                                    </div>
                                                @endif
                                                <span class="fw-bold">{{ $item->producto->nombre }}</span>
                                            </div>
                                        </td>
                                        <td class="text-center">${{ number_format($item->precio_unitario, 2) }}</td>
                                        
                                        <!-- BOTONES DE INCREMENTAR Y DECREMENTAR -->
                                        <td class="text-center" style="width: 140px;">
                                            <form method="POST" action="{{ route('carrito.actualizar', $item->id) }}" class="d-flex align-items-center justify-content-center mb-0">
                                                @csrf
                                                @method('PUT') 
                                                
                                                <button type="button" class="btn btn-sm boton-cantidad px-2" 
                                                        onclick="let input = this.nextElementSibling; if(input.value > 1) { input.value--; this.closest('form').submit(); }" 
                                                        {{ $item->cantidad <= 1 ? 'disabled' : '' }} title="Reducir cantidad">
                                                    <i class="fa-solid fa-minus"></i>
                                                </button>
                                                
                                                <input type="number" name="cantidad" class="form-control form-control-sm text-center mx-1 fw-bold" 
                                                       style="width: 55px; appearance: textfield; -moz-appearance: textfield;" 
                                                       value="{{ $item->cantidad }}" min="1" 
                                                       onchange="this.closest('form').submit()">
                                                
                                                <button type="button" class="btn btn-sm boton-cantidad px-2" 
                                                        onclick="let input = this.previousElementSibling; input.value++; this.closest('form').submit();" title="Aumentar cantidad">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                            </form>
                                        </td>
                                        
                                        <td class="text-center fw-semibold text-success">${{ number_format($item->subtotal, 2) }}</td>
                                        <td class="text-center">
                                            <form method="POST" action="{{ route('carrito.eliminar', $item->producto_id) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn boton-eliminar p-2 rounded" title="Eliminar producto">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-cart-shopping fs-1 mb-3 text-secondary"></i>
                                            <h5 class="fw-bold">Tu carrito está vacío</h5>
                                            <p>No hay productos en la lista en este momento.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- TOTAL DEL CARRITO -->
                    @if($items->count() > 0)
                    <div class="border-top pt-4 mt-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                        <form method="POST" action="{{ route('carrito.vaciar') }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn boton-eliminar fw-bold">
                                <i class="fa-solid fa-trash-can me-2"></i> Vaciar carrito
                            </button>
                        </form>
                        <div class="d-flex align-items-center gap-2 fw-bold subtitulo">
                            <span class="fs-5 text-muted">Total del pedido:</span>
                            <span class="fs-4 fw-bold text-success">${{ number_format($carrito?->total ?? 0, 2) }}</span>
                        </div>
                    </div>
                    @endif

                </div> 
            </div> 

            <!-- SECCIÓN DE PAGO Y CONFIRMACIÓN DE COMPRA -->
            @if($items->count() > 0)
            <div class="card shadow-sm border-1 rounded-4 overflow-hidden mb-4 subtitulo">
                <div class="card-header bg-white p-4 border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-credit-card me-2"></i>Pago y Confirmación</h5>
                </div>
                
                <div class="card-body p-4">
                    <!-- ENCTYPE MULTIPART AGREGADO PARA SUBIDA DE ARCHIVOS -->
                    <form id="form-pago" method="POST" action="{{ route('carrito.procesar') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- Selección de Método de Pago -->
                        <div class="mb-4">
                            <label class="form-label fw-bold mb-3">Selecciona un método de pago:</label>
                            <div class="d-flex flex-column flex-md-row gap-3">
                                @foreach($metodosPago as $metodo)
                                    <div class="col-12 col-md-4">
                                        <div class="form-check border rounded p-3 h-100 metodo-pago">
                                            <input class="form-check-input ms-0 me-2 selector-pago"
                                                   type="radio"
                                                   name="metodo_pago_id"
                                                   id="metodo{{ $metodo->id }}"
                                                   value="{{ $metodo->id }}"
                                                   data-tipo="{{ strtolower($metodo->nombre) }}"
                                                   {{ $loop->first ? 'checked' : '' }}
                                                   required>
                                            <label class="form-check-label d-inline-block mt-1 text-dark" for="metodo{{ $metodo->id }}">
                                                {{ $metodo->nombre }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Formulario de Transferencia Bancaria -->
                        <div id="seccion_transferencia" class="mb-4 fade-in">
                            <h6 class="fw-bold mb-3">Datos Bancarios</h6>
                            <div class="alert alert-info bg-opacity-10 border-info border-opacity-25 text-dark mb-4">
                                <p class="mb-2">Por favor, transfiere el total de <strong>${{ number_format($carrito?->total ?? 0, 2) }}</strong> a la siguiente cuenta:</p>
                                <ul class="list-unstyled mb-0">
                                    <li><strong>Banco:</strong> Banco de Ejemplo S.A.</li>
                                    <li><strong>Titular:</strong> GC Diseños</li>
                                    <li><strong>CBU/CVU:</strong> -</li>
                                    <li><strong>Alias:</strong> -</li>
                                </ul>
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-muted small">Adjuntar comprobante de pago <span class="text-danger">*</span></label>
                                    <input type="file" class="form-control req-transferencia" name="comprobante" accept="image/*" required>
                                    <div class="form-text">Sube una captura de pantalla o foto del ticket de transferencia. Formatos admitidos: JPG, PNG.</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid d-md-flex justify-content-md-end mt-4 pt-3 border-top">
                            <button type="submit" class="btn btn-success btn-lg px-5 fw-bold shadow-sm">
                                Confirmar Compra <i class="fa-solid fa-arrow-right ms-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

        </main>
    </div> 
</div> 

<!-- SCRIPT DE VALIDACIONES Y COMPORTAMIENTO DINÁMICO -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        const radios = document.querySelectorAll('.selector-pago');
        const secTransf = document.getElementById('seccion_transferencia');
        const inputsTransf = document.querySelectorAll('.req-transferencia');

        function actualizarFormulario() {
            const seleccionado = document.querySelector('.selector-pago:checked');
            if(!seleccionado) return;
            
            const tipo = seleccionado.dataset.tipo; 

            // Si el nombre del método incluye 'transferencia', mostramos el campo de adjuntar archivo
            if (tipo.includes('transferencia')) {
                secTransf.classList.remove('d-none');
                inputsTransf.forEach(i => i.setAttribute('required', 'true'));
            } else {
                secTransf.classList.add('d-none');
                inputsTransf.forEach(i => i.removeAttribute('required'));
            }
        }

        // Ejecutar al cargar la página por si hay un método preseleccionado
        actualizarFormulario();

        // Escuchar cambios en los radio buttons
        radios.forEach(radio => {
            radio.addEventListener('change', actualizarFormulario);
        });
    });
</script>
@endsection