<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Alumno;     // <-- IMPORTANTE
use App\Models\Profesore; // <-- IMPORTANTE
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str; // <-- IMPORTANTE

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                'unique:users', // Asegura que no se haya registrado antes en la app
                
                // REGLA PERSONALIZADA:
                function ($attribute, $value, $fail) {
                    
                    // 1. ¿Es un correo de Admin? (Ej: admin@escuelita.admin)
                    if (Str::endsWith($value, '@escuelita.admin')) {
                        return; // Es admin, pasa la validación
                    }

                    // 2. ¿Existe en profesores?
                    $isProfesor = Profesore::where('correo', $value)->exists();
                    
                    // 3. ¿Existe en alumnos?
                    $isAlumno = Alumno::where('correo', $value)->exists();

                    if (!$isProfesor && !$isAlumno) {
                        $fail('Este correo no está registrado como profesor o alumno en el sistema.');
                    }
                }
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $role = null;
        $matricula = null;
        $email = $data['email'];

        // 1. ¿Es Admin?
        // ADVERTENCIA: ¡Cualquiera que sepa esto puede ser admin!
        // Lo ideal es que crees tu usuario admin manualmente en la base de datos.
        if (Str::endsWith($email, '@escuelita.admin')) {
            $role = 'admin';
            // la matrícula se queda null
        } 
        // 2. ¿Es Profesor?
        else if ($profesor = Profesore::where('correo', $email)->first()) {
            $role = 'profesor';
            $matricula = $profesor->matricula;
        } 
        // 3. ¿Es Alumno?
        else if ($alumno = Alumno::where('correo', $email)->first()) {
            $role = 'alumno';
            $matricula = $alumno->matricula;
        }

        return User::create([
            'name' => $data['name'],
            'email' => $email,
            'password' => Hash::make($data['password']),
            'role' => $role,          // <-- ASIGNAMOS EL ROL
            'matricula' => $matricula,  // <-- ASIGNAMOS LA MATRÍCULA
        ]);
    }
}