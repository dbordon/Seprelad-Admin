<?php

namespace App\Http\Controllers;

use App\Models\Solicitud;
use App\Models\Puesto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SolicitudController extends Controller
{
    public function index(Request $request)
    {
        $puestos = Puesto::where('activo', 1)->orderBy('nombre')->get();

        $q = Solicitud::with('puesto')
            ->when($request->filled('puesto'), fn($qq) => $qq->where('id_puesto', $request->puesto))
            ->when($request->filled('desde'), fn($qq) => $qq->whereDate('created_at', '>=', $request->desde))
            ->when($request->filled('hasta'), fn($qq) => $qq->whereDate('created_at', '<=', $request->hasta))
            ->orderBy('created_at', 'desc');

        $solicitudes = $q->paginate(15)->withQueryString();

        return view('solicitudes.index', compact('solicitudes', 'puestos'));
    }

    public function create()
    {
        $puestos = Puesto::where('activo',1)->orderBy('nombre')->get();
        return view('solicitudes.create', compact('puestos'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_puesto'       => ['required','exists:puestos,id'],
            'cedula'          => ['required','max:20'],
            'nombre'          => ['required','max:120'],
            'apellido'        => ['required','max:120'],
            'email'           => ['required','email','max:200'],
            'direccion'       => ['required','max:255'],
            'celular'         => ['required','max:30'],
            'acepta_terminos' => ['accepted'],
            'cv_pdf'          => ['nullable','file','mimes:pdf','max:10240'],
        ]);

        $data['acepta_terminos'] = $request->boolean('acepta_terminos');

        if ($request->hasFile('cv_pdf')) {
            $original = $request->file('cv_pdf')->getClientOriginalName();
            // guarda SOLO el nombre (p.ej. "hash.pdf") en el disco cvpost
            $stored   = $request->file('cv_pdf')->store('', 'cvpost');
            $data['pdf_path']   = $stored;    // sin "uploads/"
            $data['pdf_nombre'] = $original;
        }

        // 👇 crea el registro
        $solicitud = Solicitud::create($data);

        // 👇 genera el código de postulante
        if (empty($solicitud->cod_postulante)) {
            // con ceros a la izquierda: sprintf('DSIS%07d', $solicitud->id)
            $solicitud->update([
                'cod_postulante' => 'DSIS' . $solicitud->id
            ]);
        }

        return redirect()->route('solicitudes.index')->with('ok','Solicitud registrada.');
    }


    public function show(Solicitud $solicitud)
    {
        $solicitud->load('puesto');
        return view('solicitudes.show', compact('solicitud'));
    }

    public function edit(Solicitud $solicitud)
    {
        $puestos = Puesto::where('activo',1)->orderBy('nombre')->get();
        return view('solicitudes.edit', compact('solicitud','puestos'));
    }

    public function update(Request $request, Solicitud $solicitud)
    {
        $data = $request->validate([
            'id_puesto'       => ['required','exists:puestos,id'],
            'cedula'          => ['required','max:20'],
            'nombre'          => ['required','max:120'],
            'apellido'        => ['required','max:120'],
            'email'           => ['required','email','max:200'],
            'direccion'       => ['required','max:255'],
            'celular'         => ['required','max:30'],
            'acepta_terminos' => ['sometimes','accepted'],
            'cv_pdf'          => ['nullable','file','mimes:pdf','max:10240'],
        ]);

        if ($request->has('acepta_terminos')) {
            $data['acepta_terminos'] = $request->boolean('acepta_terminos');
        }

        if ($request->hasFile('cv_pdf')) {
            // borra anterior si existe
            $old = $this->normalizePath($solicitud->pdf_path);
            if ($old && Storage::disk('cvpost')->exists($old)) {
                Storage::disk('cvpost')->delete($old);
            }
            $original = $request->file('cv_pdf')->getClientOriginalName();
            $stored   = $request->file('cv_pdf')->store('', 'cvpost');
            $data['pdf_path']   = $stored;   // sin "uploads/"
            $data['pdf_nombre'] = $original;
        }

        // Actualiza los datos principales
        $solicitud->update($data);

        // Si el código aún no existe (null o cadena vacía), generarlo
        if (empty($solicitud->cod_postulante) || trim($solicitud->cod_postulante) === '') {
            $solicitud->update([
                'cod_postulante' => 'DSIS' . $solicitud->id,
                // Si lo querés con ceros a la izquierda (7 dígitos), usa esta línea:
                // 'cod_postulante' => sprintf('DSIS%07d', $solicitud->id),
            ]);
        }

        return redirect()->route('solicitudes.index')->with('ok','Solicitud actualizada.');
    }


    public function destroy(Solicitud $solicitud)
    {
        $path = $this->normalizePath($solicitud->pdf_path);
        if ($path && Storage::disk('cvpost')->exists($path)) {
            Storage::disk('cvpost')->delete($path);
        }
        $solicitud->delete();
        return back()->with('ok','Solicitud eliminada.');
    }

    public function descargarCv(Solicitud $solicitud)
    {
        abort_unless($solicitud->pdf_path, 404, 'Sin archivo');

        $path = $this->normalizePath($solicitud->pdf_path);
        $name = $solicitud->pdf_nombre ?: 'cv.pdf';

        // 1) por Storage (disco externo cvpost)
        if ($path && Storage::disk('cvpost')->exists($path)) {
            return Storage::disk('cvpost')->download($path, $name);
        }

        // 2) fallback absoluto
        $root = rtrim(config('filesystems.disks.cvpost.root'), '/');
        $abs  = $root . '/' . $path;
        if (is_file($abs)) {
            return response()->download($abs, $name, ['Content-Type' => 'application/pdf']);
        }

        abort(404, 'Archivo no encontrado en el servidor');
    }

    /**
     * Normaliza pdf_path guardado en BD (quita prefijo "uploads/" o "/" si existiera).
     */
    private function normalizePath(?string $pdfPath): ?string
    {
        if (!$pdfPath) return null;
        $p = ltrim($pdfPath, '/');
        if (strpos($p, 'uploads/') === 0) {
            $p = substr($p, strlen('uploads/')); // deja solo "archivo.pdf" o "subcarpeta/archivo.pdf"
        }
        return $p;
    }

    
}
