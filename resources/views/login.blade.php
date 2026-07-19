@extends('plantilla-autenticacion') 
@section('contenido')

<title>Iniciar Sesión</title>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
  
  <div class="card tarjeta-autenticacion" style="max-width: 520px; width: 100%;">
    
    <div class="card-body">

      <div class="text-center mb-3 fs-1">
        <i class="fa-solid fa-user"></i>
      </div>

      <form class="text-center" method="POST" action="/login">
        @csrf

        <h2 class="mb-4">Iniciar sesión</h2>

        <div class="mb-3 text-start">
          <label class="form-label">Correo electrónico</label>
          <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3 text-start">
          <label class="form-label">Contraseña</label>

          <div class= "password-wrapper">
            <input type="password" name="password" class="form-control pe-5" id="password-login" required>

            <i class="bi bi-eye password-toggle toggle-password"
              data-target="password-login">
            </i>
          </div>
        </div>

        @if ($errors->any())
          <div class="alert alert-danger">
            {{ $errors->first() }}
          </div>
        @endif

        <p class="mt-3">
          ¿No tenés una cuenta? <a href="/register">Registrate acá</a>
        </p>

        <div class="d-grid">
          <button type="submit" class="btn btn-autenticar">
            Iniciar sesión
          </button>
        </div>

        <div class="d-grid mt-3">
          <a href="/" class="btn btn-invitado">
            Continuar como invitado
          </a>
        </div>

      </form>

    </div>
  </div>
</div>

@endsection