<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorialCuentaBancariaGeneral extends Model
{
    protected $table = 'historial_cuentas_bancarias_general';

    protected $fillable = ['estado', 'fecha_alta', 'fecha_baja', 'cuentas_bancarias_general_id'];

    // ✅ Relación con CuentaBancariaGeneral (Cada registro de historial pertenece a una cuenta bancaria general)
    public function cuentaBancariaGeneral()
    {
        return $this->belongsTo(CuentaBancariaGeneral::class, 'cuentas_bancarias_general_id');
    }
}
