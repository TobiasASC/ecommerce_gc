@extends('plantilla')
@section('contenido')
<div class="container-fluid px-0">
    <div class="row g-0"> 
        @include('componentes.sidebar')

        <main class="col-12 col-md-9 p-3 p-md-4">
            
            <!-- LAS ALERTAS AHORA ESTÁN DENTRO DEL MAIN -->
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

            <!-- TARJETA DEL CARRITO DE COMPRAS -->
            <div class="card shadow-sm borde rounded-4 overflow-hidden mb-4">
                <div class="table-responsive panel-card">
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
                                                <img src="{{ asset($item->producto->imagen_url) }}" 
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
                                    
                                    <!-- AQUI ESTAN LOS BOTONES DE INCREMENTAR Y DECREMENTAR -->
                                    <td class="text-center" style="width: 140px;">
                                        <form method="POST" action="{{ route('carrito.actualizar', $item->id) }}" class="d-flex align-items-center justify-content-center mb-0">
                                            @csrf
                                            {{-- IMPORTANTE: Usa el método que tengas definido en tu web.php para esta ruta (puede ser PUT, PATCH o POST). Por convención de Laravel suele ser PUT --}}
                                            @method('PUT') 
                                            
                                            <!-- Botón Restar -->
                                            <button type="button" class="btn btn-sm btn-outline-secondary px-2" 
                                                    onclick="let input = this.nextElementSibling; if(input.value > 1) { input.value--; this.closest('form').submit(); }" 
                                                    {{ $item->cantidad <= 1 ? 'disabled' : '' }} title="Reducir cantidad">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                            
                                            <!-- Input Cantidad Editable -->
                                            <input type="number" name="cantidad" class="form-control form-control-sm text-center mx-1 fw-bold" 
                                                   style="width: 55px; appearance: textfield; -moz-appearance: textfield;" 
                                                   value="{{ $item->cantidad }}" min="1" 
                                                   onchange="this.closest('form').submit()">
                                            
                                            <!-- Botón Sumar -->
                                            <button type="button" class="btn btn-sm btn-outline-secondary px-2" 
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
                                            <button type="submit" class="btn btn-outline-danger p-2 rounded" title="Eliminar producto">
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

                @if($items->count() > 0)
                <div class="card-footer bg-white border-top p-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <form method="POST" action="{{ route('carrito.vaciar') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger fw-bold">
                            <i class="fa-solid fa-trash-can me-2"></i> Vaciar carrito
                        </button>
                    </form>
                    <div class="d-flex align-items-center gap-2">
                        <span class="fs-5 text-muted">Total del pedido:</span>
                        <span class="fs-4 fw-bold text-success">${{ number_format($carrito?->total ?? 0, 2) }}</span>
                    </div>
                </div>
                @endif
            </div>

            <!-- SECCIÓN DE PAGO Y CONFIRMACIÓN DE COMPRA -->
            @if($items->count() > 0)
            <div class="card shadow-sm borde rounded-4 overflow-hidden mt-4">
                <div class="card-header bg-white p-4 border-bottom">
                    <h5 class="mb-0 fw-bold"><i class="fa-solid fa-credit-card me-2"></i>Pago y Confirmación</h5>
                </div>
                
                <div class="card-body p-4">
                    <form id="form-pago" method="POST" action="{{ route('carrito.procesar') }}">
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

                        <!-- Formulario de Tarjeta -->
                        <div id="seccion_tarjeta" class="mb-4 fade-in">
                            <h6 class="fw-bold mb-3">Datos de la Tarjeta</h6>
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-muted small">Número de la tarjeta</label>
                                    <input type="text" class="form-control req-tarjeta" name="numero_tarjeta" id="numero_tarjeta" placeholder="0000 0000 0000 0000" maxlength="19">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-muted small">Nombre del titular</label>
                                    <input type="text" class="form-control req-tarjeta" name="titular_tarjeta" id="titular_tarjeta" placeholder="Como aparece en la tarjeta">
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label text-muted small">Vencimiento</label>
                                    <input type="text" class="form-control req-tarjeta" name="vencimiento" id="vencimiento" placeholder="MM/AA" maxlength="5">
                                    <div class="invalid-feedback" id="error-vencimiento">Tarjeta vencida o mes inválido.</div>
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label text-muted small">CVV</label>
                                    <input type="text" class="form-control req-tarjeta" name="cvv" id="cvv" placeholder="123" maxlength="4">
                                </div>
                            </div>
                        </div>

                        <!-- Formulario de Transferencia Bancaria -->
                        <div id="seccion_transferencia" class="mb-4 d-none">
                            <h6 class="fw-bold mb-3">Datos Bancarios</h6>
                            <div class="alert alert-info bg-opacity-10 border-info border-opacity-25 text-dark mb-4">
                                <p class="mb-2">Por favor, transfiere el total de <strong>${{ number_format($carrito?->total ?? 0, 2) }}</strong> a la siguiente cuenta:</p>
                                <ul class="list-unstyled mb-0">
                                    <li><strong>Banco:</strong> Banco de Ejemplo S.A.</li>
                                    <li><strong>Titular:</strong> Mi Tienda Online</li>
                                    <li><strong>CBU/CVU:</strong> 0000000000000000000000</li>
                                    <li><strong>Alias:</strong> MI.TIENDA.PAGO</li>
                                </ul>
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <label class="form-label text-muted small">Número de comprobante / Referencia</label>
                                    <input type="text" class="form-control req-transferencia" name="comprobante_transferencia" placeholder="Ej: 849283129">
                                    <div class="form-text">Ingresa el código de operación de tu comprobante bancario.</div>
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
        
        // 1. Lógica para mostrar/ocultar secciones
        const radios = document.querySelectorAll('.selector-pago');
        const secTarjeta = document.getElementById('seccion_tarjeta');
        const secTransf = document.getElementById('seccion_transferencia');
        const inputsTarjeta = document.querySelectorAll('.req-tarjeta');
        const inputsTransf = document.querySelectorAll('.req-transferencia');

        function actualizarFormulario() {
            const seleccionado = document.querySelector('.selector-pago:checked');
            if(!seleccionado) return;
            
            const tipo = seleccionado.dataset.tipo; 

            if (tipo.includes('tarjeta') || tipo.includes('débito') || tipo.includes('crédito')) {
                secTarjeta.classList.remove('d-none');
                secTransf.classList.add('d-none');
                inputsTarjeta.forEach(i => i.setAttribute('required', 'true'));
                inputsTransf.forEach(i => i.removeAttribute('required'));
            } else {
                secTarjeta.classList.add('d-none');
                secTransf.classList.remove('d-none');
                inputsTarjeta.forEach(i => i.removeAttribute('required'));
                inputsTransf.forEach(i => i.setAttribute('required', 'true'));
            }
        }

        actualizarFormulario();

        radios.forEach(radio => {
            radio.addEventListener('change', actualizarFormulario);
        });

        // 2. Validaciones de Tarjeta
        const inputNumero = document.getElementById('numero_tarjeta');
        const inputTitular = document.getElementById('titular_tarjeta');
        const inputVencimiento = document.getElementById('vencimiento');
        const inputCvv = document.getElementById('cvv');
        const formPago = document.getElementById('form-pago');

        if(inputNumero){
            inputNumero.addEventListener('input', function (e) {
                let valor = e.target.value.replace(/\D/g, ''); 
                valor = valor.match(/.{1,4}/g)?.join(' ') || ''; 
                e.target.value = valor.substring(0, 19); 
            });

            inputTitular.addEventListener('input', function (e) {
                e.target.value = e.target.value.replace(/[0-9]/g, '');
            });

            inputVencimiento.addEventListener('input', function (e) {
                let valor = e.target.value.replace(/\D/g, ''); 
                if (valor.length > 2) {
                    valor = valor.substring(0, 2) + '/' + valor.substring(2, 4);
                }
                e.target.value = valor;
                inputVencimiento.classList.remove('is-invalid'); 
            });

            inputCvv.addEventListener('input', function (e) {
                e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4);
            });

            // 3. Validación al hacer Submit
            formPago.addEventListener('submit', function (e) {
                const seleccionado = document.querySelector('.selector-pago:checked');
                const tipo = seleccionado.dataset.tipo;

                if (tipo.includes('tarjeta') || tipo.includes('débito') || tipo.includes('crédito')) {
                    
                    const numLimpio = inputNumero.value.replace(/\s/g, '');
                    if (numLimpio.length < 15) {
                        e.preventDefault();
                        inputNumero.focus();
                        alert("El número de tarjeta está incompleto.");
                        return;
                    }

                    const vencimientoVal = inputVencimiento.value;
                    if (vencimientoVal.length === 5) {
                        const mes = parseInt(vencimientoVal.split('/')[0]);
                        const anio = parseInt(vencimientoVal.split('/')[1]);
                        
                        const fechaActual = new Date();
                        const mesActual = fechaActual.getMonth() + 1; 
                        const anioActual = parseInt(fechaActual.getFullYear().toString().slice(-2)); 

                        let hayError = false;

                        if (mes < 1 || mes > 12) {
                            hayError = true;
                        } else if (anio < anioActual || (anio === anioActual && mes < mesActual)) {
                            hayError = true;
                        }

                        if (hayError) {
                            e.preventDefault();
                            inputVencimiento.classList.add('is-invalid');
                            inputVencimiento.focus();
                        }
                    } else {
                        e.preventDefault();
                        inputVencimiento.classList.add('is-invalid');
                        inputVencimiento.focus();
                    }
                }
            });
        }
    });
</script>
@endsection