<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tarjeta extends Model
{
    protected $table = 'tarjetas';

    protected $fillable = ['banco_emisor_id', 'numero_tarjeta', 'cvv', 'fecha_expiracion', 'clave_cajero', 'producto_financiero', 'linea_credito', 'fecha_corte', 'fecha_vencimiento', 'banco_acceso_id'];

    // ✅ Relación con BancoAcceso (Cada tarjeta pertenece a un BancoAcceso)
    public function bancoAcceso()
    {
        return $this->belongsTo(BancoAcceso::class, 'banco_acceso_id');
    }
    // ✅ Relación con TipoTarjeta (Cada tarjeta pertenece a un tipo de tarjeta)
    public function tipoTarjeta()
    {
        return $this->belongsTo(CardType::class, 'banco_emisor_id');
    }

    // ✅ Relación inversa con CuentaBancaria (Una tarjeta puede estar asociada a una cuenta bancaria)
    public function cuentaBancaria()
    {
        return $this->hasOne(CuentaBancaria::class, 'tarjeta_id');
    }
}
