@extends('layouts.app')
@section('title', 'Iniciar Sesión')
@section('content')
    <div class="d-flex justify-content-center align-items-center">
        <div class="card shadow-lg p-4" style="width: 400px; border-radius: 15px;">
            <div class="text-center mb-3">
                <h2 class="fw-bold">Iniciar Sesión</h2>
            </div>
            <form method="POST" action="{{ route('authenticate') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Recordarme</label>
                    </div>
                    <a href="#" class="text-decoration-none">¿Olvidaste tu contraseña?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
            </form>
            <div class="text-center mt-3">
                <p class="mb-0">¿No tienes una cuenta? <a href="#" class="text-decoration-none">Regístrate</a></p>
            </div>
        </div>
    </div>
@endsection
