<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteProvider extends Model
{
    use HasFactory;

    protected $table = 'proveedor_cuota';

    protected $fillable = [
        'nombre', // Nombre único del proveedor
        'descripcion' // Descripción del proveedor
    ];

    // Relación con CasaDeApuesta (uno a muchos)
    /* public function casasDeApuesta()
    {
        return $this->hasMany(BettingHouse::class, 'proveedor_cuota_id');
    } */
}
