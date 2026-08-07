@extends('plantilla')
@section('contenido')

<title>Productos</title>
<div class="container-fluid px-0 overflow-hidden">
    <div class="row g-0"> 
        
        @include('componentes.sidebar')

        <main class="col-12 col-md-9 col-xl-10 p-3 p-md-4" style="min-width: 0;">
            
            <!-- TARJETA PRINCIPAL -->
            <div class="card shadow-sm border-1 rounded-4 mb-4">
                <div class="card-body p-4">
                    
                    <!-- ENCABEZADO Y FILTRO -->
                    <div class="d-flex flex-column flex-xl-row justify-content-between align-items-xl-center mb-3 gap-3">
                        <div class="d-flex align-items-center gap-2">
                            <h3 class="card-title m-0 titulo">Gestión de Productos</h3>
                            <span class="pill-counter">{{ $productos->total() }} productos</span>
                        </div>
                        
                        <!-- FORMULARIO Y BOTÓN NUEVO -->
                        <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-3 flex-wrap">
                            <form action="{{ route('admin.productos.index') }}" method="GET" class="d-flex flex-column flex-sm-row align-items-sm-center gap-3" id="formBusqueda">
                                
                                <!-- BUSCADOR -->
                                <div class="input-group shadow-sm" style="max-width: 280px;">
                                    <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                                    <input type="text" name="search" id="search" class="form-control border-start-0" placeholder="Buscar producto..." value="{{ request('search') }}">
                                </div>

                                <!-- FILTRO -->
                                <div class="d-flex align-items-center">
                                    <label for="categoria_id" class="me-2 fw-semibold text-muted text-nowrap mb-0">Filtrar:</label>
                                    <select name="categoria_id" id="categoria_id" class="form-select form-select-sm shadow-sm" style="width: auto; min-width: 140px;" onchange="this.form.submit()">
                                        <option value="">Todas</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>

                            <!-- BOTÓN NUEVO PRODUCTO -->
                            <a href="{{ route('admin.productos.crear') }}" class="btn boton-nuevo shadow-sm text-nowrap">
                                <i class="fa-solid fa-plus me-1"></i> Nuevo Producto
                            </a>
                        </div>
                    </div>
                    <hr>
            
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

                    <!-- TABLA DE PRODUCTOS -->
                    <div class="table-responsive panel-card mt-3 subtitulo" id="contenedorTabla" style="max-height: 500px; overflow-y: auto; overflow-x: auto;">
                        <table class="table panel-table align-middle mb-0 w-100">
                            <thead class="table-light sticky-top" style="z-index: 1;">
                                <tr>
                                    <th scope="col" class="py-3 px-4 text-center">Imagen</th>
                                    <th scope="col" class="py-3">Producto</th>
                                    <th scope="col" class="py-3 text-center">Precio</th>
                                    <th scope="col" class="py-3 text-center">Stock</th>
                                    <th scope="col" class="py-3 text-center">Acciones</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                            @forelse($productos as $producto)
                                <tr>
                                    <td class="text-center">
                                        @if($producto->imagen_url)
                                            <img src="{{ \App\Support\MediaStorage::resolveUrl($producto->imagen_url) }}" alt="{{ $producto->nombre }}" class="img-thumbnail shadow-sm" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                                        @else
                                            <div class="bg-light text-secondary shadow-sm d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 60px; border-radius: 8px;">
                                                <i class="fa-solid fa-image fs-4"></i>
                                            </div>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        <div class="fw-bold text-dark">{{ $producto->nombre }}</div>
                                        <small class="text-muted text-truncate d-inline-block" style="max-width: 250px;">
                                            {{ $producto->descripcion ?? 'Sin descripción' }}
                                        </small>
                                    </td>

                                    <td class="text-center fw-semibold text-success">
                                        ${{ number_format($producto->precio_venta, 2) }}
                                    </td>

                                    <td class="text-center">
                                        @if($producto->stock_actual <= $producto->stock_minimo)
                                            <span class="badge bg-danger rounded-pill px-3 py-2 fw-normal shadow-sm" title="Stock por debajo del mínimo ({{ $producto->stock_minimo }})">
                                                {{ $producto->stock_actual }} / {{ $producto->stock_minimo }} <i class="fa-solid fa-arrow-down ms-1"></i>
                                            </span>
                                        @else
                                            <span class="badge pil-stock rounded-pill px-3 py-2 fw-normal shadow-sm">
                                                {{ $producto->stock_actual }} / {{ $producto->stock_minimo }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="text-center text-nowrap">
                                        <a href="{{ route('admin.productos.edit', $producto->id) }}" class="btn btn-sm boton-editar shadow-sm" title="Editar">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar el producto {{ $producto->nombre }}? Esta acción no se puede deshacer.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm boton-eliminar shadow-sm" title="Eliminar">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-box-open fa-3x mb-3 text-secondary opacity-50"></i>
                                        <h5 class="fw-bold subtitulo">No se encontraron productos</h5>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Paginación -->
                    <div id="contenedorPaginacion">
                        @if($productos->hasPages())
                        <div class="mt-4 pt-3 border-top d-flex justify-content-center">
                            {{ $productos->links() }}
                        </div>
                        @endif
                    </div>

                </div>
            </div>

        </main>
    </div>
</div>

<!-- SCRIPT BUSCADOR DINÁMICO -->
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
                    document.getElementById('contenedorPaginacion').innerHTML = doc.getElementById('contenedorPaginacion').innerHTML;
                });
            }, 300);
        });
    });
</script>
@endsection