    <?php
    
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth;
    use App\Http\Controllers\HomeController;
    use App\Http\Controllers\AreaController;
    use App\Http\Controllers\CarreraController;
    use App\Http\Controllers\ProfesoreController;
    use App\Http\Controllers\MateriaController;
    use App\Http\Controllers\PaqueteController;
    use App\Http\Controllers\GrupoController;
    use App\Http\Controllers\AlumnoController;
    use App\Http\Controllers\HistorialeController;
    use App\Http\Controllers\MateriaProfesoreController;
    use App\Http\Controllers\PaqueteMateriaController;
    use App\Http\Controllers\ProcedimientoController;
    use App\Http\Controllers\UserController;
 
    
    Route::get('/', function () {
        return redirect()->route('login');
    });
    
    Auth::routes();
    
    Route::middleware(['auth'])->group(function () {
    Route::get('/home', function () {
        return view('web', ['user' => Auth::user()]);
    })->name('home');

    Route::resource('areas', AreaController::class)->middleware('role:Administrador');
    Route::resource('carreras', CarreraController::class)->middleware('role:Administrador');
    Route::resource('profesores', ProfesoreController::class)->middleware('role:Administrador');
    Route::resource('materias', MateriaController::class)->middleware('role:Administrador');
    Route::resource('paquetes', PaqueteController::class)->middleware('role:Administrador');
    Route::resource('grupos', GrupoController::class)->middleware('role:Administrador');
    Route::resource('alumnos', AlumnoController::class)->middleware('role:Administrador');
    Route::resource('materia-profesores', MateriaProfesoreController::class)->middleware('role:Administrador');
    Route::resource('paquete-materias', PaqueteMateriaController::class)->middleware('role:Administrador');

    // Reemplaza tu línea 'Route::resource('historiales', ...)' por estas tres:

// 1. Rutas para Alumnos (Solo ver)
// Todos los roles pueden ver el index y el show
Route::resource('historiales', HistorialeController::class)->only([
    'index', 'show'
])->middleware('role:Administrador,Alumno,Profesor');

// 2. Rutas para Profesores (Ver + Modificar)
// Admin y Profesor pueden editar y actualizar
Route::resource('historiales', HistorialeController::class)->only([
    'edit', 'update'
])->middleware('role:Administrador,Profesor');

// 3. Rutas para Administrador (Todo)
// Solo el Admin puede crear, guardar y borrar
Route::resource('historiales', HistorialeController::class)->only([
    'create', 'store', 'destroy'
])->middleware('role:Administrador');

    Route::prefix('procedimientos')->name('procedimientos.')->middleware('role:Administrador')->group(function () {
        Route::get('/', [ProcedimientoController::class, 'index'])->name('index');
        Route::get('/consulta-materias-alumno', [ProcedimientoController::class, 'showProc1Form'])->name('proc1.form');
        Route::post('/consulta-materias-alumno', [ProcedimientoController::class, 'runProc1'])->name('proc1.run');
        Route::get('/consulta-alumnos-grupo', [ProcedimientoController::class, 'showProc2Form'])->name('proc2.form');
        Route::post('/consulta-alumnos-grupo', [ProcedimientoController::class, 'runProc2'])->name('proc2.run');
        Route::get('/consulta-historial-alumno', [ProcedimientoController::class, 'showProc3Form'])->name('proc3.form');
        Route::post('/consulta-historial-alumno', [ProcedimientoController::class, 'runProc3'])->name('proc3.run');
        Route::post('/reporte-alumnos-grupo', [ProcedimientoController::class, 'runProc4'])->name('proc4.run');
        Route::get('/reporte-promedios', [ProcedimientoController::class, 'showProc5Form'])->name('proc5.form');
        Route::post('/reporte-promedios', [ProcedimientoController::class, 'runProc5'])->name('proc5.run');
 
    });

        Route::prefix('usuarios')->name('usuarios.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{user}', [UserController::class, 'update'])->name('update');
        });
});
    

