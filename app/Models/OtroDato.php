<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtroDato extends Model
{
    protected $table = 'otros_datos';

    protected $fillable = ['otro_dato', 'datos_desbloqueo_id'];

    public function datosDesbloqueo()
    {
        return $this->belongsTo(DatosDesbloqueo::class, 'datos_desbloqueo_id');
    }
}
