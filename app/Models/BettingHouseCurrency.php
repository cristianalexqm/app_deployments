<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BettingHouseCurrency extends Model
{
    use HasFactory;

    protected $table = 'casa_de_apuesta_moneda'; 

    protected $fillable = [
        'casa_de_apuesta_id', // ID de la casa de apuesta
        'moneda_id', // ID de la moneda
        'estado' // Estado de la relación
    ];

    // Relación con CasaDeApuesta (muchos a uno)
    public function casaDeApuesta()
    {
        return $this->belongsTo(BettingHouse::class, 'casa_de_apuesta_id');
    }

    // Relación con Moneda (muchos a uno)
    public function moneda()
    {
        return $this->belongsTo(Currency::class, 'moneda_id');
    }

    // Relación con CasaDeApuestaMonedaTipoAsociado (uno a muchos)
    public function tiposAsociados()
    {
        return $this->hasMany(BettingHouseCurrencyAssociateType::class, 'casa_de_apuesta_moneda_id');
    }
}
