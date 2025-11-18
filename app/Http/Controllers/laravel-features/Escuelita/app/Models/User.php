<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',       // <-- AÑADIDO
        'matricula',  // <-- AÑADIDO
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * ==========================================================
     * NUEVO: Relaciones para obtener el perfil
     * ==========================================================
     */

    /**
     * Obtiene el perfil de profesor si este usuario es un profesor.
     */
    public function profesorProfile()
    {
        // Vincula users.matricula con profesores.matricula
        return $this->hasOne(Profesore::class, 'matricula', 'matricula');
    }

    /**
     * Obtiene el perfil de alumno si este usuario es un alumno.
     */
    public function alumnoProfile()
    {
        // Vincula users.matricula con alumnos.matricula
        return $this->hasOne(Alumno::class, 'matricula', 'matricula');
    }
}