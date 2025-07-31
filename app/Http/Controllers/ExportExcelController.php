<?php

namespace App\Http\Controllers;

use App\Models\Resolucion;
use Shuchkin\SimpleXLSXGen;
use App\Models\TransparenciaDocumento;


class ExportExcelController extends Controller
{
    public function export()
    {
        $resoluciones = Resolucion::where('mostrar_res', 1)
            ->select('nro_res', 'titulo_res', 'fecha_res', 'estado_res')
            ->orderBy('fecha_res', 'desc')
            ->get();

        $data = [['Número', 'Título', 'Fecha', 'Estado']];
        foreach ($resoluciones as $res) {
            $data[] = [
                $res->nro_res,
                $res->titulo_res,
                $res->fecha_res,
                $res->estado_res,
            ];
        }

        $xlsx = SimpleXLSXGen::fromArray($data);
        return $xlsx->downloadAs('resoluciones.xlsx'); // ✅ CORRECTO
    }

    public function exportTransparencia()
{
    $documentos = TransparenciaDocumento::with('categoria')
    ->where('tans_doc_estado', 1)
    ->get();

    if ($documentos->isEmpty()) {
        return back()->with('warning', 'No hay documentos para exportar.');
    }

    $data = [['Categoría', 'Título', 'Archivo', 'Fecha']];
    foreach ($documentos as $doc) {
        $data[] = [
            $doc->categoria->nombre ?? 'Sin categoría',
            $doc->titulo,
            $doc->archivo,
            $doc->created_at ? $doc->created_at->format('Y-m-d') : '',
        ];
    }

    return SimpleXLSXGen::fromArray($data)->downloadAs('documentos_transparencia.xlsx');
}

public function exportResolucionesExcel()
{
    $resoluciones = Resolucion::where('mostrar_res', 1)
        ->select('nro_res', 'titulo_res', 'fecha_res', 'estado_res')
        ->orderBy('fecha_res', 'desc')
        ->get();

    if ($resoluciones->isEmpty()) {
        return back()->with('warning', 'No hay resoluciones para exportar.');
    }

    $data = [['Número', 'Título', 'Fecha', 'Estado']];
    foreach ($resoluciones as $res) {
        $data[] = [
            $res->nro_res,
            $res->titulo_res,
            $res->fecha_res,
            $res->estado_res,
        ];
    }

    return SimpleXLSXGen::fromArray($data)->downloadAs('resoluciones.xlsx');
}
}
