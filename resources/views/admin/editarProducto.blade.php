@extends('plantilla')
@section('contenido')

<title>Editar producto</title>
<div class="container-fluid px-0">
    <div class="row g-0"> 
        @include('componentes.sidebar')

        <main class="col-12 col-md-9 p-3 p-md-4">
            
            <!-- TARJETA PRINCIPAL -->
            <div class="card shadow-sm border-1 rounded-4 mb-4">
                <div class="card-body p-4">
                    
                    <!-- ENCABEZADO Y BOTÓN VOLVER -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3 gap-3">
                        <h3 class="card-title m-0 titulo fw-bold">Editar Producto: <span>{{ $producto->nombre }}</span></h3>
                        <a href="{{ route('admin.productos.index') }}" class="btn boton-volver shadow-sm">
                            <i class="fa-solid fa-arrow-left me-2"></i>Volver
                        </a>
                    </div>
                    <hr>

                    <!-- FORMULARIO -->
                    <form action="{{ route('admin.productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <!-- Columna Izquierda: Datos del Producto -->
                            <div class="col-12 col-lg-8 subtitulo">
                                
                                <div class="mb-3">
                                    <label for="nombre" class="form-label fw-semibold">Nombre del Producto</label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" placeholder="Ej: Playera Estampada">
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                                    <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="4" placeholder="Describe los detalles del producto">{{ old('descripcion', $producto->descripcion) }}</textarea>
                                    @error('descripcion')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="precio_venta" class="form-label fw-semibold">Precio de Venta ($)</label>
                                        <input type="number" step="0.01" class="form-control @error('precio_venta') is-invalid @enderror" id="precio_venta" name="precio_venta" value="{{ old('precio_venta', $producto->precio_venta) }}">
                                        @error('precio_venta')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="stock_actual" class="form-label fw-semibold">Stock Actual</label>
                                        <input type="number" class="form-control @error('stock_actual') is-invalid @enderror" id="stock_actual" name="stock_actual" value="{{ old('stock_actual', $producto->stock_actual) }}">
                                        @error('stock_actual')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="stock_minimo" class="form-label fw-semibold">Stock Mínimo</label>
                                        <input type="number" class="form-control @error('stock_minimo') is-invalid @enderror" id="stock_minimo" name="stock_minimo" value="{{ old('stock_minimo', $producto->stock_minimo) }}">
                                        @error('stock_minimo')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="categoria_id" class="form-label fw-semibold">Categoría</label>
                                    <select class="form-select @error('categoria_id') is-invalid @enderror" id="categoria_id" name="categoria_id">
                                        <option value="">Seleccione una categoría</option>
                                        @foreach($categorias as $categoria)
                                            <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('categoria_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Columna Derecha: Imagen del Producto -->
                            <div class="col-12 col-lg-4 d-flex flex-column align-items-center border-start border-light pt-3 pt-lg-0 subtitulo">
                                
                                <label class="form-label fw-semibold w-100 text-center">Imagen Actual</label>
                                
                                <div class="mb-3 text-center">
                                    @if($producto->imagen_url)
                                        <img src="{{ \App\Support\MediaStorage::resolveUrl($producto->imagen_url) }}" alt="{{ $producto->nombre }}" class="img-thumbnail rounded shadow-sm" style="max-width: 200px; height: auto;">
                                    @else
                                        <div class="bg-light border text-muted d-flex flex-column align-items-center justify-content-center rounded p-4 mx-auto" style="width: 200px; height: 200px;">
                                            <i class="fa-solid fa-image fa-3x mb-2"></i>
                                            <span>Sin imagen</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="w-100">
                                    <label for="imagen" class="form-label fw-semibold text-center w-100">Reemplazar Imagen (Opcional)</label>
                                    <input type="file" class="form-control @error('imagen') is-invalid @enderror" id="imagen" name="imagen" accept=".jpg,.jpeg,.png,.webp">
                                    <small class="text-muted d-block mt-1 text-center">Formatos: JPG, PNG, WEBP. Máx: 2MB.</small>
                                    @error('imagen')
                                        <div class="invalid-feedback text-center">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-4 text-muted">

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn boton-nuevo px-4 shadow-sm subtitulo">
                                <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                    
                </div> <!-- Fin del card-body -->
            </div> <!-- Fin del card -->
        </main>
    </div>
</div>
@endsection