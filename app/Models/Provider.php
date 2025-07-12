<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $table = 'proveedor';
    protected $fillable = [
        'tipo_banco_id',
        'cuenta_bancaria',
        'aval',
        'dato_extra_tipo_entidad_id'
    ];

    // Relación con TipoEntidad (Cada proveedor pertenece a un tipo de entidad)
    public function tipoEntidad()
    {
        return $this->belongsTo(EntityType::class, 'dato_extra_tipo_entidad_id');
    }

    // Relación con TipoBanco (Un proveedor puede estar asociado a un tipo de banco)
    public function tipoBanco()
    {
        return $this->belongsTo(BankType::class, 'tipo_banco_id');
    }
}
