@extends('plantilla-autenticacion') 

@section('contenido')

<title>Registrarse</title>

<!-- Eliminamos el div contenedor que forzaba los 100vh extra y agregamos mx-auto a la tarjeta -->
<div class="card tarjeta-autenticacion mx-auto" style="max-width: 520px; width: 100%;">
  
  <div class="card-body">

    <div class="text-center mb-2 fs-1">
      <i class="fa-solid fa-user"></i>
    </div>

    <form action="/register" method="POST" class="text-center">
      @csrf

      <h2 class="mb-3">Registrarse</h2>

      @if ($errors->any())
        <div class="alert alert-danger text-start">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- nombre apellido -->
      <div class="row">
        <div class="col-md-6 mb-2 text-start">
          <label class="form-label">Nombre</label>
          <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="col-md-6 mb-2 text-start">
          <label class="form-label">Apellido</label>
          <input type="text" name="apellido" class="form-control" required>
        </div>
      </div>

      <!-- email -->
      <div class="mb-2 text-start">
        <label class="form-label">Correo electrónico</label>
        <input type="email" 
        name="email" 
        class="form-control" 
        pattern="[a-zA-Z0-9._%+\-]+@[a-zA-Z0-9.\-]+\.[a-zA-Z]{2,}$" 
        title="Ingresa un correo electrónico válido. Por ejemplo: tu_nombre@dominio.com"
        required>
      </div>

      <!-- password -->
      <div class="row">
        <div class="col-md-6 mb-2 text-start password-wrapper">
          <label class="form-label">Contraseña</label>
            <div class="password-wrapper">
              <input type="password" 
              name="password" 
              class="form-control pe-5" 
              id="password-register" 
              minlength="8" 
              title="La contraseña debe tener al menos 8 caracteres."
              required>
           <i class="bi bi-eye password-toggle toggle-password" data-target="password-register"></i>
          </div>
        </div>

        <div class="col-md-6 mb-2 text-start">
          <label class="form-label">Confirmar contraseña</label>
          <div class="password-wrapper">
            <input type="password" name="password_confirmation" class="form-control pe-5" id="password-confirm" required>
        
            <i class="bi bi-eye password-toggle toggle-password"
              data-target="password-confirm">
            </i>
          </div>
        </div>
      </div>

      <p class="mt-2">
        ¿Ya tenés cuenta? <a href="/login">Iniciá sesión acá</a>
      </p>

      <div class="d-grid">
        <button type="submit" class="btn btn-autenticar">
          Registrarse
        </button>
      </div>

      <div class="d-grid mt-2">
        <a href="/" class="btn btn-invitado">
          Continuar como invitado
        </a>
      </div>

    </form>

  </div>
</div>

@endsection