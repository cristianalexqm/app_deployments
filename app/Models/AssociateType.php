<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociateType extends Model
{
    use HasFactory;

    protected $table = 'tipo_asociado';
    protected $fillable = ['code', 'nombre', 'tipo_control'];

    // Relación con la tabla pivote AssociateTypeAssociate (Un tipo de asociado puede pertenecer a muchos asociados)
    public function asociados()
    {
        return $this->hasMany(AssociateTypeAssociate::class, 'tipo_asociado_id');
    }

    // Relación con CasaDeApuestaMonedaTipoAsociado (uno a muchos)
    // public function casasDeApuestaMonedaTipoAsociado()
    // {
    //     return $this->hasMany(BettingHouseCurrencyAssociateType::class, 'tipo_asociado_id');
    // }
}
