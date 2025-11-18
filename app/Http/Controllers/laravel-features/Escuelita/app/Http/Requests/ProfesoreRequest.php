<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfesoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
{
    // Obtener la matrícula del profesor actual (si estamos editando)
    $matricula = $this->profesore ? $this->profesore->matricula : null;

    return [
        // AÑADIR REGLAS PARA MATRICULA
        'matricula' => [
            'required',
            'string',
            'max:20',
            // Regla 'unique': Ignora el registro actual (con $matricula)
            // al actualizar, pero la comprueba en todos los demás.
            \Illuminate\Validation\Rule::unique('profesores')->ignore($matricula, 'matricula')
        ],
        'nombre' => 'required|string|max:50',
        'apellido_paterno' => 'required|string|max:50',
        // ... resto de tus reglas
        'area_id' => 'required|exists:areas,id',
    ];
}
}
