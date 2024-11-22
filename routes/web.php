<?php

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\InscripcionController;
// use App\Filament\Resources\InscripcionesResource;
use App\Http\Controllers\InscripcionesImportController;
// use Spatie\Permission\Models\Role;

// $role = Role::create(['name'=>'usuario']);
// $role = Role::create(['name'=>'estudiante']);
// $role = Role::create(['name'=>'docente']);
// $role = Role::create(['name'=>'coordinador']);
// $role = Role::create(['name'=>'administrador']);
// $role = Role::create(['name'=>'superadmin']);

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
// routes/web.php

Route::get('/importar-inscripciones', function () {
    return view('importar-inscripciones');
})->name('mostrar.importar.inscripciones');

// Route::post('/inscripciones/import', [InscripcionController::class, 'import'])->name('inscripciones.import');
Route::post('//importar-inscripciones', [InscripcionesImportController::class, 'importar'])->name('importar.inscripciones');
