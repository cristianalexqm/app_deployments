<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosPersonalesBancarios extends Model
{
    protected $table = 'datos_personales_bancarios';

    protected $fillable = ['tipo_entidad_id'];

    // Un registro de datos_personales_bancarios puede tener varios accesos bancarios (uno por cada tipo de banco).
    public function bancoAcceso()
    {
        return $this->hasMany(BancoAcceso::class, 'datos_personales_bancarios_id');
    }

    // Un registro de datos_personales_bancarios puede tener varios celulares asociados.
    public function celulares()
    {
        return $this->hasMany(CelularDatosPersonalesBancarios::class, 'datos_personales_bancarios_id');
    }

    // Un registro de datos_personales_bancarios puede tener varios correos asociados.
    public function correos()
    {
        return $this->hasMany(CorreoDatosPersonalesBancarios::class, 'datos_personales_bancarios_id');
    }

    // Cada registro de datos_personales_bancarios pertenece a un tipo_entidad.
    public function tipoEntidad()
    {
        return $this->belongsTo(EntityType::class, 'tipo_entidad_id');
    }

    // ✅ Relación con DatosDesbloqueo (DatosPersonalesBancarios tiene un registro de datos de desbloqueo)
    public function datosDesbloqueo()
    {
        return $this->hasOne(DatosDesbloqueo::class, 'datos_personales_bancarios_id');
    }
}
