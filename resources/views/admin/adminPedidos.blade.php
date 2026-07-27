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
                                <th scope="col" class="py-3 px-4 text-center">Codigo</th>
                                <th scope="col" class="py-3 text-center">Fecha</th>
                                <th scope="col" class="py-3 text-center">Estado</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                        @forelse($pedidos as $pedido)
                                <tr>
                                    <td class="text-center">{{ $pedido->codigo_pedido }}</td>
                                    <td class="text-center">{{ \Carbon\Carbon::parse($pedido->fecha_venta ?? $pedido->created_at)->format('d/m/Y') }}</td>
                                    <td class="text-center">{{ $pedido->estado }}</td>
                                </tr>
                        @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <h5 class="fw-bold">No hay pedidos</h5>
                                        <p>Por el momento no hay pedidos disponibles para ver.</p>
                                    </td>
                                </tr>
                        
                        @endforelse
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        </main>
    
@endsection