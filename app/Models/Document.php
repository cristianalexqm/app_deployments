<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $table = 'documentos';
    protected $fillable = [
        'tipo_entidad_id',
        'url_documento'
    ];

    // Relación con TipoEntidad (Cada documento está relacionado con un tipo de entidad)
    public function tipoEntidad()
    {
        return $this->belongsTo(EntityType::class, 'tipo_entidad_id');
    }
}
