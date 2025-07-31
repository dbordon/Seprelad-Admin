<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tipo extends Model
{
    protected $table = 'seprelad_tipo'; // <- nombre real de la tabla

    protected $primaryKey = 'id_tipo'; // opcional, pero recomendable si no usás 'id'

    public $timestamps = false; // si no usás created_at / updated_at
}
