<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaBancariaGeneral extends Model
{
    protected $table = 'cuentas_bancarias_general';

    protected $fillable = ['moneda_id', 'clase_cuenta_id', 'tributario', 'financiero', 'banco_acceso_id'];

    // ✅ Relación con Moneda (Cada cuenta bancaria general pertenece a una moneda)
    public function moneda()
    {
        return $this->belongsTo(Currency::class, 'moneda_id');
    }

    // ✅ Relación con ClaseCuenta (Cada cuenta bancaria general pertenece a una clase de cuenta)
    public function claseCuenta()
    {
        return $this->belongsTo(AccountClass::class, 'clase_cuenta_id');
    }

    // ✅ Relación con BancoAcceso (Cada cuenta bancaria general pertenece a un BancoAcceso)
    public function bancoAcceso()
    {
        return $this->belongsTo(BancoAcceso::class, 'banco_acceso_id');
    }

    // ✅ Relación con CuentaBancaria (Una cuenta bancaria general estar vinculada a una cuenta bancaria)
    public function cuentaBancaria()
    {
        return $this->hasOne(CuentaBancaria::class, 'cuentas_bancarias_general_id');
    }

    // ✅ Relación con CuentaCripto (Una cuenta bancaria general puede estar vinculada a una cuenta cripto)
    public function cuentaCripto()
    {
        return $this->hasOne(CuentaCripto::class, 'cuentas_bancarias_general_id');
    }

    // ✅ Relación con CuentaBilleteraDigital (Una cuenta bancaria general puede estar vinculada a una billetera digital)
    public function cuentaBilleteraDigital()
    {
        return $this->hasOne(CuentaBilleteraDigital::class, 'cuentas_bancarias_general_id');
    }

    // ✅ Relación con HistorialCuentaBancariaGeneral (Una cuenta bancaria general puede tener múltiples registros de historial)
    public function historial()
    {
        return $this->hasMany(HistorialCuentaBancariaGeneral::class, 'cuentas_bancarias_general_id');
    }
}
