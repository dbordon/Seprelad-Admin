<?php
namespace App\Http\Controllers;

use App\Models\Resolucion;
use Shuchkin\SimpleXLSXGen;

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
                $res->estado_res
            ];
        }

        $xlsx = SimpleXLSXGen::fromArray($data);
        return response($xlsx->downloadAsString(), 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="resoluciones.xlsx"'
        ]);
    }
}

