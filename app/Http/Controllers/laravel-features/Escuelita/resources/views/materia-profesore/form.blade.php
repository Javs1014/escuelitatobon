<div class="row">
    {{-- Muestra errores de LÓGICA (Este es el que necesitas) --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>¡Error de Lógica!</strong>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    {{-- Columna Izquierda --}}
    <div class="col-md-6">
        <div class="form-floating mb-3">
            {{-- 
              Si el usuario NO es admin, deshabilita este campo.
              La directiva @disabled() de Blade es perfecta para esto.
            --}}
            <select name="alumno_matricula" class="form-select @error('alumno_matricula') is-invalid @enderror" id="alumno_matricula" @disabled(auth()->user()->role !== 'admin')>
                <option value="">-- Seleccione un Alumno --</option>
                @foreach($alumnos as $matricula => $nombre_completo)
                    <option value="{{ $matricula }}" {{ old('alumno_matricula', $historiale?->alumno_matricula) == $matricula ? 'selected' : '' }}>
                        {{ $nombre_completo }} ({{ $matricula }})
                    </option>
                @endforeach
            </select>
            <label for="alumno_matricula"><i class="fas fa-user-graduate me-2"></i>Alumno</label>
            @error('alumno_matricula') <div class="invalid-feedback">{{ $message }}</div> @enderror
            
            {{-- Si está deshabilitado, enviamos el valor antiguo en un campo oculto --}}
            @if(auth()->user()->role !== 'admin')
                <input type="hidden" name="alumno_matricula" value="{{ $historiale->alumno_matricula }}">
            @endif
        </div>

        <div class="form-floating mb-3">
            <select name="grupo_id" class="form-select @error('grupo_id') is-invalid @enderror" id="grupo_id" @disabled(auth()->user()->role !== 'admin')>
                <option value="">-- Seleccione un Grupo --</option>
                @foreach($grupos as $id => $nombre)
                    <option value="{{ $id }}" {{ old('grupo_id', $historiale?->grupo_id) == $id ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                @endforeach
            </select>
            <label for="grupo_id"><i class="fas fa-book me-2"></i>Grupo (Materia y Grupo)</label>
            @error('grupo_id') <div class="invalid-feedback">{{ $message }}</div> @enderror

            @if(auth()->user()->role !== 'admin')
                <input type="hidden" name="grupo_id" value="{{ $historiale->grupo_id }}">
            @endif
        </div>

        <div class="form-floating mb-3">
            {{-- ESTE CAMPO ESTÁ SIEMPRE HABILITADO --}}
            <input type="number" step="0.01" name="calificacion" 
                   class="form-control @error('calificacion') is-invalid @enderror" 
                   value="{{ old('calificacion', $historiale?->calificacion) ?? '' }}" 
                   id="calificacion" placeholder="Ej: 8.50 (o dejar vacío)">
            
            <label for="calificacion">
                <i class="fas fa-star-half-alt me-2"></i>Calificación (Opcional: dejar vacío si está en curso)
            </label>
            
            @error('calificacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
    </div>

    {{-- Columna Derecha --}}
    <div class="col-md-6">
        <div class="form-floating mb-3">
            <input type="number" name="semestre" class="form-control @error('semestre') is-invalid @enderror" value="{{ old('semestre', $historiale?->semestre) }}" id="semestre" placeholder="Ej: 3" @disabled(auth()->user()->role !== 'admin')>
            <label for="semestre"><i class="fas fa-calendar-alt me-2"></i>Semestre Cursado</label>
            @error('semestre')<div class="invalid-feedback">{{ $message }}</div>@enderror
            
            @if(auth()->user()->role !== 'admin')
                <input type="hidden" name="semestre" value="{{ $historiale->semestre }}">
            @endif
        </div>

        <div class="form-floating mb-3">
            <input type="number" name="año" class="form-control @error('año') is-invalid @enderror" value="{{ old('año', $historiale?->año) }}" id="año" placeholder="Ej: 2024" @disabled(auth()->user()->role !== 'admin')>
            <label for="año"><i class="fas fa-calendar-day me-2"></i>Año Cursado</label>
            @error('año')<div class="invalid-feedback">{{ $message }}</div>@enderror

            @if(auth()->user()->role !== 'admin')
                <input type="hidden" name="año" value="{{ $historiale->año }}">
            @endif
        </div>

        
    </div>
</div>

{{-- Botones de Acción --}}
<div class="d-flex justify-content-end mt-4">
    <a href="{{ route('historiales.index') }}" class="btn btn-outline-secondary me-2">
        <i class="fas fa-times me-1"></i> Cancelar
    </a>
    <button type="submit" class="btn btn-primary-custom">
        <i class="fas fa-save me-1"></i> Guardar Registro
    </button>
</div>