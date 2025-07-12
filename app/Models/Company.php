<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'empresas';
    protected $fillable = [
        'persona_contacto',
        'celular_contacto',
        'correo_contacto',
        'tipo_empresa',
        'entidad_id'
    ];

    // Relación con Entidad (Cada empresa pertenece a una entidad)
    public function entidad()
    {
        return $this->belongsTo(Entity::class, 'entidad_id');
    }
}
