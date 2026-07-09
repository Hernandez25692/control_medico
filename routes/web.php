<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\ConceptoController;
use App\Http\Controllers\AtencionDiariaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ConsolidadoMensualController;
use App\Http\Controllers\ConsolidadoAnualController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GraficaController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\PeriodoController;
use App\Http\Controllers\AuditoriaAtencionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'permission:dashboard'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'permission:medicos.ver'])->group(function () {
    Route::resource('medicos', MedicoController::class)->except(['show', 'destroy']);
    Route::patch('medicos/{medico}/estado', [MedicoController::class, 'cambiarEstado'])->name('medicos.estado');
});

Route::middleware(['auth', 'permission:conceptos.ver'])->group(function () {
    Route::resource('conceptos', ConceptoController::class)->except(['show', 'destroy']);
    Route::patch('conceptos/{concepto}/estado', [ConceptoController::class, 'cambiarEstado'])->name('conceptos.estado');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/atenciones-diarias', [AtencionDiariaController::class, 'index'])
        ->name('atenciones-diarias.index');

    Route::post('/atenciones-diarias/guardar-celda', [AtencionDiariaController::class, 'guardarCelda'])
        ->name('atenciones-diarias.guardar-celda');
});

Route::middleware(['auth', 'permission:usuarios.ver'])->group(function () {
    Route::resource('usuarios', UsuarioController::class)->except(['show', 'destroy']);
    Route::patch('usuarios/{user}/estado', [UsuarioController::class, 'cambiarEstado'])->name('usuarios.estado');
});

Route::middleware(['auth', 'permission:reportes.ver'])->group(function () {
    Route::get('/consolidado-mensual', [ConsolidadoMensualController::class, 'index'])
        ->name('consolidado-mensual.index');
});

Route::middleware(['auth', 'permission:reportes.ver'])->group(function () {
    Route::get('/consolidado-anual', [ConsolidadoAnualController::class, 'index'])
        ->name('consolidado-anual.index');
});



Route::middleware(['auth', 'permission:reportes.ver'])->group(function () {
    Route::get('/reportes', [ReporteController::class, 'index'])
        ->name('reportes.index');
    Route::get('/reportes/vista-previa', [ReporteController::class, 'vistaPrevia'])->name('reportes.preview');
    Route::get('/reportes/exportar', [ReporteController::class, 'exportar'])
        ->name('reportes.exportar');
});



Route::middleware(['auth', 'permission:configuracion'])->group(function () {
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])
        ->name('configuracion.index');
});

Route::middleware(['auth', 'permission:configuracion'])->group(function () {
    Route::get('/periodos', [PeriodoController::class, 'index'])
        ->name('periodos.index');

    Route::patch('/periodos/{periodo}/estado', [PeriodoController::class, 'cambiarEstado'])
        ->name('periodos.estado');
});

Route::middleware(['auth', 'permission:configuracion'])->group(function () {
    Route::get('/auditoria-atenciones', [AuditoriaAtencionController::class, 'index'])
        ->name('auditoria-atenciones.index');
});

require __DIR__ . '/auth.php';
