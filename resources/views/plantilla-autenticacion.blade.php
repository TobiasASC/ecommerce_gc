<!-- platilla para registro e inicio de sesion -->
<!DOCTYPE html>

<html>
    <!--links comunes-->
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    </head>

    <!--cuerpo con animacion-->
    <body class= "body-autenticacion">
        <main>
            @yield('contenido')
        </main>

        <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>

        <!--script comun para funcionalidad de contraseña-->
        <script>
            document.addEventListener('click', function (e) {
                const toggle = e.target.closest('.toggle-password');
                if (!toggle) return;

                const input = document.getElementById(toggle.dataset.target);
                if (!input) return;

                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';

                toggle.classList.toggle('bi-eye');
                toggle.classList.toggle('bi-eye-slash');
            });
        </script>

    </body>
</html>