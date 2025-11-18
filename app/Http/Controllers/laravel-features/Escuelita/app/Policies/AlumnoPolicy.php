<?php

namespace App\Policies;

use App\Models\Alumno; // <-- ¡Cambia esto por el modelo correspondiente!
use App\Models\User;

class AlumnoPolicy // <-- ¡Cambia esto por el nombre de la Política!
{
    /**
     * El admin puede hacer todo.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null; // Dejar que otros métodos decidan (pero todos devolverán false)
    }

    // Nadie más (ni profesor ni alumno) puede gestionar Alumnos.
    public function viewAny(User $user): bool { return false; }
    public function view(User $user, Alumno $model): bool { return false; } // <-- Cambia Alumno $model
    public function create(User $user): bool { return false; }
    public function update(User $user, Alumno $model): bool { return false; } // <-- Cambia Alumno $model
    public function delete(User $user, Alumno $model): bool { return false; } // <-- Cambia Alumno $model
}