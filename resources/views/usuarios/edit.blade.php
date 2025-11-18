@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Editar Rol de Usuario') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('usuarios.update', $user) }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Nombre:</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" value="{{ $user->name }}" disabled>
                            </div>
                        </div>
                        

                        <div class="row mb-3">
                            <label class="col-md-4 col-form-label text-md-end">Email:</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="matricula" class="col-md-4 col-form-label text-md-end">{{ __('Matrícula') }}</label>
                            <div class="col-md-6">
                                {{-- Este campo SÍ es editable --}}
                                <input id="matricula" type="text" class="form-control @error('matricula') is-invalid @enderror" name="matricula" value="{{ old('matricula', $user->matricula) }}" required autocomplete="matricula">

                                @error('matricula')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Asignar Nuevo Rol') }}</label>
                            <div class="col-md-6">
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                    @foreach ($roles as $rol)
                                        <option value="{{ $rol }}" {{ $user->role == $rol ? 'selected' : '' }}>
                                            {{ $rol }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Actualizar Rol') }}
                                </button>
                                <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                                    Cancelar
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection