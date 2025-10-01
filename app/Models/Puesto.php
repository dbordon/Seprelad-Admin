<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puesto extends Model
{
    public $timestamps = false; // solo created_at
    protected $fillable = ['nombre', 'activo'];

    public function solicitudes() {
        return $this->hasMany(Solicitud::class, 'id_puesto');
    }
}
