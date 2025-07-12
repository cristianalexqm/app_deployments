<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Associate extends Model
{
    use HasFactory;

    protected $table = 'asociado';
    protected $fillable = [
        'nick_apodo',
        'telefono',
        'correo_recuperacion',
        'dato_extra_tipo_entidad_id'
    ];

    public function tipoEntidad()
    {
        return $this->belongsTo(EntityType::class, 'dato_extra_tipo_entidad_id');
    }

    public function tiposAsociados()
    {
        return $this->hasMany(AssociateTypeAssociate::class, 'asociado_id');
    }

    // Relación hasMany porque un asociado puede tener múltiples correos
    public function correos()
    {
        return $this->hasMany(AssociateEmail::class, 'asociado_id');
    }
  
    public function associateCompanies()
    {
        return $this->hasMany(AssociateCompany::class, 'associated_id');
    }

    public function casasDeApuestaMonedaTipoAsociado()
    {
        return $this->hasMany(BettingHouseCurrencyAssociateType::class, 'asociado_id');
    }
}
