<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransparenciaDocumento;
use App\Models\TransparenciaCategoria;
use Shuchkin\SimpleXLSXGen;
use Barryvdh\DomPDF\Facade\Pdf;



class TransparenciaDocumentoController extends Controller
{
    public function index(Request $request)
    {
        $query = TransparenciaDocumento::with('categoria')->where('tans_doc_estado', 1);

        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('titulo', 'like', '%' . $request->buscar . '%')
                  ->orWhere('mes', 'like', '%' . $request->buscar . '%')
                  ->orWhere('ano', $request->buscar);
            });
        }

        if ($request->filled('categoria')) {
            $query->where('trans_cat_id', $request->categoria);
        }

        $documentos = $query->orderBy('ano', 'desc')->orderBy('mes', 'desc')->paginate(10)->withQueryString();
        $categorias = TransparenciaCategoria::where('trans_cat_estado', 1)->orderBy('trans_cat_descrip')->get();

        return view('transparencia.index', compact('documentos', 'categorias'));
    }

    public function create()
{
    $categorias = TransparenciaCategoria::where('trans_cat_estado', 1)->orderBy('trans_cat_descrip')->get();

    $meses = [
        'Enero', 'Febrero', 'Marzo', 'Abril',
        'Mayo', 'Junio', 'Julio', 'Agosto',
        'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
    ];

    $anios = range(date('Y'), 2015); // Desde el año actual hasta 2015
    rsort($anios); // Opcional, para que aparezca el año más reciente primero

    return view('transparencia.create', compact('categorias', 'meses', 'anios'));
}

    public function store(Request $request)
    {
        $request->validate([
            'trans_cat_id' => 'required|integer',
            'titulo' => 'required|string|max:150',
            'mes' => 'required|string|max:100',
            'ano' => 'required|integer',
            'archivo' => 'required|file|mimes:pdf|max:20480'
        ]);

        $archivo = $request->file('archivo');
        $nombreArchivo = $archivo->getClientOriginalName();
        $rutaDestino = base_path('/seprelad/transparencia/transparencia');
        $archivo->move($rutaDestino, $nombreArchivo);

        TransparenciaDocumento::create([
            'trans_cat_id' => $request->trans_cat_id,
            'titulo' => $request->titulo,
            'mes' => $request->mes,
            'ano' => $request->ano,
            'archivo' => $nombreArchivo,
            'tans_doc_estado' => 1
        ]);

        return redirect()->route('transparencia.index')->with('success', 'Documento agregado correctamente.');
    }

    public function edit($id)
    {
        $documento = TransparenciaDocumento::findOrFail($id);
        $categorias = TransparenciaCategoria::where('trans_cat_estado', 1)->orderBy('trans_cat_descrip')->get();
        return view('transparencia.edit', compact('documento', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $documento = TransparenciaDocumento::findOrFail($id);

        $request->validate([
            'trans_cat_id' => 'required|integer',
            'titulo' => 'required|string|max:150',
            'mes' => 'required|string|max:100',
            'ano' => 'required|integer',
            'archivo' => 'nullable|file|mimes:pdf|max:20480'
        ]);

        $nombreArchivo = $documento->archivo;

        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');
            $nombreArchivo = $archivo->getClientOriginalName();
            $rutaDestino = base_path('../seprelad/transparencia/transparencia');
            $archivo->move($rutaDestino, $nombreArchivo);
        }

        $documento->update([
            'trans_cat_id' => $request->trans_cat_id,
            'titulo' => $request->titulo,
            'mes' => $request->mes,
            'ano' => $request->ano,
            'archivo' => $nombreArchivo
        ]);

        return redirect()->route('transparencia.index')->with('success', 'Documento actualizado correctamente.');
    }

    public function destroy($id)
{
    $documento = TransparenciaDocumento::findOrFail($id);
    $documento->tans_doc_estado = 0; // Marcamos como eliminado
    $documento->save();

    return redirect()->route('transparencia.index')->with('success', 'Documento eliminado correctamente.');
}

public function eliminados(Request $request)
{
    $documentos = TransparenciaDocumento::onlyTrashed()
        ->with('categoria')
        ->when($request->filled('buscar'), function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                $q->where('titulo', 'like', '%' . $request->buscar . '%')
                  ->orWhere('mes', 'like', '%' . $request->buscar . '%')
                  ->orWhere('ano', $request->buscar);
            });
        })
        ->when($request->filled('categoria'), function ($query) use ($request) {
            $query->where('trans_cat_id', $request->categoria);
        })
        ->orderByDesc('ano')
        ->orderByDesc('mes')
        ->paginate(10)
        ->withQueryString();

    $categorias = TransparenciaCategoria::where('trans_cat_estado', 1)
        ->orderBy('trans_cat_descrip')
        ->get();

    return view('transparencia.eliminados', compact('documentos', 'categorias'));
}

public function exportarExcel()
{
    $documentos = TransparenciaDocumento::with('categoria')
        ->where('tans_doc_estado', 1)
        ->orderBy('ano', 'desc')
        ->orderBy('mes', 'desc')
        ->get();

    $data = [];
    $data[] = ['ID', 'Título', 'Categoría', 'Mes', 'Año', 'Archivo'];

    foreach ($documentos as $doc) {
        $data[] = [
            $doc->trans_doc_id,
            $doc->titulo,
            optional($doc->categoria)->trans_cat_descrip,
            $doc->mes,
            $doc->ano,
            $doc->archivo
        ];
    }

    $xlsx = SimpleXLSXGen::fromArray($data);
    return $xlsx->downloadAs('documentos_transparencia.xlsx');
}


}
