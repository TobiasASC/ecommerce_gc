@extends('plantilla')
@section('contenido')
<title>{{ $producto->nombre }}</title>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="mb-3 text-start"><a href="{{ route('catalogo') }}" class="btn boton-volver"><i class="fa-solid fa-arrow-left me-2"></i>Volver al catálogo</a></div>
            <div class="card shadow-sm borde-personalizado rounded-4 overflow-hidden">
                <div class="bg-light p-4 text-center"><img src="{{ \App\Support\MediaStorage::resolveUrl($producto->imagen_url) }}" class="img-fluid" style="max-height: 350px; width: 100%; object-fit: contain;" alt="{{ $producto->nombre }}"></div>
                <div class="card-body p-4 d-flex flex-column text-start">
                    <h2 class="card-title titulo fw-bold mb-3">{{ $producto->nombre }}</h2>
                    <p class="card-text subtitulo mb-4">{{ $producto->descripcion ?? 'Descripción no disponible.' }}</p>
                    @php($whatsappNumber = config('services.whatsapp_number'))
                    <a href="{{ $whatsappNumber ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsappNumber) . '?text=' . urlencode('Hola, quiero consultar por ' . $producto->nombre) : '#' }}" class="btn btn-success" target="_blank" rel="noopener" @if(!$whatsappNumber) aria-disabled="true" @endif><i class="fa-brands fa-whatsapp me-1"></i> Consultar</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
