<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShareholderOwnCompany extends Model
{
    use HasFactory;

    protected $table = 'accionista_empresa_propia';
    protected $fillable = [
        'nro_acciones',
        'porcentaje_acciones',
        'fecha_desde',
        'fecha_hasta',
        'empresa_propia_id',
        'tipo_entidad_id'
    ];

    // Relación con EmpresaPropia (Cada accionista pertenece a una empresa propia)
    public function empresaPropia()
    {
        return $this->belongsTo(OwnCompany::class, 'empresa_propia_id');
    }

    // Relación con TipoEntidad (Cada accionista pertenece a un tipo de entidad)
    public function tipoEntidad()
    {
        return $this->belongsTo(EntityType::class, 'tipo_entidad_id');
    }
}
