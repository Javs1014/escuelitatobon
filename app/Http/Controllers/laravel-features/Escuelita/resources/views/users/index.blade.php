@extends('layouts.app')

@section('template_title')
    Gestión de Usuarios
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-sm-12">

            {{-- Encabezado --}}
            <div class="d-flex justify-content-between align-items-center my-4">
                <h1 class="mb-0">Gestión de Usuarios del Sistema</h1>
                {{-- No hay botón de crear, ya que se crean por registro --}}
            </div>

            {{-- Barra de Búsqueda --}}
            <div class="card shadow border-0 mb-4">
                <div class="card-body">
                    <form action="{{ route('users.index') }}" method="GET" class="row g-3 align-items-center">
                        <div class="col-md">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" name="search" class="form-control" placeholder="Buscar por Nombre, Correo o Rol..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-auto">
                            <button type="submit" class="btn btn-info">Buscar</button>
                            @if(request('search'))
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">Limpiar</a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            @if ($message = Session::get('success'))
                <div class="alert alert-custom-success alert-dismissible fade show" role="alert">
                    <p class="mb-0">{{ $message }}</p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-lg border-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-white">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th>Matrícula Asignada</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->role == 'admin')
                                                <span class="badge bg-danger">{{ $user->role }}</span>
                                            @elseif ($user->role == 'profesor')
                                                <span class="badge bg-success">{{ $user->role }}</span>
                                            @else
                                                <span class="badge bg-primary">{{ $user->role }}</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->matricula ?? 'N/A' }}</td>
                                        <td class="text-end">
                                            <a class="btn btn-sm btn-icon btn-success" href="{{ route('users.edit', $user->id) }}" data-bs-toggle="tooltip" title="Cambiar Contraseña">
                                                <i class="fas fa-key"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="fas fa-exclamation-circle fa-4x text-muted mb-3"></i>
                                            <h4 class="text-muted">No hay usuarios registrados.</h4>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($users->count() > 0)
                <div class="card-footer d-flex justify-content-end">
                    {!! $users->withQueryString()->links() !!}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection