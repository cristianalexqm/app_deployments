<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BancoAcceso extends Model
{
    protected $table = 'banco_acceso';

    protected $fillable = [
        'codigo',
        'tipo_banco_id',
        'numero_tarjeta',
        'dni_username',
        'clave_web',
        'pin',
        'celular_banco_acceso_id',
        'correo_banco_acceso_id',
        'datos_personales_bancarios_id'
    ];

    // ✅ Relación con TiposBancos (BancoAcceso pertenece a un TipoBanco)
    public function tipoBanco()
    {
        return $this->belongsTo(BankType::class, 'tipo_banco_id');
    }

    // ✅ Relación con DatosPersonalesBancarios (BancoAcceso pertenece a un registro de datos personales)
    public function datosPersonalesBancarios()
    {
        return $this->belongsTo(DatosPersonalesBancarios::class, 'datos_personales_bancarios_id');
    }

    // ✅ Relación con Tarjetas (BancoAcceso puede tener muchas tarjetas asociadas)
    public function tarjetas()
    {
        return $this->hasMany(Tarjeta::class, 'banco_acceso_id');
    }

    // ✅ Relación con BancoClaveDinamica (BancoAcceso tiene una clave dinámica)
    public function bancoClaveDinamica()
    {
        return $this->hasOne(BancoClaveDinamica::class, 'banco_acceso_id');
    }

    // ✅ Relación con IdentificadorCuenta (BancoAcceso tiene un identificador de cuenta)
    public function identificadorCuenta()
    {
        return $this->hasOne(IdentificadorCuenta::class, 'banco_acceso_id');
    }

    // ✅ Relación con CuentasBancariasGeneral (BancoAcceso puede tener varias cuentas bancarias generales)
    public function cuentasBancariasGenerales()
    {
        return $this->hasMany(CuentaBancariaGeneral::class, 'banco_acceso_id');
    }

    // Esta relación indica que el banco acceso pertenece a un registro de celular.
    public function celularBancoAcceso()
    {
        return $this->belongsTo(CelularDatosPersonalesBancarios::class, 'celular_banco_acceso_id');
    }

    // Esta relación indica que el banco acceso pertenece a un registro de correo.
    public function correoBancoAcceso()
    {
        return $this->belongsTo(CorreoDatosPersonalesBancarios::class, 'correo_banco_acceso_id');
    }
}
