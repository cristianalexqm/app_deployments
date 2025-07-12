<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosDesbloqueo extends Model
{
    protected $table = 'datos_desbloqueo';

    protected $fillable = [
        'nombre_papa',
        'nombre_mama',
        'lugar_nacimiento',
        'ficha_reniec',
        'fecha_inscripcion_dni',
        'fecha_emision_dni',
        'fecha_vencimiento_dni',
        'datos_personales_bancarios_id'
    ];

    // ✅ Relación con BancoAcceso (Un dato de desbloqueo pertenece a un banco acceso)
    public function datosPersonalesBancarios()
    {
        return $this->belongsTo(BancoAcceso::class, 'datos_personales_bancarios_id');
    }

    // ✅ Relación con OtrosDatos (Un dato de desbloqueo puede tener un solo registro adicional)
    public function otrosDatos()
    {
        return $this->hasMany(OtroDato::class, 'datos_desbloqueo_id');
    }
}
