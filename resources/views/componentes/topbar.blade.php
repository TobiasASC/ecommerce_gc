<div class="container-fluid d-flex align-items-center justify-content-between diseño-topbar">
    <!--logo en letras de la empresa-->
        <div class="d-flex align-items-center">
        <img src="/img/logo.PNG" class="logo">
    </div>

        <!-- Barra de búsqueda -->
    <div class="flex-grow-1 mx-4 position-relative">
        <form action="{{ route('productos.buscar') }}" method="GET" class="d-flex">
            <input type="text" id="buscador" name="query" class="form-control rounded-pill" placeholder="Buscar productos..." aria-label="Buscar" autocomplete="off">
        </form>
        <div id="sugerencias-container" class="position-absolute w-100 bg-white border rounded shadow mt-1" style="z-index: 1000; display: none;"></div>
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

    <script>
        document.getElementById('buscador').addEventListener('input', function() {
            let query = this.value;
            let container = document.getElementById('sugerencias-container');

            if (query.length < 2) {
                container.style.display = 'none';
                return;
            }

            fetch(`{{ route('productos.sugerencias') }}?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    container.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(producto => {
                            let item = document.createElement('a');
                            item.href = `/producto/${producto.id}`;
                            item.className = 'dropdown-item text-decoration-none p-2';
                            item.textContent = producto.nombre;
                            container.appendChild(item);
                        });
                        container.style.display = 'block';
                    } else {
                        container.style.display = 'none';
                    }
                });
        });

        // Ocultar al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (!document.getElementById('buscador').contains(e.target)) {
                document.getElementById('sugerencias-container').style.display = 'none';
            }
        });
    </script>
</div>