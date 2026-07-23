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

            <div class="card shadow-sm borde rounded-4 overflow-hidden">
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
                                    <td class="text-center">{{ $item->cantidad }}</td>
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

                {{-- Solo mostramos el footer con el botón Vaciar y el Total si hay ítems --}}
                @if($items->count() > 0)
                <div class="card-footer bg-white border-top p-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    
                    <!-- Botón Vaciar Carrito -->
                    <form method="POST" action="{{ route('carrito.vaciar') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger fw-bold">
                            <i class="fa-solid fa-trash-can me-2"></i> Vaciar carrito
                        </button>
                    </form>

                    <!-- Total con espaciado correcto -->
                    <div class="d-flex align-items-center gap-2">
                        <span class="fs-5 text-muted">Total del pedido:</span>
                        <span class="fs-4 fw-bold text-success">${{ number_format($carrito?->total ?? 0, 2) }}</span>
                    </div>
                </div>
                @endif
                
            </div>
        </main>
    </div> <!-- Cierre de row -->
</div> <!-- Cierre de container-fluid -->
@endsection