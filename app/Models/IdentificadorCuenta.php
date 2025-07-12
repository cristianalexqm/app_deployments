<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IdentificadorCuenta extends Model
{
    protected $table = 'identificador_cuenta';

    protected $fillable = ['imagen_qr', 'frase_qr', 'celular_afiliado', 'frase_semilla', 'cuenta_id', 'imagen_id', 'correo_id', 'banco_acceso_id'];

    // ✅ Relación con BancoAcceso (Un identificador de cuenta pertenece a un banco acceso)
    public function bancoAcceso()
    {
        return $this->belongsTo(BancoAcceso::class, 'banco_acceso_id');
    }
}
