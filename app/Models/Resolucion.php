<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resolucion extends Model
{
    protected $table = 'seprelad_resoluciones';
    protected $primaryKey = 'id_res';
    public $timestamps = false; // No hay campos created_at y updated_at

    // Opcional: Campos que se pueden usar en asignación masiva (fill)
    protected $fillable = [
    'nro_res', 'titulo_res', 'fecha_res', 'id_tipo', 'id_sector',
    'estado_res', 'padre_id', 'documento_res', 'mostrar_res', 'fecha_mod_res'
];
}
