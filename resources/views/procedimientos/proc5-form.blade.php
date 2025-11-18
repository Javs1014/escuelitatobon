@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-light">
                    <h4 class="mb-0">Generar Reporte de Promedios Generales</h4>
                </div>
                <div class="card-body">
                    <p class="text-muted">Selecciona los filtros opcionales para generar el reporte de promedios.</p>

                    <form action="{{ route('procedimientos.proc5.run') }}" method="POST">
                        @csrf

                        {{-- Carrera (Opcional) --}}
                        <div class="form-floating mb-3">
                             <select name="nombre_carrera" class="form-select @error('nombre_carrera') is-invalid @enderror" id="nombre_carrera">
                                <option value="">-- Todas las Carreras --</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->nombre }}" {{ old('nombre_carrera') == $carrera->nombre ? 'selected' : '' }}>
                                        {{ $carrera->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="nombre_carrera"><i class="fas fa-graduation-cap me-2"></i>Carrera (Opcional)</label>
                            @error('nombre_carrera')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        {{-- Período (Año) (Opcional) --}}
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
                            <button type="submit" class="btn btn-secondary">
                                <i class="fas fa-chart-bar me-1"></i> Generar Reporte
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection