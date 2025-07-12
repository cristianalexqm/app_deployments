<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'empleados';
    protected $fillable = [
        'tipo_trabajador_id',
        'cargo',
        'moneda_id',
        'reembolso_basico',
        'cups_essalud',
        'hijos_asignados_familia',
        'tipo_banco_sueldo',
        'cuenta_banco',
        'cci_banco',
        'eleccion_fondo',
        'tipo_afp_id',
        'tipo_comision_afp_id',
        'dato_extra_tipo_entidad_id'
    ];

    // Relación con TipoEntidad (Cada empleado pertenece a un tipo de entidad)
    public function tipoEntidad()
    {
        return $this->belongsTo(EntityType::class, 'dato_extra_tipo_entidad_id');
    }

    // Relación con TipoTrabajador (Define el tipo de trabajador)
    public function tipoTrabajador()
    {
        return $this->belongsTo(WorkerType::class, 'tipo_trabajador_id');
    }

    // Relación con TipoAFP (Si el empleado elige AFP, se registra aquí)
    public function tipoAfp()
    {
        return $this->belongsTo(AfpType::class, 'tipo_afp_id');
    }

    // Relación con TipoComisionAFP (Si el empleado elige AFP, también se asocia con un tipo de comisión)
    public function tipoComisionAfp()
    {
        return $this->belongsTo(AfpCommissionType::class, 'tipo_comision_afp_id');
    }

    // Relación con TipoBanco (Si el empleado recibe sueldo en banco)
    public function tipoBanco()
    {
        return $this->belongsTo(BankType::class, 'tipo_banco_sueldo');
    }

    // Relación con Moneda (Moneda en la que se paga al empleado)
    public function moneda()
    {
        return $this->belongsTo(Currency::class, 'moneda_id');
    }
}
