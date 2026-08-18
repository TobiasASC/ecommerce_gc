<div class="container-fluid diseño-topbar py-2">
    <div class="row align-items-center">
        
        <!-- Izquierda: Logo (3 columnas en PC, 4 en móvil) -->
        <div class="col-4 col-md-3 d-flex align-items-center">
            <img src="/img/logo.PNG" class="logo" style="max-width: 90px;" alt="Logo Graciela Cueba">
        </div>

        <!-- Centro: Buscador (6 columnas en PC, 12 en móvil al final de la fila) -->
        <div class="col-12 col-md-6 order-3 order-md-2 mt-3 mt-md-0 d-none d-md-flex justify-content-center" id="wrapper-buscador">
            <div id="contenedor-buscador" class="position-relative w-100" style="max-width: 500px;">
                <form action="{{ route('productos.buscar') }}" method="GET" class="w-100 d-flex align-items-center position-relative">
                    <i class="fa-solid fa-magnifying-glass position-absolute text-muted" style="left: 15px; z-index: 10;"></i>
                    <input type="text" id="buscador-topbar" name="query" class="form-control rounded-pill ps-5 py-2 border-0 shadow-sm w-100" placeholder="Buscar..." aria-label="Buscar" autocomplete="off" style="background-color: #f8f9fa;">
                </form>
                
                <!-- Contenedor de Sugerencias (Absoluto y forzado hacia abajo) -->
                <div id="sugerencias-container-topbar" class="position-absolute w-100 bg-white border border-light rounded shadow-lg mt-1" style="z-index: 1050; display: none; top: 100%; left: 0; max-height: 300px; overflow-y: auto;"></div>
            </div>
        </div>

        <!-- Derecha: Iconos (3 columnas en PC, 8 en móvil) -->
        <div class="col-8 col-md-3 order-2 order-md-3 d-flex justify-content-end align-items-center gap-3 fs-3">
            
            <!-- Botón Lupa exclusivo para móvil (alineado a la derecha con los iconos) -->
            <button class="btn d-md-none fs-4 text-light p-0" id="btn-lupa-movil" type="button">
                <i class="fa-solid fa-magnifying-glass color-iconos-topbar"></i>
            </button>

            @auth
                @if(Auth::user()->rol->nombre === 'admin')
                    <!-- Dropdown Admin -->
                    <div class="dropdown">
                        <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" class="text-decoration-none">
                            <i class="fa-solid fa-circle-user color-iconos-topbar"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end fs-6 shadow">
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
                    <a href="{{ route('carrito.mostrar') }}">
                        <i class="fa-solid fa-cart-shopping color-iconos-topbar"></i>
                    </a>

                    <!-- Dropdown Cliente -->
                    <div class="dropdown">
                        <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" class="text-decoration-none">
                            <i class="fa-solid fa-circle-user color-iconos-topbar"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end fs-6 shadow">
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
                <!-- Invitado -->
                <a href="/login">
                    <i class="fa-solid fa-circle-user color-iconos-topbar"></i>
                </a>
            @endauth
        </div>
        
    </div>
</div>

<script>
    // Toggle buscador en móvil
    document.getElementById('btn-lupa-movil').addEventListener('click', function() {
        const wrapper = document.getElementById('wrapper-buscador');
        wrapper.classList.toggle('d-none');
        wrapper.classList.toggle('d-flex');
    });

    // Petición AJAX para sugerencias
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
                        // ¡NUEVO!: Se agregó la clase 'sugerencia-item' para el CSS
                        item.className = 'dropdown-item p-3 text-dark border-bottom d-block sugerencia-item';
                        item.style.cursor = 'pointer';
                        item.style.textDecoration = 'none';
                        item.textContent = producto.nombre;
                        
                        // Los eventos mouseover y mouseout fueron eliminados. 
                        // Ahora el hover se controla 100% desde el CSS.

                        container.appendChild(item);
                    });
                    container.style.display = 'block';
                } else {
                    container.style.display = 'none';
                }
            })
            .catch(error => {
                console.error("Error al buscar productos:", error);
                container.style.display = 'none';
            });
    });

    // Ocultar al hacer clic fuera del buscador
    document.addEventListener('click', function(e) {
        const wrapper = document.getElementById('wrapper-buscador');
        // NOTA: Asegúrate de que este ID coincida con tu HTML real (buscador o buscador-topbar)
        const buscador = document.getElementById('buscador'); 
        const btnLupa = document.getElementById('btn-lupa-movil');
        const container = document.getElementById('sugerencias-container');
        
        if (!buscador.contains(e.target) && !btnLupa.contains(e.target)) {
            container.style.display = 'none';
            if (window.innerWidth < 768 && !wrapper.contains(e.target)) {
                 wrapper.classList.add('d-none');
                 wrapper.classList.remove('d-flex');
            }
        }
    });
</script>
</div>