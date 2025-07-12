<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaBancaria extends Model
{
    protected $table = 'cuentas_bancarias';

    protected $fillable = ['numero_cuenta', 'cci', 'tarjeta_id', 'cuentas_bancarias_general_id'];

    // ✅ Relación con Tarjeta (Cada cuenta bancaria pertenece a una tarjeta)
    public function tarjeta()
    {
        return $this->belongsTo(Tarjeta::class, 'tarjeta_id');
    }

    // ✅ Relación con CuentaBancariaGeneral (Cada cuenta bancaria pertenece a una cuenta bancaria general)
    public function cuentaBancariaGeneral()
    {
        return $this->belongsTo(CuentaBancariaGeneral::class, 'cuentas_bancarias_general_id');
    }
}
