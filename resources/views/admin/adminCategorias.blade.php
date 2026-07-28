@extends('plantilla')
@section('contenido')
<div class="container-fluid px-0">
    <div class="row g-0"> 
        @include('componentes.sidebar')

        <main class="col-12 col-md-9 p-4">
            
            <!-- ALERTAS -->
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

            <!-- ENCABEZADO Y BOTÓN NUEVA CATEGORÍA -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-secondary m-0">Gestión de Categorías</h3>
                
                <!-- Botón que activa el Modal -->
                <button type="button" class="btn btn-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#crearCategoriaModal">
                    <i class="fa-solid fa-plus me-2"></i>Nueva Categoría
                </button>
            </div>

            <!-- TABLA DE CATEGORÍAS -->
            <div class="card shadow-sm borde rounded-4 overflow-hidden">
                <div class="table-responsive panel-card">
                    <table class="table panel-table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="py-3 px-4">Nombre de Categoría</th>
                                <th scope="col" class="py-3 text-center">Estado</th>
                                <th scope="col" class="py-3 text-center">Acciones</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                        @forelse($categorias as $categoria)
                            <tr>
                                <!-- Nombre -->
                                <td class="px-4 fw-bold text-dark">
                                    {{ $categoria->nombre }}
                                </td>

                                <!-- Estado (Basado en tu campo 'activo') -->
                                <td class="text-center">
                                    @if($categoria->activo)
                                        <span class="badge bg-success p-2">Activa</span>
                                    @else
                                        <span class="badge bg-secondary p-2">Inactiva</span>
                                    @endif
                                </td>

                                <!-- Acciones -->
                                <td class="text-center">
                                    
                                    <!-- Botón Eliminar -->
                                    <form action="{{ route('admin.categorias.destroy', $categoria->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar la categoría {{ $categoria->nombre }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger shadow-sm" title="Eliminar">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-tags fa-3x mb-3 text-light"></i>
                                    <h5 class="fw-bold">No hay categorías registradas</h5>
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

<!-- ======================================================== -->
<!-- MODAL PARA CREAR CATEGORÍA -->
<!-- ======================================================== -->
<div class="modal fade" id="crearCategoriaModal" tabindex="-1" aria-labelledby="crearCategoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold" id="crearCategoriaModalLabel">Nueva Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.categorias.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ej: Electrónica">
                    </div>

                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="activo" name="activo" value="1" checked>
                        <label class="form-check-label fw-semibold" for="activo">Categoría Activa</label>
                        <small class="d-block text-muted">Si está inactiva, los productos de esta categoría no se mostrarán en el catálogo.</small>
                    </div>

                </div>
                
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary shadow-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Categoría
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection