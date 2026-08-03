@extends('plantilla')
@section('contenido')

<title>Categorias</title>
<div class="container-fluid px-0">
    <div class="row g-0"> 
        @include('componentes.sidebar')

        <main class="col-12 col-md-9 p-3 p-md-4">
            
            <!-- TARJETA PRINCIPAL -->
            <div class="card shadow-sm border-1 rounded-4 mb-4">
                <div class="card-body p-4">
                    
                    <!-- ENCABEZADO Y BOTÓN NUEVA CATEGORÍA -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <h3 class="card-title m-0 titulo">Gestión de Categorías</h3>
                            <span class="pill-counter">{{ $categorias->count() }} categorías</span>
                        </div>
                        
                        <!-- Botón que activa el Modal -->
                        <button type="button" class="btn boton-nuevo shadow-sm" data-bs-toggle="modal" data-bs-target="#crearCategoriaModal">
                            <i class="fa-solid fa-plus me-2"></i>Nueva Categoría
                        </button>
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

                    <!-- TABLA DE CATEGORÍAS -->
                    <div class="table-responsive panel-card mt-3 subtitulo">
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

                                    <!-- Estado -->
                                    <td class="text-center">
                                        @if($categoria->activo)
                                            <span class="badge bg-success rounded-pill px-3 py-2 fw-normal shadow-sm">Activa</span>
                                        @else
                                            <span class="badge bg-danger rounded-pill px-3 py-2 fw-normal shadow-sm">Inactiva</span>
                                        @endif
                                    </td>

                                    <!-- Acciones -->
                                    <td class="text-center text-nowrap">
                                        
                                        <!-- Botón Editar que abre el modal -->
                                        <button type="button" class="btn btn-sm boton-editar shadow-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEditarCategoria{{ $categoria->id }}" title="Editar">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>

                                        <!-- Botón Eliminar -->
                                        <form action="{{ route('admin.categorias.destroy', $categoria->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar la categoría {{ $categoria->nombre }}?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm boton-eliminar shadow-sm" title="Eliminar">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- ======================================================== -->
                                <!-- MODAL PARA EDITAR CATEGORÍA (Generado por cada iteración) -->
                                <!-- ======================================================== -->
                                <div class="modal fade" id="modalEditarCategoria{{ $categoria->id }}" tabindex="-1" aria-labelledby="modalEditarLabel{{ $categoria->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content rounded-4 border-0 shadow">
                                            
                                            <div class="modal-header border-bottom-0 pb-0">
                                                <h5 class="modal-title fw-bold titulo" id="modalEditarLabel{{ $categoria->id }}">Editar Categoría</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <form action="{{ route('admin.categorias.actualizar', $categoria->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                
                                                <div class="modal-body p-4 subtitulo text-start">
                                                    
                                                    <div class="mb-3">
                                                        <label for="nombre{{ $categoria->id }}" class="form-label fw-semibold">Nombre</label>
                                                        <input type="text" class="form-control shadow-sm" id="nombre{{ $categoria->id }}" name="nombre" value="{{ $categoria->nombre }}" required placeholder="Ej: Electrónica">
                                                    </div>

                                                    <div class="mb-3 form-check form-switch">
                                                        <!-- Se utiliza un input oculto para enviar 0 si el checkbox está desmarcado -->
                                                        <input type="hidden" name="activo" value="0">
                                                        <input class="form-check-input" type="checkbox" role="switch" id="activo{{ $categoria->id }}" name="activo" value="1" {{ $categoria->activo ? 'checked' : '' }}>
                                                        <label class="form-check-label fw-semibold" for="activo{{ $categoria->id }}">Categoría Activa</label>
                                                        <small class="d-block text-muted">Si está inactiva, los productos de esta categoría no se mostrarán en el catálogo.</small>
                                                    </div>

                                                </div>
                                                
                                                <div class="modal-footer border-top-0 pt-0">
                                                    <button type="button" class="btn boton-cancelar shadow-sm" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn boton-editar shadow-sm">
                                                        <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Cambios
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- FIN MODAL EDITAR CATEGORÍA -->

                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-tags fa-3x mb-3 text-secondary opacity-50"></i>
                                        <h5 class="fw-bold subtitulo">No hay categorías registradas</h5>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                </div> <!-- Fin del card-body -->
            </div> <!-- Fin del card principal -->

        </main>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL PARA CREAR CATEGORÍA (Queda fuera del card y main) -->
<!-- ======================================================== -->
<div class="modal fade" id="crearCategoriaModal" tabindex="-1" aria-labelledby="crearCategoriaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow">
            
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold titulo" id="crearCategoriaModalLabel">Nueva Categoría</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form action="{{ route('admin.categorias.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4 subtitulo">
                    
                    <div class="mb-3">
                        <label for="nombre" class="form-label fw-semibold">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Ej: Almohadones">
                    </div>

                    <div class="mb-3 form-check form-switch">
                        <!-- Se utiliza un input oculto para enviar 0 si el checkbox está desmarcado -->
                        <input type="hidden" name="activo" value="0">
                        <input class="form-check-input" type="checkbox" role="switch" id="activo" name="activo" value="1" checked>
                        <label class="form-check-label fw-semibold" for="activo">Categoría Activa</label>
                        <small class="d-block text-muted">Si está inactiva, los productos de esta categoría no se mostrarán en el catálogo.</small>
                    </div>

                </div>
                
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn boton-cancelar shadow-sm" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn boton-nuevo shadow-sm">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Categoría
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection