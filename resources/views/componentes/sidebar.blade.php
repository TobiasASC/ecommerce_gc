<!-- Sidebar -->
<aside class="col-12 col-md-3 col-xl-2 bg-light p-3 border-end" style="position: sticky; top: 0; align-self: flex-start; max-height: 100vh; overflow-y: auto;">
    <nav class="nav nav-pills flex-column gap-2 pb-2 pb-md-0 subtitulo">
        @if(Auth::user()->rol_id == 1)
            <a class="nav-link d-flex align-items-center text-wrap {{ request()->routeIs('admin.clientes') ? 'activo' : 'text-dark' }}" href="{{ route('admin.clientes') }}">
                <i class="fas fa-users me-2"></i> Usuarios
            </a>

            <a class="nav-link d-flex align-items-center text-wrap {{ request()->routeIs('admin.pedidos') ? 'activo' : 'text-dark' }}" href="{{ route('admin.pedidos') }}">
                <i class="fas fa-clipboard-list me-2"></i> Pedidos
            </a>

            <a class="nav-link d-flex align-items-center text-wrap {{ request()->routeIs('admin.productos.index') ? 'activo' : 'text-dark' }}" href="{{ route('admin.productos.index') }}">
                <i class="fas fa-box me-2"></i> Productos
            </a>

            <a class="nav-link d-flex align-items-center text-wrap {{ request()->routeIs('admin.categorias.index') ? 'activo' : 'text-dark' }}" href="{{ route('admin.categorias.index') }}">
                <i class="fas fa-tags me-2"></i> Categorías
            </a>
        @else
            <h4 class="mb-3 titulo fw-bold">Hola, {{ Auth::user()->nombre }}</h4>
            
            <a class="nav-link d-flex align-items-center text-wrap {{ request()->routeIs('cliente.cuenta') ? 'activo' : 'text-dark' }}" href="{{ route('cliente.cuenta') }}">
                <i class="fas fa-user-cog me-2"></i> Mis Datos
            </a>
            
            <a class="nav-link d-flex align-items-center text-wrap {{ request()->routeIs('cliente.pedidos') ? 'activo' : 'text-dark' }}" href="{{ route('cliente.pedidos') }}">
                <i class="fas fa-box-open me-2"></i> Mis Pedidos
            </a>
            
            <a class="nav-link d-flex align-items-center text-wrap {{ request()->routeIs('carrito.mostrar') ? 'activo' : 'text-dark' }}" href="{{ route('carrito.mostrar') }}">
                <i class="fas fa-shopping-cart me-2"></i> Mi Carrito
            </a>
        @endif
    </nav>
</aside>