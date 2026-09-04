@extends('plantilla')
@section('contenido')

<title>Catálogo</title>

<div class="encabezado-catalogo mb-5">
    <div class="container text-center">
        <h1 class="titulo-catalogo fw-bold mb-4">Nuestro Catálogo</h1>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('catalogo') }}" method="GET" class="mb-4">
                    <div class="input-group shadow rounded-pill overflow-hidden p-1 bg-white">
                        <input type="text" name="buscar" class="form-control border-0 bg-transparent px-4" placeholder="Buscar artesanías, regalos..." value="{{ request('buscar') }}" style="box-shadow: none;">
                        <button class="btn boton-buscar px-4 fw-bold rounded-pill" type="submit"><i class="fa-solid fa-magnifying-glass me-1"></i> Buscar</button>
                    </div>
                </form>
                <div class="d-flex gap-2 justify-content-start justify-content-md-center overflow-auto py-2 px-3" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <a href="{{ route('catalogo') }}" class="btn btn-categoria-catalogo rounded-pill px-4 text-nowrap shadow-sm {{ !request()->route('id') ? 'bg-white fw-bold border-0' : 'btn-outline-light border-0' }}" style="{{ !request()->route('id') ? 'color: var(--morado_oscuro) !important;' : 'color: rgba(255,255,255,0.8);' }}">Todas</a>
                    @foreach($categorias as $categoria)
                        <a href="{{ route('catalogo.categoria', $categoria->id) }}" class="btn btn-categoria-catalogo rounded-pill px-4 text-nowrap shadow-sm {{ request()->route('id') == $categoria->id ? 'bg-white fw-bold border-0' : 'btn-outline-light border-0' }}" style="{{ request()->route('id') == $categoria->id ? 'color: var(--morado_oscuro) !important;' : 'color: rgba(255,255,255,0.8);' }}">{{ $categoria->nombre }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row g-4">
        @foreach($productos as $producto)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border-0 texto-secundario tarjeta-custom">
                    <div class="card-img-container"><img src="{{ \App\Support\MediaStorage::resolveUrl($producto->imagen_url) }}" class="card-img-top-catalog" alt="{{ $producto->nombre }}"></div>
                    <div class="card-body d-flex flex-column p-3">
                        <span class="badge categoria-producto mb-2 align-self-start">{{ $producto->categoria->nombre }}</span>
                        <h5 class="card-title fw-bold mb-1 subtitulo">{{ $producto->nombre }}</h5>
                        <p class="card-text text-muted small mb-2">{{ Str::limit($producto->descripcion, 70) }}</p>
                        <h4 class="mt-auto fw-bold subtitulo mb-3">${{ number_format($producto->precio_venta, 2) }}</h4>
                        @if($producto->stock_actual <= 0)
                            <span class="text-danger fw-bold small mb-2 d-block"><i class="fa-solid fa-circle-xmark me-1"></i> Sin Stock</span>
                        @endif
                        <div class="d-grid gap-2">
                            <a href="{{ route('producto.mostrar', $producto->id) }}" class="btn boton-detalle rounded-pill">Ver detalles</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
