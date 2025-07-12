<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntityType extends Model
{
    use HasFactory;

    protected $table = 'tipo_entidades';
    protected $fillable = [
        'code',
        'tipo_id',
        'entidad_id',
        'estado',
        'fecha_alta',
        'fecha_baja'
    ];

    // Relación con Tipo (Cada tipo entidad pertenece a un tipo específico)
    public function tipo()
    {
        return $this->belongsTo(Type::class, 'tipo_id');
    }

    // Relación con Entidad (Cada tipo entidad pertenece a una entidad)
    public function entidad()
    {
        return $this->belongsTo(Entity::class, 'entidad_id');
    }

    public function empleado()
    {
        return $this->hasOne(Employee::class, 'dato_extra_tipo_entidad_id');
    }

    public function proveedor()
    {
        return $this->hasOne(Provider::class, 'dato_extra_tipo_entidad_id');
    }

    public function cliente()
    {
        return $this->hasOne(Client::class, 'dato_extra_tipo_entidad_id');
    }

    public function empresaPropia()
    {
        return $this->hasOne(OwnCompany::class, 'dato_extra_tipo_entidad_id');
    }

    public function asociadoTrading()
    {
        return $this->hasOne(Associate::class, 'dato_extra_tipo_entidad_id');
    }

    public function accionistaEmpresaPropia()
    {
        return $this->hasMany(ShareholderOwnCompany::class, 'tipo_entidad_id');
    }

    // ✅ Relación con DatosPersonalesBancarios (Un tipo de entidad puede tener un solo registro de datos personales bancarios)
    public function datosPersonalesBancarios()
    {
        return $this->hasOne(DatosPersonalesBancarios::class, 'tipo_entidad_id');
    }
}
