<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaBilleteraDigital extends Model
{
    protected $table = 'cuentas_billetera_digital';

    protected $fillable = ['cuentas_bancarias_general_id'];

    public function cuentaBancariaGeneral()
    {
        return $this->belongsTo(CuentaBancariaGeneral::class, 'cuentas_bancarias_general_id');
    }

    // ✅ Relación con CorreosBilleteraDigital (Uno a muchos)
    public function correosBilletera()
    {
        return $this->hasMany(CorreoBilleteraDigital::class, 'cuenta_billetera_digital_id');
    }
}
