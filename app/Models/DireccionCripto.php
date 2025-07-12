<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DireccionCripto extends Model
{
    protected $table = 'direcciones_cripto';

    protected $fillable = ['tipo_red_cripto_id', 'direccion', 'imagen_direccion', 'cuenta_cripto_id'];

    // ✅ Relación con TipoRedCripto (Cada cuenta cripto pertenece a una red cripto)
    public function tipoRedCripto()
    {
        return $this->belongsTo(TipoRedCripto::class, 'tipo_red_cripto_id');
    }

    // ✅ Relación con CuentaCripto (Muchos a uno)
    public function cuentaCripto()
    {
        return $this->belongsTo(CuentaCripto::class, 'cuenta_cripto_id');
    }
}
