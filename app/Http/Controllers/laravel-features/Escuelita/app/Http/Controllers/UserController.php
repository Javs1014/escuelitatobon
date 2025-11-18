<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Aplica la política de seguridad a todos los métodos.
     */
    public function __construct()
    {
        // Esto asegura que solo el 'admin' (definido en UserPolicy)
        // pueda acceder a CUALQUIER método de este controlador.
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Muestra la lista de usuarios.
     */
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $users = User::when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%")
                             ->orWhere('role', 'like', "%{$search}%");
            })
            ->paginate(20);

        return view('users.index', compact('users'))
            ->with('i', ($request->input('page', 1) - 1) * $users->perPage());
    }

    /**
     * Muestra el formulario para editar la contraseña.
     */
    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Actualiza la contraseña del usuario.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        // 1. Validar la entrada
        $request->validate([
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        // 2. Actualizar la contraseña
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // 3. Redirigir con mensaje de éxito
        return Redirect::route('users.index')
            ->with('success', 'Contraseña del usuario ' . $user->email . ' actualizada exitosamente.');
    }
}