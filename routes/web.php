<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ResolucionController;
use App\Http\Controllers\TransparenciaDocumentoController;
use App\Http\Controllers\ExportExcelController;
use App\Http\Controllers\ExportPdfController;
use App\Http\Controllers\ExportTransparenciaPdfController;

Route::get('/transparencia/exportar/excel', [ExportExcelController::class, 'exportTransparencia'])->name('transparencia.exportar.excel');

Route::get('/transparencia/exportar/excel', [ExportExcelController::class, 'exportTransparencia'])->name('transparencia.exportar.excel');


Route::middleware(['auth'])->group(function () {
    Route::get('/transparencia', [TransparenciaDocumentoController::class, 'index'])->name('transparencia.index');
    Route::get('/transparencia/create', [TransparenciaDocumentoController::class, 'create'])->name('transparencia.create');
    Route::post('/transparencia', [TransparenciaDocumentoController::class, 'store'])->name('transparencia.store');
    Route::get('/transparencia/{id}/edit', [TransparenciaDocumentoController::class, 'edit'])->name('transparencia.edit');
    Route::put('/transparencia/{id}', [TransparenciaDocumentoController::class, 'update'])->name('transparencia.update');
    Route::delete('/transparencia/{id}', [TransparenciaDocumentoController::class, 'destroy'])->name('transparencia.destroy');

    Route::get('/transparencia/eliminados', [TransparenciaDocumentoController::class, 'eliminados'])->name('transparencia.eliminados');
    Route::post('/transparencia/{id}/restaurar', [TransparenciaDocumentoController::class, 'restaurar'])->name('transparencia.restaurar');

    // Exportaciones
    Route::get('/transparencia/export/excel', [App\Http\Controllers\ExportExcelController::class, 'exportTransparencia'])->name('transparencia.export.excel');
    Route::get('/transparencia/export/pdf', [App\Http\Controllers\ExportTransparenciaPdfController::class, 'export'])->name('transparencia.export.pdf');
});


Route::get('/resoluciones/eliminadas', [ResolucionController::class, 'eliminadas'])->name('resoluciones.eliminadas');

Route::get('/resoluciones/export/pdf', [ExportPdfController::class, 'exportResolucionesPdf'])->name('resoluciones.export.pdf');


Route::get('/resoluciones/export/excel', [ExportExcelController::class, 'exportResolucionesExcel'])->name('resoluciones.export.excel');


Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Módulo de Resoluciones
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('resoluciones', ResolucionController::class);
});
    // Módulo de Transparencia
 
});
Route::get('/resoluciones/eliminadas', [ResolucionController::class, 'eliminadas'])->name('resoluciones.eliminadas');
Route::post('/resoluciones/{id}/restaurar', [ResolucionController::class, 'restaurar'])->name('resoluciones.restaurar');


require __DIR__.'/auth.php';

