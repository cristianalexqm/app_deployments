<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaCripto extends Model
{
    protected $table = 'cuentas_cripto';

    protected $fillable = ['cuentas_bancarias_general_id'];

    // ✅ Relación con CuentasBancariasGeneral (Cada cuenta cripto pertenece a una cuenta bancaria general)
    public function cuentaBancariaGeneral()
    {
        return $this->belongsTo(CuentaBancariaGeneral::class, 'cuentas_bancarias_general_id');
    }

    // ✅ Relación con DireccionesCripto (Uno a muchos)
    public function direccionesCripto()
    {
        return $this->hasMany(DireccionCripto::class, 'cuenta_cripto_id');
    }
}
