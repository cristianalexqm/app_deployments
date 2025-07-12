<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CelularDatosPersonalesBancarios extends Model
{
    protected $table = 'celulares_datos_personales_bancarios';

    protected $fillable = ['celular', 'operador_movil_id', 'datos_personales_bancarios_id'];

    // Un registro de celulares_datos_personales_bancarios pertenece a un operador_movil.
    public function operadorMovil()
    {
        return $this->belongsTo(MobileOperator::class, 'operador_movil_id');
    }

    // Un registro de celulares_datos_personales_bancarios pertenece a un dato personal bancario.
    public function datosPersonalesBancarios()
    {
        return $this->belongsTo(DatosPersonalesBancarios::class, 'datos_personales_bancarios_id');
    }

    // Un celular puede estar registrado en distintos accesos bancarios
    public function bancoAcceso()
    {
        return $this->hasMany(BancoAcceso::class, 'celular_banco_acceso_id');
    }
}
