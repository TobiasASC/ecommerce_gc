@extends('plantilla')
@section('contenido')

<title>Detalles del pedido</title>
<div class="container-fluid px-0 overflow-hidden">
    <div class="row g-0"> 
        @include('componentes.sidebar')

        <main class="col-12 col-md-9 col-xl-10 p-3 p-md-4" style="min-width: 0;">
            
            <div class="card shadow-sm border-1 rounded-4">
                <div class="card-body p-4">
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h3 class="card-title m-0 titulo fw-bold">Detalle de Pedido</h3>
                            <p class="text-muted mb-0 subtitulo">Código: <strong>{{ $pedido->codigo_pedido }}</strong> | Fecha: {{ \Carbon\Carbon::parse($pedido->fecha_venta ?? $pedido->created_at)->format('d/m/Y H:i') }}</p>
                        </div>
                        <a href="{{ route('admin.pedidos') }}" class="btn boton-volver btn-sm shadow-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Volver
                        </a>
                    </div>
                    <hr>

                    <!-- INFO DEL CLIENTE (Solo visible para Admin) -->
                    <div class="row mb-4 subtitulo">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-2">Datos del Cliente:</h6>
                            <div class="p-3 bg-light rounded-3 border">
                                <p class="mb-1"><i class="fa-solid fa-user me-2 text-secondary"></i> {{ $pedido->usuario->nombre ?? 'N/A' }} {{ $pedido->usuario->apellido ?? '' }}</p>
                                <p class="mb-0"><i class="fa-solid fa-envelope me-2 text-secondary"></i> {{ $pedido->usuario->email ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6 mt-3 mt-md-0 d-flex flex-column justify-content-center align-items-md-end">
                             <h6 class="fw-bold mb-2 w-100 text-md-end">Estado Actual:</h6>
                             @switch(strtolower($pedido->estado))
                                @case('confirmado')
                                    <span class="badge bg-success px-4 py-2 fs-5 shadow-sm"><i class="fa-solid fa-circle-check me-1"></i> Confirmado</span>
                                @break
                                @case('pendiente')
                                    <span class="badge bg-warning text-dark px-4 py-2 fs-5 shadow-sm"><i class="fa-solid fa-clock me-1"></i> Pendiente</span>
                                @break
                                @default
                                    <span class="badge bg-secondary px-4 py-2 fs-5 shadow-sm">{{ ucfirst($pedido->estado) }}</span>
                            @endswitch
                        </div>
                    </div>

                    <!-- TABLA DETALLES DEL PEDIDO -->
                    <div class="table-responsive panel-card mt-3 subtitulo" style="max-height: 500px; overflow-y: auto; overflow-x: auto; border-radius: 8px;">
                        <table class="table panel-table align-middle mb-0 w-100">
                            <thead class="table-light sticky-top" style="z-index: 2;">
                                <tr>
                                    <th scope="col" class="py-3 px-4 text-center">Imagen</th>
                                    <th scope="col" class="py-3">Producto</th>
                                    <th scope="col" class="py-3 text-center">Precio Unit.</th>
                                    <th scope="col" class="py-3 text-center">Cantidad</th>
                                    <th scope="col" class="py-3 text-center">Subtotal</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                            @php $totalPedido = 0; @endphp
                            
                            @forelse($pedido->detalles as $detalle)
                                @php 
                                    $subtotal = $detalle->precio_unitario * $detalle->cantidad;
                                    $totalPedido += $subtotal;
                                @endphp
                                <tr>
                                    <!-- Imagen -->
                                    <td class="text-center px-4">
                                        @if($detalle->producto && $detalle->producto->imagen_url)
                                            <img src="{{ asset($detalle->producto->imagen_url) }}" alt="Producto" class="img-thumbnail shadow-sm" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        @else
                                            <div class="bg-light text-secondary shadow-sm d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 60px; border-radius: 8px;">
                                                <i class="fa-solid fa-image fs-4"></i>
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <!-- Producto -->
                                    <td class="fw-bold text-dark">
                                        {{ $detalle->producto->nombre ?? 'Producto Eliminado' }}
                                    </td>

                                    <!-- Precio -->
                                    <td class="text-center fw-semibold text-secondary">
                                        ${{ number_format($detalle->precio_unitario, 2) }}
                                    </td>

                                    <!-- Cantidad -->
                                    <td class="text-center text-secondary">
                                        {{ $detalle->cantidad }}
                                    </td>
                                    
                                    <!-- Subtotal -->
                                    <td class="text-center fw-semibold text-success">
                                        ${{ number_format($subtotal, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <p class="mb-0">No se encontraron detalles para este pedido.</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="4" class="text-end fw-bold py-3">Total del Pedido:</td>
                                    <td class="text-center fw-bold fs-5 text-success py-3">${{ number_format($totalPedido, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- NUEVA SECCIÓN: COMPROBANTE DE PAGO -->
                    @if($pedido->comprobante_url)
                    <div class="mt-5">
                        <h5 class="fw-bold mb-3 titulo"><i class="fa-solid fa-receipt me-2"></i>Comprobante de Pago</h5>
                        <div class="card border-1 shadow-sm rounded-4" style="max-width: 400px;">
                            <div class="card-body text-center p-2">
                                <!-- Se usa asset('storage/...') para acceder a la imagen -->
                                <a href="{{ asset('storage/' . $pedido->comprobante_url) }}" target="_blank" title="Clic para ampliar">
                                    <img src="{{ asset('storage/' . $pedido->comprobante_url) }}" alt="Comprobante de transferencia" class="img-fluid rounded-3" style="max-height: 300px; object-fit: contain;">
                                </a>
                                <p class="text-muted small mt-2 mb-1">Clic en la imagen para ampliar</p>
                            </div>
                        </div>
                    </div>
                    @endif

                </div> 
            </div> 

        </main>
    </div>
</div>
@endsection