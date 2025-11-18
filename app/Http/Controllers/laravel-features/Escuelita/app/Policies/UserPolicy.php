<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Realiza una comprobación previa.
     * Si el usuario es 'admin', tiene permiso para TODO.
     */
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null; // Dejar que los otros métodos decidan
    }

    /**
     * Determina si el usuario puede ver la lista de usuarios.
     * (Solo el admin puede, gracias al 'before')
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determina si el usuario puede ver un usuario específico.
     * (Solo el admin puede, gracias al 'before')
     */
    public function view(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determina si el usuario puede actualizar un usuario.
     * (Solo el admin puede, gracias al 'before')
     */
    public function update(User $user, User $model): bool
    {
        return false;
    }

    // No permitimos que nadie cree o borre usuarios desde aquí
    public function create(User $user): bool { return false; }
    public function delete(User $user, User $model): bool { return false; }
}