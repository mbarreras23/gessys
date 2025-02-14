@extends('layouts.app')
@section('title', 'Iniciar Sesión')
@section('content')
    <div class="container">
        @include('alerts.alerts')
    </div>
    <div class="d-flex justify-content-center align-items-center">
        <div class="card shadow-lg p-4" style="width: 400px; border-radius: 15px;">
            <div class="text-center mb-3">
                <h2 class="fw-bold">Iniciar Sesión</h2>
            </div>
            <form method="POST" action="{{ route('authenticate') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label"><i class="fa fa-user"></i> Correo Electrónico</label>
                    <input type="email" class="form-control" id="email" name="email" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label"><i class="fa fa-lock"></i> Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Ingresar</button>
            </form>
        </div>
    </div>
@endsection
