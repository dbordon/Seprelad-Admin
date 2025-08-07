<?php

namespace App\Http\Controllers;

use App\Models\Tipo;
use App\Models\Sector;
use App\Models\Resolucion;
use Illuminate\Http\Request;

class ResolucionController extends Controller
{
   public function index(Request $request)
{
    $query = Resolucion::query()->where('mostrar_res', 1);

    if ($request->filled('buscar')) {
        $query->where(function($q) use ($request) {
            $q->where('titulo_res', 'like', '%' . $request->buscar . '%')
              ->orWhere('nro_res', 'like', '%' . $request->buscar . '%');
        });
    }

    if ($request->filled('tipo')) {
        $query->where('id_tipo', $request->tipo);
    }

    if ($request->filled('sector')) {
        $query->where('id_sector', $request->sector);
    }

    $resoluciones = $query->orderBy('fecha_res', 'desc')->paginate(10)->withQueryString();

    $tipos = Tipo::orderBy('descrip_tipo')->get();
    $sectores = Sector::orderBy('descrip_sector')->get();

    return view('resoluciones.index', compact('resoluciones', 'tipos', 'sectores'));
}


    public function create()
{
    $tipos = Tipo::orderBy('descrip_tipo')->get();
    $sectores = Sector::orderBy('descrip_sector')->get();
    $resolucionesPadre = Resolucion::orderBy('nro_res')->get();

    return view('resoluciones.create', compact('tipos', 'sectores', 'resolucionesPadre'));
}

public function store(Request $request)
{
    $request->validate([
        'nro_res' => 'required|string',
        'titulo_res' => 'required|string',
        'fecha_res' => 'required|date',
        'id_tipo' => 'nullable|integer',
        'id_sector' => 'nullable|integer',
        'estado_res' => 'nullable|string',
        'padre_id' => 'nullable|integer',
        'documento_res' => 'required|file|mimes:pdf|max:20480', // 20MB
    ]);

    $nombreArchivo = null;

    if ($request->hasFile('documento_res')) {
        $archivo = $request->file('documento_res');
        $nombreArchivo = $archivo->getClientOriginalName(); // ✅ sin timestamp
        $rutaDestino = '/var/www/html/resoluciones/resoluciones';
        $archivo->move($rutaDestino, $nombreArchivo);
    }

    Resolucion::create([
        'nro_res' => $request->nro_res,
        'titulo_res' => $request->titulo_res,
        'fecha_res' => $request->fecha_res,
        'id_tipo' => $request->id_tipo,
        'id_sector' => $request->id_sector,
        'estado_res' => $request->estado_res,
        'padre_id' => $request->padre_id,
        'documento_res' => $nombreArchivo,
        'mostrar_res' => $request->mostrar_res,
        'fecha_mod_res' => now(),
    ]);

    return redirect()->route('resoluciones.index')->with('success', 'Resolución creada correctamente.');
}



    public function edit($id)
{
    $resolucion = Resolucion::findOrFail($id);
    $tipos = Tipo::orderBy('descrip_tipo')->get();
    $sectores = Sector::orderBy('descrip_sector')->get();
    $padres = Resolucion::orderBy('nro_res')->get();

    return view('resoluciones.edit', compact('resolucion', 'tipos', 'sectores', 'padres'));
}

    public function update(Request $request, $id)
{
    $request->validate([
        'nro_res' => 'required|string',
        'titulo_res' => 'required|string',
        'fecha_res' => 'required|date',
        'id_tipo' => 'nullable|integer',
        'id_sector' => 'nullable|integer',
        'estado_res' => 'nullable|string',
        'padre_id' => 'nullable|integer',
        'documento_res' => 'nullable|file|mimes:pdf|max:20480',
    ]);

    $resolucion = Resolucion::findOrFail($id);

    $directorio = '/var/www/html/resoluciones/resoluciones'; 
    $nombreArchivo = $resolucion->documento_res; // por defecto conserva el anterior

    if ($request->hasFile('documento_res')) {
        $archivo = $request->file('documento_res');
        $nombreArchivo = $archivo->getClientOriginalName();

        // 🔐 Comprobamos que el directorio exista
        if (!file_exists($directorio)) {
            mkdir($directorio, 0755, true);
        }

        // ✅ Guardamos
        $archivo->move($directorio, $nombreArchivo);
    }

    // Ahora sí actualizamos
    $resolucion->update([
        'nro_res' => $request->nro_res,
        'titulo_res' => $request->titulo_res,
        'fecha_res' => $request->fecha_res,
        'id_tipo' => $request->id_tipo,
        'id_sector' => $request->id_sector,
        'estado_res' => $request->estado_res,
        'padre_id' => $request->padre_id,
        'documento_res' => $nombreArchivo,
        'mostrar_res' => $request->mostrar_res,
        'fecha_mod_res' => now(),
    ]);

    return redirect()
    ->route('resoluciones.index')
    ->with('success', 'Resolución actualizada correctamente.')
    ->with('archivo_mensaje', $request->hasFile('documento_res')
        ? '📄 Se ha subido un nuevo archivo PDF.'
        : '📄 El documento anterior fue conservado.');

}


public function destroy($id)
{
    $resolucion = Resolucion::findOrFail($id);
    $resolucion->mostrar_res = 0;
    $resolucion->save();

    return redirect()->route('resoluciones.index')
                     ->with('success', 'Resolución eliminada correctamente (borrado lógico).');
}

public function eliminadas()
{
    $resoluciones = Resolucion::where('mostrar_res', 0)
                    ->orderBy('fecha_mod_res', 'desc')
                    ->paginate(10);

    return view('resoluciones.eliminadas', compact('resoluciones'));
}


public function restaurar($id)
{
    $resolucion = Resolucion::findOrFail($id);
    $resolucion->mostrar_res = 1;
    $resolucion->save();

    return redirect()->route('resoluciones.eliminadas')
                     ->with('success', 'Resolución restaurada correctamente.');
}




}
