<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MateriaProfesoreRequest extends FormRequest
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
    public function rules(): array
    {
        // Estas son las únicas reglas que necesita esta tabla pivote
        return [
            'materia_id' => 'required|integer|exists:materias,id',
            'profesor_id' => 'required|string|exists:profesores,matricula',
        ];
    }
}