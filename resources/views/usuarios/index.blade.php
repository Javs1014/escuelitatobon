@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fs-5">{{ __('Gestión de Usuarios y Roles') }}</span>

                    <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Crear Nuevo Usuario
                    </a>
                </div>


                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email / Username</th>
                                    <th>Matrícula</th>
                                    <th>Rol Actual</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->matricula ?? 'N/A' }}</td>

                                        <td>
                                            @if ($user->role == 'Administrador')
                                                <span class="badge bg-danger">{{ $user->role }}</span>
                                            @elseif ($user->role == 'Docente')
                                                <span class="badge bg-info text-dark">{{ $user->role }}</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $user->role }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('usuarios.edit', $user) }}" class="btn btn-sm btn-primary">
                                                Editar Rol
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection