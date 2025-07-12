<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorreoBilleteraDigital extends Model
{
    protected $table = 'correos_billetera_digital';

    protected $fillable = ['correo', 'imagen', 'condicion', 'cuenta_billetera_digital_id'];

    // ✅ Relación con CuentaBilleteraDigital (Muchos a uno)
    public function cuentaBilleteraDigital()
    {
        return $this->belongsTo(CuentaBilleteraDigital::class, 'cuenta_billetera_digital_id');
    }
}
