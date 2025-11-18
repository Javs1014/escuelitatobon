@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Consultar Historial de Alumno</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">Selecciona un alumno y, opcionalmente, un período para ver su historial.</p>

                    <form action="{{ route('procedimientos.proc3.run') }}" method="POST">
                        @csrf

                        {{-- Campo para seleccionar el Alumno por matrícula --}}
                        <div class="form-floating mb-3">
                             <select name="matricula_alumno" class="form-select @error('matricula_alumno') is-invalid @enderror" id="matricula_alumno" required>
                                <option value="">-- Seleccione un Alumno --</option>
                                @foreach($alumnos as $alumno)
                                    <option value="{{ $alumno->matricula }}" {{ old('matricula_alumno') == $alumno->matricula ? 'selected' : '' }}>
                                        {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}, {{ $alumno->nombre }} ({{ $alumno->matricula }})
                                    </option>
                                @endforeach
                            </select>
                            <label for="matricula_alumno"><i class="fas fa-user-graduate me-2"></i>Alumno (Requerido)</label>
                            @error('matricula_alumno')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Período (Año) - Opcional --}}
                        <div class="form-floating mb-3">
                             <select name="periodo" class="form-select @error('periodo') is-invalid @enderror" id="periodo">
                                <option value="">-- Todos los Períodos --</option>
                                @foreach($años as $año)
                                    <option value="{{ $año }}" {{ old('periodo') == $año ? 'selected' : '' }}>
                                        {{ $año }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="periodo"><i class="fas fa-calendar-alt me-2"></i>Período (Año) (Opcional)</label>
                            @error('periodo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('procedimientos.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i> Consultar Historial
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection