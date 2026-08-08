@extends('plantilla')
@section('contenido')

<title>Usuarios</title>
<div class="container-fluid px-0">
    <div class="row g-0"> 
        @include('componentes.sidebar')

        <main class="col-12 col-md-9 p-3 p-md-4">
            
            <!-- TARJETA PRINCIPAL -->
            <div class="card shadow-sm border-1 rounded-4">
                <div class="card-body p-4">
                    
                    <!-- ENCABEZADO Y FILTRO -->
                    <div class="d-flex flex-column flex-xl-row justify-content-between align-items-xl-center mb-3 gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <h3 class="card-title m-0 titulo">Usuarios</h3>
                            <span class="pill-counter">{{ $clientes->total() }} usuarios</span>
                        </div>
                        
                        <!-- FORMULARIO DE BUSQUEDA Y FILTRO -->
                        <form action="{{ route('admin.clientes') }}" method="GET" class="d-flex flex-column flex-sm-row align-items-sm-center gap-4" id="formBusqueda">
                            
                            <!-- BUSCADOR DINÁMICO -->
                            <div class="input-group shadow-sm" style="max-width: 350px;">
                                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                                <input type="text" name="search" id="search" class="form-control border-start-0" placeholder="Buscar" value="{{ request('search') }}">
                            </div>

                            <!-- FILTRO DE ROL -->
                            <div class="d-flex align-items-center">
                                <label for="rol" class="me-2 fw-semibold text-muted text-nowrap mb-0">Rol:</label>
                                <select name="rol" id="rol" class="form-select form-select-sm shadow-sm" style="width: auto; min-width: 150px;" onchange="this.form.submit()">
                                    <option value="">Todos los roles</option>
                                    <option value="admin" {{ request('rol') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="cliente" {{ request('rol') == 'cliente' ? 'selected' : '' }}>Cliente</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <hr>
            
                    <!-- ALERTAS DENTRO DE LA TARJETA -->
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

                    <!-- CONTENEDOR AJAX Y TABLA CON SCROLL -->
                    <div id="contenedorTabla" class="mt-3">
                        <!-- El contenedor interno maneja el scroll explícitamente -->
                        <div class="table-responsive panel-card subtitulo" style="max-height: 500px; overflow-y: auto; border-radius: 8px;">
                            <table class="table panel-table align-middle mb-0 w-100">
                                <!-- sticky-top mantiene fijo el encabezado mientras scrolleas -->
                                <thead class="table-light sticky-top" style="z-index: 2;">
                                    <tr>
                                        <th scope="col" class="py-3 px-4 text-center">Usuario</th>
                                        <th scope="col" class="py-3 text-center">Correo</th>
                                        <th scope="col" class="py-3 text-center">Rol</th>
                                        <th scope="col" class="py-3 text-center">Activo desde</th>
                                        <th scope="col" class="py-3 text-center">Acciones</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                @forelse($clientes as $cliente)
                                    <tr>
                                        <td class="text-center fw-bold text-dark">{{ $cliente->nombre }} {{ $cliente->apellido }}</td>
                                        <td class="text-center text-secondary">{{ $cliente->email }}</td>
                                        
                                        <!-- Columna Rol -->
                                        <td class="text-center text-secondary fw-semibold">
                                            {{ ucfirst($cliente->rol->nombre) }}
                                        </td>
                                        
                                        <td class="text-center text-secondary">{{ $cliente->created_at->format('d/m/Y') }}</td>
                                        <td class="text-center text-nowrap">
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
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="fa-solid fa-users-slash fa-3x mb-3 text-secondary opacity-50"></i>
                                            <h5 class="fw-bold subtitulo">No hay usuarios para mostrar</h5>
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Paginación -->
                    <div id="contenedorPaginacion">
                        @if(method_exists($clientes, 'hasPages') && $clientes->hasPages())
                        <div class="mt-4 pt-3 border-top d-flex justify-content-center">
                            {{ $clientes->links() }}
                        </div>
                        @endif
                    </div>

                </div> <!-- Fin del card-body -->
            </div> <!-- Fin del card principal -->

        </main>
    </div>
</div>

<!-- SCRIPT PARA BUSCADOR DINÁMICO MIENTRAS SE ESCRIBE -->
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
                    
                    // Actualizamos el contenedor global para no romper la estructura del scroll
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