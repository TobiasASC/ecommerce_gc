@extends('plantilla')
@section('contenido')
<!-- Cambiamos 'container' por 'container-fluid' y quitamos el padding horizontal con 'px-0' -->
<div class="container-fluid px-0">
    <div class="row g-0"> <!-- g-0 quita los espacios predeterminados (gutters) entre columnas -->
        
    @include('componentes.sidebar')

        <!-- Contenido principal (Columna de 9/12 en Desktop) -->
        <main class="col-12 col-md-9">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="card-title mb-3 titulo">Mis Datos</h3>
                    <hr>
                
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
                    


                <form method="POST" action="{{ route('cliente.actualizar') }}">
                @csrf
                @method('PUT')

                <div class="row subtitulo">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control"
                            name="nombre"
                            value="{{ $usuario->nombre }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Apellido</label>
                        <input type="text" class="form-control"
                            name="apellido"
                            value="{{ $usuario->apellido }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email" class="form-control"
                            name="email"
                            value="{{ $usuario->email }}">
                    </div>
                </div>

                <div class="row align-items-end subtitulo">

                        <div class="col-md-8 mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password"
                                class="form-control"
                                value="********"
                                disabled>
                        </div>

                        <div class="col-md-4 mb-3">
                            <button type="button"
                                    class="btn btn-contraseña w-100"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#cambiarPassword">
                                <i class="bi bi-key me-1"></i>
                                Cambiar contraseña
                            </button>
                        </div>

                    </div>

                    <div class="collapse" id="cambiarPassword">

                        <div class="row mt-2 subtitulo">

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Contraseña actual</label>
                                <input type="password"
                                    name="contraseña_actual"
                                    class="form-control">

                                @error('password_actual')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nueva contraseña</label>
                                <input type="password"
                                    name="contraseña"
                                    class="form-control">
                                @error('password')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Confirmar contraseña</label>
                                <input type="password"
                                    name="confirmacion_contraseña"
                                    class="form-control">
                            </div>

                        </div>

                    </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-confirmar-cuenta w-100">
                        Guardar cambios
                </button>

                </div>
                </form>
                    
                </div>
            </div>
        </main>

    </div>
</div>
@endsection