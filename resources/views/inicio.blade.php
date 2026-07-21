@extends('plantilla')
@section('contenido')

<title>Inicio</title>

<div class="banner">
  <div class="blob b1"></div>
  <div class="blob b2"></div>

  <div class="text-side">
    <div class="eyebrow">Hecho a mano</div>
    <h1>Regala algo<br><em>único</em></h1>
    <p class="subtitle">Regalos personalizados y manualidades hechas a mano, pensadas para acompañar cada historia con cariño.</p>
    <div class="cta-row">
      <a href="/catalogo" class="cta">
        Ver catálogo
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
      </a>
    </div>
  </div>

  <div class="gallery">
    <div class="pic p1"></div>
    <div class="pic p2"></div>
    <div class="pic p3"></div>
    <div class="pic p4"></div>
    <div class="pic p5"></div>
  </div>
</div>



<section class="seccion-categoria pt-4" id="categorias">
    <!-- El "container" agrupa el contenido y "contenedor-reducido" ajusta el ancho -->
    <div class="container contenedor-reducido">
        <div class="text-center mb-5">
            <h1 class="titulo-inicio fw-bold">Categorias</h1>
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

<section class="seccion-destacados" id="destacados">
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

<section class="seccion-contacto mt-5" id="contacto">
    <!-- El "container" agrupa el contenido y "contenedor-reducido" ajusta el ancho -->
    <div class="container contenedor-reducido">
        <div class="text-center mb-5">
            <h1 class="titulo-inicio mt-4 fw-bold">Contacto</h1>
        </div>
        
        <!-- "justify-content-center" asegura que si sobran columnas, queden en el medio -->
        <div class="row justify-content-center text-start">
            <div class="col-md-12 mb-4">
                <div class="card p-4 tarjeta-contacto-custom h-100">
                    <div class="card-body">
                        <h2 class="fw-bold fs-3">Información de Contacto</h2>

                        <div class="mb-3">
                            <strong><i class="fa-brands fa-whatsapp"></i> Teléfono</strong><br>
                            <span>+54 3794-382461</span>
                        </div>

                        <div class="mb-3">
                            <strong><i class="fa-solid fa-envelope"></i> Email</strong><br>
                            <span>gcdiseños@gmail.com</span>
                        </div>

                        <div class="mb-3">
                            <strong><i class="fa-solid fa-clock"></i> Horarios de Atención</strong><br>
                            <span>Lun - Vie: 9:00 - 12:00 / 17:00 - 21:00</span><br>
                            <span>Sab: 9:00 - 13:00</span>
                        </div>
                          
                        <div class="mb-3">
                            <strong><i class="fa-brands fa-instagram"></i> Instagram</strong><br>
                            <span>@gcdiseños</span>
                        </div>

                        <div class="mb-3">
                            <strong><i class="fa-brands fa-square-facebook"></i> Facebook </strong><br>
                            <span>@gc_diseños</span>
                        </div>
                    </div>
                    </div>


            
        </div>
    </div>
</section>



@endsection