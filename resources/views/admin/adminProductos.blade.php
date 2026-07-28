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

            <!-- ENCABEZADO Y FILTRO -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-secondary m-0">Gestión de Productos</h3>
                
                <form action="{{ route('admin.productos.index') }}" method="GET" class="d-flex align-items-center">
                    <label for="categoria_id" class="me-2 fw-semibold text-muted">Filtrar:</label>
                    <select name="categoria_id" id="categoria_id" class="form-select form-select-sm shadow-sm" onchange="this.form.submit()">
                        <option value="">Todas las categorías</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            <!-- TABLA DE PRODUCTOS -->
            <div class="card shadow-sm borde rounded-4 overflow-hidden">
                <div class="table-responsive panel-card">
                    <table class="table panel-table align-middle mb-0">
                        <thead class="table-light">
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
                                <!-- Imagen -->
                                <td class="text-center">
                                    @if($producto->imagen_url)
                                        <img src="{{ asset($producto->imagen_url) }}" alt="{{ $producto->nombre }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary text-white rounded d-flex align-items-center justify-content-center mx-auto" style="width: 60px; height: 60px;">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                </td>
                                
                                <!-- Producto -->
                                <td>
                                    <div class="fw-bold text-dark">{{ $producto->nombre }}</div>
                                    <small class="text-muted text-truncate d-inline-block" style="max-width: 250px;">
                                        {{ $producto->descripcion ?? 'Sin descripción' }}
                                    </small>
                                </td>

                                <!-- Precio -->
                                <td class="text-center fw-semibold text-success">
                                    ${{ number_format($producto->precio_venta, 2) }}
                                </td>

                                <!-- Stock (Con alerta visual si es bajo) -->
                                <td class="text-center">
                                    @if($producto->stock_actual <= $producto->stock_minimo)
                                        <span class="badge bg-danger p-2" title="Stock por debajo del mínimo ({{ $producto->stock_minimo }})">
                                            {{ $producto->stock_actual }} / {{ $producto->stock_minimo }} <i class="fa-solid fa-arrow-down ms-1"></i>
                                        </span>
                                    @else
                                        <span class="badge bg-primary p-2">
                                            {{ $producto->stock_actual }} / {{ $producto->stock_minimo }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Acciones -->
                                <td class="text-center">
                                    <!-- Botón Editar -->
                                    <a href="{{ route('admin.productos.edit', $producto->id) }}" class="btn btn-sm btn-outline-secondary shadow-sm" title="Editar">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    <!-- Formulario Eliminar -->
                                    <form action="{{ route('admin.productos.destroy', $producto->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Estás seguro de eliminar el producto {{ $producto->nombre }}? Esta acción no se puede deshacer.');">
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
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fa-solid fa-box-open fa-3x mb-3 text-light"></i>
                                    <h5 class="fw-bold">No se encontraron productos</h5>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Paginación (si decides usarla) -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $productos->links() }}
            </div>

        </main>
    </div>
</div>
@endsection