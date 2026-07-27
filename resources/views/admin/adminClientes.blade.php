@extends('plantilla')
@section('contenido')
<div class="container-fluid px-0">
    <div class="row g-0"> 
        @include('componentes.sidebar')

        <main class="col-12 col-md-9 p-4">
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
                                <th scope="col" class="py-3 px-4 text-center">Usuario</th>
                                <th scope="col" class="py-3 text-center">Correo</th>
                                <th scope="col" class="py-3 text-center">Activo desde</th>
                                <th scope="col" class="py-3 text-center">Acciones</th> <!-- NUEVA COLUMNA -->
                            </tr>
                        </thead>
                        
                        <tbody>
                        @forelse($clientes as $cliente)
                            <tr>
                                <td class="text-center">{{ $cliente->nombre }}, {{ $cliente->apellido }}</td>
                                <td class="text-center">{{ $cliente->email }}</td>
                                <td class="text-center">{{ $cliente->created_at->format('d/m/Y') }}</td>
<td class="text-center">
    {{-- Accedemos a la relación 'rol' y luego a la propiedad 'nombre' --}}
    @if($cliente->rol->nombre !== 'admin') 
        <form action="{{ route('admin.clientes.hacer-admin', $cliente->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de asignar el rol de Administrador a {{ $cliente->nombre }}?');">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-sm btn-outline-primary shadow-sm" title="Hacer Administrador">
                <i class="fa-solid fa-user-shield"></i>
            </button>
        </form>
    
    @else
        <form action="{{ route('admin.clientes.hacer-cliente', $cliente->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de quitar los permisos de Administrador a {{ $cliente->nombre }}?');">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm" title="Quitar Administrador">
                <i class="fa-solid fa-user-xmark"></i>
            </button>
        </form>
    @endif
</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <h5 class="fw-bold">No hay usuarios para mostrar</h5>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection