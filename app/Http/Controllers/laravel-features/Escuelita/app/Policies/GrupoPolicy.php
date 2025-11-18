<?php

namespace App\Policies;

use App\Models\Grupo;
use App\Models\User;

class GrupoPolicy
{
    // El admin puede hacer todo
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null;
    }

    // ¿Quién puede ver la lista de grupos? (Admin y Profesores)
    public function viewAny(User $user): bool
    {
        return $user->role === 'profesor';
    }

    // ¿Quién puede ver UN grupo? (Solo el profesor de ese grupo)
    public function view(User $user, Grupo $grupo): bool
    {
        return $user->matricula === $grupo->profesor_id;
    }

    // ¿Quién puede crear? (Solo Admin)
    public function create(User $user): bool { return false; }
    // ¿Quién puede editar? (Solo Admin)
    public function update(User $user, Grupo $grupo): bool { return false; }
    // ¿Quién puede borrar? (Solo Admin)
    public function delete(User $user, Grupo $grupo): bool { return false; }
}