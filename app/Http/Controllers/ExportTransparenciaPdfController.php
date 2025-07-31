<?php

namespace App\Http\Controllers;

use App\Models\TransparenciaDocumento;
use Illuminate\Http\Request;
use PDF;

class ExportTransparenciaPdfController extends Controller
{
    public function export()
    {
        $documentos = TransparenciaDocumento::with('categoria')
            ->where('tans_doc_estado', 1)
            ->orderBy('ano', 'desc')
            ->orderBy('mes', 'desc')
            ->get();

        $pdf = PDF::loadView('transparencia.export_pdf', compact('documentos'));

        return $pdf->download('transparencia_documentos.pdf');
    }
}
