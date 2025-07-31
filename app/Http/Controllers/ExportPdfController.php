<?php

namespace App\Http\Controllers;

use App\Models\Resolucion;
use App\Models\TransparenciaDocumento;
use PDF;

class ExportPdfController extends Controller
{
    /**
     * Exportar resoluciones a PDF
     */
    public function exportResolucionesPdf()
    {
        $resoluciones = Resolucion::where('mostrar_res', 1)
            ->select('nro_res', 'titulo_res', 'fecha_res', 'estado_res')
            ->orderBy('fecha_res', 'desc')
            ->get();

        $pdf = PDF::loadView('resoluciones.export_pdf', compact('resoluciones'));

        return $pdf->download('resoluciones.pdf');
    }

    /**
     * Exportar documentos de transparencia a PDF
     */
    public function exportTransparenciaPdf()
    {
        $documentos = TransparenciaDocumento::with('categoria')
            ->where('mostrar', 1)
            ->get();

        $pdf = PDF::loadView('transparencia.export_pdf', compact('documentos'));

        return $pdf->download('documentos_transparencia.pdf');
    }
}
