@extends('plantilla')
@section('contenido')

<title>Nuevo producto</title>
<div class="container-fluid px-0 overflow-hidden">
    <div class="row g-0"> 
        
        @include('componentes.sidebar')

        <main class="col-12 col-md-9 col-xl-10 p-3 p-md-4" style="min-width: 0;">
            
            <div class="card shadow-sm border-1 rounded-4 mb-4">
                <div class="card-body p-4">
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="card-title m-0 titulo">Crear Nuevo Producto</h3>
                        <a href="{{ route('admin.productos.index') }}" class="btn boton-volver btn-sm shadow-sm">
                            <i class="fa-solid fa-arrow-left me-1"></i> Volver
                        </a>
                    </div>
                    <hr>

                    <!-- ALERTAS DE ERROR DE VALIDACIÓN -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm panel-alerta mb-4" role="alert">
                        <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <!-- FORMULARIO DE CREACIÓN -->
                    <form action="{{ route('admin.productos.guardar') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-3 subtitulo">
                            <!-- Nombre -->
                            <div class="col-md-6">
                                <label for="nombre" class="form-label fw-semibold">Nombre del Producto</label>
                                <input type="text" class="form-control shadow-sm" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                            </div>

                            <!-- Categoría -->
                            <div class="col-md-6">
                                <label for="categoria_id" class="form-label fw-semibold">Categoría</label>
                                <select class="form-select shadow-sm" id="categoria_id" name="categoria_id" required>
                                    <option value="">Seleccione una categoría</option>
                                    @foreach($categorias as $categoria)
                                        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Precio de Venta -->
                            <div class="col-md-4">
                                <label for="precio_venta" class="form-label fw-semibold">Precio de Venta ($)</label>
                                <input type="number" step="0.01" class="form-control shadow-sm" id="precio_venta" name="precio_venta" value="{{ old('precio_venta') }}" required>
                            </div>

                            <!-- Stock Actual -->
                            <div class="col-md-4">
                                <label for="stock_actual" class="form-label fw-semibold">Stock Actual</label>
                                <input type="number" class="form-control shadow-sm" id="stock_actual" name="stock_actual" value="{{ old('stock_actual') }}" required>
                            </div>

                            <!-- Stock Mínimo -->
                            <div class="col-md-4">
                                <label for="stock_minimo" class="form-label fw-semibold">Stock Mínimo</label>
                                <input type="number" class="form-control shadow-sm" id="stock_minimo" name="stock_minimo" value="{{ old('stock_minimo') }}" required>
                            </div>

                            <!-- Descripción -->
                            <div class="col-12">
                                <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                                <textarea class="form-control shadow-sm" id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                            </div>

                            <!-- Imagen -->
                            <div class="col-12">
                                <label for="imagen" class="form-label fw-semibold">Imagen del Producto</label>
                                <input type="file" class="form-control shadow-sm" id="imagen" name="imagen" accept="image/png, image/jpeg, image/jpg, image/webp">
                            </div>

                            <!-- Botones de Acción -->
                            <div class="col-12 mt-4 d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.productos.index') }}" class="btn boton-cancelar shadow-sm">Cancelar</a>
                                <button type="submit" class="btn boton-nuevo shadow-sm">
                                    <i class="fa-solid fa-floppy-disk me-2"></i>Guardar Producto</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>

        </main>
    </div>
</div>
@endsection