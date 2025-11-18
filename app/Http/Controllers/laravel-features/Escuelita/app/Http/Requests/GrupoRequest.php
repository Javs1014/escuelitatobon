<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrupoRequest extends FormRequest
{
    // ... (authorize) ...

    public function rules(): array
    {
        return [
            // Reglas para el grupo
            'nombre' => 'required|string|max:10',
            'materia_id' => 'required|integer|exists:materias,id',

            // ======== AQUÍ ESTÁ EL CAMBIO ========
            // 'profesor_id' => 'required|integer|exists:profesores,id', // <-- INCORRECTO
            'profesor_id' => 'required|string|exists:profesores,matricula', // <-- CORRECTO
            // ===================================

            // --- REGLAS NUEVAS PARA LOS HORARIOS ---
            'horarios' => 'nullable|array', 
            'horarios.*.dia_semana' => 'required_with:horarios|string|in:lunes,martes,miercoles,jueves,viernes,sabado,domingo',
            'horarios.*.hora_inicio' => 'required_with:horarios|date_format:H:i',
            'horarios.*.hora_fin' => 'required_with:horarios|date_format:H:i|after:horarios.*.hora_inicio',
        ];
    }
}