<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash; // Asegúrate que este import exista

class UserController extends Controller
{
    /**
     * Muestra la lista de usuarios para gestionar roles.
     * (Como se especifica en la instrucción: usuarios/index.blade.php)
     */
    public function index()
    {
        // Obtenemos todos los usuarios, paginados
        $users = User::orderBy('name')->paginate(20);
        
        return view('usuarios.index', compact('users'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        // Roles permitidos
        $roles = ['Administrador', 'Profesor', 'Alumno'];
        
        return view('usuarios.create', compact('roles'));
    }

    /**
     * Guarda un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        // Roles válidos
        $roles_validos = ['Administrador', 'Profesor', 'Alumno'];

        // Validación para un NUEVO usuario
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'matricula' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'], // 'confirmed' busca 'password_confirmation'
            'role' => [
                'required',
                Rule::in($roles_validos),
            ],
        ]);

        // Crear el usuario
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'matricula' => $validatedData['matricula'],
            'password' => Hash::make($validatedData['password']), // Hashear la contraseña
            'role' => $validatedData['role'],
        ]);

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuario creado correctamente.');
    }

    /**
     * Muestra el formulario para editar el rol de un usuario.
     */
    public function edit(User $user)
    {
        // Definimos los roles permitidos según tus instrucciones
        $roles = ['Administrador', 'Profesor', 'Alumno'];
        
        return view('usuarios.edit', compact('user', 'roles'));
    }

    /**
     * Actualiza el rol del usuario en la base de datos.
     */
    public function update(Request $request, User $user)
    {
        // Roles válidos
        $roles_validos = ['Administrador', 'Profesor', 'Alumno'];

        // Validación
        $validatedData = $request->validate([
            'role' => [
                'required',
                Rule::in($roles_validos), // Asegura que el rol sea uno de los permitidos
            ],
            'matricula' => [
                'required',
                'string',
                'max:255',
                // Asegura que la matrícula sea única en la tabla 'users',
                // ignorando al usuario actual que estamos editando.
                Rule::unique('users')->ignore($user->id),
            ],
        ]);

        // Actualizar el usuario usando los datos validados.
        $user->update($validatedData);

        return redirect()->route('usuarios.index')
                         ->with('success', 'Usuario actualizado correctamente.');
    }
}