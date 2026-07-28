

        <!-- Sidebar -->
        <!-- bg-light: fondo gris claro. vh-100: alto de toda la pantalla. sticky-top: se queda fija al hacer scroll -->
        <aside class="col-12 col-md-3 col-lg-2 bg-light p-3 sticky-top vh-100 overflow-auto border-end">
            <nav class="nav nav-pills flex-row flex-nowrap flex-md-column gap-2 pb-2 pb-md-0 subtitulo">
                @if(Auth::user()->rol_id == 1)
                <a class="nav-link text-nowrap {{ request()->routeIs('admin.estadisticas') ? 'activo' : 'text-dark' }}" href="{{ route('admin.estadisticas') }}">
                    <i class="fas fa-user me-2"></i> Estadisticas generales
                </a>

                <a class="nav-link text-nowrap {{ request()->routeIs('admin.clientes') ? 'activo' : 'text-dark' }}" href="{{ route('admin.clientes') }}">
                    <i class="fas fa-user me-2"></i> Clientes
                </a>

                <a class="nav-link text-nowrap {{ request()->routeIs('admin.pedidos') ? 'activo' : 'text-dark' }}" href="{{ route('admin.pedidos') }}">
                    <i class="fas fa-user me-2"></i> Pedidos
                </a>

                <a class="nav-link text-nowrap {{ request()->routeIs('admin.productos.index') ? 'activo' : 'text-dark' }}" href="{{ route('admin.productos.index') }}">
                    <i class="fas fa-box me-2"></i> Productos
                </a>

                <a class="nav-link text-nowrap {{ request()->routeIs('admin.categorias.index') ? 'activo' : 'text-dark' }}" href="{{ route('admin.categorias.index') }}">
                    <i class="fas fa-tags me-2"></i> Categorias
                </a>
                @else
                <h2>Hola {{ Auth::user()->nombre }}</h2>
                
                <a class="nav-link text-nowrap {{ request()->routeIs('cliente.cuenta') ? 'activo' : 'text-dark' }}" href="{{ route('cliente.cuenta') }}">
                    <i class="fas fa-user me-2"></i> Mis Datos
                </a>
                
                <a class="nav-link text-nowrap {{ request()->routeIs('cliente.pedidos') ? 'activo' : 'text-dark' }}" href="{{ route('cliente.pedidos') }}">
                    <i class="fas fa-box me-2"></i> Mis Pedidos
                </a>
                
                <a class="nav-link text-nowrap {{ request()->routeIs('carrito.mostrar') ? 'activo' : 'text-dark' }}" href="{{ route('carrito.mostrar') }}">
                    <i class="fas fa-shopping-cart me-2"></i> Mi Carrito
                </a>
            @endif
            </nav>
        </aside>