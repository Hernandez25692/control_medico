<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MedicoController;
use App\Http\Controllers\ConceptoController;
use App\Http\Controllers\AtencionDiariaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ConsolidadoMensualController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'permission:dashboard'])->name('dashboard');

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

require __DIR__ . '/auth.php';
