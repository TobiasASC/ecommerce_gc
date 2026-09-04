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



<section class="seccion-categoria pt-4 pb-5" id="categorias">
    <div class="container contenedor-reducido">
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="titulo-inicio fw-bold">Categorías</h1>
            <p class="fs-4">Regala lo que más gusta</p>
        </div>
        
        <div class="row justify-content-center text-center">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card p-4 tarjeta-custom h-100">
                    <div class="card-body">
                        <i class="fa-solid fa-bag-shopping fs-1 mb-3"></i>
                        <h2 class="fw-bold fs-3">Bolsos</h2>
                        <p class="fs-6">Diseños exclusivos y funcionales, pensados para acompañarte en tu día a día con comodidad y un estilo único.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card p-4 tarjeta-custom h-100">
                    <div class="card-body">
                        <i class="fa-regular fa-face-kiss-wink-heart fs-1 mb-3"></i>
                        <h2 class="fw-bold fs-3">Decoraciones</h2>
                        <p class="fs-6">Detalles únicos y llenos de calidez para darle vida a cada rincón y convertir cualquier espacio en un verdadero hogar.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="card p-4 tarjeta-custom h-100">
                    <div class="card-body">
                        <i class="fa-solid fa-key fs-1 mb-3"></i>
                        <h2 class="fw-bold fs-3">Llaveros</h2>
                        <p class="fs-6">Un pequeño gran detalle para regalar o regalarte. Llevá siempre con vos un accesorio original, artesanal y con mucho estilo.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="seccion-destacados py-5" id="destacados">
    <div class="container contenedor-reducido">
        <div class="text-center mb-5" data-aos="fade-up">
            <h1 class="titulo-inicio fw-bold">Productos destacados</h1>
        </div>
        
        <!-- Contenedor principal que oculta lo que se sale de la pantalla -->
        <div class="marquee-container" data-aos="fade-up" data-aos-delay="100">
            <!-- La pista que se mueve -->
            <div class="marquee-track">
                

                <!-- Tarjeta 1 -->
                <div class="card p-3 tarjeta-custom tarjeta-slider">
                    <div class="card-body">
                        <img src="img/destacados/atrapa-sueños-vive.jpeg" alt="Producto de Graciela Cueba" class="img-destacada-ajustada mb-3">
                        <h2 class="fw-bold fs-4">Atrapasueños Vive</h2>
                        <p class="fs-6 text-muted">Detalles encapsulados para llevar un pedacito de arte a todos lados.</p>
                    </div>
                </div>

                <!-- Tarjeta 2 -->
                <div class="card p-3 tarjeta-custom tarjeta-slider">
                    <div class="card-body">
                        <img src="img/destacados/bolsa-arpillera-cuadrados.jpeg" alt="Producto de Graciela Cueba" class="img-destacada-ajustada mb-3">
                        <h2 class="fw-bold fs-4">Bolsa Arpillera</h2>
                        <p class="fs-6 text-muted">Calidez y estilo rústico para llevar.</p>
                    </div>
                </div>

                <!-- Tarjeta 3 -->
                <div class="card p-3 tarjeta-custom tarjeta-slider">
                    <div class="card-body">
                        <img src="img/destacados/bolso-lienzo-tela.jpeg" alt="Producto de GC" class="img-destacada-ajustada mb-3">
                        <h2 class="fw-bold fs-4">Bolsa de tela</h2>
                        <p class="fs-6 text-muted">Práctica, cómoda y con un diseño que destaca del resto.</p>
                    </div>
                </div>
                
                <!-- Tarjeta 4 -->
                <div class="card p-3 tarjeta-custom tarjeta-slider">
                    <div class="card-body">
                        <img src="img/destacados/bolsa-baño.jpeg" alt="Producto de GC" class="img-destacada-ajustada mb-3">
                        <h2 class="fw-bold fs-4">Bolsa para Baño</h2>
                        <p class="fs-6 text-muted">Un toque especial para organizar tus espacios con estilo.</p>
                    </div>
                </div>

                <!-- ================= GRUPO 2 (Duplicado exacto para el efecto infinito) ================= -->
                <!-- Tarjeta 1 -->
                <div class="card p-3 tarjeta-custom tarjeta-slider">
                    <div class="card-body">
                        <img src="img/destacados/1785696115_casa-decorativa.jpeg" alt="Producto de GC" class="img-destacada-ajustada mb-3">
                        <h2 class="fw-bold fs-4">Casa decorativa</h2>
                        <p class="fs-6 text-muted">Diseño único y artesanal, ideal para acompañar tus tardes.</p>
                    </div>
                </div>

                <!-- Tarjeta 2 -->
                <div class="card p-3 tarjeta-custom tarjeta-slider">
                    <div class="card-body">
                        <img src="img/destacados/atrapa-sueños-vive.jpeg" alt="Producto de GC" class="img-destacada-ajustada mb-3">
                        <h2 class="fw-bold fs-4">Atrapasueños Vive</h2>
                        <p class="fs-6 text-muted">Detalles encapsulados para llevar un pedacito de arte a todos lados.</p>
                    </div>
                </div>

                <!-- Tarjeta 3 -->
                <div class="card p-3 tarjeta-custom tarjeta-slider">
                    <div class="card-body">
                        <img src="img/destacados/bolsa-arpillera-cuadrados.jpeg" alt="Producto de GC" class="img-destacada-ajustada mb-3">
                        <h2 class="fw-bold fs-4">Bolsa Arpillera</h2>
                        <p class="fs-6 text-muted">Calidez y estilo rústico para llevar.</p>
                    </div>
                </div>

                <!-- Tarjeta 4 -->
                <div class="card p-3 tarjeta-custom tarjeta-slider">
                    <div class="card-body">
                        <img src="img/destacados/bolso-lienzo-tela.jpeg" alt="Producto de GC" class="img-destacada-ajustada mb-3">
                        <h2 class="fw-bold fs-4">Bolsa de tela</h2>
                        <p class="fs-6 text-muted">Práctica, cómoda y con un diseño que destaca del resto.</p>
                    </div>
                </div>
                
                <!-- Tarjeta 5 -->
                <div class="card p-3 tarjeta-custom tarjeta-slider">
                    <div class="card-body">
                        <img src="img/destacados/bolsa-baño.jpeg" alt="Producto de GC" class="img-destacada-ajustada mb-3">
                        <h2 class="fw-bold fs-4">Bolsa para Baño</h2>
                        <p class="fs-6 text-muted">Un toque especial para organizar tus espacios con estilo.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<!-- SECCIÓN DE CONTACTO DINÁMICA (Sin bg-light para que tome el var(--rosa)) -->
<section class="seccion-contacto py-5" id="contacto">
    <div class="container contenedor-reducido">
        <div class="text-center mb-5" data-aos="fade-down">
            <h1 class="titulo-inicio mt-4 fw-bold">Contacto</h1>
            <p class="subtitulo fs-4">Estamos aquí para ayudarte a crear el regalo perfecto.</p>
        </div>
        
        <div class="row justify-content-center text-center g-4">
            
            <!-- WhatsApp -->
            <div class="col-12 col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
                <div class="card h-100 p-4 tarjeta-contacto shadow-sm border-0 rounded-4">
                    <div class="icono-flotante mb-3 text-success">
                        <i class="fa-brands fa-whatsapp" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="fw-bold">WhatsApp</h4>
                    <p class="text-muted mb-4">-</p>
                    @php($whatsappNumber = config('services.whatsapp_number'))
                    <a href="{{ $whatsappNumber ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $whatsappNumber) . '?text=' . urlencode('Hola, quiero realizar una consulta') : '#' }}" class="btn btn-outline-success rounded-pill mt-auto fw-bold" target="_blank" rel="noopener" @if(!$whatsappNumber) aria-disabled="true" @endif>Enviar mensaje</a>
                </div>
            </div>

            <!-- Email -->
            <div class="col-12 col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
                <div class="card h-100 p-4 tarjeta-contacto shadow-sm border-0 rounded-4">
                    <div class="icono-flotante mb-3 text-primary">
                        <i class="fa-brands fa-square-facebook" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="fw-bold">Facebook</h4>
                    <p class="text-muted mb-4 small">-</p>
                    <a href="#" class="btn btn-outline-primary rounded-pill mt-auto fw-bold">Seguir pagina</a>
                </div>
            </div>

            <!-- Redes -->
            <div class="col-12 col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="400">
                <div class="card h-100 p-4 tarjeta-contacto shadow-sm border-0 rounded-4">
                    <div class="icono-flotante mb-3" style="color: #E1306C;">
                        <i class="fa-brands fa-instagram" style="font-size: 3rem;"></i>
                    </div>
                    <h4 class="fw-bold">Instagram</h4>
                    <p class="text-muted mb-4">@gcdiseños</p>
                    <a href="https://www.instagram.com/gracielacueba/" class="btn btn-outline-dark rounded-pill mt-auto fw-bold">Seguir página</a>
                </div>
            </div>

        </div>
    </div>
</section>


@endsection