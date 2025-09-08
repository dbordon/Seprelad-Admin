<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResolucionController;
use App\Http\Controllers\TransparenciaDocumentoController;
use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\ExportPdfController;
use App\Http\Controllers\ExportTransparenciaPdfController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;

// Página de inicio
Route::get('/', function () {
    return redirect('/login');
});

// Rutas públicas para recuperación de contraseña
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.update');

// Rutas protegidas
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Resoluciones
    Route::get('/resoluciones/eliminadas', [ResolucionController::class, 'eliminadas'])->name('resoluciones.eliminadas');
    Route::resource('resoluciones', ResolucionController::class);
    
    Route::post('/resoluciones/{id}/restaurar', [ResolucionController::class, 'restaurar'])->name('resoluciones.restaurar');
    Route::get('/resoluciones/export/pdf', [ExportPdfController::class, 'exportResolucionesPdf'])->name('resoluciones.export.pdf');
    Route::get('/resoluciones/export/excel', [ExportExcelController::class, 'exportResolucionesExcel'])->name('resoluciones.export.excel');

    // Transparencia
    Route::get('/transparencia', [TransparenciaDocumentoController::class, 'index'])->name('transparencia.index');
    Route::get('/transparencia/create', [TransparenciaDocumentoController::class, 'create'])->name('transparencia.create');
    Route::post('/transparencia', [TransparenciaDocumentoController::class, 'store'])->name('transparencia.store');
    Route::get('/transparencia/{id}/edit', [TransparenciaDocumentoController::class, 'edit'])->name('transparencia.edit');
    Route::put('/transparencia/{id}', [TransparenciaDocumentoController::class, 'update'])->name('transparencia.update');
    Route::delete('/transparencia/{id}', [TransparenciaDocumentoController::class, 'destroy'])->name('transparencia.destroy');
    Route::get('/transparencia/eliminados', [TransparenciaDocumentoController::class, 'eliminados'])->name('transparencia.eliminados');
    Route::post('/transparencia/{id}/restaurar', [TransparenciaDocumentoController::class, 'restaurar'])->name('transparencia.restaurar');
    Route::get('/transparencia/exportar/excel', [ExportExcelController::class, 'exportTransparencia'])->name('transparencia.exportar.excel'); // nombre corregido
    Route::get('/transparencia/export/pdf', [ExportTransparenciaPdfController::class, 'export'])->name('transparencia.export.pdf');
});

// Autenticación Laravel Breeze
require __DIR__.'/auth.php';
