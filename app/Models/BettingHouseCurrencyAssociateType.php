<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BettingHouseCurrencyAssociateType extends Model
{
    use HasFactory;

    protected $table = 'casa_de_apuesta_moneda_tipo_asociado';

    protected $fillable = [
        'tipo_asociado_id', // ID del tipo de asociado
        'casa_de_apuesta_moneda_id', // ID de la casa de apuesta moneda
        'estado' // Estado de la relación
    ];

    // Relación con TipoAsociado (muchos a uno)
    public function tipoAsociado()
    {
        return $this->belongsTo(AssociateType::class, 'tipo_asociado_id');
    }

    // Relación con CasaDeApuestaMoneda (muchos a uno)
    public function casaDeApuestaMoneda()
    {
        return $this->belongsTo(BettingHouseCurrency::class, 'casa_de_apuesta_moneda_id');
    }
}
