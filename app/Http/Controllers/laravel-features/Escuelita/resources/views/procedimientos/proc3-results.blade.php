@extends('layouts.app')

@section('template_title')
    Historial de Alumno
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Historial Académico</h4>
                        <a href="{{ route('procedimientos.proc3.form') }}" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Nueva Consulta
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    
                    {{-- Información del Alumno --}}
                    <div class="mb-4 p-3 bg-light rounded border">
                        <h5 class="mb-1">{{ $alumno->nombre }} {{ $alumno->segundo_nombre }} {{ $alumno->apellido_paterno }} {{ $alumno->apellido_materno }}</h5>
                        <p class="text-muted mb-1">Matrícula: <span class="fw-bold">{{ $alumno->matricula }}</span></p>
                        <p class="text-muted mb-0">
                            Período consultado: 
                            <span class="badge bg-primary">{{ $periodo ?? 'Todos los períodos' }}</span>
                        </p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="thead-light">
                                <tr>
                                    <th>Materia</th>
                                    <th>Grupo</th>
                                    <th>Semestre</th>
                                    <th>Año</th>
                                    <th>Calificación</th>
                                    <th>Oportunidad</th>
                                    <th>Profesor</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($resultados as $resultado)
                                    <tr>
                                        <td>{{ $resultado->nombre_materia }}</td>
                                        <td><span class="badge bg-secondary">{{ $resultado->nombre_grupo ?? 'N/A' }}</span></td>
                                        <td>{{ $resultado->semestre }}</td>
                                        <td>{{ $resultado->anio }}</td>
                                        <td><span class="badge bg-{{ $resultado->calificacion >= 7 ? 'success' : 'danger' }}">{{ number_format($resultado->calificacion, 2) }}</span></td>
                                        <td>{{ $resultado->oportunidad }}</td>
                                        <td>{{ $resultado->nombre_profesor }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="mb-0">No se encontraron registros en el historial para los filtros seleccionados.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection