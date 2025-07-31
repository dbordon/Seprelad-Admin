<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransparenciaDocumento extends Model
{
    protected $table = 'seprelad_transparencia_documentos';
    protected $primaryKey = 'trans_doc_id';
    public $timestamps = false;

    protected $fillable = [
        'trans_cat_id',
        'titulo',
        'archivo',
        'mes',
        'ano',
        'tans_doc_estado',
    ];
    protected $dates = ['deleted_at'];

  public function categoria()
{
    return $this->belongsTo(TransparenciaCategoria::class, 'trans_cat_id');
}

}
