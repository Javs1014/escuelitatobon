@extends('layouts.app')

@section('template_title')
    Cambiar Contraseña
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Encabezado --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">Cambiar Contraseña</h1>
                <a class="btn btn-outline-secondary" href="{{ route('users.index') }}">
                    <i class="fas fa-arrow-left"></i> Volver al listado
                </a>
            </div>

            {{-- Tarjeta con el formulario --}}
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <h5 class="mb-0">Usuario: {{ $user->name }}</h5>
                    <p class="text-muted">{{ $user->email }}</p>
                    <hr>

                    <form method="POST" action="{{ route('users.update', $user->id) }}" role="form">
                        @method('PATCH')
                        @csrf
                        @include('users.form')
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection