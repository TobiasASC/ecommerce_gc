@extends('plantilla')
@section('contenido')

<title>Pedidos</title>
<div class="container-fluid px-0 overflow-hidden">
    <div class="row g-0"> 
        @include('componentes.sidebar')

        <main class="col-12 col-md-9 col-xl-10 p-3 p-md-4" style="min-width: 0;">
            
            <div class="card shadow-sm border-1 rounded-4">
                <div class="card-body p-4">
                    
                    <div class="d-flex flex-column flex-xl-row justify-content-between align-items-xl-center mb-3 gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <h3 class="card-title m-0 titulo">Pedidos</h3>
                            <span class="pill-counter">{{ $pedidos->total() }} pedidos</span>
                        </div>
                        
                        <form action="{{ route('admin.pedidos') }}" method="GET" class="d-flex flex-column flex-sm-row align-items-sm-center gap-4" id="formBusqueda">
                            
                            <div class="input-group shadow-sm" style="max-width: 350px;">
                                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                                <input type="text" name="search" id="search" class="form-control border-start-0" placeholder="Buscar por código..." value="{{ request('search') }}">
                            </div>

                            <div class="d-flex align-items-center">
                                <label for="estado" class="me-2 fw-semibold text-muted text-nowrap mb-0">Estado:</label>
                                <select name="estado" id="estado" class="form-select form-select-sm shadow-sm" style="width: auto; min-width: 150px;" onchange="this.form.submit()">
                                    <option value="">Todos</option>
                                    <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="confirmado" {{ request('estado') == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                                </select>
                            </div>
                        </form>
                    </div>
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

                    <div id="contenedorTabla" class="mt-3">
                        <div class="table-responsive panel-card subtitulo" style="max-height: 500px; overflow-y: auto; overflow-x: auto; border-radius: 8px;">
                            <table class="table panel-table align-middle mb-0 w-100">
                                <thead class="table-light sticky-top" style="z-index: 2;">
                                    <tr>
                                        <th scope="col" class="py-3 px-4 text-center">Código</th>
                                        <th scope="col" class="py-3 text-center">Fecha</th>
                                        <th scope="col" class="py-3 text-center">Estado</th>
                                        <th scope="col" class="py-3 text-center">Acciones</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                @forelse($pedidos as $pedido)
                                    <tr>
                                        <td class="text-center text-secondary align-middle">{{ $pedido->codigo_pedido }}</td>
                                        <td class="text-center text-secondary align-middle">{{ \Carbon\Carbon::parse($pedido->fecha_venta ?? $pedido->created_at)->format('d/m/Y H:i') }}</td>
                                        
                                        <!-- ESTADOS CON ANCHO FIJO PARA MISMA PROPORCIÓN -->
                                        <td class="text-center align-middle">
                                            @switch(strtolower($pedido->estado))
                                                @case('confirmado')
                                                    <span class="badge bg-success rounded-pill py-2 fs-6 fw-normal shadow-sm" style="width: 130px; display: inline-block;">
                                                        <i class="fa-solid fa-circle-check me-1"></i> Confirmado
                                                    </span>
                                                    @break
                                                @case('pendiente')
                                                    <span class="badge bg-warning text-dark rounded-pill py-2 fs-6 fw-normal shadow-sm" style="width: 130px; display: inline-block;">
                                                        <i class="fa-solid fa-clock me-1"></i> Pendiente
                                                    </span>
                                                    @break
                                                @case('carrito')
                                                    <span class="badge bg-secondary rounded-pill py-2 fs-6 fw-normal shadow-sm" style="width: 130px; display: inline-block;">
                                                        <i class="fa-solid fa-cart-shopping me-1"></i> Carrito
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="badge bg-secondary rounded-pill py-2 fs-6 fw-normal shadow-sm" style="width: 130px; display: inline-block;">
                                                        <i class="fa-solid fa-box me-1"></i> {{ ucfirst($pedido->estado) }}
                                                    </span>
                                            @endswitch
                                        </td>
                                        
                                        <!-- ACCIONES UNIFICADAS EN UNA SOLA COLUMNA -->
                                        <td class="text-center align-middle text-nowrap">
                                            <div class="d-flex justify-content-center gap-2">
                                                
                                                <!-- Botón de Detalles (Único) -->
                                                <a href="{{ route('admin.pedidos.detalle', $pedido->id) }}" class="btn btn-sm boton-detalle shadow-sm" title="Ver detalle">
                                                    <i class="fa-solid fa-eye"></i> Detalles
                                                </a>

                                                <!-- Botón de Confirmar (Solo visible si es 'pendiente') -->
                                                @if(strtolower($pedido->estado) === 'pendiente')
                                                <form action="{{ route('admin.pedidos.confirmar', $pedido->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de que deseas confirmar este pedido?');">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-sm btn-success shadow-sm" title="Confirmar pago y pedido">
                                                        <i class="fa-solid fa-check"></i> Confirmar
                                                    </button>
                                                </form>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-box-open fa-3x mb-3 text-secondary opacity-50"></i>
                                            <h5 class="fw-bold subtitulo">No hay pedidos</h5>
                                            <p>Por el momento no hay pedidos disponibles para ver.</p>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div> 
                    
                    <div id="contenedorPaginacion">
                        @if(method_exists($pedidos, 'hasPages') && $pedidos->hasPages())
                        <div class="mt-4 pt-3 border-top d-flex justify-content-center">
                            {{ $pedidos->links() }}
                        </div>
                        @endif
                    </div>

                </div>
            </div> 

        </main>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('search');
        const formBusqueda = document.getElementById('formBusqueda');
        let timeout = null;

        searchInput.addEventListener('input', function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                const url = new URL(formBusqueda.action);
                const formData = new FormData(formBusqueda);
                formData.forEach((value, key) => {
                    url.searchParams.append(key, value);
                });

                fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    document.getElementById('contenedorTabla').innerHTML = doc.getElementById('contenedorTabla').innerHTML;
                    const paginacionActual = document.getElementById('contenedorPaginacion');
                    const paginacionNueva = doc.getElementById('contenedorPaginacion');
                    
                    if(paginacionActual && paginacionNueva) {
                        paginacionActual.innerHTML = paginacionNueva.innerHTML;
                    }
                });
            }, 300);
        });
    });
</script>
@endsection