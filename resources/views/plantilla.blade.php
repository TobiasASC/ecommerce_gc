<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/img/logo.png">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/styles.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
</head>
<body class="d-flex flex-column min-vh-100">
    <header>
    @include('componentes.topbar')
    @include('componentes.navbar')
    </header>
    
    <main class="flex-grow-1">
    @yield('contenido')
    </main>

    <footer class="mt-auto">
    @include('componentes.footer')
    </footer>
    





<script src="/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        AOS.init({
            duration: 800, // Duración de la animación en milisegundos
            once: true, // Si es true, la animación solo ocurre una vez al bajar
            offset: 100 // Distancia en píxeles desde el borde de la pantalla para activarse
        });
    });
</script>

</body>
</html>