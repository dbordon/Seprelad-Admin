<?php



use App\Http\Controllers\Controller;
use App\Models\Puesto;
use Illuminate\Http\Request;

class PuestoController extends Controller
{
    public function index(){ $puestos = Puesto::orderBy('nombre')->paginate(20); return view('puestos.index', compact('puestos')); }
    public function create(){ return view('puestos.create'); }
    public function store(Request $r){ $data = $r->validate(['nombre'=>'required|max:160','activo'=>'boolean']); Puesto::create($data + ['activo'=>$r->boolean('activo')]); return to_route('puestos.index')->with('ok','Puesto creado'); }
    public function edit(Puesto $puesto){ return view('puestos.edit', compact('puesto')); }
    public function update(Request $r, Puesto $puesto){ $data = $r->validate(['nombre'=>'required|max:160','activo'=>'boolean']); $puesto->update($data + ['activo'=>$r->boolean('activo')]); return to_route('puestos.index')->with('ok','Puesto actualizado'); }
    public function destroy(Puesto $puesto){ $puesto->delete(); return back()->with('ok','Puesto eliminado'); }
}
