<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'cliente';
    protected $fillable = [
        'tipo_banco_id',
        'cuenta_bancaria',
        'aval',
        'dato_extra_tipo_entidad_id'
    ];

    // Relación con TipoEntidad (Cada cliente pertenece a un tipo de entidad)
    public function tipoEntidad()
    {
        return $this->belongsTo(EntityType::class, 'dato_extra_tipo_entidad_id');
    }

    // Relación con Tipos de Banco (Si el cliente tiene una cuenta bancaria)
    public function tipoBanco()
    {
        return $this->belongsTo(BankType::class, 'tipo_banco_id');
    }
}
