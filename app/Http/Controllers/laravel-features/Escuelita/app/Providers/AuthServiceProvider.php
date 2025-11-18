<?php

namespace App\Providers;

// AÑADIR TODAS ESTAS LÍNEAS
use App\Models\Alumno;
use App\Models\Profesore;
use App\Models\Area;
use App\Models\Carrera;
use App\Models\Materia;
use App\Models\Paquete;
use App\Models\Grupo;
use App\Models\Historiale;
use App\Policies\AlumnoPolicy;
use App\Policies\ProfesorePolicy;
use App\Policies\AreaPolicy;
use App\Policies\CarreraPolicy;
use App\Policies\MateriaPolicy;
use App\Policies\PaquetePolicy;
use App\Policies\GrupoPolicy;
use App\Policies\HistorialePolicy;
use App\Models\User;
use App\Policies\UserPolicy;
// Quitamos 'use Illuminate\Pagination\Paginator;' de aquí

// FIN DE LÍNEAS A AÑADIR

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // AÑADE TODO ESTE BLOQUE
        Alumno::class => AlumnoPolicy::class,
        Profesore::class => ProfesorePolicy::class,
        Area::class => AreaPolicy::class,
        Carrera::class => CarreraPolicy::class,
        Materia::class => MateriaPolicy::class,
        Paquete::class => PaquetePolicy::class,
        Grupo::class => GrupoPolicy::class,
        Historiale::class => HistorialePolicy::class,
        User::class => UserPolicy::class,
        // FIN DEL BLOQUE
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // La línea del Paginator se fue al AppServiceProvider
    }
}