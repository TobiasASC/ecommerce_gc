<!-- barra de navegacion para las vistas -->
<nav class="navbar navbar-expand-lg diseño-navbar">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav fw-bold">
                <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" aria-current="page" href="/">INICIO</a>
                <a class="nav-link {{ request()->is('catalogo') || request()->is('categorias/*')? 'active' : '' }}" href="/catalogo">CATÁLOGO</a>
                <a class="nav-link {{ request()->is('contacto') ? 'active' : '' }}" href="{{ route('inicio') }}#categorias">DESTACADOS</a>
                <a class="nav-link {{ request()->is('contacto') ? 'active' : '' }}" href="{{ route('inicio') }}#contacto">CONTACTO</a>
            </div>
        </div>
    </div>
</nav>