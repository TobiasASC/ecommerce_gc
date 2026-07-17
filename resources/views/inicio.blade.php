@extends('plantilla')
@section('contenido')

<title>Inicio</title>

<img src="{{ asset('img/Banner.png') }}" class="banner">



<section class="seccion-categoria mt-5">
    <!-- El "container" agrupa el contenido y "contenedor-reducido" ajusta el ancho -->
    <div class="container contenedor-reducido">
        <div class="text-center mb-5">
            <h1 class="titulo-inicio mt-4 fw-bold">Categorias</h1>
            <p class="fs-4">Regala lo que mas gusta</p>
        </div>
        
        <!-- "justify-content-center" asegura que si sobran columnas, queden en el medio -->
        <div class="row justify-content-center text-center">
            
            <div class="col-md-4 mb-4">
                <div class="card p-4 tarjeta-custom h-100">
                    <div class="card-body">
                        <i class="fa-solid fa-bag-shopping fs-1 mb-3"></i>
                        <h2 class="fw-bold fs-3">Bolsos</h2>
                        <p class="fs-6">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ratione sunt.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card p-4 tarjeta-custom h-100">
                    <div class="card-body">
                        <i class="fa-regular fa-face-kiss-wink-heart fs-1 mb-3"></i>
                        <h2 class="fw-bold fs-3">Decoraciones</h2>
                        <p class="fs-6">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card p-4 tarjeta-custom h-100">
                    <div class="card-body">
                        <i class="fa-solid fa-key fs-1 mb-3"></i>
                        <h2 class="fw-bold fs-3">Llaveros</h2>
                        <p class="fs-6">Lorem ipsum dolor sit amet consectetur, adipisicing elit.</p>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<section class="seccion-destacados">
    <div class="container contenedor-reducido">
        <h1 class="text-center titulo-inicio mt-4 mb-5 fw-bold">Productos destacados</h1>
        
        <div class="row justify-content-center text-center">
            
            <div class="col-md-4 mb-4">
                <div class="card p-3 tarjeta-custom h-100">
                    <div class="card-body">
                        <span class="d-block mb-3 bg-light p-4 rounded">imagen</span>
                        <h2 class="fw-bold fs-4">Producto</h2>
                        <p class="fs-6">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card p-3 tarjeta-custom h-100">
                    <div class="card-body">
                        <span class="d-block mb-3 bg-light p-4 rounded">imagen</span>
                        <h2 class="fw-bold fs-4">Producto</h2>
                        <p class="fs-6">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card p-3 tarjeta-custom h-100">
                    <div class="card-body">
                        <span class="d-block mb-3 bg-light p-4 rounded">imagen</span>
                        <h2 class="fw-bold fs-4">Producto</h2>
                        <p class="fs-6">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card p-3 tarjeta-custom h-100">
                    <div class="card-body">
                        <span class="d-block mb-3 bg-light p-4 rounded">imagen</span>
                        <h2 class="fw-bold fs-4">Producto</h2>
                        <p class="fs-6">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card p-3 tarjeta-custom h-100">
                    <div class="card-body">
                        <span class="d-block mb-3 bg-light p-4 rounded">imagen</span>
                        <h2 class="fw-bold fs-4">Producto</h2>
                        <p class="fs-6">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card p-3 tarjeta-custom h-100">
                    <div class="card-body">
                        <span class="d-block mb-3 bg-light p-4 rounded">imagen</span>
                        <h2 class="fw-bold fs-4">Producto</h2>
                        <p class="fs-6">Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>



@endsection