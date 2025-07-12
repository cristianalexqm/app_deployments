<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BancoClaveDinamica extends Model
{
    protected $table = 'banco_clave_dinamica';

    protected $fillable = ['celular_afiliado', 'celular_imagen', 'banco_acceso_id'];

    public function bancoAcceso()
    {
        return $this->belongsTo(BancoAcceso::class, 'banco_acceso_id');
    }
}
