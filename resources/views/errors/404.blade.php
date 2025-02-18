@extends('layouts.app', ['show_footer' => false])
@section('title', '404 - Página no encontrada')
@section('content')
    <div class="container text-center">
        {{ Auth::user() }}
        <h1 class="display-1 text-danger">404 :(</h1>
        <h2 class="h3 mb-4">¡Lo sentimos, no pudimos encontrar la página!</h2>
        <p>La página que buscas no existe o fue removida.</p>
        <a href="{{ route('welcome') }}" class="btn btn-primary">
            <i class="fa-solid fa-home"></i> Volver al inicio
        </a>
    </div>
@endsection
