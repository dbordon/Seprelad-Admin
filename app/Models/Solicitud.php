<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    protected $table = 'solicitudes';
    public $timestamps = false;

    protected $fillable = [
        'id_puesto','cedula','nombre','apellido','email','direccion','celular',
        'acepta_terminos','pdf_path','pdf_nombre','created_at','cod_postulante', // <-- incluye el campo
    ];

    protected $casts = [
        'acepta_terminos' => 'boolean',
        'created_at'      => 'datetime',
    ];

    public function puesto()
    {
        return $this->belongsTo(Puesto::class, 'id_puesto');
    }

    // ✅ compatible con todas las versiones
    protected static function boot()
    {
        parent::boot();

        static::created(function (Solicitud $solicitud) {
            if (empty($solicitud->cod_postulante)) {
                // Si quieres con ceros: sprintf('DSIS%07d', $solicitud->id)
                $solicitud->cod_postulante = 'DSIS' . $solicitud->id;
                $solicitud->saveQuietly(); // evita disparar eventos otra vez
            }
        });
    }
}
