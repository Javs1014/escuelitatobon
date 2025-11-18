<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Profesore
 *
 * @property string $matricula // Cambiado de $id
 * @property $nombre
 * @property $apellido_paterno
 * @property $apellido_materno
 * @property $correo
 * @property $telefono
 * @property $area_id
 *
 * @property Area $area
 * @property Grupo[] $grupos
 * @property MateriaProfesor[] $materiaProfesors
 * @property Materia[] $materias // Relación Many-to-Many
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Profesore extends Model
{
    // --- INICIO DE CAMBIOS ---

    /**
     * La llave primaria del modelo.
     *
     * @var string
     */
    protected $primaryKey = 'matricula';

    /**
     * Indica si la llave primaria es autoincremental.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * El tipo de dato de la llave primaria.
     *
     * @var string
     */
    protected $keyType = 'string';

    // --- FIN DE CAMBIOS ---

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // CAMBIO: Añadir 'matricula' a $fillable
    protected $fillable = ['matricula', 'nombre', 'apellido_paterno', 'apellido_materno', 'correo', 'telefono', 'area_id'];


    /**
     * Obtener el nombre de la llave para el Route-Model Binding.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'matricula'; // ¡MUY IMPORTANTE!
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area()
    {
        return $this->belongsTo(\App\Models\Area::class, 'area_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function grupos()
    {
        // CAMBIO: La llave local ahora es 'matricula' y la foránea es 'profesor_id'
        return $this->hasMany(\App\Models\Grupo::class, 'profesor_id', 'matricula');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materiaProfesors()
    {
        // CAMBIO: La llave local ahora es 'matricula' y la foránea es 'profesor_id'
        return $this->hasMany(\App\Models\MateriaProfesor::class, 'profesor_id', 'matricula');
    }

    /**
     * Relación Muchos-a-Muchos con Materias.
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function materias()
    {
        return $this->belongsToMany(
            \App\Models\Materia::class,
            'materia_profesores', // Tabla pivote
            'profesor_id',        // Llave foránea en pivote para este modelo (Profesor)
            'materia_id'          // Llave foránea en pivote para el otro modelo (Materia)
        );
    }
}