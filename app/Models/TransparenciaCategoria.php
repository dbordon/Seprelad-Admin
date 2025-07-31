<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransparenciaCategoria extends Model
{
    protected $table = 'seprelad_transparencia_categoria';
    protected $primaryKey = 'trans_cat_id';
    public $timestamps = false;

    protected $fillable = ['trans_cat_descrip', 'trans_cat_estado'];

    public function documentos()
    {
        return $this->hasMany(TransparenciaDocumento::class, 'trans_cat_id');
    }
}
