<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BettingHouse extends Model
{
    use HasFactory;

    protected $table = 'casa_de_apuesta';

    protected $fillable = [
        'foto', // Foto de la casa de apuesta
        'descripcion', // Descripción de la casa de apuesta
        'nombre', // Nombre único de la casa de apuesta
        'proveedor_cuota_id', // ID del proveedor de cuota
        'link_casa_apuesta', // URL de la casa de apuesta
        'pais', // País donde opera la casa de apuesta
        'estado', // Estado de la casa de apuesta
        'fecha_alta', // Fecha de registro
        'fecha_baja', // Fecha de baja (si aplica)
        'verificacion' // Información de verificación
    ];

    // Relación con ProveedorCuota (muchos a uno)
    public function proveedorCuota()
    {
        return $this->belongsTo(QuoteProvider::class, 'proveedor_cuota_id');
    }

    // Relación con CasaDeApuestaMoneda (uno a muchos)
    public function casasMonedas()
    {
        return $this->hasMany(BettingHouseCurrency::class, 'casa_de_apuesta_id');
    }
}
