<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorreoDatosPersonalesBancarios extends Model
{
    protected $table = 'correos_datos_personales_bancarios';

    protected $fillable = ['correo', 'password', 'datos_personales_bancarios_id'];

    // Un registro de correos_datos_personales_bancarios pertenece a un dato personal bancario.
    public function datosPersonalesBancarios()
    {
        return $this->belongsTo(DatosPersonalesBancarios::class, 'datos_personales_bancarios_id');
    }

    // Un correo puede estar registrado en distintos accesos bancarios
    public function bancoAcceso()
    {
        return $this->hasMany(BancoAcceso::class, 'correo_banco_acceso_id');
    }
}
