<?php

namespace App\Policies;

use App\Models\Historiale;
use App\Models\User;

class HistorialePolicy
{
    // El admin puede hacer todo
    public function before(User $user, string $ability): bool|null
    {
        if ($user->role === 'admin') {
            return true;
        }
        return null;
    }

    // ¿Quién puede ver la lista? (Todos, pero se filtra en el controlador)
    public function viewAny(User $user): bool
    {
        return true;
    }

    // ¿Quién puede ver UN registro? (El alumno dueño o el profesor del grupo)
    public function view(User $user, Historiale $historiale): bool
    {
        if ($user->role === 'alumno') {
            return $user->matricula === $historiale->alumno_matricula;
        }
        if ($user->role === 'profesor' && $historiale->grupo) {
            return $user->matricula === $historiale->grupo->profesor_id;
        }
        return false;
    }
    public function update(User $user, Historiale $historiale): bool
    {
        // 1. ¿Es un profesor?
        if ($user->role === 'profesor') {
            
            // 2. ¿El historial tiene un grupo asignado?
            if ($historiale->grupo) {
                
                // 3. ¿La matrícula del usuario (profesor) es la misma que la del profesor del grupo?
                return $user->matricula === $historiale->grupo->profesor_id;
            }
        }
        
        // Alumnos u otros roles no pueden
        return false;
    }
    public function delete(User $user, Historiale $historiale): bool
    {
        return false; // Solo el admin puede, manejado por el 'before'
    }

    // Nadie (excepto admin) puede crear, editar o borrar historiales
    public function create(User $user): bool { return false; }
}