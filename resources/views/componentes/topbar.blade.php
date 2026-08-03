<div class="container-fluid d-flex align-items-center justify-content-between diseño-topbar">
    <!--logo en letras de la empresa-->
    <div class="d-flex align-items-center">
        <img src="/img/logo.png" class="logo">
    </div>

    <!--iconos-->
    <div class="d-flex align-items-center gap-3 fs-3">
        @auth
            @if(Auth::user()->rol->nombre === 'admin')
                <!-- Dropdown Admin -->
                <div class="dropdown">
                    <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" class="text-decoration-none">
                        <i class="fa-solid fa-circle-user color-iconos-topbar"></i>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end fs-6">
                        <li><a class="dropdown-item" href="{{ route('admin.clientes') }}">Gestionar</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="/logout" method="POST" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="dropdown-item">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
                
            @else
                
                <!-- Ícono carrito (solo cliente) -->
                <a href="{{ route('carrito.mostrar') }}"><i class="fa-solid fa-cart-shopping color-iconos-topbar"></i></a>

                <!-- Dropdown Cliente -->
                <div class="dropdown">
                    <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" class="text-decoration-none">
                        <i class="fa-solid fa-circle-user color-iconos-topbar"></i>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end fs-6">
                        <li><a class="dropdown-item" href="{{ route('cliente.cuenta') }}">Mi perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="/logout" method="POST" class="m-0 p-0">
                                @csrf
                                <button type="submit" class="dropdown-item">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
                
            @endif

        @else
            <!-- Invitado (Sin dropdown, te lleva directo al login) -->
            <a href="/login">
                <i class="fa-solid fa-circle-user color-iconos-topbar"></i>
            </a>
            
        @endauth
    </div>
</div>